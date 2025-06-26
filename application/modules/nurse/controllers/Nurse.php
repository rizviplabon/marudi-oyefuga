<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nurse extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('nurse_model');
        $this->load->helper('drive_helper');
        $this->load->model('storage/storage_model');
        if (!$this->ion_auth->in_group('admin')) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['nurses'] = $this->nurse_model->getNurse();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('nurse', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('nurse', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard'); 
        $this->load->view('nurse', $data);
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
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $profile=$this->input->post('profile');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[5]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['nurse'] = $this->nurse_model->getNurseById($id);
                $this->load->view('home/dashboard'); 
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); 
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); 
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $storage_type = $this->storage_model->get_storage_type();
            $temp_dir = 'uploads/';
            
            // Create upload directory if it doesn't exist
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0755, true);
            }

            // Common upload configuration
            $config = [
                'upload_path'   => $temp_dir,
                'allowed_types' => '*',
                'max_size'      => 10240, // 10MB
                'encrypt_name'  => true
            ];

        $this->load->library('Upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('img_url')) {
            $upload_data = $this->upload->data();
            $file_path = $upload_data['full_path'];
            
            if ($storage_type == "drive") {
                // Google Drive Upload
                $access_token = get_google_drive_service();
                $account = $this->storage_model->get_googledrive_settings();
                $parent_folder_id = $account->default_folder_id;
                
                $result = upload_to_google_drive($access_token, $file_path, $parent_folder_id);
                
                // Delete local temp file after Drive upload
                unlink($file_path);
                
                if ($result['status'] !== 'success') {
                    throw new Exception('Google Drive upload failed: ' . print_r($result['response'], true));
                }
                
                $file_id = $result['response']['id'];
                $unique_name = $result['unique_name'];
                // $img_url = 'https://drive.google.com/file/d/' . $file_id . '/view';
                $img_url = 'https://drive.google.com/thumbnail?id='. $file_id; 
                
            } else {
                // Local Storage
                $file_id = $upload_data['file_name']; // Using encrypted name as ID
                $unique_name = $upload_data['file_name'];
                $img_url = 'uploads/'. $unique_name;
                
            }
            $data = array();
            $data = array(
                'img_url' => $img_url,
                        'name' => $name,
                        'email' => $email,
                        'address' => $address,
                        'phone' => $phone,
                        'profile' => $profile,
            );
        } else {

            $data = array();
            $data = array(
               
                        'name' => $name,
                        'email' => $email,
                        'address' => $address,
                        'phone' => $phone,
                        'profile' => $profile,
            );
        }


       


            $username = $this->input->post('name');
            if (empty($id)) {     // Adding New Nurse
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                    redirect('nurse/addNewView');
                } else {
                    $dfg = 6;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                    $this->nurse_model->insertNurse($data);
                    $nurse_id = $this->db->insert_id();
                    $nurse_user_id = $this->db->get_where('nurse', array('email' => $email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->nurse_model->updateNurse($nurse_user_id, $id_info);
                    $this->hospital_model->addHospitalIdToIonUser($ion_user_id, $this->hospital_id);
                    $base_url = str_replace(array('http://', 'https://', ' '), '', base_url()) . "auth/login";
                    $set['settings'] = $this->settings_model->getSettings();
                    $name1 = explode(' ', $name);
                    if (!isset($name1[1])) {
                        $name1[1] = null;
                    }
                    $data1 = array(
                        'firstname' => $name1[0],
                        'lastname' => $name1[1],
                        'name' => $name,
                        'base_url' => $base_url,
                        'email' => $email,
                        'password' => $password,
                        'company' => $set['settings']->system_vendor
                    );
                    $autoemail = $this->email_model->getAutoEmailByType('nurse');
                    if ($autoemail->status == 'Active') {
                        $mail_provider = $this->settings_model->getSettings()->emailtype;
                        $settngs_name = $this->settings_model->getSettings()->system_vendor;
                        $email_Settings = $this->email_model->getEmailSettingsByType($mail_provider);
                        $message1 = $autoemail->message;
                        $messageprint1 = $this->parser->parse_string($message1, $data1);
                        if ($mail_provider == 'Domain Email') {
                            $this->email->from($email_Settings->admin_email);
                        }
                        if ($mail_provider == 'Smtp') {
                            $this->email->from($email_Settings->user, $settngs_name);
                        }
                        $this->email->to($email);
                        $this->email->subject('Registration confirmation');
                        $this->email->message($messageprint1);
                        $this->email->send();
                    }
                    $this->session->set_flashdata('feedback', lang('added'));
                }
                 // Common upload configuration
        $config1 = [
            'upload_path'   => $temp_dir,
            'allowed_types' => '*',
            'max_size'      => 10240, // 10MB
            'encrypt_name'  => true
        ];

    $this->load->library('Upload', $config1);
    $this->upload->initialize($config1);

    if ($this->upload->do_upload('signature')) {
        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];
        
        if ($storage_type == "drive") {
            // Google Drive Upload
            $access_token = get_google_drive_service();
            $account = $this->storage_model->get_googledrive_settings();
            $parent_folder_id = $account->default_folder_id;
            
            $result = upload_to_google_drive($access_token, $file_path, $parent_folder_id);
            
            // Delete local temp file after Drive upload
            unlink($file_path);
            
            if ($result['status'] !== 'success') {
                throw new Exception('Google Drive upload failed: ' . print_r($result['response'], true));
            }
            
            $file_id = $result['response']['id'];
            $unique_name = $result['unique_name'];
            // $img_url = 'https://drive.google.com/file/d/' . $file_id . '/view';
            $img_url = 'https://drive.google.com/thumbnail?id='. $file_id; 
            
        } else {
            // Local Storage
            $file_id = $upload_data['file_name']; // Using encrypted name as ID
            $unique_name = $upload_data['file_name'];
            $img_url = 'uploads/'. $unique_name;
            
        }

                    $data2 = array(
                        'signature' => $img_url
                    );
                    $this->nurse_model->updateNurse($nurse_id, $data2);
                }
            } else { // Updating Nurse
                $nurse_details = $this->nurse_model->getNurseById($id);
                if ($email != $nurse_details->email) {
                    if ($this->ion_auth->email_check($email)) {
                        $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                        redirect("nurse/editNurse?id=" . $id);
                    }
                }
                $ion_user_id = $this->db->get_where('nurse', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->nurse_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->nurse_model->updateNurse($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('nurse');
        }
    }

    function getNurse() {
        $data['nurses'] = $this->nurse_model->get_nurse();
        $this->load->view('nurse', $data);
    }

    function editNurse() {
        $data = array();
        $id = $this->input->get('id');
        $data['nurse'] = $this->nurse_model->getNurseById($id);
        $this->load->view('home/dashboard'); 
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); 
    }

    function editNurseByJason() {
        $id = $this->input->get('id');
        $data['nurse'] = $this->nurse_model->getNurseById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('nurse', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->nurse_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('nurse');
    }
    function deleteNurseImage(){
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('nurse', array('id' => $id))->row();
        $path = $user_data->signature;
        if (!empty($path)) {
            unlink($path);
        }
        $data=array('signature'=>'');
        $this->nurse_model->updateNurse($id,$data);
        $data_response=array();
        $data_response['response']='yes';
        echo json_encode($data_response);
    }
}

/* End of file nurse.php */
/* Location: ./application/modules/nurse/controllers/nurse.php */
