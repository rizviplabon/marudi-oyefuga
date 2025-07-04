<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Donor extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('donor_model');

        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor', 'Patient'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['donors'] = $this->donor_model->getDonor();
        $data['groups'] = $this->donor_model->getBloodBank();
        if ($this->ion_auth->in_group(array('Patient'))) {

            $current_user_id = $this->ion_auth->user()->row()->id;
            $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
            $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
            $group_name = strtolower($group_name);
            $user_theme = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->dashboard_theme;
            if ($user_theme == 'main') {
                $this->load->view('patient/layout/header');
                $this->load->view('donor', $data);
                $this->load->view('patient/layout/footer');
            } else {
                $this->load->view('home/dashboard'); 
                $this->load->view('donor', $data);
                $this->load->view('home/footer');
            }
        }       elseif($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('donor', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('donor', $data);
                $this->load->view('home/footer');
            }}else{ 
        $this->load->view('home/dashboard'); 
        $this->load->view('donor', $data);
        $this->load->view('home/footer'); 
        }
    }

    public function addDonorView() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        $data = array();
        $data['groups'] = $this->donor_model->getBloodBank();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('add_donor', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('add_donor', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard'); 
        $this->load->view('add_donor', $data);
        $this->load->view('home/footer'); 
            }
    }

    public function addDonor() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $group = $this->input->post('group');
        $age = $this->input->post('age');
        $sex = $this->input->post('sex');
        $ldd = $this->input->post('ldd');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('donor', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Name Field
        $this->form_validation->set_rules('group', 'group', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Name Field
        $this->form_validation->set_rules('age', 'age', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Name Field
        $this->form_validation->set_rules('sex', 'sex', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Name Field
        $this->form_validation->set_rules('ldd', 'Last Donation Date', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Name Field
        $this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Name Field
        $this->form_validation->set_rules('email', 'email', 'trim|required|min_length[2]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['groups'] = $this->donor_model->getBloodBank();
                $data['donor'] = $this->donor_model->getDonorById($id);
                $this->load->view('home/dashboard'); 
                $this->load->view('add_donor', $data);
                $this->load->view('home/footer'); 
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['groups'] = $this->donor_model->getBloodBank();
                $this->load->view('home/dashboard'); 
                $this->load->view('add_donor', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $data = array();
            $data = array('name' => $name,
                'group' => $group,
                'age' => $age,
                'sex' => $sex,
                'ldd' => $ldd,
                'phone' => $phone,
                'email' => $email,
                'add_date' => $add_date
            );
            if (empty($id)) {
                $this->donor_model->insertDonor($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->donor_model->updateDonor($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('donor');
        }
    }

    function editDonor() {
        $data = array();
        $data['groups'] = $this->donor_model->getBloodBank();
        $id = $this->input->get('id');
        $data['donor'] = $this->donor_model->getDonorById($id);
        $this->load->view('home/dashboard'); 
        $this->load->view('add_donor', $data);
        $this->load->view('home/footer'); 
    }

    function editDonorByJason() {
        $id = $this->input->get('id');
        $data['donor'] = $this->donor_model->getDonorById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->donor_model->deleteDonor($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('donor');
    }

    public function bloodBank() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['groups'] = $this->donor_model->getBloodBank();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('blood_bank', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('blood_bank', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard'); 
        $this->load->view('blood_bank', $data);
        $this->load->view('home/footer'); 
            }
    }

    public function updateView() {
        $this->load->view('home/dashboard'); 
        $this->load->view('update_blood_bank');
        $this->load->view('home/footer'); 
    }

    public function updateBloodBank() {
        $id = $this->input->post('id');
        $group = $this->input->post('group');
        $status = $this->input->post('status');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Description Field
        $this->form_validation->set_rules('status', 'Status', 'required|max_length[100]');
        if ($this->form_validation->run() == FALSE) {
             $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect('donor/bloodBank');
        } else {
            $data = array();
            $data = array(
                'status' => $status
            );

            $this->donor_model->updateBloodBank($id, $data);
            $this->session->set_flashdata('feedback', lang('updated'));
            redirect('donor/bloodBank');
        }
    }

    function updateBloodBankByJason() {
        $id = $this->input->get('id');
        $data['bloodbank'] = $this->donor_model->getBloodBankById($id);
        echo json_encode($data);
    }

    function editBloodBank() {
        $data = array();
        $id = $this->input->get('id');
        $data['donor'] = $this->donor_model->getBloodBankById($id);
        $this->load->view('home/dashboard'); 
        $this->load->view('update_blood_bank', $data);
        $this->load->view('home/footer'); 
    }

}

/* End of file accountant.php */
/* Location: ./application/modules/accountant/controllers/accountant.php */
