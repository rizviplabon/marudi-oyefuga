<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Country_model extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertCountry($data) {
        $this->db->insert('country', $data);
    }

    function getCountry() {
       
        $query = $this->db->get('country');
        return $query->result();
    }

    function getCountryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('country');
        return $query->row();
    }

    function updateCountry($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('country', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('country');
    }

    function getProvinceByCountryId($country_id) {
       
        $this->db->where('country', $country_id);
        $query = $this->db->get('province');
        return $query->result();
    }

    function getCityByProvinceId($province_id) {
       
        $this->db->where('province', $province_id);
        $query = $this->db->get('city');
        return $query->result();
    }

} // End of Country_model class