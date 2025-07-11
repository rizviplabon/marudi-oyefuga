<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notice extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('notice_model');
        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Accountant', 'Doctor','Receptionist', 'Laboratorist', 'im', 'Patient'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $data['notices'] = $this->notice_model->getNotice();
        $data['settings'] = $this->settings_model->getSettings();
        if ($this->ion_auth->in_group(array('Patient'))) {

            $current_user_id = $this->ion_auth->user()->row()->id;
            $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
            $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
            $group_name = strtolower($group_name);
            $user_theme = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->dashboard_theme;
            if ($user_theme == 'main') {
                $this->load->view('patient/layout/header');
                $this->load->view('notice', $data);
                $this->load->view('patient/layout/footer');
            } else {
                $this->load->view('home/dashboard', $data);
                $this->load->view('notice', $data);
                $this->load->view('home/footer');
            }
        }        elseif($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('notice', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('notice', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard', $data); 
        $this->load->view('notice', $data);
        $this->load->view('home/footer'); 
        }
    }

    public function addNewView() {
        $data['notices'] = $this->notice_model->getNotice();
        $data['settings'] = $this->settings_model->getSettings();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('add_new', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('add_new', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard', $data); 
        $this->load->view('add_new');
        $this->load->view('home/footer'); 
            }
    }

    public function addNew() {

        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }
        $type = $this->input->post('type');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Title Field
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating date Field
        $this->form_validation->set_rules('date', 'date', 'trim|required|min_length[5]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("notice/editNotice?id=$id");
            } else {
                $this->load->view('home/dashboard'); 
                $this->load->view('add_new');
                $this->load->view('home/footer'); 
            }
        } else {

            
            $data = array();
            $data = array(
                'title' => $title,
                'description' => $description,
                'date' => $date,
                'type' => $type
            );



            if (empty($id)) {     // Adding New Notice
                $this->notice_model->insertNotice($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating Notice
                $this->notice_model->updateNotice($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('notice'); 
        }
    }

    function getNotice() {
        $data['notices'] = $this->notice_model->getNotice();
        $this->load->view('notice', $data);
    }

    function editNotice() {
        $data = array();
        $id = $this->input->get('id');
        $data['notice'] = $this->notice_model->getNoticeById($id);
        $this->load->view('home/dashboard'); 
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); 
    }

    function editNoticeByJason() {
        $id = $this->input->get('id');
        $data['notice'] = $this->notice_model->getNoticeById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $this->notice_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('notice');
    }

}

/* End of file notice.php */
/* Location: ./application/modules/notice/controllers/notice.php */
