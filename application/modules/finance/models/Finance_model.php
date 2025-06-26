<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance_model extends CI_model
{
    // List of fields that should be encrypted
    public $encrypted_fields = array(
        'patient_name',
        'patient_phone', 
        'patient_address',
        'remarks',
        
        
    );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('db_encrypt');
    }

    /**
     * Safe decrypt method to handle both encrypted and plaintext values 
     */
    private function safe_decrypt($value) {
        if (empty($value)) {
            return $value;
        }
        
        // Try to decrypt
        $decrypted = db_decrypt($value);
        
        // If decryption fails or returns same value, it might not be encrypted
        // In that case, return the original value
        return $decrypted === false ? $value : $decrypted; 
    }

    /**
     * Decrypt fields in an object or array of objects
     */
    protected function decrypt_fields($data) {
        if (empty($data)) {
            return $data;
        }
        
        // For debugging
        log_message('debug', 'Decrypting fields in Finance_model for data: ' . print_r(is_object($data) ? 'Single object' : 'Array of objects', true));
        
        // If it's a single object
        if (is_object($data)) {
            // First decrypt any encrypted fields
            foreach ($this->encrypted_fields as $field) {
                if (isset($data->$field)) {
                    $data->$field = $this->safe_decrypt($data->$field);
                }
            }
            
            // Handle patient data if this is a payment object with patient ID
            if (isset($data->patient) && is_numeric($data->patient)) {
                // Try to get patient details and ensure they're decrypted
                $this->db->where('id', $data->patient);
                $patient = $this->db->get('patient')->row();
                
                if ($patient) {
                    // Always decrypt and set patient name
                    $data->patient_name = $this->safe_decrypt($patient->name);
                    
                    // Add additional patient info if needed
                    if (isset($patient->phone)) {
                        $data->patient_phone = $this->safe_decrypt($patient->phone);
                    }
                    
                    if (isset($patient->address)) {
                        $data->patient_address = $this->safe_decrypt($patient->address);
                    }
                    
                    if (isset($patient->email)) {
                        $data->patient_email = $this->safe_decrypt($patient->email);
                    }
                }
            }
            
            return $data;
        }
        
        // If it's an array of objects
        foreach ($data as $key => $obj) {
            if (is_object($obj)) {
                // First decrypt any encrypted fields
                foreach ($this->encrypted_fields as $field) {
                    if (isset($obj->$field)) {
                        $obj->$field = $this->safe_decrypt($obj->$field);
                    }
                }
                
                // Handle patient data if this is a payment object with patient ID
                if (isset($obj->patient) && is_numeric($obj->patient)) {
                    // Try to get patient details and ensure they're decrypted
                    $this->db->where('id', $obj->patient);
                    $patient = $this->db->get('patient')->row();
                    
                    if ($patient) {
                        // Always decrypt and set patient name
                        $obj->patient_name = $this->safe_decrypt($patient->name);
                        
                        // Add additional patient info if needed
                        if (isset($patient->phone)) {
                            $obj->patient_phone = $this->safe_decrypt($patient->phone);
                        }
                        
                        if (isset($patient->address)) {
                            $obj->patient_address = $this->safe_decrypt($patient->address);
                        }
                        
                        if (isset($patient->email)) {
                            $obj->patient_email = $this->safe_decrypt($patient->email);
                        }
                    }
                }
            }
        }
        
        return $data;
    }

    /**
     * Encrypt fields in an array
     */
    protected function encrypt_data($data) {
        if (empty($data) || !is_array($data)) {
            return $data;
        }
        
        foreach ($this->encrypted_fields as $field) {
            if (isset($data[$field])) {
                $data[$field] = db_encrypt($data[$field]);
            }
        }
        
        return $data;
    }

    function insertPayment($data)
    {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('payment', $data2);
    }

    function getPayment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getPaymentWitoutSearch($order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->get('payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getPaymentBySearch($search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
            ->from('payment')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR amount LIKE '%" . $search . "%' OR gross_total LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%'OR patient_phone LIKE '%" . $search . "%'OR patient_address LIKE '%" . $search . "%'OR remarks LIKE '%" . $search . "%'OR doctor_name LIKE '%" . $search . "%'OR flat_discount LIKE '%" . $search . "%'OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getPaymentByLimit($limit, $start, $order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getGatewayByName($name)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('name', $name);
        $query = $this->db->get('paymentGateway')->row();
        // No need to decrypt as it doesn't contain patient data
        return $query;
    }

    function getPaymentByLimitBySearch($limit, $start, $search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
            ->from('payment')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR amount LIKE '%" . $search . "%' OR gross_total LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%'OR patient_phone LIKE '%" . $search . "%'OR patient_address LIKE '%" . $search . "%'OR remarks LIKE '%" . $search . "%'OR doctor_name LIKE '%" . $search . "%'OR flat_discount LIKE '%" . $search . "%'OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    /**
     * Get payment with guaranteed decrypted patient data
     */
    function getPaymentWithDecryptedPatientData($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
        $payment = $query->row();
        
        if (!$payment) {
            return null;
        }
        
        // First decrypt all payment fields
        $payment = $this->decrypt_fields($payment);
        
        // If payment has a patient ID, ensure all patient data is decrypted
        if ($payment && isset($payment->patient) && is_numeric($payment->patient)) {
            // Load patient model to get patient details
            $this->load->model('patient/patient_model');
            $patient = $this->patient_model->getDecryptedPatientById($payment->patient);
            
            if ($patient) {
                // Always set decrypted patient data
                $payment->patient_name = $patient->name;
                $payment->patient_phone = $patient->phone;
                $payment->patient_address = $patient->address;
                $payment->patient_email = $patient->email;
                
                // Log successful decryption
                log_message('debug', 'Successfully decrypted patient data for payment ID: ' . $id);
            }
        }
        
        return $payment;
    }

    function getPaymentById($id)
    {
        // Use the new method to ensure fully decrypted data
        return $this->getPaymentWithDecryptedPatientData($id);
    }

    function getPaymentByPatientId($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getPaymentByPatientIdByDate($id, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $id);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get('payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getPaymentByUserId($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('user', $id);
        $query = $this->db->get('payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function thisMonthPayment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                $total[] = $q->gross_total;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }
    function PreviousMonthPayment()
    {
        $prevMonth = strtotime("-1 month");
       
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', $prevMonth) == date('m/Y', $q->date)) {
                $total[] = $q->gross_total;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }
    function thisMonthExpense()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                $total[] = $q->amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisMonthAppointment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                $total[] = '1';
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisDayPayment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('d/m/Y', time()) == date('d/m/Y', $q->date)) {
                $total[] = $q->gross_total;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisDayExpense()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('d/m/Y', time()) == date('d/m/Y', $q->date)) {
                $total[] = $q->amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisDayAppointment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('d/m/Y', time()) == date('d/m/Y', $q->date)) {
                $total[] = '1';
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisYearPayment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                $total[] = $q->gross_total;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }
    function PreviousYearPayment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)-1) {
                $total[] = $q->gross_total;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisYearExpense()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                $total[] = $q->amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisYearAppointment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                $total[] = '1';
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisMonthAppointmentTreated()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                if ($q->status == 'Treated') {
                    $total[] = '1';
                }
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisMonthAppointmentCancelled()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                if ($q->status == 'Cancelled') {
                    $total[] = '1';
                }
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function getPaymentPerMonthThisYear()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                if (date('m', $q->date) == '01') {
                    $total['january'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '02') {
                    $total['february'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '03') {
                    $total['march'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '04') {
                    $total['april'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '05') {
                    $total['may'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '06') {
                    $total['june'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '07') {
                    $total['july'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '08') {
                    $total['august'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '09') {
                    $total['september'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '10') {
                    $total['october'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '11') {
                    $total['november'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '12') {
                    $total['december'][] = $q->gross_total;
                }
            }
        }


        if (!empty($total['january'])) {
            $total['january'] = array_sum($total['january']);
        } else {
            $total['january'] = 0;
        }
        if (!empty($total['february'])) {
            $total['february'] = array_sum($total['february']);
        } else {
            $total['february'] = 0;
        }
        if (!empty($total['march'])) {
            $total['march'] = array_sum($total['march']);
        } else {
            $total['march'] = 0;
        }
        if (!empty($total['april'])) {
            $total['april'] = array_sum($total['april']);
        } else {
            $total['april'] = 0;
        }
        if (!empty($total['may'])) {
            $total['may'] = array_sum($total['may']);
        } else {
            $total['may'] = 0;
        }
        if (!empty($total['june'])) {
            $total['june'] = array_sum($total['june']);
        } else {
            $total['june'] = 0;
        }
        if (!empty($total['july'])) {
            $total['july'] = array_sum($total['july']);
        } else {
            $total['july'] = 0;
        }
        if (!empty($total['august'])) {
            $total['august'] = array_sum($total['august']);
        } else {
            $total['august'] = 0;
        }
        if (!empty($total['september'])) {
            $total['september'] = array_sum($total['september']);
        } else {
            $total['september'] = 0;
        }
        if (!empty($total['october'])) {
            $total['october'] = array_sum($total['october']);
        } else {
            $total['october'] = 0;
        }
        if (!empty($total['november'])) {
            $total['november'] = array_sum($total['november']);
        } else {
            $total['november'] = 0;
        }
        if (!empty($total['december'])) {
            $total['december'] = array_sum($total['december']);
        } else {
            $total['december'] = 0;
        }

        return $total;
    }

    function getExpensePerMonthThisYear()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                if (date('m', $q->date) == '01') {
                    $total['january'][] = $q->amount;
                }
                if (date('m', $q->date) == '02') {
                    $total['february'][] = $q->amount;
                }
                if (date('m', $q->date) == '03') {
                    $total['march'][] = $q->amount;
                }
                if (date('m', $q->date) == '04') {
                    $total['april'][] = $q->amount;
                }
                if (date('m', $q->date) == '05') {
                    $total['may'][] = $q->amount;
                }
                if (date('m', $q->date) == '06') {
                    $total['june'][] = $q->amount;
                }
                if (date('m', $q->date) == '07') {
                    $total['july'][] = $q->amount;
                }
                if (date('m', $q->date) == '08') {
                    $total['august'][] = $q->amount;
                }
                if (date('m', $q->date) == '09') {
                    $total['september'][] = $q->amount;
                }
                if (date('m', $q->date) == '10') {
                    $total['october'][] = $q->amount;
                }
                if (date('m', $q->date) == '11') {
                    $total['november'][] = $q->amount;
                }
                if (date('m', $q->date) == '12') {
                    $total['december'][] = $q->amount;
                }
            }
        }


        if (!empty($total['january'])) {
            $total['january'] = array_sum($total['january']);
        } else {
            $total['january'] = 0;
        }
        if (!empty($total['february'])) {
            $total['february'] = array_sum($total['february']);
        } else {
            $total['february'] = 0;
        }
        if (!empty($total['march'])) {
            $total['march'] = array_sum($total['march']);
        } else {
            $total['march'] = 0;
        }
        if (!empty($total['april'])) {
            $total['april'] = array_sum($total['april']);
        } else {
            $total['april'] = 0;
        }
        if (!empty($total['may'])) {
            $total['may'] = array_sum($total['may']);
        } else {
            $total['may'] = 0;
        }
        if (!empty($total['june'])) {
            $total['june'] = array_sum($total['june']);
        } else {
            $total['june'] = 0;
        }
        if (!empty($total['july'])) {
            $total['july'] = array_sum($total['july']);
        } else {
            $total['july'] = 0;
        }
        if (!empty($total['august'])) {
            $total['august'] = array_sum($total['august']);
        } else {
            $total['august'] = 0;
        }
        if (!empty($total['september'])) {
            $total['september'] = array_sum($total['september']);
        } else {
            $total['september'] = 0;
        }
        if (!empty($total['october'])) {
            $total['october'] = array_sum($total['october']);
        } else {
            $total['october'] = 0;
        }
        if (!empty($total['november'])) {
            $total['november'] = array_sum($total['november']);
        } else {
            $total['november'] = 0;
        }
        if (!empty($total['december'])) {
            $total['december'] = array_sum($total['december']);
        } else {
            $total['december'] = 0;
        }

        return $total;
    }

    function getOtPaymentByPatientId($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('ot_payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getOtPaymentByUserId($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('user', $id);
        $query = $this->db->get('ot_payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function insertDeposit($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('patient_deposit', $data2);
    }

    function getDeposit()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('patient_deposit');
        $deposits = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposits);
    }

    function updateDeposit($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('patient_deposit', $data);
    }

    function getDepositById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('patient_deposit');
        $deposit = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposit);
    }

    function getDepositByPatientId($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('patient_deposit');
        $deposits = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposits);
    }

    function getDepositByPatientIdByDate($id, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $id);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get('patient_deposit');
        $deposits = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposits);
    }

    function getDepositByUserId($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('user', $id);
        $query = $this->db->get('patient_deposit');
        $deposits = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposits);
    }

    function deleteDeposit($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('patient_deposit');
    }

    function deleteDepositByInvoiceId($id)
    {
        $this->db->where('payment_id', $id);
        $this->db->delete('patient_deposit');
    }
    function deleteLabByInvoiceId($id)
    {
        $this->db->where('invoice_id', $id);
        $this->db->delete('lab');
    }

    function getPaymentByPatientIdByStatus($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $query = $this->db->get('payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getOtPaymentByPatientIdByStatus($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $query = $this->db->get('ot_payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function updatePayment($id, $data)
    {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $this->db->update('payment', $data);
    }

    function insertOtPayment($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('ot_payment', $data2);
    }

    function getOtPayment()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('ot_payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getOtPaymentById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('ot_payment');
        $payment = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payment);
    }

    function updateOtPayment($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('ot_payment', $data);
    }

    function deleteOtPayment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ot_payment');
    }

    function insertPaymentCategory($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('payment_category', $data2);
    }

    function getPaymentCategory()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('payment_category');
        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }

    function getPaymentCategoryById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('payment_category');
        $category = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($category);
    }

    function getDoctorCommissionByCategory($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('payment_category');
        $category = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($category);
    }

    function updatePaymentCategory($id, $data)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $this->db->update('payment_category', $data);
    }

    function deletePayment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('payment');
    }

    function deletePaymentCategory($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('payment_category');
    }

    function insertExpense($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('expense', $data2);
    }

    function getExpense()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('expense');
        $expenses = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($expenses);
    }

    function getExpenseWithoutSearch($order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('expense');
        $expenses = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($expenses);
    }

    function getExpenseBySearch($search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
            ->from('expense')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR amount LIKE '%" . $search . "%' OR datestring LIKE '%" . $search . "%' OR category LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();
        $expenses = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($expenses);
    }

    function getExpenseByLimit($limit, $start, $order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('expense');
        $expenses = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($expenses);
    }

    function getExpenseByLimitBySearch($limit, $start, $search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
            ->from('expense')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR amount LIKE '%" . $search . "%' OR datestring LIKE '%" . $search . "%' OR category LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();
        $expenses = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($expenses);
    }

    function getExpenseById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('expense');
        $expense = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($expense);
    }

    function updateExpense($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('expense', $data);
    }

    function insertExpenseCategory($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('expense_category', $data2);
    }

    function getExpenseCategory()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('expense_category');
        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }

    function getExpenseCategoryById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('expense_category');
        $category = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($category);
    }

    function updateExpenseCategory($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('expense_category', $data);
    }

    function deleteExpense($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('expense');
    }

    function deleteExpenseCategory($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('expense_category');
    }

    function getDiscountType()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('settings');
        $settings = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($settings);
    }

    function getPaymentByDoctor($doctor)
    {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor);
        $query = $this->db->get();
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getDepositAmountByPaymentId($payment_id)
    {
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get();
        $total = array();
        $deposited_total = array();
        $total = $query->result();

        foreach ($total as $deposit) {
            $deposited_total[] = $deposit->deposited_amount;
        }

        if (!empty($deposited_total)) {
            $deposited_total = array_sum($deposited_total);
        } else {
            $deposited_total = 0;
        }

        return $deposited_total;
    }

    function getPaymentByDate($date_from, $date_to)
    {
       
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getPaymentByDoctorDate($doctor, $date_from, $date_to)
    {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getDepositByPaymentId($payment_id)
    {
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get();
        $total = array();
        $deposited_total = array();
        $total = $query->result();
        return $total;
    }

    function getOtPaymentByDate($date_from, $date_to)
    {
        $this->db->select('*');
        $this->db->from('ot_payment');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getDepositsByDate($date_from, $date_to)
    {
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $deposits = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposits);
    }

    function getExpenseByDate($date_from, $date_to)
    {
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $expenses = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($expenses);
    }
    function getDueCollectionByDate($date_from, $date_to)
    {
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $deposits = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposits);
    }
    function makeStatusPaid($id, $patient_id, $data, $data1)
    {
        $this->db->where('patient', $patient_id);
        $this->db->where('status', 'paid-last');
        $this->db->update('payment', $data);
        $this->db->where('id', $id);
        $this->db->update('payment', $data1);
    }

    function makePaidByPatientIdByStatus($id, $data, $data1)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $this->db->update('payment', $data1);

        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $this->db->update('ot_payment', $data1);

        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $this->db->update('payment', $data);

        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $this->db->update('ot_payment', $data);
    }

    function makeOtStatusPaid($id)
    {
        $this->db->where('id', $id);
        $this->db->update('ot_payment', array('status' => 'paid'));
    }

    function lastPaidInvoice($id)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $query = $this->db->get('payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function lastOtPaidInvoice($id)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $query = $this->db->get('ot_payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function amountReceived($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('payment', $data);
    }

    function otAmountReceived($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('ot_payment', $data);
    }
    function getThisMonthPayments(){
        $first_minute = mktime(0, 0, 0, date('m'), 1, date('y'));
        $last_minute = mktime(23, 59, 59, date('m'), date("t", $first_minute),date('y'));
       
        $payments_da = $this->getPaymentByDate($first_minute, $last_minute);
      
        $all_payments_da = array();
        foreach ($payments_da as $payment) {
            $date = date('D d-m-y', $payment->date);
            if (array_key_exists($date, $all_payments_da)) {
                $all_payments_da[$date] = $all_payments_da[$date] + $payment->gross_total;
            } else {
                $all_payments_da[$date] = $payment->gross_total;
            }
        }
        return $all_payments_da;
    } 
    function getThisMonthExpense(){
        $first_minute = mktime(0, 0, 0, date('m'), 1, date('y'));
        $last_minute = mktime(23, 59, 59, date('m'), date("t", $first_minute),date('y'));
       
        $expenses = $this->getExpenseByDate($first_minute, $last_minute);
        $all_expenses = array();
        foreach ($expenses as $expense) {
            $date = date('D d-m-y', $expense->date);
            if (array_key_exists($date, $all_expenses)) {
                $all_expenses[$date] = $all_expenses[$date] + $expense->amount;
            } else {
                $all_expenses[$date] = $expense->amount;
            }
        }
        return $all_expenses;
    }
    function getThisMonthDueCollection(){
        $first_minute = mktime(0, 0, 0, date('m'), 1, date('y'));
        $last_minute = mktime(23, 59, 59, date('m'), date("t", $first_minute),date('y'));
       
        $dues = $this->getDueCollectionByDate($first_minute, $last_minute);
       
        $all_collection = array();
        foreach ($dues as $due) {
            $date = date('D d-m-y', $due->date);
            if (array_key_exists($date, $all_collection)) {
                $all_collection[$date] = $all_collection[$date] + $due->deposited_amount;
            } else {
                $all_collection[$date] = $due->deposited_amount;
            }
        }
        
        return $all_collection;
    }
    function getThisMonth()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $payments = $this->db->get('payment')->result();
        $expenses = $this->db->get('expense')->result();
        $appointments = $this->db->get('appointment')->result();

        $this_month_payment = array_sum(array_column($payments, 'gross_total'));
        $this_month_expense = array_sum(array_column($expenses, 'amount'));
        $this_month_appointment = array_sum(array_column($appointments, '1'));

        $this_month_details = array($this_month_payment, $this_month_expense, $this_month_appointment);
        return $this_month_details;
    }

    function getPaymentByUserIdByDate($user, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('user', $user);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getOtPaymentByUserIdByDate($user, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->select('*');
        $this->db->from('ot_payment');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('user', $user);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getDepositByUserIdByDate($user, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('user', $user);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $deposits = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposits);
    }

    function getDueBalanceByPatientId($patient)
    {
        $query = $this->db->get_where('payment', array('patient' => $patient->id))->result();
        $deposits = $this->db->get_where('patient_deposit', array('patient' => $patient->id))->result();
        $balance = array();
        $deposit_balance = array();
        foreach ($query as $gross) {
            $balance[] = $gross->gross_total;
        }
        $balance = array_sum($balance);


        foreach ($deposits as $deposit) {
            $deposit_balance[] = $deposit->deposited_amount;
        }
        $deposit_balance = array_sum($deposit_balance);



        $bill_balance = $balance;

        return $due_balance = $bill_balance - $deposit_balance;
    }

    

    function getPaymentSummaryById($id) 
    {
        $query = $this->db->get_where('payment', array('id' => $id))->result();
        $deposits = $this->db->get_where('patient_deposit', array('payment_id' => $id))->result();

        foreach ($query as $gross) {
            $balance[] = $gross->gross_total;
        }
        foreach ($deposits as $deposit) {
            $deposit_balance[] = $deposit->deposited_amount;
        }

        if (!empty($balance)) {
            $data['total'] = array_sum($balance);
        } else {
            $data['total'] = 0;
        }
        if (!empty($deposit_balance)) {
            $data['paid'] = array_sum($deposit_balance);
        } else {
            $data['paid'] = 0;
        }

        $data['due'] = $data['total'] - $data['paid'];

        return $data;
    }






    function getFirstRowPaymentById()
    {

        //  $this->load->database();
        $last = $this->db->order_by('id', "asc")
            ->limit(1)
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->get('payment')
            ->row();
        return $last;
    }

    function getLastRowPaymentById()
    {

        // $this->load->database();
        $last = $this->db->order_by('id', "desc")
            ->limit(1)
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->get('payment')
            ->row();
        return $last;
    }

    function getPreviousPaymentById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
        $payment = $query->previous_row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payment);
    }

    function getNextPaymentById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
        $payment = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payment);
    }
    function getPaymentCategoryByNameSearch($attr)
    {
        return $this->db->where('hospital_id', $this->session->userdata('hospital_id'))->like('category', $attr)
            ->get('payment_category')->result();
    }
    function getCategoryById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        $category = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($category);
    }
    function deleteCategory($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('category');
    }
    function insertCategory($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('category', $data2);
    }
    function updateCategory($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('category', $data);
    }
    function getCategory()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('category');
        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    function getDepositByInvoiceId($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('payment_id', $id);
        $query = $this->db->get('patient_deposit');
        $deposits = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($deposits);
    }
    function insertDraftPayment($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('draft_payment', $data2);
    }

    function updateDraftPayment($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('draft_payment', $data);
    }
    function getDraftPaymentWitoutSearch($order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->get('draft_payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getDraftPaymentBySearch($search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
            ->from('draft_payment')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR amount LIKE '%" . $search . "%' OR gross_total LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%'OR patient_phone LIKE '%" . $search . "%'OR patient_address LIKE '%" . $search . "%'OR remarks LIKE '%" . $search . "%'OR doctor_name LIKE '%" . $search . "%'OR flat_discount LIKE '%" . $search . "%'OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }

    function getDraftPaymentByLimit($limit, $start, $order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('draft_payment');
        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }
    function getDraftPaymentByLimitBySearch($limit, $start, $search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
            ->from('draft_payment')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR amount LIKE '%" . $search . "%' OR gross_total LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%'OR patient_phone LIKE '%" . $search . "%'OR patient_address LIKE '%" . $search . "%'OR remarks LIKE '%" . $search . "%'OR doctor_name LIKE '%" . $search . "%'OR flat_discount LIKE '%" . $search . "%'OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        $payments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payments);
    }
    function getPaymentCategoryWithoutSearch($order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->get('payment_category');
        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    
    function getPaymentCategoryBySearch($search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
            ->from('payment_category')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%' OR type LIKE '%" . $search . "%'OR category LIKE '%" . $search . "%'OR payment_category_name LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    
    function getPaymentCategoryByLimitBySearch($limit, $start, $search, $order, $dir)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
            ->from('payment_category')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%' OR type LIKE '%" . $search . "%'OR category LIKE '%" . $search . "%'OR payment_category_name LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    
    function getPaymentCategoryByLimit($limit, $start, $order, $dir)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('payment_category');
        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    
    function getPaymentCategoryWithoutSearchByCategory($order, $dir, $filter_category)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->where('payment_category', $filter_category)->get('payment_category');
        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    
    function getPaymentCategoryBySearchByCategory($search, $order, $dir, $filter_category)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
            ->from('payment_category')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where('payment_category', $filter_category)
            ->where("(id LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%' OR type LIKE '%" . $search . "%'OR category LIKE '%" . $search . "%'OR payment_category_name LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    
    function getPaymentCategoryByLimitBySearchByCategory($limit, $start, $search, $order, $dir, $filter_category)
    {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
            ->from('payment_category')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where('payment_category', $filter_category)
            ->where("(id LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%' OR type LIKE '%" . $search . "%'OR category LIKE '%" . $search . "%'OR payment_category_name LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    
    function getPaymentCategoryByLimitByCategory($limit, $start, $order, $dir, $filter_category)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->where('payment_category', $filter_category)->get('payment_category');
        $categories = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($categories);
    }
    function getPaymentByAppointmentId($appointment_id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('appointment_id', $appointment_id);
        $query = $this->db->get('payment');
        $payment = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payment);
    }
    function lastRowByHospitalPayment(){
        $payment = $this->db->where('hospital_id', $this->session->userdata('hospital_id'))
                        ->order_by('id',"desc")->limit(1)->get('payment')->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payment);
    }

    function thisYearPaymentByCategory($catgory)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->where('payment_from',$catgory)->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                $total[] = $q->gross_total;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }
    function thismonthPaymentByCategory($catgory)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->where('payment_from',$catgory)->get('payment')->result();
        $total = array();
       
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                $total[] = $q->gross_total;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    // getPaymentBysearch and getPaymentBysearchByDate are defined earlier in this file
    // and have been updated to correctly decrypt patient data

    function getDraftPaymentById($id)
    {
        $payment = $this->db->where('id', $id)->get('draft_payment')->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($payment);
    }

    // Payment Procedure Template Management
    function insertPaymentProcedureTemplate($data)
    {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('payment_procedure_templates', $data2);
        return $this->db->insert_id();
    }

    function getPaymentProcedureTemplates()
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('is_active', 1);
        $this->db->order_by('template_name', 'asc');
        $query = $this->db->get('payment_procedure_templates');
        return $query->result();
    }

    function getPaymentProcedureTemplateById($id)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('payment_procedure_templates');
        return $query->row();
    }

    function updatePaymentProcedureTemplate($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->update('payment_procedure_templates', $data);
    }

    function deletePaymentProcedureTemplate($id)
    {
        $this->db->where('id', $id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->delete('payment_procedure_templates');
        
        // Also delete associated template fields
        $this->deletePaymentProcedureTemplateFields($id);
    }

    // Payment Procedure Template Fields Management
    function insertPaymentProcedureTemplateField($data)
    {
        $this->db->insert('payment_procedure_template_fields', $data);
        return $this->db->insert_id();
    }

    function getPaymentProcedureTemplateFields($template_id)
    {
        $this->db->where('template_id', $template_id);
        $this->db->order_by('field_order', 'asc');
        $query = $this->db->get('payment_procedure_template_fields');
        return $query->result();
    }

    function updatePaymentProcedureTemplateField($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('payment_procedure_template_fields', $data);
    }

    function deletePaymentProcedureTemplateField($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('payment_procedure_template_fields');
    }

    function deletePaymentProcedureTemplateFields($template_id)
    {
        $this->db->where('template_id', $template_id);
        $this->db->delete('payment_procedure_template_fields');
    }

    // Get templates by procedure type
    function getPaymentProcedureTemplatesByType($procedure_type)
    {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('procedure_type', $procedure_type);
        $this->db->where('is_active', 1);
        $this->db->order_by('template_name', 'asc');
        $query = $this->db->get('payment_procedure_templates');
        return $query->result();
    }

    // Search templates
    function searchPaymentProcedureTemplates($searchTerm)
    {
        if (!empty($searchTerm)) {
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('is_active', 1);
            $this->db->where("(template_name LIKE '%" . $searchTerm . "%' OR procedure_type LIKE '%" . $searchTerm . "%')");
            $fetched_records = $this->db->get('payment_procedure_templates');
            $templates = $fetched_records->result_array();
        } else {
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('is_active', 1);
            $this->db->limit(10);
            $fetched_records = $this->db->get('payment_procedure_templates');
            $templates = $fetched_records->result_array();
        }

        $data = array();
        foreach ($templates as $template) {
            $data[] = array(
                "id" => $template['id'],
                "text" => $template['template_name'] . ' (' . $template['procedure_type'] . ')',
                "template_name" => $template['template_name'],
                "procedure_type" => $template['procedure_type']
            );
        }
        return $data;
    }
}
