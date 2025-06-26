<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('db_encrypt');
    }

    /**
     * Helper method to safely decrypt department names
     * This handles both encrypted and plaintext values
     */
    private function safe_decrypt($value) {
        if (empty($value)) {
            return $value;
        }
        
        // Try to decrypt
        $decrypted = db_decrypt($value);
        
        // Log for debugging
        log_message('debug', 'Decryption attempt - Original: ' . substr($value, 0, 20) . '... Decrypted: ' . 
            ($decrypted === false ? 'FAILED' : substr($decrypted, 0, 20) . '...'));
        
        // If decryption fails or returns same value, it might not be encrypted
        // In that case, return the original value
        return $decrypted === false ? $value : $decrypted; 
    }

    function insertDepartment($data) {
        if (isset($data['name'])) {
            $data['name'] = db_encrypt($data['name']);
        }
        
        // Also encrypt the description
        if (isset($data['description'])) {
            $data['description'] = db_encrypt($data['description']);
        }
        
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id')); 
        $data2 = array_merge($data, $data1);
        $this->db->insert('department', $data2);
    }

    function getDepartment() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('department');
        $results = $query->result();
        
        foreach ($results as $result) {
            if (isset($result->name)) {
                $result->name = $this->safe_decrypt($result->name);
            }
            // Decrypt description
            if (isset($result->description)) {
                $result->description = $this->safe_decrypt($result->description);
            }
        }
        
        return $results;
    }

    function getDepartmentByName($name) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        
        // Try with encrypted name first
        $encrypted_name = db_encrypt($name);
        $this->db->where('name', $encrypted_name);
        
        $query = $this->db->get('department');
        
        // If no results, try with plaintext (for backward compatibility)
        if ($query->num_rows() == 0) {
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('name', $name);
            $query = $this->db->get('department');
        }
        
        $result = $query->row();
        
        // Decrypt the name in the result
        if ($result && isset($result->name)) {
            $result->name = $this->safe_decrypt($result->name);
        }
        
        // Decrypt the description
        if ($result && isset($result->description)) {
            $result->description = $this->safe_decrypt($result->description);
        }
        
        return $result;
    }

    function getDepartmentById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('department');
        $result = $query->row();
        
        // Decrypt the name in the result
        if ($result && isset($result->name)) {
            $result->name = $this->safe_decrypt($result->name);
        }
        
        // Decrypt the description
        if ($result && isset($result->description)) {
            $result->description = $this->safe_decrypt($result->description);
        }
        
        return $result;
    }

    function updateDepartment($id, $data) {
        if (isset($data['name'])) {
            $data['name'] = db_encrypt($data['name']);
        }
        
        // Also encrypt the description
        if (isset($data['description'])) {
            $data['description'] = db_encrypt($data['description']);
        }
        
        $this->db->where('id', $id);
        $this->db->update('department', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('department');
    }

}
