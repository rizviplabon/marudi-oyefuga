<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class City_model extends CI_model {

    function __construct() {
        parent::__construct();
    }

    function insertCity($data) {
        $this->db->insert('city', $data);
    }

    function getCity() {
        $this->db->select('city.*, province.province as province_name');
        $this->db->from('city');
        $this->db->join('province', 'province.id = city.province');
        $query = $this->db->get();
        return $query->result();
    }

    function getCityById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('city');
        return $query->row();
    }

    function updateCity($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('city', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('city');
    }

    function getProvinceList() {
        
        $query = $this->db->get('province');
        return $query->result();
    }
    function getCountryList() {
        
        $query = $this->db->get('country');
        return $query->result();
    }
}