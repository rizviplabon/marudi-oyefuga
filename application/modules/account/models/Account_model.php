<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertAccount($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('account_balance', $data2);
    }

    function getAccount()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('account_balance');
        return $query->result();
    }

    function getAccountById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('account_balance');
        return $query->row();
    }
    
    function updateAccount($id, $data)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $this->db->update('account_balance', $data);
    }

    function delete($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $this->db->delete('account_balance');
    }

    function getAccountBysearch($search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->like('id', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('date', $search);
        $this->db->or_like('deposit_amount', $search);
        $this->db->or_like('balance_amount', $search);
        $this->db->or_like('deposit_type', $search);
        $this->db->or_like('account_no', $search);
        $this->db->or_like('transaction_id', $search);
        $query = $this->db->get('account_balance');
        return $query->result();
    }

    function getAccountByLimit($limit, $start, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->limit($limit, $start);
        $query = $this->db->get('account_balance');
        return $query->result();
    }

    function getAccountByLimitBySearch($limit, $start, $search, $order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->like('id', $search);

        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }

        $this->db->or_like('patient_name', $search);
        $this->db->or_like('date', $search);
        $this->db->or_like('deposit_amount', $search);
        $this->db->or_like('balance_amount', $search);
        $this->db->or_like('deposit_type', $search);
        $this->db->or_like('account_no', $search);
        $this->db->or_like('transaction_id', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('account_balance');
        return $query->result();
    }

    function getAccountWithoutSearch($order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->get('account_balance');
        return $query->result();
    }
    
    function getTotalBalanceByPatient($patient_id)
    {
        $this->db->select_sum('balance_amount');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $patient_id);
        $query = $this->db->get('account_balance');
        $result = $query->row();
        return $result->balance_amount ? $result->balance_amount : 0;
    }
    
    function deductBalanceFromMultipleRows($patient_id, $amount_to_deduct)
    {
        // Get all account balance rows for the patient ordered by ID (newest first for deduction)
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $patient_id);
        $this->db->order_by('id', 'desc'); // Process newest entries first for deduction
        $query = $this->db->get('account_balance');
        $accounts = $query->result();
        
        if (empty($accounts)) {
            // No account entries found, cannot process deduction
            return 0;
        }
        
        $remaining_amount = $amount_to_deduct;
        $accounts_processed = 0;
        
        // Process deductions from positive balance accounts first
        foreach ($accounts as $account) {
            if ($remaining_amount <= 0) {
                break; // No more amount to deduct
            }
            
            $current_balance = $account->balance_amount;
            
            // Only deduct from positive balance accounts in this first pass
            if ($current_balance > 0) {
                if ($current_balance >= $remaining_amount) {
                    // This account has enough balance to cover the remaining amount
                    $data = array(
                        'balance_amount' => $current_balance - $remaining_amount
                    );
                    $this->updateAccount($account->id, $data);
                    $remaining_amount = 0;
                    $accounts_processed++;
                } else {
                    // Deduct all available balance from this account
                    $data = array(
                        'balance_amount' => 0
                    );
                    $this->updateAccount($account->id, $data);
                    $remaining_amount -= $current_balance;
                    $accounts_processed++;
                }
            }
        }
        
        // If there's still remaining amount and no positive balances were found,
        // or after exhausting all positive balances, apply to the most recent account
        if ($remaining_amount > 0) {
            // Get the most recent account entry (could be positive, zero, or negative)
            $most_recent_account = $accounts[0]; // First in desc order = most recent
            
            // Apply the remaining deduction to this account (making it more negative if needed)
            $new_balance = $most_recent_account->balance_amount - $remaining_amount;
            
            $data = array(
                'balance_amount' => $new_balance
            );
            $this->updateAccount($most_recent_account->id, $data);
            $remaining_amount = 0;
            $accounts_processed++;
        }
        
        return $amount_to_deduct - $remaining_amount; // Return the actual amount deducted
    }
}