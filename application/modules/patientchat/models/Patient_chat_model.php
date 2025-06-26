<?php

class Patient_chat_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('db_encrypt'); // Load encryption helper
        $this->load->model('patient/patient_model'); // Load patient model for decryption
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
    
    public function getPatientName($patient_id) {
        $this->db->where('id', $patient_id);
        $patient = $this->db->get('patient')->row();
        if (!$patient) {
            return 'Unknown Patient';
        }
        
        // Decrypt the patient name
        $patient_name = $this->safe_decrypt($patient->name);
        
        return $patient_name;
    }
    
    public function getReceptionistName($receptionist_id) {
        $this->db->where('id', $receptionist_id);
        $receptionist = $this->db->get('receptionist')->row();
        if (!$receptionist) {
            return 'Unknown Receptionist';
        }
        return $receptionist->name; // Receptionist names are not encrypted
    }
    
    public function getPatientChats($patient_id, $receptionist_id, $limit = 20, $offset = 0) {
        try {
            $this->db->order_by('date_time', 'desc');
            $this->db->limit($limit, $offset);
            $this->db->where('patient_id', $patient_id);
            $this->db->where('receptionist_id', $receptionist_id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $result = $this->db->get('patient_chat');
            
            if ($result) {
                return $result->result_array();
            } else {
                return array();
            }
        } catch (Exception $e) {
            log_message('error', 'Error in getPatientChats: ' . $e->getMessage());
            return array();
        }
    }
    
    public function getUnreadChats($receiver_id, $receiver_type) {
        if ($receiver_type == 'patient') {
            $this->db->where('patient_id', $receiver_id);
            $this->db->where('sender_type', 'receptionist');
        } else {
            $this->db->where('receptionist_id', $receiver_id);
            $this->db->where('sender_type', 'patient');
        }
        $this->db->where('status', 'unread');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        return $this->db->get('patient_chat')->result_array();
    }
    
    public function markAsRead($chat_id) {
        $data = array(
            'status' => 'read'
        );
        $this->db->where('id', $chat_id);
        $this->db->update('patient_chat', $data);
        return true;
    }
    
    public function addMessage($data) {
        try {
            // Ensure hospital_id is set
            if (!isset($data['hospital_id']) || empty($data['hospital_id'])) {
                $data['hospital_id'] = $this->session->userdata('hospital_id');
            }
            
            // Log the data being inserted for debugging
            log_message('debug', 'Adding chat message: ' . print_r($data, true));
            
            // Try to insert the message
            $this->db->insert('patient_chat', $data);
            
            // Get the insert ID
            $insert_id = $this->db->insert_id();
            
            if (!$insert_id) {
                log_message('error', 'Failed to insert message: ' . $this->db->_error_message());
            }
            
            return $insert_id;
        } catch (Exception $e) {
            log_message('error', 'Error in addMessage: ' . $e->getMessage());
            return false;
        }
    }
    
    // Get all patients that have chatted with a receptionist
    public function getPatientsWithChats($receptionist_id) {
        $this->db->distinct();
        $this->db->select('patient_id');
        $this->db->where('receptionist_id', $receptionist_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('patient_chat');
        
        $patients = array();
        foreach ($query->result_array() as $row) {
            $patient_id = $row['patient_id'];
            $patient = $this->db->get_where('patient', array('id' => $patient_id))->row();
            if ($patient) {
                // Decrypt patient name
                $patient_name = $this->safe_decrypt($patient->name);
                
                $patients[] = array(
                    'id' => $patient_id,
                    'name' => $patient_name,
                    'id_new' => isset($patient->id_new) ? $patient->id_new : $patient_id,
                    'has_unread' => $this->hasUnreadMessages($patient_id, $receptionist_id, 'receptionist')
                );
            }
        }
        
        return $patients;
    }
    
    // Get all receptionists that have chatted with a patient
    public function getReceptionistsWithChats($patient_id) {
        $this->db->distinct();
        $this->db->select('receptionist_id');
        $this->db->where('patient_id', $patient_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('patient_chat');
        
        $receptionists = array();
        foreach ($query->result_array() as $row) {
            $receptionist_id = $row['receptionist_id'];
            $receptionist = $this->db->get_where('receptionist', array('id' => $receptionist_id))->row();
            if ($receptionist) {
                $receptionists[] = array(
                    'id' => $receptionist_id,
                    'name' => $receptionist->name,
                    'has_unread' => $this->hasUnreadMessages($patient_id, $receptionist_id, 'patient')
                );
            }
        }
        
        return $receptionists;
    }
    
    public function hasUnreadMessages($patient_id, $receptionist_id, $for_user_type) {
        $this->db->where('patient_id', $patient_id);
        $this->db->where('receptionist_id', $receptionist_id);
        
        if ($for_user_type == 'patient') {
            $this->db->where('sender_type', 'receptionist');
        } else {
            $this->db->where('sender_type', 'patient');
        }
        
        $this->db->where('status', 'unread');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('patient_chat');
        
        return ($query->num_rows() > 0);
    }
    
    // For receptionists to see list of available patients
    public function getAllPatients() {
        try {
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $result = $this->db->get('patient');
            
            if ($result) {
                $patients = $result->result_array();
                
                // Decrypt patient names
                foreach ($patients as &$patient) {
                    if (isset($patient['name'])) {
                        $patient['name'] = $this->safe_decrypt($patient['name']);
                    }
                }
                
                return $patients;
            } else {
                return array();
            }
        } catch (Exception $e) {
            log_message('error', 'Error in getAllPatients: ' . $e->getMessage());
            return array();
        }
    }
    
    // For patients to see list of available receptionists
    public function getAllReceptionists() {
        try {
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $result = $this->db->get('receptionist');
            
            if ($result) {
                return $result->result_array();
            } else {
                return array();
            }
        } catch (Exception $e) {
            log_message('error', 'Error in getAllReceptionists: ' . $e->getMessage());
            return array();
        }
    }
} 