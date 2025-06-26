<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class City extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('city_model');
        $this->load->model('province_model');
        $this->load->model('country/country_model');
        $this->load->model('country/province_model');
     
    }

    public function index() {
        $data['cities'] = $this->city_model->getCity();
        $data['countries'] = $this->city_model->getCountryList();
        if($this->ion_auth->in_group('admin')){
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header');
                $this->load->view('city', $data);
                $this->load->view('home/layout/footer');
            }else{
                $this->load->view('home/dashboard');
                $this->load->view('city', $data);
                $this->load->view('home/footer');
            }
        }else{
            $this->load->view('home/dashboard');
            $this->load->view('city', $data);
            $this->load->view('home/footer');
        }
    }

    public function addNew() {
        $id = $this->input->post('id');
        $country = $this->input->post('country');
        $province = $this->input->post('province');
        $city = $this->input->post('city');
        $hospital_id = $this->session->userdata('hospital_id');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('province', 'Province', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('city', 'City', 'trim|required|min_length[2]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['provinces'] = $this->city_model->getProvinceList();
            if (!empty($id)) {
                $data['city'] = $this->city_model->getCityById($id);
            }
            $this->load->view('home/dashboard');
            $this->load->view('add_city', $data);
            $this->load->view('home/footer');
        } else {
            $data = array(
                'country' => $country,
                'province' => $province,
                'city' => $city,
                'hospital_id' => $hospital_id,
                'date' => date('Y-m-d H:i:s')
            );
            if (empty($id)) {
                $this->city_model->insertCity($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->city_model->updateCity($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('country/city');
        }
    }

    function editCity() {
        $data = array();
        $id = $this->input->get('id');
        $data['city'] = $this->city_model->getCityById($id);
        $data['countries'] = $this->city_model->getCountryList();
        $this->load->view('home/dashboard');
        $this->load->view('add_city', $data);
        $this->load->view('home/footer');
    }

    function editCityByJason() {
        $id = $this->input->get('id');
        $data['city'] = $this->city_model->getCityById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->city_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('country/city');
    }


    public function getProvinceByCountryIdByJason() {
        $country = $this->input->get('country');
        if (!empty($country)) {
            $provinces = $this->province_model->getProvincesByCountry($country);
            $options = '<option value=""> Select Province </option>';
            foreach ($provinces as $province) {
                $options .= '<option value="' . $province->id . '">' . $province->province . '</option>';
            }
            $data['content'] = $options;
            echo json_encode($data);
        }
    }

    public function getCityByProvinceIdByJason() {
        $province = $this->input->get('province');
        if (!empty($province)) {
            $this->db->where('province', $province);
            $cities = $this->db->get('city')->result();
            $options = '<option value=""> Select City </option>';
            foreach ($cities as $city) {
                $options .= '<option value="' . $city->id . '">' . $city->city . '</option>';
            }
            $data['content'] = $options;
            echo json_encode($data);
        }
    }
}