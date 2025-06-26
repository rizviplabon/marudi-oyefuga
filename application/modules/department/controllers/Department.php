<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('department_model');

        if (!$this->ion_auth->in_group('admin')) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['departments'] = $this->department_model->getDepartment();
        if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){
            $this->load->view('home/layout/header'); 
            $this->load->view('department', $data);
            $this->load->view('home/layout/footer'); 
        }else{
            $this->load->view('home/dashboard'); 
            $this->load->view('department', $data);
            $this->load->view('home/footer'); 
        }}else{
            $this->load->view('home/dashboard'); 
            $this->load->view('department', $data);
            $this->load->view('home/footer'); 
        }
       
    }

    public function addNewView() {
        $this->load->view('home/dashboard'); 
        $this->load->view('add_new');
        $this->load->view('home/footer'); 
    }

    public function addNew() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field    
        // Validating Email Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[2]|max_length[1000]|xss_clean');
        // Validating Address Field   
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['department'] = $this->department_model->getDepartmentById($id);
                $this->load->view('home/dashboard'); 
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); 
            } else {
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); 
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); 
            }
        } else {
           
            $data = array();
            $data = array(
                'name' => $name,
                'description' => $description
            );
            if (empty($id)) {     // Adding New department
                $this->department_model->insertDepartment($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->department_model->updateDepartment($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('department');
        }
    }

    function getDepartment() {
        $data['departments'] = $this->department_model->getDepartment();
        $this->load->view('department', $data);
    }

    function editDepartment() {
        $data = array();
        $id = $this->input->get('id');
        $data['department'] = $this->department_model->getDepartmentById($id);
        $this->load->view('home/dashboard'); 
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); 
    }

    function editDepartmentByJason() {
        $id = $this->input->get('id');
        $data['department'] = $this->department_model->getDepartmentById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->department_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('department');
    }
    function doctorDirectory(){
        $id=$this->input->get('id');
        $data['department']=$this->department_model->getDepartmentById($id);
       
        if($this->ion_auth->in_group(array('admin'))){
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('doctor_directory', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('doctor_directory', $data);
                $this->load->view('home/footer');
            }
        }else{
        $this->load->view('home/dashboard'); 
        $this->load->view('doctor_directory', $data);
        $this->load->view('home/footer'); 
    } 

    }

    public function encrypt_department_names() {  
        // Check if the user is an admin
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        
        // Load the db_encrypt helper
        $this->load->helper('db_encrypt');
        
        // Get all departments
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('department');
        $departments = $query->result();
        
        $name_success = 0;
        $desc_success = 0;
        $total_count = count($departments);
        
        // Re-encrypt all department names and descriptions with our new approach
        foreach ($departments as $department) {
            $updated = false;
            $update_data = array();
            
            // Process name field
            if (!empty($department->name)) {
                // Try to decrypt first (in case it's already encrypted)
                $name = db_decrypt($department->name);
                
                // Then re-encrypt with our new approach
                $update_data['name'] = db_encrypt($name);
                $updated = true;
            }
            
            // Process description field
            if (!empty($department->description)) {
                // Try to decrypt first (in case it's already encrypted)
                $description = db_decrypt($department->description);
                
                // Then re-encrypt with our new approach
                $update_data['description'] = db_encrypt($description);
                $updated = true;
            }
            
            // Update the record if we have changes
            if ($updated) {
                $this->db->where('id', $department->id);
                $this->db->update('department', $update_data);
                
                if ($this->db->affected_rows() > 0) {
                    if (isset($update_data['name'])) $name_success++;
                    if (isset($update_data['description'])) $desc_success++;
                }
            }
        }
        
        // Output the results
        echo json_encode(array(
            'status' => 'success',
            'message' => sprintf('Re-encrypted %d names and %d descriptions out of %d departments.', 
                $name_success, $desc_success, $total_count)
        ));
    }

    public function test_encryption() {
        // Only allow admin access
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        
        $this->load->helper('db_encrypt');
        
        // Test data
        $test_data = 'Test Department ' . date('Y-m-d H:i:s');
        
        // Test encryption
        $encrypted = db_encrypt($test_data);
        
        // Test decryption
        $decrypted = db_decrypt($encrypted);
        
        // Output results
        echo "<h2>Encryption Test</h2>";
        echo "<p><strong>Original:</strong> $test_data</p>";
        echo "<p><strong>Encrypted:</strong> " . htmlspecialchars(substr(bin2hex($encrypted), 0, 100)) . "...</p>";
        echo "<p><strong>Decrypted:</strong> $decrypted</p>";
        
        // Check if encryption/decryption worked correctly
        if ($test_data === $decrypted) {
            echo "<p style='color:green'><strong>SUCCESS!</strong> Encryption/decryption is working properly.</p>";
        } else {
            echo "<p style='color:red'><strong>FAILED!</strong> The decrypted text does not match the original.</p>";
        }
        
        // Check encryption key
        $key = config_item('encryption_key');
        if (empty($key)) {
            echo "<p style='color:red'><strong>WARNING!</strong> Encryption key is not set in config.</p>";
        } else {
            echo "<p style='color:green'>Encryption key length: " . strlen($key) . " characters</p>";
        }
        
        // Check encryption library
        $CI = &get_instance();
        if (!isset($CI->encryption)) {
            $CI->load->library('encryption');
        }
        
        // Show the cipher and mode being used
        echo "<p><strong>Encryption cipher:</strong> " . $CI->encryption->_get_cipher() . "</p>";
        echo "<p><strong>Encryption mode:</strong> " . $CI->encryption->_get_mode() . "</p>";
    }

}

/* End of file department.php */
/* Location: ./application/modules/department/controllers/department.php */
