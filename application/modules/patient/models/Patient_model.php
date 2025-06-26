<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient_model extends MY_Model {

    // List of fields that should be encrypted
    public $encrypted_fields = array(
        'name',
        'phone',
        'address',
        'birthdate',
        'bloodgroup',
        'sex',
        'add_date',
        'registration_time', 
        'social_history',
        'family_history',
        'medical_history',
        'other_history',
        'id_number'
    );

    function __construct() {
        parent::__construct();
        $this->table = 'patient';
        // $this->primary_key = 'id';
        $this->load->helper('db_encrypt');
    }

    /**
     * Safe decrypt method to handle both encrypted and plaintext values
     */
    public function safe_decrypt($value) {
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
    function decrypt_fields($data) {
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

    function insertPatient($data) {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('patient', $data2);
    }

    function getPatient() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('patient');
        $patients = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($patients);
    }

    function getLimit() {
        $current = $this->db->get_where('patient', array('hospital_id' => $this->session->userdata('hospital_id')))->num_rows();
        $limit = $this->db->get_where('hospital', array('id' => $this->session->userdata('hospital_id')))->row()->p_limit;
        if (!is_numeric($limit)) {
            $limit = 0;
        }
        return $limit - $current;
    }

    function getPatientWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('patient');
        $patients = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($patients);
    }

    function getPatientBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        // Since we're searching on encrypted fields, we need to get all records and filter after decryption
        $query = $this->db->select('*')
                ->from('patient')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->get();
        
        $results = $query->result();
        $decrypted_results = $this->decrypt_fields($results);
        
        // Filter the decrypted results
        return array_filter($decrypted_results, function($item) use ($search) {
            return (
                stripos($item->id, $search) !== false ||
                stripos($item->name, $search) !== false ||
                stripos($item->id_new, $search) !== false ||
                stripos($item->phone, $search) !== false ||
                stripos($item->address, $search) !== false
            );
        });
    }

    function getPatientByLimit($limit, $start, $order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('patient');
        $patients = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($patients);
    }

    function getPatientByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('patient')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR id_new LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        
        $patients = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($patients);
    }

    function getPatientById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('patient');
        $patient = $query->row();
        
        // Decrypt sensitive fields
        $patient = $this->decrypt_fields($patient);
        
        // Prepare image URL (Google Drive or local)
        return $this->preparePatientImageUrl($patient);
    }

    function getPatientByIonUserId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('ion_user_id', $id);
        $query = $this->db->get('patient');
        $patient = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($patient); 
    }

    function getPatientByEmail($email) { 
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('email', $email);
        $query = $this->db->get('patient');
        $patient = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($patient);
    }

    function updatePatient($id, $data) {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $this->db->where('id', $id);
        $this->db->update('patient', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('patient');
    }

    function insertMedicalHistory($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('medical_history', $data2);
    }

    function getMedicalHistoryByPatientId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient_id', $id);
        $query = $this->db->get('medical_history');
        return $query->result();
    }

    function getMedicalHistory() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('medical_history');
        return $query->result();
    }

    function getMedicalHistoryBySearch($search) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')
                ->from('medical_history')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        ;
        return $query->result();
    }

    function getMedicalHistoryByLimit($limit, $start) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('medical_history');
        return $query->result();
    }

    function getMedicalHistoryByLimitBySearch($limit, $start, $search) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('medical_history')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        ;
        return $query->result();
    }

    function getMedicalHistoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('medical_history');
        return $query->row();
    }

    function updateMedicalHistory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('medical_history', $data);
    }

    function insertDiagnosticReport($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('diagnostic_report', $data2);
    }

    function updateDiagnosticReport($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('diagnostic_report', $data);
    }

    function getDiagnosticReport() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('diagnostic_report');
        return $query->result();
    }

    function getDiagnosticReportById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('diagnostic_report');
        return $query->row();
    }

    function getDiagnosticReportByInvoiceId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('invoice', $id);
        $query = $this->db->get('diagnostic_report');
        return $query->row();
    }

    function getDiagnosticReportByPatientId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $id);
        $query = $this->db->get('diagnostic_report');
        return $query->result();
    }

    function insertPatientMaterial($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('patient_material', $data2);
    }

    function getPatientMaterial() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function getPatientMaterialWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function getDocumentBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('patient_material')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%' OR title LIKE '%" . $search . "%' OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        ;
        return $query->result();
    }

    function getDocumentByLimit($limit, $start, $order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function getDocumentByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('patient_material')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%' OR title LIKE '%" . $search . "%' OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        ;
        return $query->result();
    }

    function getPatientMaterialById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('patient_material');
        return $query->row();
    }

    function getPatientMaterialByPatientId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $id);
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function deletePatientMaterial($id) {
        $this->db->where('id', $id);
        $this->db->delete('patient_material');
    }

    function deleteMedicalHistory($id) {
        $this->db->where('id', $id);
        $this->db->delete('medical_history');
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

    function getDueBalanceByPatientId($patient) {
        $query = $this->db->get_where('payment', array('patient' => $patient))->result();
        $deposits = $this->db->get_where('patient_deposit', array('patient' => $patient))->result();
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

    function getPatientInfoId($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
            $decrypted_users = $this->decrypt_fields($users);
            
            // Filter after decryption
            $users = array_filter($decrypted_users, function($user) use ($searchTerm) {
                return (
                    stripos($user['name'], $searchTerm) !== false ||
                    stripos($user['id'], $searchTerm) !== false ||
                    stripos($user['phone'], $searchTerm) !== false
                );
            });
        } else {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->limit(10);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            if(empty($user['age'])){
                $dateOfBirth = $user['birthdate'];
                if(empty($dateOfBirth)){
                    $age[0]='0';
                }else{
                    if(strtotime($dateOfBirth)){
                        $today = date("Y-m-d");
                        $diff = date_diff(date_create($dateOfBirth), date_create($today));
                        $age[0]=$diff->format('%y');
                    }else{
                        $age[0]='';
                    }
                }
            }else{
                $age=explode('-',$user['age']);
            }
            
            // Directly decrypt fields for display
            $decrypted_name = $this->safe_decrypt($user['name']);
            $decrypted_phone = $this->safe_decrypt($user['phone']);
            
            $data[] = array("id" => $user['id'], "text" => $decrypted_name . ' (' . lang('id') . ': ' . $user['id_new'] . '- '.lang('phone'). ': '.$decrypted_phone.'- '.lang('age').': '.$age[0].' years )');
        }
        return $data;
    }
    function getPatientInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where("name like '%" . $searchTerm . "%' OR id like '%" . $searchTerm . "%' OR phone like '%" . $searchTerm . "%'");
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->limit(10);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            if(empty($user['age'])){
                $dateOfBirth = $user['birthdate'];
                if(empty($dateOfBirth)){
                    $age[0]='0';
                }else{
                    if(strtotime($dateOfBirth)){
                        $today = date("Y-m-d");
                        $diff = date_diff(date_create($dateOfBirth), date_create($today));
                        $age[0]=$diff->format('%y');
                    }else{
                        $age[0]='';
                    }
                }
                
            }else{
                $age=explode('-',$user['age']);
            }
            
            // Decrypt sensitive fields
            $decrypted_name = $this->safe_decrypt($user['name']);
            $decrypted_phone = $this->safe_decrypt($user['phone']);
            
            $data[] = array("id" => $user['id'], "text" => $decrypted_name . ' (' . lang('id') . ': ' . $user['id_new'] . '- '.lang('phone'). ': '.$decrypted_phone.'- '.lang('age').': '.$age[0].' years )');
        }
        return $data;
    }

    function getPatientinfoWithAddNewOption($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where("name like '%" . $searchTerm . "%' OR id like '%" . $searchTerm . "%' OR phone like '%" . $searchTerm . "%'");
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->limit(10);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
           
            if(empty($user['age'])){
                $dateOfBirth = $user['birthdate'];
                if(empty($dateOfBirth)){
                    $age[0]='0';
                }else{
                    if(strtotime($dateOfBirth)){
                        $today = date("Y-m-d");
                        $diff = date_diff(date_create($dateOfBirth), date_create($today));
                        $age[0]=$diff->format('%y');
                    }else{
                        $age[0]='';
                    }
                }
                
            }else{
                $age=explode('-',$user['age']);
            }
            
            // Decrypt sensitive fields
            $decrypted_name = $this->safe_decrypt($user['name']);
            $decrypted_phone = $this->safe_decrypt($user['phone']);
            
            $data[] = array("id" => $user['id'], "text" => $decrypted_name . ' (' . lang('id') . ': ' . $user['id_new'] . ' - '.lang('phone'). ': '.$decrypted_phone.' - '.lang('age').': '.$age[0]. ' '.lang('years').')');
        }
        return $data;
    }

    function insertFolder($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('folder', $data2);
    }

    function getFolder() {
        $this->db->order_by('id', 'desc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('folder');
        return $query->result();
    }

    function getFolderById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('folder');
        return $query->row();
    }

    function updateFolder($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('folder', $data);
    }

    function getFolderByPatientId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient', $id);
        $query = $this->db->get('folder');
        return $query->result();
    }

    function getPatientMaterialByFolderId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('folder', $id);
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function deleteFolder($id) {

        $this->db->where(array('id' => $id));
        $this->db->delete('folder');
    }

    function deletePatientMaterialByFolderId($id) {
        $this->db->where('folder' , $id);   
        $this->db->delete('patient_material');
    }

    public function deleteImage($con) {
        // Delete image data 
        $delete = $this->db->delete($this->imgTbl, $con);

        // Return the status 
        return $delete ? true : false;
    }

    function getPatientMaterialByyPatientId($patient_id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $patient_id);
        $query = $this->db->get('patient_material');
        return $query->result();
    }
    function insertVitalSign($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('vital_signs', $data2);
    }
    function updateVitalSign($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('vital_signs', $data);
    }
    function getVitalSignByPatientId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient_id', $id);
        $query = $this->db->get('vital_signs');
        return $query->result();
    }
    function getVitalsByPatientId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('patient_id', $id);
        $query = $this->db->get('vital_signs');
        return $query->row();
    }
    function getVitalSignById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('vital_signs');
        return $query->row();
    }
    function deleteVitalSign($id) {
        $this->db->where('id', $id);
        $this->db->delete('vital_signs');
    } 
    function getOdontogram($pid) {
        $this->db->where('patient_id',$pid);
        $query = $this->db->get('odontogram')->row();
        
        if(!empty($query)) {
          return $query;
        } else {
            $value = array('patient_id' => $pid, 'Tooth1' => 'white', 'Tooth2' => 'white', 'Tooth3' => 'white', 
                'Tooth4' => 'white', 'Tooth5' => 'white', 'Tooth6' => 'white', 'Tooth7' => 'white', 'Tooth8' => 'white', 'Tooth1' => 'white', 
                'Tooth9' => 'white', 'Tooth10' => 'white', 'Tooth11' => 'white', 'Tooth12' => 'white', 
                'Tooth13' => 'white', 'Tooth14' => 'white', 'Tooth15' => 'white', 'Tooth16' => 'white', 'Tooth17' => 'white', 
                'Tooth18' => 'white', 'Tooth19' => 'white', 'Tooth20' => 'white', 
                'Tooth21' => 'white', 'Tooth22' => 'white', 'Tooth23' => 'white', 'Tooth24' => 'white',
                'Tooth25' => 'white', 'Tooth26' => 'white', 'Tooth27' => 'white', 'Tooth28' => 'white',
                'Tooth29' => 'white', 'Tooth30' => 'white', 'Tooth31' => 'white', 'Tooth32' => 'white',
                'description' => ''
            );
            $this->db->insert('odontogram',$value);
            $this->db->where('patient_id',$pid);
            $query = $this->db->get('odontogram')->row();
            return $query;
        }
    }
    function odontogram($pid,$value) {
        $this->db->where('patient_id',$pid);
        $this->db->update('odontogram',$value);
    }
    public function getConversationHistory($session_id)
    {
        // Ensure that $session_id is safe to use in a query
        $session_id = $this->session->userdata('hospital_id') . '-case-' . $this->db->escape_str($session_id);

        // Query the database for the history using the session ID
        $this->db->select('history');
        $this->db->from('gpt_memory');
        $this->db->where('session_id', $session_id);
        $query = $this->db->get();

        // Check if a history was found
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return json_decode($row['history'], true); // Return the history as a PHP array
        } else {
            return []; // Return an empty array if no history was found
        }
    }

    /**
     * Check if the image is stored on Google Drive
     * 
     * @param string $img_url The image URL or path
     * @return boolean True if the image is stored on Google Drive
     */
    function isGoogleDriveImage($img_url) {
        // If empty, it's not a Google Drive image
        if (empty($img_url)) {
            return false;
        }
        
        // Check if the URL is a Google Drive URL
        return (strpos($img_url, 'drive.google.com') !== false);
    }

    /**
     * Get a Google Drive image public URL from the database field
     * 
     * @param object $patient The patient object
     * @return object Updated patient object with adjusted img_url
     */
    function preparePatientImageUrl($patient) {
        if (empty($patient)) {
            return $patient;
        }
        
        // If this is an array of patients
        if (is_array($patient)) {
            foreach ($patient as $key => $single_patient) {
                $patient[$key] = $this->preparePatientImageUrl($single_patient);
            }
            return $patient;
        }
        
        // If this is a single patient
        if (empty($patient->img_url)) {
            return $patient;
        }
        
        // Check if this is a Google Drive image
        if ($this->isGoogleDriveImage($patient->img_url)) {
            // It's already a Google Drive URL, no need to modify
            $patient->is_google_drive = true;
        } else {
            // It's a local path
            $patient->is_google_drive = false;
        }
        
        return $patient;
    }

    /**
     * Get patient by ID with guaranteed decrypted data
     */
    function getDecryptedPatientById($id) {
        $this->db->where('id', $id);
        $patient = $this->db->get('patient')->row();
        
        if (!$patient) {
            return null;
        }
        
        // Ensure all sensitive fields are decrypted
        if (isset($patient->name)) {
            $patient->name = $this->safe_decrypt($patient->name);
        }
        
        if (isset($patient->phone)) {
            $patient->phone = $this->safe_decrypt($patient->phone);
        }
        
        if (isset($patient->address)) {
            $patient->address = $this->safe_decrypt($patient->address);
        }
        
        if (isset($patient->email)) {
            $patient->email = $this->safe_decrypt($patient->email);
        }
        
        // Log successful decryption
        log_message('debug', 'Successfully decrypted patient data for ID: ' . $id);
        
        return $patient;
    }


    function getAvaiablePatietListforBedAllotment($searchTerm)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where("name like '%" . $searchTerm . "%' OR hospital_patient_id like '%" . $searchTerm . "%' OR id like '%" . $searchTerm . "%' OR phone like '%" . $searchTerm . "%'");
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->limit(10);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $this->db->select('*');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $bed_allotments = $this->db->get('alloted_bed')->result();
        $alloted_patients = array();
        foreach ($bed_allotments as $allotment) {
            if (empty($allotment->d_timestamp) && !empty($allotment->a_timestamp)) {
                $alloted_patients[] = $allotment->patient;
            } elseif ($allotment->d_timestamp > time()) {
                $alloted_patients[] = $allotment->patient;
            }
        }

        $data = array();
        foreach ($users as $user) {
            if (!in_array($user['id'], $alloted_patients)) {
                if (empty($user['age'])) {
                    $dateOfBirth = $user['birthdate'];
                    if (empty($dateOfBirth)) {
                        $age[0] = '0';
                    } else {
                        $today = date("Y-m-d");
                        $diff = date_diff(date_create($dateOfBirth), date_create($today));
                        $age[0] = $diff->format('%y');
                    }
                } else {
                    $age = explode('-', $user['age']);
                }
                $decrypted_name = $this->safe_decrypt($user['name']);
                $decrypted_phone = $this->safe_decrypt($user['phone']);
                $data[] = array("id" => $user['id'], "text" => $decrypted_name . ' (' . lang('id') . ': ' . $user['id_new'] . '- ' . lang('phone') . ': ' . $decrypted_phone . '- ' . lang('age') . ': ' . $age[0] . ' years )');
            }
        }
                 return $data;
    }

    /**
     * Get patients that can be guardians/primary contacts
     * Rules: 
     * - Patient must not have a guardian themselves (cannot be both guardian and dependent)
     * - Patient can have multiple dependents (guardians can have multiple dependents)
     * Used to populate the guardian dropdown in patient registration
     */
    function getAvailableParentPatients($exclude_patient_id = null, $search_term = null) {
        $this->db->select('id, name, phone, id_new');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('parent_patient_id IS NULL', null, false); // Only patients without guardians
        
        if ($exclude_patient_id) {
            $this->db->where('id !=', $exclude_patient_id);
        }
        
        $this->db->order_by('name', 'asc');
        
        // Limit results for performance (Select2 will load more as needed)
        if (empty($search_term)) {
            $this->db->limit(20); // Initial load limit
        } else {
            $this->db->limit(50); // Search results limit
        }
        
        $query = $this->db->get('patient');
        $patients = $query->result();
        
        // Decrypt fields - we already filtered out patients with guardians in the SQL query
        // A patient can be a guardian to multiple dependents, so we don't exclude based on hasChildren
        $available_parents = array();
        foreach ($patients as $patient) {
            $patient->name = $this->safe_decrypt($patient->name);
            $patient->phone = $this->safe_decrypt($patient->phone);
            
            // Apply search filter after decryption
            if (!empty($search_term)) {
                $search_term_lower = strtolower($search_term);
                $name_match = strpos(strtolower($patient->name), $search_term_lower) !== false;
                $phone_match = strpos($patient->phone, $search_term) !== false;
                $id_match = strpos($patient->id_new, $search_term) !== false;
                
                if (!($name_match || $phone_match || $id_match)) {
                    continue; // Skip this patient if no match
                }
            }
            
            $available_parents[] = $patient;
        }
        
        return $available_parents;
    }
    
    /**
     * Check if a patient has children
     */
    function hasChildren($patient_id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('parent_patient_id', $patient_id);
        $count = $this->db->count_all_results('patient');
        return $count > 0;
    }
    
    /**
     * Get children of a patient
     */
    function getChildrenPatients($parent_patient_id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('parent_patient_id', $parent_patient_id);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('patient');
        $children = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($children);
    }
    
    /**
     * Get parent of a patient
     */
    function getParentPatient($patient_id) {
        $this->db->select('p1.*, p2.name as parent_name, p2.phone as parent_phone, p2.id_new as parent_id_new');
        $this->db->from('patient p1');
        $this->db->join('patient p2', 'p1.parent_patient_id = p2.id', 'left');
        $this->db->where('p1.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('p1.id', $patient_id);
        
        $query = $this->db->get();
        $result = $query->row();
        
        if ($result && $result->parent_patient_id) {
            // Decrypt parent fields
            $result->parent_name = $this->safe_decrypt($result->parent_name);
            $result->parent_phone = $this->safe_decrypt($result->parent_phone);
        }
        
        return $result;
    }
    
    /**
     * Validate guardian-dependent relationship rules
     * Returns array with 'valid' boolean and 'message' string
     */
    function validateParentChildRelationship($patient_id, $parent_patient_id) {
        // If no guardian selected, it's valid
        if (empty($parent_patient_id)) {
            return array('valid' => true, 'message' => '');
        }
        
        // Patient cannot be their own guardian
        if ($patient_id == $parent_patient_id) {
            return array('valid' => false, 'message' => 'Patient cannot be their own guardian');
        }
        
        // Check if the proposed guardian exists and belongs to same hospital
        $this->db->where('id', $parent_patient_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $parent = $this->db->get('patient')->row();
        
        if (!$parent) {
            return array('valid' => false, 'message' => 'Selected guardian patient does not exist');
        }
        
        // Check if the proposed guardian already has a guardian (would create invalid hierarchy)
        if (!empty($parent->parent_patient_id)) {
            return array('valid' => false, 'message' => 'Selected patient already has a guardian and cannot be a guardian to another patient');
        }
        
        // For existing patients being updated - check if they have dependents
        // A patient who has dependents cannot become a dependent themselves
        if (!empty($patient_id) && $this->hasChildren($patient_id)) {
            return array('valid' => false, 'message' => 'Patient has dependents and cannot be assigned a guardian');
        }
        
        // Check for circular reference (if patient_id would become ancestor of parent_patient_id)
        if ($this->wouldCreateCircularReference($patient_id, $parent_patient_id)) {
            return array('valid' => false, 'message' => 'This relationship would create a circular reference');
        }
        
        return array('valid' => true, 'message' => '');
    }
    
    /**
     * Check if assigning parent would create circular reference
     */
    private function wouldCreateCircularReference($patient_id, $parent_patient_id) {
        // For new patients, no circular reference possible
        if (empty($patient_id)) {
            return false;
        }
        
        // Check if parent_patient_id is a descendant of patient_id
        return $this->isDescendantOf($parent_patient_id, $patient_id);
    }
    
    /**
     * Check if patient A is a descendant of patient B
     */
    private function isDescendantOf($patient_a_id, $patient_b_id) {
        $this->db->where('parent_patient_id', $patient_b_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $children = $this->db->get('patient')->result();
        
        foreach ($children as $child) {
            if ($child->id == $patient_a_id) {
                return true;
            }
            // Recursively check grandchildren
            if ($this->isDescendantOf($patient_a_id, $child->id)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get patient hierarchy tree (for displaying family relationships)
     */
    function getPatientHierarchy($patient_id) {
        $patient = $this->getPatientById($patient_id);
        if (!$patient) {
            return null;
        }
        
        $hierarchy = array(
            'patient' => $patient,
            'parent' => null,
            'children' => array(),
            'siblings' => array()
        );
        
        // Get parent
        if (!empty($patient->parent_patient_id)) {
            $hierarchy['parent'] = $this->getPatientById($patient->parent_patient_id);
            
            // Get siblings (other children of the same parent)
            $siblings = $this->getChildrenPatients($patient->parent_patient_id);
            foreach ($siblings as $sibling) {
                if ($sibling->id != $patient_id) {
                    $hierarchy['siblings'][] = $sibling;
                }
            }
        }
        
        // Get children
        $hierarchy['children'] = $this->getChildrenPatients($patient_id);
        
        return $hierarchy;
    }

}
