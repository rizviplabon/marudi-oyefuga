<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prescription_model extends CI_model {

    // List of fields that should be encrypted
    public $encrypted_fields = array(
        'symptom',
        'diagnosis',
        'medicine',
        'note'
    );

    function __construct() {
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
        
        // If it's a single object
        if (is_object($data)) {
            foreach ($this->encrypted_fields as $field) {
                if (isset($data->$field)) {
                    $data->$field = $this->safe_decrypt($data->$field);
                }
            }
            return $data;
        }
        
        // If it's an array of objects
        foreach ($data as $key => $obj) {
            if (is_object($obj)) {
                foreach ($this->encrypted_fields as $field) {
                    if (isset($obj->$field)) {
                        $obj->$field = $this->safe_decrypt($obj->$field);
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

    function insertPrescription($data) {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('prescription', $data2);
    }

    function getPrescription() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('prescription');
        $prescription = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescription);
    }

    function getPrescriptionByPatientId($patient_id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $patient_id);
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionByDoctorId($doctor_id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor_id);
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function updatePrescription($id, $data) {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $this->db->where('id', $id);
        $this->db->update('prescription', $data);
    }

    function deletePrescription($id) {
        $this->db->where('id', $id);
        $this->db->delete('prescription');
    }
    
    function getPrescriptionWithoutSearch($order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('prescription')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionByLimit($limit, $start, $order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('prescription')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionByDoctor($doctor_id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor_id);
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }
    
    function getPrescriptionByDoctorWithoutSearch($doctor_id, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor_id);
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionBySearchByDoctor($doctor, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('prescription')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionByLimitByDoctor($doctor, $limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor);
        $this->db->limit($limit, $start);
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

    function getPrescriptionByLimitBySearchByDoctor($doctor, $limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('prescription')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $prescriptions = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($prescriptions);
    }

}
