<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appointment_model extends CI_model {

    // List of fields that should be encrypted
    public $encrypted_fields = array(
        'remarks',
        'status',
        'patient_name',
        'patient_phone',
        'patient_address'
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

    function insertAppointment($data) {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('appointment', $data2);
    }

    function getAppointment() {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getAppointmentWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentByLimit($limit, $start, $order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentForCalendar() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentByDoctor($doctor) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentRequest() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('request', 'Yes');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentRequestByDoctor($doctor) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('request', 'Yes');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentByPatient($patient) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $patient);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentByStatus($status) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('status', $status);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentByStatusByDoctor($status, $doctor) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('status', $status);
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('appointment');
        $appointment = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointment);
    }

    function getAppointmentByDate($date_from, $date_to) {
        $this->db->select('*');
        $this->db->from('appointment');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentByDoctorByToday($doctor_id) {
        $today = strtotime(date('Y-m-d'));
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor_id);
        $this->db->where('date', $today);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function updateAppointment($id, $data) {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $this->db->where('id', $id);
        $this->db->update('appointment', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('appointment');
    }

    function updateIonUser($username, $email, $password, $ion_user_id) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }

    function getRequestAppointment() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Requested');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getRequestAppointmentWithoutSearch($order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('status', 'Requested');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getRequestAppointmentBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Requested')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getRequestAppointmentByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Requested');
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getRequestAppointmentByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Requested')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getPendingAppointment() {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Pending Confirmation');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getPendingAppointmentWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Pending Confirmation');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getPendingAppointmentByDoctorWithoutSearch($doctor, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Pending Confirmation');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getPendingAppointmentBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Pending Confirmation')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getPendingAppointmentByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Pending Confirmation');
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getPendingAppointmentByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Pending Confirmation')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getConfirmedAppointment() {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Confirmed');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getConfirmedAppointmentWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Confirmed');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getConfirmedAppointmentBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Confirmed')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getConfirmedAppointmentByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Confirmed');
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getConfirmedAppointmentByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Confirmed')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getTreatedAppointment() {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Treated');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getTreatedAppointmentWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Treated');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getTreatedAppointmentBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Treated')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getTreatedAppointmentByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Treated');
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getTreatedAppointmentByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Treated')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getCancelledAppointment() {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Cancelled');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getCancelledAppointmentWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Cancelled');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getCancelledAppointmentBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Cancelled')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getCancelledAppointmentByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Cancelled');
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getCancelledAppointmentByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('status', 'Cancelled')
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentListByDoctor($doctor) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getAppointmentListByDoctorWithoutSearch($doctor, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentListBySearchByDoctor($doctor, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentListByLimitByDoctor($doctor, $limit, $start, $order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctor);
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentListByLimitBySearchByDoctor($doctor, $limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getRequestAppointmentByDoctor($doctor) {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Requested');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getRequestAppointmentByDoctorWithoutSearch($doctor, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Requested');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getRequestAppointmentBySearchByDoctor($doctor, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Requested')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getRequestAppointmentByLimitByDoctor($doctor, $limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Requested');
        $this->db->where('doctor', $doctor);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getRequestAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Requested')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getCancelledAppointmentByDoctor($doctor) {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Cancelled');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getCancelledAppointmentByDoctorWithoutSearch($doctor, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Cancelled');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getCancelledAppointmentBySearchByDoctor($doctor, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Cancelled')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getCancelledAppointmentByLimitByDoctor($doctor, $limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Cancelled');
        $this->db->where('doctor', $doctor);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getCancelledAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Cancelled')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getPendingAppointmentByDoctor($doctor, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Pending Confirmation');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getPendingAppointmentBySearchByDoctor($doctor, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Pending Confirmation')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getPendingAppointmentByLimitByDoctor($doctor, $limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Pending Confirmation');
        $this->db->where('doctor', $doctor);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getPendingAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Pending Confirmation')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getTreatedAppointmentByDoctor($doctor) {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Treated');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getTreatedAppointmentByDoctorWithoutSearch($doctor, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Treated');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getTreatedAppointmentBySearchByDoctor($doctor, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Treated')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getTreatedAppointmentByLimitByDoctor($doctor, $limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Treated');
        $this->db->where('doctor', $doctor);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getTreatedAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Treated')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getConfirmedAppointmentByDoctor($doctor) {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Confirmed');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }
    
    function getConfirmedAppointmentByDoctorWithoutSearch($doctor, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Confirmed');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getConfirmedAppointmentBySearchByDoctor($doctor, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Confirmed')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getConfirmedAppointmentByLimitByDoctor($doctor, $limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'Confirmed');
        $this->db->where('doctor', $doctor);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getConfirmedAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Confirmed')
                ->where('doctor', $doctor)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

    function getAppointmentByPatientByDate($patient, $date) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $patient);
        $this->db->where('date', $date);
        $query = $this->db->get('appointment');
        $appointments = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($appointments);
    }

}
