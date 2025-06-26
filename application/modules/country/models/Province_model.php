<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Province_model extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertProvince($data) {
        $this->db->insert('province', $data);
    }

    function getProvince() {
        $this->db->select('province.*, country.country as country_name');
        $this->db->from('province');
        $this->db->join('country', 'country.id = province.country');
        
        $query = $this->db->get();
        return $query->result();
    }

    function getProvinceById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('province');
        return $query->row();
    }

    function updateProvince($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('province', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('province');
    }

    function getCountryList() {
       
        $query = $this->db->get('country');
        return $query->result();
    }

    function getProvinceList() {
        
        $query = $this->db->get('province');
        return $query->result();
    }

    function getProvincesByCountry($country_id) {
        $this->db->select('province.*, country.country as country_name');
        $this->db->from('province');
        $this->db->join('country', 'country.id = province.country');
       
        $this->db->where('province.country', $country_id);
        $query = $this->db->get();
        return $query->result();
    }
}