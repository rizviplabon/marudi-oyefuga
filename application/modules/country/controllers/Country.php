<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Country extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('country_model');
       
    }

    public function index() {
        $data['countries'] = $this->country_model->getCountry();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('country', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('country', $data);
                $this->load->view('home/footer');
            }
        }else{
            $this->load->view('home/dashboard'); 
            $this->load->view('country', $data);
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
        $country = $this->input->post('country');
        $hospital_id = $this->session->userdata('hospital_id');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|min_length[2]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['country'] = $this->country_model->getCountryById($id);
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
            $data = array(
                'country' => $country,
                'hospital_id' => $hospital_id,
                'date' => date('Y-m-d H:i:s')
            );
            if (empty($id)) {
                $this->country_model->insertCountry($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->country_model->updateCountry($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('country');
        }
    }

    function getCountry() {
        $data['countries'] = $this->country_model->getCountry();
        $this->load->view('country', $data);
    }

    function editCountry() {
        $data = array();
        $id = $this->input->get('id');
        $data['country'] = $this->country_model->getCountryById($id);
        $this->load->view('home/dashboard'); 
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); 
    }

    function editCountryByJason() {
        $id = $this->input->get('id');
        $data['country'] = $this->country_model->getCountryById($id);
        echo json_encode($data);
    }

    function getProvinceByCountryIdByJason() {
        $id = $this->input->get('id');
        $data['provinces'] = $this->country_model->getProvinceByCountryId($id);
        echo json_encode($data);
    }

    function getCityByProvinceIdByJason() {
        $id = $this->input->get('id');
        $data['cities'] = $this->country_model->getCityByProvinceId($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->country_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('country');
    }
}

/* End of file country.php */
/* Location: ./application/modules/country/controllers/country.php */