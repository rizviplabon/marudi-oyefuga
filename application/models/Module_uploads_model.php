<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Module_uploads_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Insert a module upload record
     *
     * @param array $data Upload data
     * @return int|boolean Insert ID on success, false on failure
     */
    function insertModuleUpload($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        
        $this->db->insert('module_uploads', $data2);
        return $this->db->insert_id();
    }

    /**
     * Get all module uploads
     *
     * @return array List of module uploads
     */
    function getModuleUploads() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('module_uploads');
        return $query->result();
    }

    /**
     * Get uploads by module name
     *
     * @param string $moduleName Module name
     * @return array List of uploads for the module
     */
    function getUploadsByModule($moduleName) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('module_name', $moduleName);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('module_uploads');
        return $query->result();
    }

    /**
     * Get uploads by module name and ID
     *
     * @param string $moduleName Module name
     * @param int $moduleId Module ID
     * @return array List of uploads for the module and ID
     */
    function getUploadsByModuleAndId($moduleName, $moduleId) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('module_name', $moduleName);
        $this->db->where('module_id', $moduleId);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('module_uploads');
        return $query->result();
    }

    /**
     * Get a specific upload by ID
     *
     * @param int $id Upload ID
     * @return object Upload record
     */
    function getUploadById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('module_uploads');
        return $query->row();
    }

    /**
     * Update a module upload record
     *
     * @param int $id Upload ID
     * @param array $data New data
     * @return boolean True on success, false on failure
     */
    function updateModuleUpload($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('module_uploads', $data);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Delete a module upload
     *
     * @param int $id Upload ID
     * @return boolean True on success, false on failure
     */
    function deleteModuleUpload($id) {
        // Get upload info first to handle Google Drive deletion if needed
        $upload = $this->getUploadById($id);
        
        if ($upload && $upload->is_google_drive && !empty($upload->google_drive_id)) {
            // Load helper to delete from Google Drive
            $this->load->helper('google_drive');
            delete_file_from_google_drive($upload->google_drive_id);
        }
        
        $this->db->where('id', $id);
        $this->db->delete('module_uploads');
        
        return $this->db->affected_rows() > 0;
    }

    /**
     * Get uploads with search and pagination
     *
     * @param string $search Search term
     * @param string $order Order field
     * @param string $dir Order direction
     * @return array List of uploads matching search
     */
    function getUploadsBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        
        $query = $this->db->select('*')
                ->from('module_uploads')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR title LIKE '%" . $search . "%' OR module_name LIKE '%" . $search . "%' OR upload_type LIKE '%" . $search . "%' OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
                
        return $query->result();
    }

    /**
     * Get uploads with pagination
     *
     * @param int $limit Results per page
     * @param int $start Start index
     * @param string $order Order field
     * @param string $dir Order direction
     * @return array Paginated list of uploads
     */
    function getUploadsByLimit($limit, $start, $order, $dir) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->get('module_uploads');
        return $query->result();
    }

    /**
     * Get uploads with search and pagination
     *
     * @param int $limit Results per page
     * @param int $start Start index
     * @param string $search Search term
     * @param string $order Order field
     * @param string $dir Order direction
     * @return array Paginated list of uploads matching search
     */
    function getUploadsByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('id', 'desc');
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('module_uploads')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR title LIKE '%" . $search . "%' OR module_name LIKE '%" . $search . "%' OR upload_type LIKE '%" . $search . "%' OR date_string LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
                
        return $query->result();
    }
} 