<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Province extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('province_model');
        $this->load->model('country_model');
  
    }

    public function getProvincesByCountry() {
        $country_id = $this->input->get('country_id');
        $provinces = $this->province_model->getProvincesByCountry($country_id);
        echo json_encode($provinces);
    }
    

    public function index() {
        $data['provinces'] = $this->province_model->getProvince();
        $data['countries'] = $this->province_model->getCountryList();
        if($this->ion_auth->in_group('admin')){
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header');
                $this->load->view('province', $data);
                $this->load->view('home/layout/footer');
            }else{
                $this->load->view('home/dashboard');
                $this->load->view('province', $data);
                $this->load->view('home/footer');
            }
        }else{
            $this->load->view('home/dashboard');
            $this->load->view('province', $data);
            $this->load->view('home/footer');
        }
    }

    public function addNew() {
        $id = $this->input->post('id');
        $country = $this->input->post('country');
        $province = $this->input->post('province');
        $hospital_id = $this->session->userdata('hospital_id');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('province', 'Province', 'trim|required|min_length[2]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['countries'] = $this->province_model->getCountryList();
            if (!empty($id)) {
                $data['province'] = $this->province_model->getProvinceById($id);
            }
            $this->load->view('home/dashboard');
            $this->load->view('add_province', $data);
            $this->load->view('home/footer');
        } else {
            $data = array(
                'country' => $country,
                'province' => $province,
                'hospital_id' => $hospital_id,
                'date' => date('Y-m-d H:i:s')
            );
            if (empty($id)) {
                $this->province_model->insertProvince($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->province_model->updateProvince($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('country/province');
        }
    }

    function editProvince() {
        $data = array();
        $id = $this->input->get('id');
        $data['province'] = $this->province_model->getProvinceById($id);
        $data['countries'] = $this->province_model->getCountryList();
        $this->load->view('home/dashboard');
        $this->load->view('add_province', $data);
        $this->load->view('home/footer');
    }

    function editProvinceByJason() {
        $id = $this->input->get('id');
        $data['province'] = $this->province_model->getProvinceById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->province_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('country/province');
    }
}