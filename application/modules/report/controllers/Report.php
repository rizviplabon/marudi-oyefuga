<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model');
        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist', 'Patient'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        $data['reports'] = $this->report_model->getReport();
        $this->load->view('home/dashboard'); 
        $this->load->view('birth_report', $data);
        $this->load->view('home/footer'); 
    }

    function birth() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $type = 'birth';
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['reports'] = $this->report_model->getReportByType($type);
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('birth_report', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('birth_report', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard'); 
        $this->load->view('birth_report', $data);
        $this->load->view('home/footer'); 
            }
    }

    function operation() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $type = 'operation';
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['reports'] = $this->report_model->getReportByType($type);
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('operation_report', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('operation_report', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard'); 
        $this->load->view('operation_report', $data);
        $this->load->view('home/footer'); 
            }
    }

    function expire() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $type = 'expire';
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['reports'] = $this->report_model->getReportByType($type);
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('expire_report', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('expire_report', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard'); 
        $this->load->view('expire_report', $data);
        $this->load->view('home/footer'); 
            }
    }

    public function addReportView() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['patients'] = $this->patient_model->getPatient();
        $this->load->view('home/dashboard'); 
        $this->load->view('add_report', $data);
        $this->load->view('home/footer'); 
    }

    public function addReport() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $description = $this->input->post('description');
        $patient = $this->input->post('patient');
        $doctor = $this->input->post('doctor');
        $date = $this->input->post('date');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('report', array('id' => $id))->row()->add_date;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[1000]|xss_clean');
        // Validating Price Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Company Name Field
        $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if(!empty($id)){
                $this->session->set_flashdata('feedback', lang('validation_error'));
                redirect('report/editReport?id'.$id);
            }else{
            $data = array();
            $data['setval'] = 'setval';
            $data['doctors'] = $this->doctor_model->getDoctor();
            $data['patients'] = $this->patient_model->getPatient();
            $this->load->view('home/dashboard'); 
            $this->load->view('add_report', $data);
            $this->load->view('home/footer'); 
            }
        } else {
            $data = array();
            $data = array('report_type' => $type,
                'description' => $description,
                'patient' => $patient,
                'doctor' => $doctor,
                'date' => $date,
                'add_date' => $add_date
            );
            if (empty($id)) {
                $this->report_model->insertReport($data); 
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->report_model->updateReport($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            if ($type == 'birth') {
                redirect('report/birth');
            } elseif ($type == 'operation') {
                redirect('report/operation');
            } else {
                redirect('report/expire');
            }
        }
    }

    function editReport() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['patients'] = $this->patient_model->getPatient();
        $id = $this->input->get('id');
        $data['report'] = $this->report_model->getReportById($id);
        $this->load->view('home/dashboard'); 
        $this->load->view('add_report', $data);
        $this->load->view('home/footer'); 
    }
    
    function editReportByJason(){
        $id = $this->input->get('id');
        $data['report'] = $this->report_model->getReportById($id);
        echo json_encode($data);
    }

    function myReport() {
        if ($this->ion_auth->in_group('Patient')) {
            $data = array();
            $id = $this->ion_auth->get_user_id();
            $data['report'] = $this->report_model->getReportById($id);
        }
    }

    function myreports() {
        $data['reports'] = $this->report_model->getReport();
        $data['user_id'] = $this->ion_auth->user()->row()->id;
        if ($this->ion_auth->in_group(array('Patient'))) {

            $current_user_id = $this->ion_auth->user()->row()->id;
            $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
            $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
            $group_name = strtolower($group_name);
            $user_theme = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->dashboard_theme;
            if ($user_theme == 'main') {
                $this->load->view('patient/layout/header');
                $this->load->view('myreports', $data);
                $this->load->view('patient/layout/footer');
            } else {
                $this->load->view('home/dashboard'); 
        $this->load->view('myreports', $data);
        $this->load->view('home/footer'); 
            }
        } else {
        $this->load->view('home/dashboard'); 
        $this->load->view('myreports', $data);
        $this->load->view('home/footer'); 
        }
    }

    function delete() {
        if ($this->ion_auth->in_group('Patient')) {
            redirect('home/permission');
        }
        $id = $this->input->get('id');
        $type = $this->report_model->getReportById($id)->report_type;
        $this->report_model->deleteReport($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        if ($type == 'birth') {
            redirect('report/birth');
        } elseif ($type == 'operation') {
            redirect('report/operation');
        } else {
            redirect('report/expire');
        }
    }

}

/* End of file report.php */
/* Location: ./application/modules/report/controllers/re.phportp */
