<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Doctor_model extends CI_model {

    // List of fields that should be encrypted
    public $encrypted_fields = array(
        'name',
        'email',
        'phone',
        'address',
        'profile'
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

    function insertDoctor($data) {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('doctor', $data2);
    }

    function getDoctor() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('doctor');
        $doctors = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctors);
    }
    
    function getDoctorWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('doctor');
        $doctors = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctors);
    }

    function getLimit() {
        $current = $this->db->get_where('doctor', array('hospital_id' => $this->hospital_id))->num_rows();
        $limit = $this->db->get_where('hospital', array('id' => $this->hospital_id))->row()->d_limit;
        return $limit - $current;
    }

    function getDoctorBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('doctor')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%'OR email LIKE '%" . $search . "%'OR department_name LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $doctors = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctors);
    }

    function getDoctorByLimit($limit, $start, $order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('doctor');
        $doctors = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctors);
    }

    function getDoctorByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('doctor')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%'OR email LIKE '%" . $search . "%'OR department_name LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();

        $doctors = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctors);
    }

    function getDoctorById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('doctor');
        $doctor = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctor);
    }

    function getDoctorByIonUserId($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('ion_user_id', $id);
        $query = $this->db->get('doctor');
        $doctor = $query->row();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctor);
    }

    function updateDoctor($id, $data) {
        // Encrypt sensitive fields
        $data = $this->encrypt_data($data);
        
        $this->db->where('id', $id);
        $this->db->update('doctor', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('doctor');
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

    function getDoctorInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $query = $this->db->select('*')
                    ->from('doctor')
                    ->where('hospital_id', $this->session->userdata('hospital_id'))
                    ->where("(id LIKE '%" . $searchTerm . "%' OR name LIKE '%" . $searchTerm . "%')", NULL, FALSE)
                    ->get();
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->limit(10);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        if ($this->ion_auth->in_group(array('Doctor'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('ion_user_id', $doctor_ion_id);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            // Decrypt the name if it's encrypted
            $decrypted_name = $this->safe_decrypt($user['name']);
            $data[] = array("id" => $user['id'], "text" => $decrypted_name . ' (' . lang('id') . ': ' . $user['id'] . ')');
        }
        return $data;
    }

    function getDoctorWithAddNewOption($searchTerm) {
        if (!empty($searchTerm)) {
            $query = $this->db->select('*')
                    ->from('doctor')
                    ->where('hospital_id', $this->session->userdata('hospital_id'))
                    ->where("(id LIKE '%" . $searchTerm . "%' OR name LIKE '%" . $searchTerm . "%')", NULL, FALSE)
                    ->get();
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->limit(10);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        if ($this->ion_auth->in_group(array('Doctor'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('ion_user_id', $doctor_ion_id);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }



        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            // Decrypt the name if it's encrypted
            $decrypted_name = $this->safe_decrypt($user['name']);
            $data[] = array("id" => $user['id'], "text" => $decrypted_name . ' (' . lang('id') . ': ' . $user['id'] . ')');
        }
        return $data;
    }
    function getDoctorByHospital($hospital_id) {
        $this->db->where('hospital_id', $hospital_id);
        $query = $this->db->get('doctor');
        return $query->result();
    }
    function getDoctorBySearchByDepartment($search, $order, $dir,$department) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $query = $this->db->select('*')
                ->from('doctor')
                ->where('department', $department)
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%'OR email LIKE '%" . $search . "%'OR department_name LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        $doctors = $query->result();
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctors);
    }

    function getDoctorByLimitByDepartment($limit, $start, $order, $dir,$department) {
        $this->db->where('department', $department);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get('doctor');
        $doctors = $query->result();
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctors);
    }

    function getDoctorByLimitBySearchByDepartment($limit, $start, $search, $order, $dir,$department) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('doctor')
                ->where('department', $department)
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%'OR email LIKE '%" . $search . "%'OR department_name LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();

                $doctors = $query->result();
                // Decrypt sensitive fields
                return $this->decrypt_fields($doctors);
    }
    function getDoctorWithoutSearchByDepartment($order, $dir,$department) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('department', $department);
        $query = $this->db->get('doctor');
        $doctors = $query->result();
        
        // Decrypt sensitive fields
        return $this->decrypt_fields($doctors);
    }
    function getDoctorVisitByDoctorId($id) {
        $this->db->where('doctor_id', $id);
        $query = $this->db->get('doctor_visit');
        return $query->result();
    }

    /**
     * Insert a doctor material (image/document)
     *
     * @param array $data Material data
     * @return int|boolean Insert ID on success, false on failure
     */
    function insertDoctorMaterial($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('doctor_material', $data2);
        return $this->db->insert_id();
    }

    /**
     * Get all doctor materials
     *
     * @return array List of doctor materials
     */
    function getDoctorMaterials() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('doctor_material');
        return $query->result();
    }

    /**
     * Get materials for a specific doctor
     *
     * @param int $doctorId Doctor ID
     * @return array List of materials for the doctor
     */
    function getDoctorMaterialsByDoctor($doctorId) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('doctor', $doctorId);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('doctor_material');
        return $query->result();
    }

    /**
     * Get a specific doctor material by ID
     *
     * @param int $id Material ID
     * @return object Material record
     */
    function getDoctorMaterialById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('doctor_material');
        return $query->row();
    }

    /**
     * Update a doctor material
     *
     * @param int $id Material ID
     * @param array $data New data
     * @return boolean True on success, false on failure
     */
    function updateDoctorMaterial($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('doctor_material', $data);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Delete a doctor material
     *
     * @param int $id Material ID
     * @return boolean True on success, false on failure
     */
    function deleteDoctorMaterial($id) {
        // Get material info first to handle Google Drive deletion if needed
        $material = $this->getDoctorMaterialById($id);
        
        if ($material && $material->is_google_drive && !empty($material->google_drive_id)) {
            // Load helper to delete from Google Drive
            $this->load->helper('google_drive');
            delete_file_from_google_drive($material->google_drive_id);
        }
        
        $this->db->where('id', $id);
        $this->db->delete('doctor_material');
        
        return $this->db->affected_rows() > 0;
    }

    /**
     * Get doctor materials with search and pagination
     *
     * @param string $search Search term
     * @param string $order Order field
     * @param string $dir Order direction
     * @return array List of materials matching search
     */
    function getDoctorMaterialsBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        
        $query = $this->db->select('*')
                ->from('doctor_material')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR doctor_name LIKE '%" . $search . "%' OR title LIKE '%" . $search . "%' OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
                
        return $query->result();
    }

    /**
     * Get doctor materials with pagination
     *
     * @param int $limit Results per page
     * @param int $start Start index
     * @param string $order Order field
     * @param string $dir Order direction
     * @return array Paginated list of materials
     */
    function getDoctorMaterialsByLimit($limit, $start, $order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->get('doctor_material');
        return $query->result();
    }

    /**
     * Get doctor materials with search and pagination
     *
     * @param int $limit Results per page
     * @param int $start Start index
     * @param string $search Search term
     * @param string $order Order field
     * @param string $dir Order direction
     * @return array Paginated list of materials matching search
     */
    function getDoctorMaterialsByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('doctor_material')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR doctor_name LIKE '%" . $search . "%' OR title LIKE '%" . $search . "%' OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
                
        return $query->result();
    }
}
