<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Labworkflow_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Specimen Types Management
    function insertSpecimenType($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('specimen_types', $data2);
        return $this->db->insert_id();
    }

    function getSpecimenTypes() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('specimen_types');
        return $query->result();
    }

    function getSpecimenTypeById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('specimen_types');
        return $query->row();
    }

    function updateSpecimenType($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('specimen_types', $data);
    }

    function deleteSpecimenType($id) {
        $this->db->where('id', $id);
        $this->db->delete('specimen_types');
    }

    // Lab Test Templates Management (now using payment_procedure_templates)
    function insertLabTestTemplate($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('payment_procedure_templates', $data2);
        return $this->db->insert_id();
    }

    function getLabTestTemplates() {
        $this->db->select('payment_procedure_templates.*, payment_category.category as category_name, specimen_types.name as specimen_type_name');
        $this->db->from('payment_procedure_templates');
        $this->db->join('payment_category', 'payment_category.id = payment_procedure_templates.category_id', 'left');
        $this->db->join('specimen_types', 'specimen_types.id = payment_procedure_templates.specimen_type_id', 'left');
        $this->db->where('payment_procedure_templates.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('payment_procedure_templates.template_name', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function getLabTestTemplateById($id) {
        $this->db->select('payment_procedure_templates.*, payment_category.category as category_name, specimen_types.name as specimen_type_name');
        $this->db->from('payment_procedure_templates');
        $this->db->join('payment_category', 'payment_category.id = payment_procedure_templates.category_id', 'left');
        $this->db->join('specimen_types', 'specimen_types.id = payment_procedure_templates.specimen_type_id', 'left');
        $this->db->where('payment_procedure_templates.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('payment_procedure_templates.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getActiveLabTestTemplates() {
        $this->db->select('payment_procedure_templates.*, payment_category.category as category_name, specimen_types.name as specimen_type_name');
        $this->db->from('payment_procedure_templates');
        $this->db->join('payment_category', 'payment_category.id = payment_procedure_templates.category_id', 'left');
        $this->db->join('specimen_types', 'specimen_types.id = payment_procedure_templates.specimen_type_id', 'left');
        $this->db->where('payment_procedure_templates.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('payment_procedure_templates.is_active', 1);
        $this->db->order_by('payment_procedure_templates.template_name', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function updateLabTestTemplate($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('payment_procedure_templates', $data);
    }

    function deleteLabTestTemplate($id) {
        $this->db->where('id', $id);
        $this->db->delete('payment_procedure_templates');
    }

    // Lab Specimens Management
    function insertLabSpecimen($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('lab_specimens', $data2);
        return $this->db->insert_id();
    }

    function getLabSpecimens() {
        $this->db->select('lab_specimens.*, specimen_types.name as specimen_type_name, patient.name as patient_name');
        $this->db->from('lab_specimens');
        $this->db->join('specimen_types', 'specimen_types.id = lab_specimens.specimen_type_id', 'left');
        $this->db->join('patient', 'patient.id = lab_specimens.patient_id', 'left');
        $this->db->where('lab_specimens.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('lab_specimens.collection_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getLabSpecimenById($id) {
        $this->db->select('lab_specimens.*, specimen_types.name as specimen_type_name, patient.name as patient_name');
        $this->db->from('lab_specimens');
        $this->db->join('specimen_types', 'specimen_types.id = lab_specimens.specimen_type_id', 'left');
        $this->db->join('patient', 'patient.id = lab_specimens.patient_id', 'left');
        $this->db->where('lab_specimens.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab_specimens.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getLabSpecimensForTesting() {
        $this->db->select('lab_specimens.*, specimen_types.name as specimen_type_name, patient.name as patient_name');
        $this->db->from('lab_specimens');
        $this->db->join('specimen_types', 'specimen_types.id = lab_specimens.specimen_type_id', 'left');
        $this->db->join('patient', 'patient.id = lab_specimens.patient_id', 'left');
        $this->db->where('lab_specimens.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where_in('lab_specimens.status', array('collected', 'received'));
        $this->db->order_by('lab_specimens.collection_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getLabSpecimensByPatient($patient_id) {
        $this->db->select('lab_specimens.*, specimen_types.name as specimen_type_name');
        $this->db->from('lab_specimens');
        $this->db->join('specimen_types', 'specimen_types.id = lab_specimens.specimen_type_id', 'left');
        $this->db->where('lab_specimens.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab_specimens.patient_id', $patient_id);
        $this->db->order_by('lab_specimens.collection_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function updateLabSpecimen($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('lab_specimens', $data);
    }

    function deleteLabSpecimen($id) {
        $this->db->where('id', $id);
        $this->db->delete('lab_specimens');
    }

    // Enhanced Lab Tests (extends existing lab functionality)
    function getEnhancedLabTests() {
        $this->db->select('lab.*, lab_specimens.specimen_id, lab_specimens.status as specimen_status, 
                          payment_procedure_templates.template_name as template_name, payment_procedure_templates.units, 
                          payment_procedure_templates.normal_range, specimen_types.name as specimen_type_name');
        $this->db->from('lab');
        $this->db->join('lab_specimens', 'lab_specimens.id = lab.specimen_id', 'left');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab.test_template_id', 'left');
        $this->db->join('specimen_types', 'specimen_types.id = payment_procedure_templates.specimen_type_id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('lab.date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getEnhancedLabTestById($id) {
        $this->db->select('lab.*, lab_specimens.specimen_id, lab_specimens.status as specimen_status, 
                          payment_procedure_templates.template_name as template_name, payment_procedure_templates.units, 
                          payment_procedure_templates.normal_range, payment_procedure_templates.template_config as result_template,
                          specimen_types.name as specimen_type_name');
        $this->db->from('lab');
        $this->db->join('lab_specimens', 'lab_specimens.id = lab.specimen_id', 'left');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab.test_template_id', 'left');
        $this->db->join('specimen_types', 'specimen_types.id = payment_procedure_templates.specimen_type_id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getLabTestsBySpecimen($specimen_id) {
        $this->db->select('lab.*, payment_procedure_templates.template_name as template_name');
        $this->db->from('lab');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab.test_template_id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab.specimen_id', $specimen_id);
        $this->db->order_by('lab.date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    // Lab Result Values Management
    function insertLabResultValue($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('lab_result_values', $data2);
        return $this->db->insert_id();
    }

    function getLabResultValues($lab_id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab_id', $lab_id);
        $this->db->order_by('parameter_name', 'asc');
        $query = $this->db->get('lab_result_values');
        return $query->result();
    }

    function updateLabResultValue($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('lab_result_values', $data);
    }

    function deleteLabResultValue($id) {
        $this->db->where('id', $id);
        $this->db->delete('lab_result_values');
    }

    function deleteLabResultValuesByLabId($lab_id) {
        $this->db->where('lab_id', $lab_id);
        $this->db->delete('lab_result_values');
    }

    // Quality Control Management
    function insertQualityControlRecord($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('lab_quality_control', $data2);
        return $this->db->insert_id();
    }

    function getQualityControlRecords() {
        $this->db->select('lab_quality_control.*, payment_procedure_templates.template_name as test_name');
        $this->db->from('lab_quality_control');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab_quality_control.test_template_id', 'left');
        $this->db->where('lab_quality_control.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('lab_quality_control.control_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getQualityControlRecordById($id) {
        $this->db->select('lab_quality_control.*, payment_procedure_templates.template_name as test_name');
        $this->db->from('lab_quality_control');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab_quality_control.test_template_id', 'left');
        $this->db->where('lab_quality_control.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab_quality_control.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function updateQualityControlRecord($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('lab_quality_control', $data);
    }

    function deleteQualityControlRecord($id) {
        $this->db->where('id', $id);
        $this->db->delete('lab_quality_control');
    }

    // Search and Filter Methods
    function getLabTestsByDateRange($from_date, $to_date) {
        $this->db->select('lab.*, lab_specimens.specimen_id, payment_procedure_templates.template_name as template_name');
        $this->db->from('lab');
        $this->db->join('lab_specimens', 'lab_specimens.id = lab.specimen_id', 'left');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab.test_template_id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($from_date) {
            $this->db->where('lab.date >=', strtotime($from_date));
        }
        
        if ($to_date) {
            $this->db->where('lab.date <=', strtotime($to_date));
        }
        
        $this->db->order_by('lab.date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getLabTestsByStatus($status) {
        $this->db->select('lab.*, lab_specimens.specimen_id, payment_procedure_templates.template_name as template_name');
        $this->db->from('lab');
        $this->db->join('lab_specimens', 'lab_specimens.id = lab.specimen_id', 'left');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab.test_template_id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab.test_status', $status);
        $this->db->order_by('lab.date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getLabTestsByTemplate($template_id) {
        $this->db->select('lab.*, lab_specimens.specimen_id, payment_procedure_templates.template_name as template_name');
        $this->db->from('lab');
        $this->db->join('lab_specimens', 'lab_specimens.id = lab.specimen_id', 'left');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab.test_template_id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab.test_template_id', $template_id);
        $this->db->order_by('lab.date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    // Statistics and Reports
    function getLabStatistics() {
        $stats = array();
        
        // Total specimens today
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('DATE(collection_date)', date('Y-m-d'));
        $stats['specimens_today'] = $this->db->count_all_results('lab_specimens');
        
        // Pending tests
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('test_status', 'not_done');
        $stats['pending_tests'] = $this->db->count_all_results('lab');
        
        // Completed tests today
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('test_status', 'done');
        $this->db->where('DATE(FROM_UNIXTIME(date))', date('Y-m-d'));
        $stats['completed_today'] = $this->db->count_all_results('lab');
        
        // Tests awaiting verification
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('test_status', 'done');
        $this->db->where('verified_by IS NULL');
        $stats['awaiting_verification'] = $this->db->count_all_results('lab');
        
        return $stats;
    }

    function getTurnaroundTimeReport($from_date = null, $to_date = null) {
        $this->db->select('lab.*, payment_procedure_templates.template_name as template_name, payment_procedure_templates.turnaround_time as expected_tat, 
                          TIMESTAMPDIFF(HOUR, lab.collection_date, lab.verification_date) as actual_tat');
        $this->db->from('lab');
        $this->db->join('payment_procedure_templates', 'payment_procedure_templates.id = lab.test_template_id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('lab.verification_date IS NOT NULL');
        
        if ($from_date) {
            $this->db->where('DATE(lab.collection_date) >=', $from_date);
        }
        
        if ($to_date) {
            $this->db->where('DATE(lab.collection_date) <=', $to_date);
        }
        
        $this->db->order_by('lab.collection_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    // AJAX Helper Methods
    function getSpecimenInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('lab_specimens.*, specimen_types.name as specimen_type_name, patient.name as patient_name');
            $this->db->from('lab_specimens');
            $this->db->join('specimen_types', 'specimen_types.id = lab_specimens.specimen_type_id', 'left');
            $this->db->join('patient', 'patient.id = lab_specimens.patient_id', 'left');
            $this->db->where('lab_specimens.hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where_in('lab_specimens.status', array('collected', 'received'));
            $this->db->where("(lab_specimens.specimen_id LIKE '%" . $searchTerm . "%' OR patient.name LIKE '%" . $searchTerm . "%')");
            $fetched_records = $this->db->get();
            $specimens = $fetched_records->result_array();
        } else {
            $this->db->select('lab_specimens.*, specimen_types.name as specimen_type_name, patient.name as patient_name');
            $this->db->from('lab_specimens');
            $this->db->join('specimen_types', 'specimen_types.id = lab_specimens.specimen_type_id', 'left');
            $this->db->join('patient', 'patient.id = lab_specimens.patient_id', 'left');
            $this->db->where('lab_specimens.hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where_in('lab_specimens.status', array('collected', 'received'));
            $this->db->limit(10);
            $fetched_records = $this->db->get();
            $specimens = $fetched_records->result_array();
        }

        $data = array();
        foreach ($specimens as $specimen) {
            $data[] = array(
                "id" => $specimen['id'],
                "text" => $specimen['specimen_id'] . ' - ' . $specimen['patient_name'] . ' (' . $specimen['specimen_type_name'] . ')',
                "specimen_id" => $specimen['specimen_id'],
                "patient_name" => $specimen['patient_name']
            );
        }
        return $data;
    }

    function getTestTemplateInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('payment_procedure_templates.*, payment_category.category as category_name, specimen_types.name as specimen_type_name');
            $this->db->from('payment_procedure_templates');
            $this->db->join('payment_category', 'payment_category.id = payment_procedure_templates.category_id', 'left');
            $this->db->join('specimen_types', 'specimen_types.id = payment_procedure_templates.specimen_type_id', 'left');
            $this->db->where('payment_procedure_templates.hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('payment_procedure_templates.is_active', 1);
            $this->db->where("(payment_procedure_templates.template_name LIKE '%" . $searchTerm . "%' OR payment_procedure_templates.procedure_type LIKE '%" . $searchTerm . "%')");
            $fetched_records = $this->db->get();
            $templates = $fetched_records->result_array();
        } else {
            $this->db->select('payment_procedure_templates.*, payment_category.category as category_name, specimen_types.name as specimen_type_name');
            $this->db->from('payment_procedure_templates');
            $this->db->join('payment_category', 'payment_category.id = payment_procedure_templates.category_id', 'left');
            $this->db->join('specimen_types', 'specimen_types.id = payment_procedure_templates.specimen_type_id', 'left');
            $this->db->where('payment_procedure_templates.hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('payment_procedure_templates.is_active', 1);
            $this->db->limit(10);
            $fetched_records = $this->db->get();
            $templates = $fetched_records->result_array();
        }

        $data = array();
        foreach ($templates as $template) {
            $data[] = array(
                "id" => $template['id'],
                "text" => $template['template_name'] . ' (' . $template['procedure_type'] . ')',
                "cost" => isset($template['cost']) ? $template['cost'] : 0,
                "specimen_type" => $template['specimen_type_name'],
                "category" => $template['category_name']
            );
        }
        return $data;
    }

    // Additional Report Methods
    function getSpecimenReport($from_date = null, $to_date = null, $specimen_type = null) {
        $this->db->select('lab_specimens.*, specimen_types.name as specimen_type_name, patient.name as patient_name');
        $this->db->from('lab_specimens');
        $this->db->join('specimen_types', 'specimen_types.id = lab_specimens.specimen_type_id', 'left');
        $this->db->join('patient', 'patient.id = lab_specimens.patient_id', 'left');
        $this->db->where('lab_specimens.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($from_date) {
            $this->db->where('DATE(lab_specimens.collection_date) >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('DATE(lab_specimens.collection_date) <=', $to_date);
        }
        if ($specimen_type) {
            $this->db->where('lab_specimens.specimen_type_id', $specimen_type);
        }
        
        $this->db->order_by('lab_specimens.collection_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getTestTemplateUsageReport($from_date = null, $to_date = null) {
        $this->db->select('payment_procedure_templates.template_name as template_name, COUNT(lab.id) as usage_count, SUM(COALESCE(payment_procedure_templates.cost, 0)) as total_revenue');
        $this->db->from('lab');
        $this->db->join('payment_procedure_templates', 'lab.test_template_id = payment_procedure_templates.id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($from_date) {
            $this->db->where('DATE(lab.date_string) >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('DATE(lab.date_string) <=', $to_date);
        }
        
        $this->db->group_by('lab.test_template_id');
        $this->db->order_by('usage_count', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getQCReport($from_date = null, $to_date = null) {
        $this->db->select('lab_quality_control.*, payment_procedure_templates.template_name as template_name, users.first_name, users.last_name');
        $this->db->from('lab_quality_control');
        $this->db->join('payment_procedure_templates', 'lab_quality_control.test_template_id = payment_procedure_templates.id', 'left');
        $this->db->join('users', 'lab_quality_control.performed_by = users.id', 'left');
        $this->db->where('lab_quality_control.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($from_date) {
            $this->db->where('DATE(lab_quality_control.control_date) >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('DATE(lab_quality_control.control_date) <=', $to_date);
        }
        
        $this->db->order_by('lab_quality_control.control_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
} 