<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Labworkflow extends MX_Controller {

    private $settings;

    function __construct() {
        parent::__construct();
        $this->load->model('labworkflow_model');
        $this->load->model('lab/lab_model');
        $this->load->model('patient/patient_model');
        $this->load->model('settings/settings_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('finance/finance_model');
        $this->load->library('pagination');
        
        if (!$this->ion_auth->in_group(array('admin', 'Laboratorist', 'Doctor', 'Nurse'))) {
            redirect('home/permission');
        }

        $this->settings = $this->settings_model->getSettings();
    } 
 
    public function index() { 
        $data = [];
        $data['page'] = 'Lab Workflow';
        $data['page_title'] = 'Lab Workflow Management';
        $data['specimens'] = $this->labworkflow_model->getLabSpecimens();
        $data['templates'] = $this->labworkflow_model->getLabTestTemplates();
        $data['settings'] = $this->settings_model->getSettings();
        $data['labs'] = $this->lab_model->getLab();
        
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('dashboard', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('dashboard', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('dashboard', $data);
            $this->load->view('home/footer'); 
        }
    }

    // Specimen Management
    public function specimens() {
        $data = [];
        $data['page'] = 'Specimens';
        $data['page_title'] = 'Specimen Management';
        $data['specimens'] = $this->labworkflow_model->getLabSpecimens();
        $data['specimen_types'] = $this->labworkflow_model->getSpecimenTypes();
        
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('Specimens', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('Specimens', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('Specimens', $data);
            $this->load->view('home/footer'); 
        }
    }

    public function addSpecimen() {
        $this->form_validation->set_rules('patient_id', 'Patient', 'required');
        $this->form_validation->set_rules('specimen_type_id', 'Specimen Type', 'required');
        $this->form_validation->set_rules('collection_date', 'Collection Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $data['page'] = 'Add Specimen';
            $data['page_title'] = 'Collect Specimen';
            $data['specimen_types'] = $this->labworkflow_model->getSpecimenTypes();
            $data['patients'] = $this->patient_model->getPatient();
            
            if($this->ion_auth->in_group('admin')){                
                if($this->settings->dashboard_theme == 'main'){
                    $this->load->view('home/layout/header'); 
                    $this->load->view('add_specimen', $data);
                    $this->load->view('home/layout/footer'); 
                }else{
                    $this->load->view('home/dashboard'); 
                    $this->load->view('add_specimen', $data);
                    $this->load->view('home/footer'); 
                }
            } else {
                $this->load->view('home/dashboard'); 
                $this->load->view('add_specimen', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            // Generate unique specimen ID
            $specimen_id = 'SPEC-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
            
            $data = array(
                'specimen_id' => $specimen_id,
                'patient_id' => $this->input->post('patient_id'),
                'specimen_type_id' => $this->input->post('specimen_type_id'),
                'collection_date' => $this->input->post('collection_date'),
                'collection_method' => $this->input->post('collection_method'),
                'quantity' => $this->input->post('quantity'),
                'quantity_unit' => $this->input->post('quantity_unit'),
                'container_type' => $this->input->post('container_type'),
                'condition_on_collection' => $this->input->post('condition_on_collection'),
                'collected_by' => $this->session->userdata('user_id'),
                'notes' => $this->input->post('notes'),
                'status' => 'collected'
            );

            $specimen_db_id = $this->labworkflow_model->insertLabSpecimen($data);
            
            $this->session->set_flashdata('success', 'Specimen collected successfully. Specimen ID: ' . $specimen_id);
            redirect('labworkflow/specimens');
        }
    }

    public function receiveSpecimen($id) {
        $specimen = $this->labworkflow_model->getLabSpecimenById($id);
        
        if (!$specimen) {
            $this->session->set_flashdata('error', 'Specimen not found');
            redirect('labworkflow/specimens');
        }

        if ($this->input->post()) {
            $update_data = array(
                'condition_on_receipt' => $this->input->post('condition_on_receipt'),
                'received_date' => date('Y-m-d H:i:s'),
                'received_by' => $this->session->userdata('user_id'),
                'status' => 'received',
                'notes' => $specimen->notes . "\n" . $this->input->post('notes')
            );

            $this->labworkflow_model->updateLabSpecimen($id, $update_data);
            $this->session->set_flashdata('success', 'Specimen received successfully');
            redirect('labworkflow/specimens');
        }

        $data = [];
        $data['page'] = 'Receive Specimen';
        $data['page_title'] = 'Receive Specimen';
        $data['specimen'] = $specimen;
        $this->load->view('home/dashboard', $data);
    }

    // Test Templates Management
    public function testTemplates() {
        $data = [];
        $data['page'] = 'Test Templates';
        $data['page_title'] = 'Lab Test Templates';
        $data['templates'] = $this->labworkflow_model->getLabTestTemplates();
        
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('TestTemplates', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('TestTemplates', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('TestTemplates', $data);
            $this->load->view('home/footer'); 
        }
    }

    public function addTestTemplate() {
        $this->form_validation->set_rules('name', 'Template Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('specimen_type_id', 'Specimen Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $data['page'] = 'Add Test Template';
            $data['page_title'] = 'Create Test Template';
            $data['categories'] = $this->lab_model->getLabCategory();
            $data['specimen_types'] = $this->labworkflow_model->getSpecimenTypes();
            
            if($this->ion_auth->in_group('admin')){                
                if($this->settings->dashboard_theme == 'main'){
                    $this->load->view('home/layout/header'); 
                    $this->load->view('add_test_template', $data);
                    $this->load->view('home/layout/footer'); 
                }else{
                    $this->load->view('home/dashboard'); 
                    $this->load->view('add_test_template', $data);
                    $this->load->view('home/footer'); 
                }
            } else {
                $this->load->view('home/dashboard'); 
                $this->load->view('add_test_template', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $test_code = $this->input->post('test_code');
            if (empty($test_code)) {
                $test_code = 'TEST-' . strtoupper(substr(md5(uniqid()), 0, 8));
            }

            $data = array(
                'name' => $this->input->post('name'),
                'test_code' => $test_code,
                'category_id' => $this->input->post('category_id'),
                'specimen_type_id' => $this->input->post('specimen_type_id'),
                'normal_range' => $this->input->post('normal_range'),
                'units' => $this->input->post('units'),
                'methodology' => $this->input->post('methodology'),
                'preparation_instructions' => $this->input->post('preparation_instructions'),
                'result_template' => $this->input->post('result_template'),
                'turnaround_time' => $this->input->post('turnaround_time') ?: 0,
                'cost' => $this->input->post('cost') ?: 0.00,
                'is_active' => 1,
                'created_by' => $this->session->userdata('user_id')
            );

            $this->labworkflow_model->insertLabTestTemplate($data);
            $this->session->set_flashdata('success', 'Test template created successfully');
            redirect('labworkflow/testTemplates');
        }
    }

    public function editTestTemplate($id) {
        $template = $this->labworkflow_model->getLabTestTemplateById($id);
        
        if (!$template) {
            $this->session->set_flashdata('error', 'Template not found');
            redirect('labworkflow/testTemplates');
        }

        $this->form_validation->set_rules('name', 'Template Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('specimen_type_id', 'Specimen Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $data['page'] = 'Edit Test Template';
            $data['page_title'] = 'Edit Test Template';
            $data['template'] = $template;
            $data['categories'] = $this->lab_model->getLabCategory();
            $data['specimen_types'] = $this->labworkflow_model->getSpecimenTypes();
            $this->load->view('home/dashboard', $data);
        } else {
            $update_data = array(
                'name' => $this->input->post('name'),
                'category_id' => $this->input->post('category_id'),
                'specimen_type_id' => $this->input->post('specimen_type_id'),
                'normal_range' => $this->input->post('normal_range'),
                'units' => $this->input->post('units'),
                'methodology' => $this->input->post('methodology'),
                'preparation_instructions' => $this->input->post('preparation_instructions'),
                'result_template' => $this->input->post('result_template'),
                'turnaround_time' => $this->input->post('turnaround_time') ?: 0,
                'cost' => $this->input->post('cost') ?: 0.00,
                'is_active' => $this->input->post('is_active') ? 1 : 0
            );

            $this->labworkflow_model->updateLabTestTemplate($id, $update_data);
            $this->session->set_flashdata('success', 'Test template updated successfully');
            redirect('labworkflow/testTemplates');
        }
    }

    // Enhanced Lab Test Management
    public function labTests() {
        $data = [];
        $data['page'] = 'Lab Tests';
        $data['page_title'] = 'Lab Tests Management';
        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings;
        $data['categories'] = $this->finance_model->getPaymentCategory(); // Use payment categories like testStatus
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('LabTests', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('LabTests', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('LabTests', $data);
            $this->load->view('home/footer'); 
        }
    }

    // Method to get lab tests grouped by invoice
    private function getGroupedLabTests() {
        $this->db->select('
            MIN(lab.id) as id,
            lab.patient,
            lab.patient_name,
            lab.patient_phone,
            lab.patient_address,
            lab.doctor,
            lab.doctor_name,
            lab.date,
            lab.date_string,
            lab.invoice_id,
            lab.status,
            GROUP_CONCAT(lab.category SEPARATOR ", ") as combined_test_names,
            COUNT(lab.id) as test_count
        ');
        $this->db->from('lab');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->group_by('lab.invoice_id');
        $this->db->order_by('lab.date', 'DESC');
        
        return $this->db->get()->result();
    }

    public function addLabTest() {
        $this->form_validation->set_rules('patient_id', 'Patient', 'required');
        $this->form_validation->set_rules('test_template_id', 'Test Template', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $data['page'] = 'Add Lab Test';
            $data['page_title'] = 'Order Lab Test';
            $data['test_templates'] = $this->labworkflow_model->getLabTestTemplates();
            $data['specimens'] = $this->labworkflow_model->getLabSpecimensForTesting();
            $data['patients'] = $this->patient_model->getPatient();
            
            if($this->ion_auth->in_group('admin')){                
                if($this->settings->dashboard_theme == 'main'){
                    $this->load->view('home/layout/header'); 
                    $this->load->view('add_lab_test', $data);
                    $this->load->view('home/layout/footer'); 
                }else{
                    $this->load->view('home/dashboard'); 
                    $this->load->view('add_lab_test', $data);
                    $this->load->view('home/footer'); 
                }
            } else {
                $this->load->view('home/dashboard'); 
                $this->load->view('add_lab_test', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            // Get template info
            $template = $this->labworkflow_model->getLabTestTemplateById($this->input->post('test_template_id'));
            
            $lab_data = array(
                'patient' => $this->input->post('patient_id'),
                'patient_name' => $this->input->post('patient_name'),
                'patient_phone' => $this->input->post('patient_phone'),
                'patient_address' => $this->input->post('patient_address'),
                'doctor' => $this->input->post('doctor'),
                'doctor_name' => $this->input->post('doctor_name'),
                'date' => strtotime(date('Y-m-d')),
                'date_string' => date('Y-m-d'),
                'category' => $template->name,
                'category_id' => $template->category_id,
                'specimen_id' => $this->input->post('specimen_id'),
                'test_template_id' => $this->input->post('test_template_id'),
                'collection_date' => $this->input->post('collection_date'),
                'result_entry_method' => 'manual',
                'test_status' => 'not_done',
                'status' => 'pending'
            );

            $lab_id = $this->lab_model->insertLab($lab_data);

            // Link specimen to test if provided
            if ($this->input->post('specimen_id')) {
                $this->labworkflow_model->updateLabSpecimen($this->input->post('specimen_id'), 
                    array('status' => 'processing'));
            }

            $this->session->set_flashdata('success', 'Lab test ordered successfully');
            redirect('labworkflow/labTests');
        }
    }

    public function enterResults($lab_id) {
        $lab_test = $this->labworkflow_model->getEnhancedLabTestById($lab_id);
        
        if (!$lab_test) {
            $this->session->set_flashdata('error', 'Lab test not found');
            redirect('labworkflow/labTests');
        }

        if ($this->input->post()) {
            $result_entry_method = $this->input->post('result_entry_method');
            
            $update_data = array(
                'report' => $this->input->post('report'),
                'result_entry_method' => $result_entry_method,
                'critical_values' => $this->input->post('critical_values'),
                'interpretation' => $this->input->post('interpretation'),
                'technician_id' => $this->session->userdata('user_id'),
                'test_status' => 'done',
                'status' => 'pending'
            );

            // Handle file upload for results
            if ($result_entry_method == 'upload' && !empty($_FILES['result_file']['name'])) {
                $config['upload_path'] = './uploads/lab_results/';
                $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx';
                $config['file_name'] = 'lab_result_' . $lab_id . '_' . time();
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('result_file')) {
                    $file_data = $this->upload->data();
                    $update_data['result_file_path'] = 'uploads/lab_results/' . $file_data['file_name'];
                    $update_data['result_file_type'] = $file_data['file_ext'];
                }
            }

            $this->lab_model->updateLab($lab_id, $update_data);

            // Save individual result values if provided
            $parameters = $this->input->post('parameters');
            $values = $this->input->post('values');
            $reference_ranges = $this->input->post('reference_ranges');
            $units = $this->input->post('units');
            $statuses = $this->input->post('statuses');

            if ($parameters && $values) {
                for ($i = 0; $i < count($parameters); $i++) {
                    if (!empty($parameters[$i]) && !empty($values[$i])) {
                        $result_data = array(
                            'lab_id' => $lab_id,
                            'parameter_name' => $parameters[$i],
                            'result_value' => $values[$i],
                            'reference_range' => $reference_ranges[$i] ?? '',
                            'units' => $units[$i] ?? '',
                            'status' => $statuses[$i] ?? 'normal'
                        );
                        
                        $this->labworkflow_model->insertLabResultValue($result_data);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Results entered successfully');
            redirect('labworkflow/labTests');
        }

        $data = [];
        $data['page'] = 'Enter Results';
        $data['page_title'] = 'Enter Lab Results';
        $data['lab_test'] = $lab_test;
        $data['result_values'] = $this->labworkflow_model->getLabResultValues($lab_id);
        $this->load->view('home/dashboard', $data);
    }

    public function verifyResults($lab_id) {
        $lab_test = $this->labworkflow_model->getEnhancedLabTestById($lab_id);
        
        if (!$lab_test) {
            $this->session->set_flashdata('error', 'Lab test not found');
            redirect('labworkflow/labTests');
        }

        if ($this->input->post()) {
            $update_data = array(
                'verified_by' => $this->session->userdata('user_id'),
                'verification_date' => date('Y-m-d H:i:s'),
                'status' => 'completed',
                'quality_control' => $this->input->post('quality_control')
            );

            $this->lab_model->updateLab($lab_id, $update_data);

            // Update specimen status if linked
            if ($lab_test->specimen_id) {
                $this->labworkflow_model->updateLabSpecimen($lab_test->specimen_id, 
                    array('status' => 'completed'));
            }

            $this->session->set_flashdata('success', 'Results verified successfully');
            redirect('labworkflow/labTests');
        }

        $data = [];
        $data['page'] = 'Verify Results';
        $data['page_title'] = 'Verify Lab Results';
        $data['lab_test'] = $lab_test;
        $data['result_values'] = $this->labworkflow_model->getLabResultValues($lab_id);
        $this->load->view('home/dashboard', $data);
    }

    // Specimen Types Management
    public function specimenTypes() {
        $data = [];
        $data['page'] = 'Specimen Types';
        $data['page_title'] = 'Specimen Types';
        $data['specimen_types'] = $this->labworkflow_model->getSpecimenTypes();
        $this->load->view('home/dashboard', $data);
    }

    public function addSpecimenType() {
        $this->form_validation->set_rules('name', 'Specimen Type Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $data['page'] = 'Add Specimen Type';
            $data['page_title'] = 'Add Specimen Type';
            $this->load->view('home/dashboard', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'collection_requirements' => $this->input->post('collection_requirements'),
                'storage_requirements' => $this->input->post('storage_requirements'),
                'processing_time' => $this->input->post('processing_time') ?: 0
            );

            $this->labworkflow_model->insertSpecimenType($data);
            $this->session->set_flashdata('success', 'Specimen type added successfully');
            redirect('labworkflow/specimenTypes');
        }
    }

    // Quality Control
    public function qualityControl() {
        $data = [];
        $data['page'] = 'Quality Control';
        $data['page_title'] = 'Lab Quality Control';
        $data['qc_records'] = $this->labworkflow_model->getQualityControlRecords();
        
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('QualityControl', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('QualityControl', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('QualityControl', $data);
            $this->load->view('home/footer'); 
        }
    }

    public function addQCRecord() {
        $this->form_validation->set_rules('control_type', 'Control Type', 'required');
        $this->form_validation->set_rules('control_date', 'Control Date', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $data['page'] = 'Add QC Record';
            $data['page_title'] = 'Add Quality Control Record';
            $data['test_templates'] = $this->labworkflow_model->getLabTestTemplates();
            
            if($this->ion_auth->in_group('admin')){                
                if($this->settings->dashboard_theme == 'main'){
                    $this->load->view('home/layout/header'); 
                    $this->load->view('add_qc_record', $data);
                    $this->load->view('home/layout/footer'); 
                }else{
                    $this->load->view('home/dashboard'); 
                    $this->load->view('add_qc_record', $data);
                    $this->load->view('home/footer'); 
                }
            } else {
                $this->load->view('home/dashboard'); 
                $this->load->view('add_qc_record', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $data = array(
                'control_type' => $this->input->post('control_type'),
                'test_template_id' => $this->input->post('test_template_id'),
                'control_date' => $this->input->post('control_date'),
                'control_lot' => $this->input->post('control_lot'),
                'expected_value' => $this->input->post('expected_value'),
                'actual_value' => $this->input->post('actual_value'),
                'acceptable_range' => $this->input->post('acceptable_range'),
                'status' => $this->input->post('status'),
                'performed_by' => $this->session->userdata('user_id'),
                'notes' => $this->input->post('notes'),
                'corrective_action' => $this->input->post('corrective_action')
            );

            $this->labworkflow_model->insertQualityControlRecord($data);
            $this->session->set_flashdata('success', 'QC record added successfully');
            redirect('labworkflow/qualityControl');
        }
    }

    // Reports
    public function reports() {
        $data = [];
        $data['page'] = 'Workflow Reports';
        $data['page_title'] = 'Lab Workflow Reports';
        
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $specimen_type = $this->input->get('specimen_type');
        
        $data['specimen_report'] = $this->labworkflow_model->getSpecimenReport($from_date, $to_date, $specimen_type);
        $data['test_template_usage'] = $this->labworkflow_model->getTestTemplateUsageReport($from_date, $to_date);
        $data['turnaround_time_report'] = $this->labworkflow_model->getTurnaroundTimeReport($from_date, $to_date);
        $data['qc_summary'] = $this->labworkflow_model->getQCReport($from_date, $to_date);
        $data['specimen_types'] = $this->labworkflow_model->getSpecimenTypes();
        
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('Reports', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('Reports', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('Reports', $data);
            $this->load->view('home/footer'); 
        }
    }

    // AJAX Methods
    public function getPatientInfo($searchTerm = '') {
        $patients = $this->patient_model->getPatientInfo($searchTerm);
        echo json_encode($patients);
    }

    public function getTestTemplateInfo($id) {
        $template = $this->labworkflow_model->getLabTestTemplateById($id);
        echo json_encode($template);
    }

    public function getSpecimenInfo($searchTerm = '') {
        $specimens = $this->labworkflow_model->getSpecimenInfo($searchTerm);
        echo json_encode($specimens);
    }

    // New modern report writing interface
    public function writeReport($invoice_id = null) {
        // Get invoice_id from URL segment if not passed as parameter
        if (!$invoice_id) {
            $invoice_id = $this->uri->segment(3);
        }
        
        if (!$invoice_id) {
            $this->session->set_flashdata('error', 'Invalid invoice ID');
            redirect('labworkflow/labTests');
            return;
        }

        // Get lab tests for this invoice
        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $lab_tests = $this->db->get('lab')->result();

        // If no tests found by invoice_id, try alternative search
        if (empty($lab_tests)) {
            $payment = $this->db->get_where('payment', array('id' => $invoice_id))->row();
            if ($payment) {
                $this->db->where('patient', $payment->patient);
                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                $payment_date = date('Y-m-d', $payment->date);
                $this->db->where('date_string', $payment_date);
                $lab_tests = $this->db->get('lab')->result();
            }
        }

        if (empty($lab_tests)) {
            $this->session->set_flashdata('error', 'No tests found for invoice ' . $invoice_id);
            redirect('labworkflow/labTests');
            return;
        }

        // Prepare data
        $data = array(
            'page' => 'Write Report',
            'page_title' => 'Lab Report Writing',
            'lab_tests' => $lab_tests,
            'invoice_id' => $invoice_id,
            'settings' => $this->settings
        );
        
        // Get patient info
        $data['patient'] = $this->patient_model->getPatientById($lab_tests[0]->patient);
        if (!$data['patient']) {
            $data['patient'] = (object) array(
                'id' => $lab_tests[0]->patient,
                'name' => $lab_tests[0]->patient_name ?? 'Unknown Patient',
                'patient_id' => 'P' . $lab_tests[0]->patient,
                'age' => 'Unknown',
                'sex' => 'Unknown',
                'phone' => $lab_tests[0]->patient_phone ?? 'N/A'
            );
        }
        
        // Get doctor info
        $data['doctor'] = $this->doctor_model->getDoctorById($lab_tests[0]->doctor);
        if (!$data['doctor']) {
            $data['doctor'] = (object) array(
                'id' => $lab_tests[0]->doctor,
                'name' => $lab_tests[0]->doctor_name ?? 'Unknown Doctor'
            );
        }
        
        // Get additional data
        $data['payment_categories'] = $this->finance_model->getPaymentCategory();
        $data['specimen_types'] = array(); // Use default options in view
        $data['lab_test_templates'] = array();
        $data['specimens'] = array();
        
        // Get existing lab result values and test names
        $result_values = array();
        foreach ($lab_tests as $test) {
            $this->db->where('lab_id', $test->id);
            $result_values[$test->id] = $this->db->get('lab_result_values')->result();
            
            // Get test name from payment category
            if (!empty($test->category_id)) {
                $category = $this->db->get_where('payment_category', array('id' => $test->category_id))->row();
                if ($category) {
                    $test->test_name = $category->category;
                } else {
                    $test->test_name = $test->category; // fallback
                }
            } else {
                $test->test_name = $test->category; // fallback
            }
        }
        $data['result_values'] = $result_values;
        
        // Get payment procedure templates and link them to tests
        $data['lab_test_templates'] = array();
        $data['test_templates'] = array(); // Templates assigned to specific tests
        
        if ($this->db->table_exists('payment_procedure_templates')) {
            // Get all diagnostic templates
            $this->db->where('procedure_type', 'diagnostic_test');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('is_active', 1);
            $data['lab_test_templates'] = $this->db->get('payment_procedure_templates')->result();
            
            // Get templates assigned to each test's category
            foreach ($lab_tests as $test) {
                if (!empty($test->category_id)) {
                    // Get the payment category for this test
                    $this->db->where('id', $test->category_id);
                    $category = $this->db->get('payment_category')->row();
                    
                    if ($category && !empty($category->template_id)) {
                        // Get the assigned template
                        $this->db->where('id', $category->template_id);
                        $template = $this->db->get('payment_procedure_templates')->row();
                        
                        if ($template) {
                            // Get template fields
                            $this->db->where('template_id', $template->id);
                            $this->db->order_by('field_order', 'asc');
                            $template_fields = $this->db->get('payment_procedure_template_fields')->result();
                            $template->fields = $template_fields;
                            
                            $data['test_templates'][$test->id] = $template;
                        }
                    }
                }
            }
        }
        
        // Load view
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('write_report_enhanced', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('write_report_enhanced', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('write_report_enhanced', $data);
            $this->load->view('home/footer'); 
        }
    }

    // Enhanced save report method
    public function saveReport() {
        $invoice_id = $this->input->post('invoice_id');
        $test_reports = $this->input->post('test_reports');
        $specimens = $this->input->post('specimens'); // Per-test specimens
        $template_fields = $this->input->post('template_fields'); // Template field values
        $template_status = $this->input->post('template_status'); // Template field status
        
        // Debug: Log what data we received
        log_message('debug', 'SaveReport - Invoice ID: ' . $invoice_id);
        log_message('debug', 'SaveReport - Patient ID: ' . $this->input->post('patient_id'));
        log_message('debug', 'SaveReport - All POST data: ' . json_encode($_POST));
        log_message('debug', 'SaveReport - Specimens received: ' . json_encode($specimens));
        log_message('debug', 'SaveReport - Test reports received: ' . json_encode($test_reports));
        log_message('debug', 'SaveReport - Template fields received: ' . json_encode($template_fields));
        
        // CRITICAL DEBUG: Check if we're receiving inventory data at all
        $raw_inventory_data = $this->input->post('inventory_usage');
        log_message('debug', 'SaveReport - RAW inventory_usage POST data: ' . json_encode($raw_inventory_data));
        log_message('debug', 'SaveReport - inventory_usage is_array: ' . (is_array($raw_inventory_data) ? 'YES' : 'NO'));
        log_message('debug', 'SaveReport - inventory_usage count: ' . (is_array($raw_inventory_data) ? count($raw_inventory_data) : 'N/A'));

        // Save per-test specimens if provided
        if (!empty($specimens)) {
            foreach ($specimens as $test_id => $specimen_data) {
                if (!empty($specimen_data['specimen_type'])) {
                    $specimen_insert_data = array(
                        'specimen_id' => 'SPEC-' . $test_id . '-' . time(),
                        'lab_id' => $test_id, // Use lab_id instead of lab_test_id
                        'patient_id' => $this->input->post('patient_id'),
                'specimen_type_id' => $specimen_data['specimen_type'],
                'collection_date' => $specimen_data['collection_date'],
                        'collected_by' => $specimen_data['collected_by'] ?: $this->session->userdata('user_id'),
                'collection_method' => $specimen_data['collection_method'],
                        'volume_amount' => ($specimen_data['quantity'] ?? '') . ' ' . ($specimen_data['quantity_unit'] ?? ''),
                'container_type' => $specimen_data['container_type'],
                        'condition_on_receipt' => $specimen_data['condition'],
                        'received_date' => date('Y-m-d H:i:s'),
                        'received_by' => $this->session->userdata('user_id'),
                        'status' => 'received',
                        'invoice_id' => $invoice_id,
                'hospital_id' => $this->session->userdata('hospital_id')
            );
                    
                    // Insert specimen if table exists
                    if ($this->db->table_exists('lab_specimens')) {
                        $insert_result = $this->db->insert('lab_specimens', $specimen_insert_data);
                        
                        // Log error if insert fails
                        if (!$insert_result) {
                            log_message('error', 'Failed to insert specimen for test ' . $test_id . ': ' . $this->db->error()['message']);
                        }
                    }
                }
            }
        }
        
        // Save template field values if provided
        log_message('debug', 'Processing template fields...');
        if (!empty($template_fields)) {
            log_message('debug', 'Template fields not empty, processing ' . count($template_fields) . ' tests');
            foreach ($template_fields as $test_id => $fields) {
                log_message('debug', 'Processing test ID: ' . $test_id . ' with ' . count($fields) . ' fields');
                foreach ($fields as $field_id => $field_value) {
                    log_message('debug', 'Field ID: ' . $field_id . ', Value: "' . $field_value . '"');
                    if (!empty($field_value)) {
                        // Get field details to populate proper column names
                        $this->db->where('id', $field_id);
                        $field_details = $this->db->get('payment_procedure_template_fields')->row();
                        
                        // Get status for this field
                        $field_status = 'normal'; // default
                        if (isset($template_status[$test_id][$field_id])) {
                            $field_status = $template_status[$test_id][$field_id];
                        }
                        
                        $template_result_data = array(
                            'lab_id' => $test_id,
                            'parameter_name' => $field_details ? $field_details->field_label : 'Parameter ' . $field_id,
                            'result_value' => $field_value,
                            'reference_range' => $field_details ? ($field_details->reference_value ?: $field_details->reference_range ?: '') : '',
                            'units' => $field_details ? $field_details->units : '',
                            'status' => $field_status,
                            'hospital_id' => $this->session->userdata('hospital_id'),
                            'created_at' => date('Y-m-d H:i:s')
                        );
                        
                        log_message('debug', 'Inserting lab result: ' . json_encode($template_result_data));
                        
                        // Check if result already exists for this lab_id and parameter
                        $this->db->where('lab_id', $test_id);
                        $this->db->where('parameter_name', $template_result_data['parameter_name']);
                        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                        $existing_result = $this->db->get('lab_result_values')->row();
                        
                        if ($existing_result) {
                            // Update existing result
                            $this->db->where('id', $existing_result->id);
                            $insert_result = $this->db->update('lab_result_values', $template_result_data);
                            log_message('debug', 'Updated existing lab result');
                        } else {
                            // Insert new result
                            $insert_result = $this->db->insert('lab_result_values', $template_result_data);
                            log_message('debug', 'Inserted new lab result');
                        }
                        
                        if ($insert_result) {
                            log_message('debug', 'Successfully saved template field result');
                        } else {
                            log_message('error', 'Failed to save template field result: ' . $this->db->error()['message']);
                        }
                    } else {
                        log_message('debug', 'Skipping empty field value for field ID: ' . $field_id);
                }
            }
            }
        } else {
            log_message('debug', 'No template fields received in POST data');
        }

        // Save test reports
        if ($test_reports) {
            foreach ($test_reports as $test_id => $report_data) {
                $update_data = array(
                    'report' => $report_data['report'],
                    'interpretation' => $report_data['interpretation'],
                    'critical_values' => $report_data['critical_values'],
                    'status' => 'completed',
                    'test_status' => 'done',
                    'updated_on' => time(),
                    'reported_by' => $this->session->userdata('user_id')
                );
                
                $this->db->where('id', $test_id);
                $this->db->update('lab', $update_data);
            }
        }

        // Check if there are existing inventory usage records for this invoice
        $this->db->where('reference_id', $invoice_id);
        $this->db->where('reference_type', 'lab_test');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $inventory_usage_count = $this->db->count_all_results('inventory_usage');
        
        log_message('debug', 'Existing inventory usage records for invoice ' . $invoice_id . ': ' . $inventory_usage_count);
        
        // Note: Inventory is now saved separately via saveInventoryUsage() method
        // This method only handles lab reports and test results
        
        // Create detailed success message
        $success_details = array();
        $success_details[] = 'Lab report saved successfully';
        
        if (!empty($specimens)) {
            $specimen_count = count($specimens);
            $success_details[] = $specimen_count . ' specimen record(s) processed';
        }
        
        if (!empty($template_fields)) {
            $template_field_count = 0;
            foreach ($template_fields as $test_fields) {
                $template_field_count += count($test_fields);
            }
            $success_details[] = $template_field_count . ' template field(s) saved';
        }
        
        if (!empty($test_reports)) {
            $report_count = count($test_reports);
            $success_details[] = $report_count . ' test report(s) updated';
        }
        
        if ($inventory_usage_count > 0) {
            $success_details[] = $inventory_usage_count . ' inventory item(s) recorded';
        } else if (!empty($inventory_usage)) {
            $success_details[] = 'Inventory items processed but none recorded (check logs for details)';
        }
        
        // Log final success message for debugging
        log_message('debug', 'Final success message: ' . implode(' • ', $success_details));
        
        // Check if this is an AJAX request
        if ($this->input->is_ajax_request()) {  
            // Return JSON response for AJAX
            $response = array(
                'success' => true,
                'message' => implode(' • ', $success_details),
                'inventory_count' => $inventory_usage_count,
                'total_fields_saved' => !empty($template_fields) ? array_sum(array_map('count', $template_fields)) : 0
            );
            
            log_message('debug', 'Sending AJAX response: ' . json_encode($response));
            
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        } else {
            // Regular form submission - redirect
            $this->session->set_flashdata('success', implode(' • ', $success_details));
            redirect('labworkflow/labTests');
        }
    }

    // New method to generate PDF for individual test results
    public function generateTestPdf($test_id = null) {
        // Get test_id from URL segment if not passed as parameter
        if (!$test_id) {
            $test_id = $this->uri->segment(3);
        }
        
        if (!$test_id) {
            $this->session->set_flashdata('error', 'Invalid test ID');
            redirect('labworkflow/labTests');
            return;
        }

        // Get specific lab test
        $this->db->where('id', $test_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $lab_test = $this->db->get('lab')->row();

        if (!$lab_test) {
            $this->session->set_flashdata('error', 'Test not found');
            redirect('labworkflow/labTests');
            return;
        }

        // Get patient info
        $patient = $this->patient_model->getPatientById($lab_test->patient);
        if (!$patient) {
            $this->session->set_flashdata('error', 'Patient not found');
            redirect('labworkflow/labTests');
            return;
        }

        // Get doctor info
        $doctor = null;
        if ($lab_test->doctor) {
            $doctor = $this->doctor_model->getDoctorById($lab_test->doctor);
        }

        // Get hospital settings
        $settings = $this->settings_model->getSettings();

        // Get detailed results and specimen info for this specific test
        // Get template field results
        $this->db->where('lab_id', $test_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $lab_test->template_results = $this->db->get('lab_result_values')->result();

        // Get specimen info
        $this->db->where('lab_id', $test_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $lab_test->specimen_info = $this->db->get('lab_specimens')->row();

        // Get test category name
        if ($lab_test->category_id) {
            $category = $this->db->get_where('payment_category', array('id' => $lab_test->category_id))->row();
            $lab_test->category_name = $category ? $category->category : $lab_test->category;
        } else {
            $lab_test->category_name = $lab_test->category;
        }

        // Prepare data for PDF (single test)
        $data = array(
            'lab_tests' => array($lab_test), // Single test in array for consistency with template
            'patient' => $patient,
            'doctor' => $doctor,
            'settings' => $settings,
            'invoice_id' => $lab_test->invoice_id ?: 'N/A',
            'generated_date' => date('Y-m-d H:i:s'),
            'generated_by' => $this->session->userdata('user_name') ?: $this->session->userdata('username')
        );

        // Load the PDF view
        $html = $this->load->view('labworkflow_report_pdf', $data, true);

        // Initialize mPDF with proper settings to avoid header overlap
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 30,     // Reduced top margin
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        // Create simplified header for individual test
        $header = $this->generateSimpleHeader($data);
        
        // Create footer content  
        $footer = $this->generateReportFooter($data);

        // Set header and footer
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);

        // Write HTML content
        $mpdf->WriteHTML($html);

        // Output PDF
        $filename = 'LAB-TEST-' . $test_id . '_' . date('d-m-Y-H-i') . '.pdf';
        $mpdf->Output($filename, 'D');
    }

    // Helper method to generate simple header for individual test
    private function generateSimpleHeader($data) {
        $settings = $data['settings'];
        $patient = $data['patient'];
        $test = $data['lab_tests'][0]; // Get the single test
        
        $header = '
        <table width="100%" style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
            <tr>
                <td width="70%" style="vertical-align: top;">
                    <h3 style="margin: 0; color: #2c3e50; font-size: 16px;">' . $settings->system_vendor . '</h3>
                    <p style="margin: 2px 0; font-size: 10px; color: #666;">' . $settings->address . '</p>
                    <p style="margin: 2px 0; font-size: 10px; color: #666;">Tel: ' . $settings->phone . '</p>
                </td>
                <td width="30%" style="text-align: right; vertical-align: top; font-size: 10px;">
                    <strong>Patient:</strong> ' . $patient->name . '<br>
                    <strong>Test:</strong> ' . $test->category_name . '<br>
                    <strong>Date:</strong> ' . date('d-m-Y') . '
                </td>
            </tr>
        </table>';
        
        return $header;
    }

    // Modified original method to handle invoice-level reports properly
    public function generateReportPdf($invoice_id = null) {
        // Get invoice_id from URL segment if not passed as parameter
        if (!$invoice_id) {
            $invoice_id = $this->uri->segment(3);
        }
        
        if (!$invoice_id) {
            $this->session->set_flashdata('error', 'Invalid invoice ID');
            redirect('labworkflow/labTests');
            return;
        }

        // Get lab tests for this invoice
        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'ASC');
        $lab_tests = $this->db->get('lab')->result();

        if (empty($lab_tests)) {
            $this->session->set_flashdata('error', 'No tests found for invoice ' . $invoice_id);
            redirect('labworkflow/labTests');
            return;
        }

        // Get patient info from first test
        $patient = $this->patient_model->getPatientById($lab_tests[0]->patient);
        if (!$patient) {
            $this->session->set_flashdata('error', 'Patient not found');
            redirect('labworkflow/labTests');
            return;
        }

        // Get doctor info
        $doctor = null;
        if ($lab_tests[0]->doctor) {
            $doctor = $this->doctor_model->getDoctorById($lab_tests[0]->doctor);
        }

        // Get hospital settings
        $settings = $this->settings_model->getSettings();

        // For each test, get detailed results and specimen info
        foreach ($lab_tests as &$test) {
            // Get template field results
            $this->db->where('lab_id', $test->id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $test->template_results = $this->db->get('lab_result_values')->result();

            // Get specimen info
            $this->db->where('lab_id', $test->id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $test->specimen_info = $this->db->get('lab_specimens')->row();

            // Get test category name
            if ($test->category_id) {
                $category = $this->db->get_where('payment_category', array('id' => $test->category_id))->row();
                $test->category_name = $category ? $category->category : $test->category;
            } else {
                $test->category_name = $test->category;
            }
        }

        // Prepare data for PDF
        $data = array(
            'lab_tests' => $lab_tests,
            'patient' => $patient,
            'doctor' => $doctor,
            'settings' => $settings,
            'invoice_id' => $invoice_id,
            'generated_date' => date('Y-m-d H:i:s'),
            'generated_by' => $this->session->userdata('user_name') ?: $this->session->userdata('username')
        );

        // Load the PDF view
        $html = $this->load->view('labworkflow_report_pdf', $data, true);

        // Initialize mPDF with proper settings to avoid header overlap
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 35,     // Adequate top margin for header
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        // Create header content
        $header = $this->generateReportHeader($data);
        
        // Create footer content  
        $footer = $this->generateReportFooter($data);

        // Set header and footer
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);

        // Write HTML content
        $mpdf->WriteHTML($html);

        // Output PDF
        $filename = 'LAB-REPORT-' . $invoice_id . '_' . date('d-m-Y-H-i') . '.pdf';
        $mpdf->Output($filename, 'D');
    }

    // Helper method to generate PDF header
    private function generateReportHeader($data) {
        $settings = $data['settings'];
        $patient = $data['patient'];
        $invoice_id = $data['invoice_id'];
        
        $logo_path = base_url() . $settings->logo;
        
        $header = '
        <div style="border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 15px;">
            <table width="100%" style="border: none;">
                <tr>
                    <td width="20%" style="text-align: left; vertical-align: top;">
                        <img src="' . $logo_path . '" style="max-width: 80px; max-height: 60px;" />
                    </td>
                    <td width="50%" style="text-align: center; vertical-align: top;">
                        <h2 style="color: #2c3e50; margin: 0; font-size: 18px;">' . $settings->system_vendor . '</h2>
                        <p style="margin: 2px 0; font-size: 11px; color: #666;">' . $settings->address . '</p>
                        <p style="margin: 2px 0; font-size: 11px; color: #666;">Tel: ' . $settings->phone . ' | Email: ' . $settings->email . '</p>
                        <h3 style="color: #007bff; margin: 8px 0 0 0; font-size: 16px;">LABORATORY REPORT</h3>
                    </td>
                    <td width="30%" style="text-align: right; vertical-align: top; font-size: 11px;">
                        <strong>Patient:</strong> ' . $patient->name . '<br>
                        <strong>Patient ID:</strong> ' . ($patient->patient_id ?: 'P-' . $patient->id) . '<br>
                        <strong>Invoice #:</strong> ' . $invoice_id . '<br>
                        <strong>Report Date:</strong> ' . date('d-m-Y H:i') . '
                    </td>
                </tr>
            </table>
        </div>';  
        
        return $header;
    }

    // Helper method to generate PDF footer
    private function generateReportFooter($data) {
        $settings = $data['settings'];
        $generated_by = $data['generated_by'];
        
        $current_date = date('d-m-Y H:i:s');
        $footer = '
        <div style="border-top: 1px solid #ddd; padding-top: 8px; font-size: 10px; color: #666;">
            <table width="100%">
                <tr>
                    <td width="50%">
                        <strong>Generated by:</strong> ' . $generated_by . '<br>
                        <strong>Generated on:</strong> ' . $current_date . '
                    </td>
                    <td width="50%" style="text-align: right;">
                        <strong>' . $settings->system_vendor . '</strong><br>
                        This is a computer-generated report
                    </td>
                </tr>
            </table>
        </div>';
        
        return $footer;
    }

    // AJAX method to save specimen data immediately
    public function saveSpecimenData() {
        // Set JSON response header
        header('Content-Type: application/json');
        
        $test_id = $this->input->post('test_id');
        $patient_id = $this->input->post('patient_id');
        $invoice_id = $this->input->post('invoice_id');
        $specimen_data = $this->input->post('specimen_data');
        
        if (!$test_id || !$patient_id || !$specimen_data) {
            echo json_encode(['success' => false, 'message' => 'Missing required data']);
            return;
        }
        
        try {
            // Check if specimen already exists for this test
            $this->db->where('lab_id', $test_id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $existing_specimen = $this->db->get('lab_specimens')->row();
            
                         // Get current user's name
             $current_user_name = $this->session->userdata('user_name') ?: $this->session->userdata('username');
             
             $specimen_insert_data = array(
                 'specimen_id' => $existing_specimen ? $existing_specimen->specimen_id : 'SPEC-' . $test_id . '-' . time(),
                 'lab_id' => $test_id,
                 'patient_id' => $patient_id,
                 'specimen_type_id' => $specimen_data['specimen_type'],
                 'collection_date' => $specimen_data['collection_date'],
                 'collected_by' => $specimen_data['collected_by'] ?: $current_user_name,
                 'collection_method' => $specimen_data['collection_method'],
                 'volume_amount' => ($specimen_data['quantity'] ?? '') . ' ' . ($specimen_data['quantity_unit'] ?? ''),
                 'container_type' => $specimen_data['container_type'],
                 'condition_on_receipt' => $specimen_data['condition'],
                 'received_date' => date('Y-m-d H:i:s'),
                 'received_by' => $this->session->userdata('user_id'),
                 'status' => 'collected',
                 'invoice_id' => $invoice_id,
                 'hospital_id' => $this->session->userdata('hospital_id')
             );
            
            if ($existing_specimen) {
                // Update existing specimen
                $this->db->where('id', $existing_specimen->id);
                $result = $this->db->update('lab_specimens', $specimen_insert_data);
                $message = 'Specimen data updated successfully';
            } else {
                // Insert new specimen
                $result = $this->db->insert('lab_specimens', $specimen_insert_data);
                $message = 'Specimen data saved successfully';
            }
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => $message]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $this->db->error()['message']]);
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // AJAX method to get existing specimen data for a test
    public function getSpecimenData() {
        header('Content-Type: application/json');
        
        $test_id = $this->input->get('test_id');
        
        if (!$test_id) {
            echo json_encode(['success' => false, 'message' => 'Test ID required']);
            return;
        }
        
        try {
            $this->db->where('lab_id', $test_id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $specimen = $this->db->get('lab_specimens')->row();
            
            if ($specimen) {
                // Parse volume_amount back to quantity and unit
                $volume_parts = explode(' ', $specimen->volume_amount, 2);
                $quantity = isset($volume_parts[0]) ? $volume_parts[0] : '';
                $quantity_unit = isset($volume_parts[1]) ? $volume_parts[1] : 'ml';
                
                $specimen_data = array(
                    'specimen_type' => $specimen->specimen_type_id,
                    'collection_date' => $specimen->collection_date,
                    'collection_method' => $specimen->collection_method,
                    'container_type' => $specimen->container_type,
                    'quantity' => $quantity,
                    'quantity_unit' => $quantity_unit,
                    'collected_by' => $specimen->collected_by,
                    'condition' => $specimen->condition_on_receipt,
                    'status' => $specimen->status
                );
                
                echo json_encode(['success' => true, 'data' => $specimen_data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No specimen data found']);
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // AJAX method to get template details - with error handling
    public function getTemplateDetails() {
        $template_id = $this->input->get('template_id');
        if ($template_id) {
            try {
                // Get template from payment_procedure_templates
                $this->db->where('id', $template_id);
                $template = $this->db->get('payment_procedure_templates')->row();
                
                if ($template) {
                    // Get template fields from payment_procedure_template_fields
                    $this->db->where('template_id', $template_id);
                    $this->db->order_by('field_order', 'asc');
                    $template_fields = $this->db->get('payment_procedure_template_fields')->result();
                    
                    // Combine template and fields
                    $template->fields = $template_fields;
                    $template->field_count = count($template_fields);
                    
                    // Add some default properties for compatibility
                    $template->name = $template->template_name;
                    $template->test_code = 'PROC-' . $template->id;
                    $template->specimen_type_name = 'Blood'; // Default
                    $template->normal_range = 'See individual parameters';
                    $template->units = 'Various';
                    $template->methodology = $template->description;
                    
                    echo json_encode($template);
                } else {
                    echo json_encode(array('error' => 'Template not found'));
                }
            } catch (Exception $e) {
                echo json_encode(array('error' => 'Template not found: ' . $e->getMessage()));
            }
        } else {
            echo json_encode(array('error' => 'Template ID required'));
        }
    }

    // AJAX method to get templates by category - with error handling
    public function getTemplatesByCategory() {
        $category_id = $this->input->get('category_id');
        if ($category_id) {
            try {
                $this->db->where('procedure_type', 'diagnostic_test');
                $this->db->where('is_active', 1);
                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                
                // Join with payment_category to filter by category
                $this->db->join('payment_category', 'payment_category.id = payment_procedure_templates.category_id', 'left');
                $this->db->where('payment_category.id', $category_id);
                
                $this->db->select('payment_procedure_templates.*, payment_category.category as category_name');
                $templates = $this->db->get('payment_procedure_templates')->result();
                
                // Add compatibility fields
                foreach ($templates as $template) {
                    $template->name = $template->template_name;
                    $template->test_code = 'PROC-' . $template->id;
                }
                
                echo json_encode($templates);
            } catch (Exception $e) {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    // Diagnostic method to check system status
    public function checkSystem() {
        if (!$this->ion_auth->in_group('admin')) {
            show_404();
            return;
        }
        
        echo "<h3>Lab Workflow System Diagnostic</h3>";
        echo "<hr>";
        
        // Check database tables
        $tables_to_check = ['lab', 'lab_specimens', 'payment_procedure_templates', 'payment_procedure_template_fields', 'lab_result_values', 'specimen_types', 'payment_category'];
        
        echo "<h4>Database Tables:</h4>";
        foreach ($tables_to_check as $table) {
            try {
                if ($this->db->table_exists($table)) {
                    $count = $this->db->count_all($table);
                    echo "<p style='color: green;'>✓ Table '$table' exists (Records: $count)</p>";
                } else {
                    echo "<p style='color: red;'>✗ Table '$table' does not exist</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error checking table '$table': " . $e->getMessage() . "</p>";
            }
        }
        
        echo "<h4>Payment Procedure Templates (Diagnostic Tests):</h4>";
        try {
            $this->db->where('procedure_type', 'diagnostic_test');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $diagnostic_templates = $this->db->get('payment_procedure_templates')->result();
            
            if (!empty($diagnostic_templates)) {
                echo "<p style='color: green;'>✓ Found " . count($diagnostic_templates) . " diagnostic test templates</p>";
                foreach ($diagnostic_templates as $template) {
                    echo "<p>&nbsp;&nbsp;&nbsp;- " . $template->template_name . " (ID: " . $template->id . ")</p>";
                }
            } else {
                echo "<p style='color: orange;'>⚠ No diagnostic test templates found</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ Error checking diagnostic templates: " . $e->getMessage() . "</p>";
        }
        
        echo "<h4>Model Methods:</h4>";
        $methods_to_check = [
            'labworkflow_model' => ['getSpecimenTypes', 'insertLabSpecimen', 'insertLabResultValue'],
            'finance_model' => ['getPaymentCategory', 'getPaymentProcedureTemplates', 'getPaymentProcedureTemplateFields']
        ];
        
        foreach ($methods_to_check as $model => $methods) {
            echo "<h5>$model:</h5>";
            foreach ($methods as $method) {
                if (method_exists($this->$model, $method)) {
                    echo "<p style='color: green;'>✓ Method '$method' exists</p>";
                } else {
                    echo "<p style='color: red;'>✗ Method '$method' does not exist (using direct DB queries instead)</p>";
                }
            }
        }
        
        echo "<h4>Error Log (if any):</h4>";
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        
        echo "<hr>";
        echo "<h4>Actions:</h4>";
        echo "<a href='labworkflow/createSampleTemplates' class='btn btn-primary'>Create Sample Diagnostic Templates</a>";
    }

    // Method to create sample diagnostic test templates
    public function createSampleTemplates() {
        if (!$this->ion_auth->in_group('admin')) {
            show_404();
            return;
        }
        
        $hospital_id = $this->session->userdata('hospital_id');
        $user_id = $this->session->userdata('user_id');
        
        // Sample diagnostic test templates
        $templates = [
            [
                'template_name' => 'Complete Blood Count (CBC)',
                'description' => 'Complete blood count with differential',
                'procedure_type' => 'diagnostic_test',
                'category_id' => 1, // Adjust based on your payment categories
                'cost' => 25.00,
                'fields' => [
                    ['field_label' => 'White Blood Cells', 'field_type' => 'number', 'units' => '10^3/μL', 'reference_range' => '4.5-11.0'],
                    ['field_label' => 'Red Blood Cells', 'field_type' => 'number', 'units' => '10^6/μL', 'reference_range' => '4.5-5.5'],
                    ['field_label' => 'Hemoglobin', 'field_type' => 'number', 'units' => 'g/dL', 'reference_range' => '12-16'],
                    ['field_label' => 'Hematocrit', 'field_type' => 'number', 'units' => '%', 'reference_range' => '36-46'],
                    ['field_label' => 'Platelets', 'field_type' => 'number', 'units' => '10^3/μL', 'reference_range' => '150-450']
                ]
            ],
            [
                'template_name' => 'Basic Metabolic Panel (BMP)',
                'description' => 'Basic metabolic panel including electrolytes and glucose',
                'procedure_type' => 'diagnostic_test',
                'category_id' => 1,
                'cost' => 30.00,
                'fields' => [
                    ['field_label' => 'Glucose', 'field_type' => 'number', 'units' => 'mg/dL', 'reference_range' => '70-100'],
                    ['field_label' => 'Sodium', 'field_type' => 'number', 'units' => 'mmol/L', 'reference_range' => '136-146'],
                    ['field_label' => 'Potassium', 'field_type' => 'number', 'units' => 'mmol/L', 'reference_range' => '3.5-5.1'],
                    ['field_label' => 'Chloride', 'field_type' => 'number', 'units' => 'mmol/L', 'reference_range' => '98-107'],
                    ['field_label' => 'Creatinine', 'field_type' => 'number', 'units' => 'mg/dL', 'reference_range' => '0.6-1.2']
                ]
            ],
            [
                'template_name' => 'Lipid Panel',
                'description' => 'Complete lipid profile',
                'procedure_type' => 'diagnostic_test',
                'category_id' => 1,
                'cost' => 35.00,
                'fields' => [
                    ['field_label' => 'Total Cholesterol', 'field_type' => 'number', 'units' => 'mg/dL', 'reference_range' => '<200'],
                    ['field_label' => 'HDL Cholesterol', 'field_type' => 'number', 'units' => 'mg/dL', 'reference_range' => '>40'],
                    ['field_label' => 'LDL Cholesterol', 'field_type' => 'number', 'units' => 'mg/dL', 'reference_range' => '<100'],
                    ['field_label' => 'Triglycerides', 'field_type' => 'number', 'units' => 'mg/dL', 'reference_range' => '<150']
                ]
            ]
        ];
        
        $created_count = 0;
        
        foreach ($templates as $template_data) {
            $fields = $template_data['fields'];
            unset($template_data['fields']);
            
            $template_data['hospital_id'] = $hospital_id;
            $template_data['created_by'] = $user_id;
            $template_data['is_active'] = 1;
            $template_data['created_at'] = date('Y-m-d H:i:s');
            
            // Insert template
            $this->db->insert('payment_procedure_templates', $template_data);
            $template_id = $this->db->insert_id();
            
            if ($template_id) {
                // Insert template fields
                foreach ($fields as $index => $field) {
                    $field_data = array(
                        'template_id' => $template_id,
                        'field_label' => $field['field_label'],
                        'field_type' => $field['field_type'],
                        'field_order' => $index + 1,
                        'is_required' => 1,
                        'units' => $field['units'],
                        'reference_range' => $field['reference_range'],
                        'hospital_id' => $hospital_id,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    
                    $this->db->insert('payment_procedure_template_fields', $field_data);
                }
                
                $created_count++;
            }
        }
        
        echo "<h3>Sample Templates Created</h3>";
        echo "<p style='color: green;'>✓ Created $created_count diagnostic test templates</p>";
        echo "<p><a href='labworkflow/checkSystem'>← Back to System Check</a></p>";
        echo "<p><a href='labworkflow/writeReport/330'>Test Enhanced Report Interface →</a></p>";
    }

    // Method to fix database structure by adding missing columns
    public function fixDatabase() {
        if (!$this->ion_auth->in_group('admin')) {
            show_404();
            return;
        }
        
        echo "<h3>Database Structure Fix</h3>";
        echo "<hr>";
        
        $fixes_applied = 0;
        
        // Check and add invoice_id column to lab table
        try {
            $lab_columns = $this->db->list_fields('lab');
            if (!in_array('invoice_id', $lab_columns)) {
                $sql = "ALTER TABLE `lab` ADD COLUMN `invoice_id` INT(11) DEFAULT NULL AFTER `hospital_id`";
                $this->db->query($sql);
                echo "<p style='color: green;'>✓ Added invoice_id column to lab table</p>";
                $fixes_applied++;
            } else {
                echo "<p style='color: blue;'>ℹ invoice_id column already exists in lab table</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ Error adding invoice_id column: " . $e->getMessage() . "</p>";
        }
        
        // Check and add other helpful columns
        try {
            $lab_columns = $this->db->list_fields('lab');
            
            // Add test_status column if it doesn't exist
            if (!in_array('test_status', $lab_columns)) {
                $sql = "ALTER TABLE `lab` ADD COLUMN `test_status` VARCHAR(50) DEFAULT 'not_done' AFTER `status`";
                $this->db->query($sql);
                echo "<p style='color: green;'>✓ Added test_status column to lab table</p>";
                $fixes_applied++;
            } else {
                echo "<p style='color: blue;'>ℹ test_status column already exists in lab table</p>";
            }
            
            // Add test_status_date column if it doesn't exist
            if (!in_array('test_status_date', $lab_columns)) {
                $sql = "ALTER TABLE `lab` ADD COLUMN `test_status_date` INT(11) DEFAULT NULL AFTER `test_status`";
                $this->db->query($sql);
                echo "<p style='color: green;'>✓ Added test_status_date column to lab table</p>";
                $fixes_applied++;
            } else {
                echo "<p style='color: blue;'>ℹ test_status_date column already exists in lab table</p>";
            }
            
            // Add done_by column if it doesn't exist
            if (!in_array('done_by', $lab_columns)) {
                $sql = "ALTER TABLE `lab` ADD COLUMN `done_by` VARCHAR(255) DEFAULT NULL AFTER `test_status_date`";
                $this->db->query($sql);
                echo "<p style='color: green;'>✓ Added done_by column to lab table</p>";
                $fixes_applied++;
            } else {
                echo "<p style='color: blue;'>ℹ done_by column already exists in lab table</p>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ Error adding additional columns: " . $e->getMessage() . "</p>";
        }
        
        // Create missing tables if they don't exist
        if (!$this->db->table_exists('lab_specimens')) {
            try {
                $sql = "CREATE TABLE `lab_specimens` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `specimen_id` varchar(50) NOT NULL,
                    `lab_id` int(11) NOT NULL,
                    `patient_id` int(11) NOT NULL,
                    `specimen_type_id` int(11) DEFAULT NULL,
                    `collection_date` datetime NOT NULL,
                    `collection_time` time DEFAULT NULL,
                    `collected_by` varchar(255) DEFAULT NULL,
                    `collection_method` varchar(100) DEFAULT NULL,
                    `volume_amount` varchar(50) DEFAULT NULL,
                    `container_type` varchar(100) DEFAULT NULL,
                    `condition_on_receipt` text DEFAULT NULL,
                    `received_date` datetime DEFAULT NULL,
                    `received_by` int(11) DEFAULT NULL,
                    `status` varchar(50) DEFAULT 'collected',
                    `notes` text,
                    `invoice_id` int(11) DEFAULT NULL,
                    `hospital_id` int(11) NOT NULL,
                    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `lab_id` (`lab_id`),
                    KEY `patient_id` (`patient_id`),
                    KEY `specimen_type_id` (`specimen_type_id`),
                    KEY `invoice_id` (`invoice_id`),
                    KEY `hospital_id` (`hospital_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
                
                $this->db->query($sql);
                echo "<p style='color: green;'>✓ Created lab_specimens table</p>";
                $fixes_applied++;
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error creating lab_specimens table: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: blue;'>ℹ lab_specimens table already exists</p>";
        }
        
        if (!$this->db->table_exists('lab_result_values')) {
            try {
                $sql = "CREATE TABLE `lab_result_values` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `lab_id` int(11) NOT NULL,
                    `parameter_name` varchar(255) NOT NULL,
                    `result_value` varchar(255) DEFAULT NULL,
                    `reference_range` varchar(255) DEFAULT NULL,
                    `units` varchar(50) DEFAULT NULL,
                    `status` varchar(50) DEFAULT 'normal',
                    `hospital_id` int(11) NOT NULL,
                    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `lab_id` (`lab_id`),
                    KEY `hospital_id` (`hospital_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
                
                $this->db->query($sql);
                echo "<p style='color: green;'>✓ Created lab_result_values table</p>";
                $fixes_applied++;
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error creating lab_result_values table: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: blue;'>ℹ lab_result_values table already exists</p>";
        }
        
        if (!$this->db->table_exists('specimen_types')) {
            try {
                $sql = "CREATE TABLE `specimen_types` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(100) NOT NULL,
                    `description` text,
                    `hospital_id` int(11) NOT NULL,
                    `is_active` tinyint(1) DEFAULT 1,
                    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `hospital_id` (`hospital_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
                
                $this->db->query($sql);
                
                // Insert default specimen types
                $specimen_types = [
                    ['name' => 'Blood', 'description' => 'Whole blood sample'],
                    ['name' => 'Serum', 'description' => 'Blood serum sample'],
                    ['name' => 'Plasma', 'description' => 'Blood plasma sample'],
                    ['name' => 'Urine', 'description' => 'Urine sample'],
                    ['name' => 'Stool', 'description' => 'Stool sample'],
                    ['name' => 'Sputum', 'description' => 'Sputum sample'],
                    ['name' => 'CSF', 'description' => 'Cerebrospinal fluid'],
                    ['name' => 'Tissue', 'description' => 'Tissue biopsy sample']
                ];
                
                foreach ($specimen_types as $type) {
                    $type['hospital_id'] = $this->session->userdata('hospital_id');
                    $this->db->insert('specimen_types', $type);
                }
                
                echo "<p style='color: green;'>✓ Created specimen_types table with default data</p>";
                $fixes_applied++;
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error creating specimen_types table: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: blue;'>ℹ specimen_types table already exists</p>";
        }
        
        echo "<hr>";
        echo "<h4>Summary:</h4>";
        echo "<p><strong>Total fixes applied: $fixes_applied</strong></p>";
        
        if ($fixes_applied > 0) {
            echo "<p style='color: green;'>✓ Database structure updated successfully!</p>";
            echo "<p>You can now use the enhanced lab workflow features.</p>";
        } else {
            echo "<p style='color: blue;'>ℹ Database structure is already up to date.</p>";
        }
        
        echo "<p><a href='labworkflow/checkSystem' class='btn btn-info'>Check System Status</a></p>";
        echo "<p><a href='labworkflow/writeReport/330' class='btn btn-primary'>Test Enhanced Report Interface</a></p>";
    }

    // AJAX method for DataTables - grouped lab tests
    public function getGroupedLab() {
        try {
            $status = $this->input->get('status');
            $category = $this->input->get('category');
            $from_date = $this->input->get('from');
            $to_date = $this->input->get('to');

            // DataTables parameters
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $search_value = $this->input->post("search")["value"];

            // Initialize base query
            $this->db->select('
                MIN(lab.id) as id,
                lab.patient,
                COALESCE(lab.patient_name, patient.name) as patient_name,
                COALESCE(lab.patient_phone, patient.phone) as patient_phone,
                lab.doctor,
                COALESCE(lab.doctor_name, doctor.name) as doctor_name,
                lab.date,
                lab.invoice_id,
                lab.status,
                GROUP_CONCAT(DISTINCT lab.category ORDER BY lab.category SEPARATOR ", ") as combined_test_names,
                COUNT(lab.id) as test_count,
                payment.invoice as invoice_no,
                payment.date as invoice_date,
                payment.payment_status
            ');
            $this->db->from('lab');
            $this->db->join('patient', 'patient.id = lab.patient', 'left');
            $this->db->join('doctor', 'doctor.id = lab.doctor', 'left');
            $this->db->join('payment', 'payment.id = lab.invoice_id', 'left');
            $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));

            // Apply filters
            if ($status && $status != 'all') {
                $this->db->where('lab.status', $status);
            }
            if ($category && $category != 'all') {
                $this->db->where('lab.category_id', $category);
            }
            if ($from_date) {
                $this->db->where('lab.date >=', strtotime($from_date));
            }
            if ($to_date) {
                $this->db->where('lab.date <=', strtotime($to_date));
            }

            // Search functionality
            if (!empty($search_value)) {
                $this->db->group_start();
                $this->db->like('patient.name', $search_value);
                $this->db->or_like('patient.phone', $search_value);
                $this->db->or_like('doctor.name', $search_value);
                $this->db->or_like('lab.category', $search_value);
                $this->db->or_like('payment.invoice', $search_value);
                $this->db->group_end();
            }

            $this->db->group_by('lab.invoice_id');

            // Get total count for pagination
            $this->db->order_by('lab.date', 'DESC');
            
            // Clone query for count
            $count_query = clone $this->db;
            $total_records = $count_query->count_all_results('', FALSE);

            // Apply pagination to main query
            if ($length > 0) {
                $this->db->limit($length, $start);
            }

            $query = $this->db->get();
            
            if (!$query) {
                throw new Exception('Database query failed');
            }
            
            $data = $query->result();

            $json_data = array(
                "draw" => $draw,
                "recordsTotal" => $total_records,
                "recordsFiltered" => $total_records,
                "data" => array()
            );

            foreach ($data as $row) {
                $options = '';
                if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) {
                    $options = '
                        <a class="btn btn-info btn-xs" href="labworkflow/writeReport/' . $row->invoice_id . '" title="Write Report">
                            <i class="fa fa-edit"></i> Report
                        </a>
                        <a class="btn btn-success btn-xs" href="labworkflow/generateTestPdf/' . $row->id . '" target="_blank" title="Download PDF">
                            <i class="fa fa-download"></i> PDF
                        </a>
                    ';
                }

                $json_data["data"][] = array(
                    $row->patient ? $row->patient : 'N/A',
                    $row->patient_name ? $row->patient_name : 'N/A',
                    $row->patient_phone ? $row->patient_phone : 'N/A',
                    $row->invoice_no ? $row->invoice_no : 'N/A',
                    $row->invoice_date ? date('d-m-Y H:i', $row->invoice_date) : 'N/A',
                    ($row->combined_test_names ? $row->combined_test_names : 'No tests') . ' (' . $row->test_count . ' tests)',
                    ucfirst($row->status ? $row->status : 'pending'),
                    $row->payment_status ? ucfirst($row->payment_status) : 'N/A',
                    $row->date ? date('d-m-Y H:i', $row->date) : 'N/A',
                    'Lab Team',
                    $options
                );
            }

            header('Content-Type: application/json');
            echo json_encode($json_data);
            
        } catch (Exception $e) {
            // Return empty data in case of error
            $json_data = array(
                "draw" => intval($this->input->post("draw")),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => array(),
                "error" => $e->getMessage()
            );
            
            header('Content-Type: application/json');
            echo json_encode($json_data);
        }
    }

    // Test method to check if controller is working
    public function testAjax() {
        $test_data = array(
            "draw" => 1,
            "recordsTotal" => 3,
            "recordsFiltered" => 3,
            "data" => array(
                array("001", "John Doe", "123-456-7890", "INV001", "2024-01-15", "Blood Test, CBC (2 tests)", "Pending", "Paid", "2024-01-15", "Lab Team", '<a href="#" class="btn btn-info btn-xs">Report</a>'),
                array("002", "Jane Smith", "098-765-4321", "INV002", "2024-01-14", "Urine Test (1 test)", "Completed", "Paid", "2024-01-14", "Lab Team", '<a href="#" class="btn btn-info btn-xs">Report</a>'),
                array("003", "Bob Johnson", "555-123-4567", "INV003", "2024-01-13", "X-Ray, CT Scan (2 tests)", "In Progress", "Pending", "2024-01-13", "Lab Team", '<a href="#" class="btn btn-info btn-xs">Report</a>')
            )
        );
        
        header('Content-Type: application/json');
        echo json_encode($test_data);
    }

    // New method to get individual lab test entries like testStatus page
    public function getLabTestStatus() {
        $requestData = $_REQUEST;
        $status = $this->input->get('status');
        $category = $this->input->get('category');
        $from = $this->input->get('from');
        $to = $this->input->get('to');

        $columns = array(
            0 => 'patient',
            1 => 'patient_name',
            2 => 'date',
            3 => 'from',
            4 => 'test_status',
            5 => 'status',
            6 => 'options'
        );

        $limit = $requestData['length'];
        $start = $requestData['start'];
        $order = $columns[$requestData['order'][0]['column']];
        $dir = $requestData['order'][0]['dir'];
        $search = $requestData['search']['value'];

        if (empty($requestData['length'])) {
            if (!empty($search)) {
                $data['labs'] = $this->getLabTestStatusBySearch($search, $order, $dir, $status, $category, $from, $to);
            } else {
                $data['labs'] = $this->getLabTestStatusWithoutSearch($order, $dir, $status, $category, $from, $to);
            }
        } else {
            if (!empty($search)) {
                $data['labs'] = $this->getLabTestStatusByLimitBySearch($limit, $start, $search, $order, $dir, $status, $category, $from, $to);
            } else {
                $data['labs'] = $this->getLabTestStatusByLimit($limit, $start, $order, $dir, $status, $category, $from, $to);
            }
        }

        // Group tests by invoice ID
        $grouped_labs = array();
        foreach ($data['labs'] as $lab) {
            $invoice_id = $lab->invoice_id;
            if (!isset($grouped_labs[$invoice_id])) {
                $grouped_labs[$invoice_id] = array();
            }
            $grouped_labs[$invoice_id][] = $lab;
        }

        $i = 0;
        $info = array();
        
        foreach ($grouped_labs as $invoice_id => $invoice_tests) {
            // Add invoice header row
            $first_test = $invoice_tests[0];
            
            // Patient information
            $patient_info = $this->patient_model->getPatientById($first_test->patient);
            if (!empty($patient_info)) {
                $patient_name = $patient_info->name;
                $patient_phone = $patient_info->phone;
            } else {
                $patient_name = $first_test->patient_name ? $first_test->patient_name : 'N/A';
                $patient_phone = $first_test->patient_phone ? $first_test->patient_phone : 'N/A';
            }

            // Invoice details
            if ($first_test->invoice_id != null) {
                $invoice_details = $this->db->get_where('payment', array('id' => $first_test->invoice_id))->row();
                $invoice_deposit = $this->db->get_where('patient_deposit', array('payment_id' => $first_test->invoice_id))->result();
                if (empty($invoice_deposit)) {
                    $total_deposit = '0';
                } else {
                    foreach ($invoice_deposit as $deposit_amount) {
                        $deposit[] = $deposit_amount->deposited_amount;
                    }
                    $total_deposit = array_sum($deposit);
                }
                if ($invoice_details) {
                    $invoice_date_time = date('d-m-y h:i A', $invoice_details->date);
                } else {
                    $invoice_date_time = "";
                }
            } else {
                $invoice_date_time = "";
            }

            // Bill status
            $bill_status = "";
            if (!empty($invoice_details)) {
                if (($invoice_details->gross_total - $total_deposit) > 0) {
                    $bill_status = '<span class="badge bg-danger">' . lang('due_have') . '</span>';
                } else {
                    $bill_status = '<span class="badge bg-success">' . lang('paid') . '</span>';
                }
            }

            // From source
            $payment = $this->finance_model->getPaymentById($first_test->invoice_id);
            $from = '<span class="badge bg-primary">' . lang('opd') . '</span>';
            if ($payment) {
                if ($payment->payment_from == 'admitted_patient_bed_medicine') {
                    $from = '<span class="badge bg-warning">' . lang('ipd_medicine') . '</span>';
                } elseif ($payment->payment_from == 'admitted_patient_bed_service') {
                    $from = '<span class="badge bg-success">' . lang('ipd_service') . '</span>';
                } elseif ($payment->payment_from == 'admitted_patient_bed_diagnostic') {
                    $from = '<span class="badge bg-info">' . lang('ipd_diagnostic') . '</span>';
                }
            }

            // Add invoice header row
            $i++;
            $invoice_header = '<div class="invoice-group-header bg-primary text-white p-2 rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button class="btn btn-sm btn-outline-light toggle-group me-2" data-invoice="' . $invoice_id . '" title="Toggle Tests">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <strong><i class="fas fa-receipt me-2"></i>Invoice #' . $invoice_id . '</strong>
                        <span class="badge bg-light text-primary ms-2">' . count($invoice_tests) . ' Test(s)</span>
                    </div>
                    <div class="invoice-info">
                        <i class="fas fa-user me-1"></i>' . $patient_name . '
                    </div>
                </div>
            </div>';
            
            $info[] = array(
                isset($patient_info->id) ? $patient_info->id : "",
                $invoice_header, // Show invoice header in patient name column
                $invoice_date_time,
                $from,
                '', // Empty status for header
                $bill_status,
                '<a class="btn btn-primary btn-sm" href="labworkflow/writeReport/' . $invoice_id . '" title="Write Report">
                    <i class="fas fa-edit me-1"></i>Report All
                </a>'
            );

            // Add individual test rows
            foreach ($invoice_tests as $lab) {
                $i++;
                
                // Test name
                if ($lab->category_id != null) {
                    $test_name = $this->finance_model->getPaymentCategoryById($lab->category_id);
                    $test_name = $test_name ? $test_name->category : '';
                } else {
                    $test_name = $lab->category ? $lab->category : '';
                }

                // Enhanced Status dropdown with result-based status determination
                $result_status = $this->getTestResultStatus($lab->id);
                $status_class = $this->getStatusClass($lab->test_status, $result_status);
                
                $status_dropdown = "<select class='form-control test-status-dropdown test_status' data-id='" . $lab->id . "'>";
                if ($lab->test_status == "done") {
                    $status_dropdown .= "<option value='done' selected>" . lang('done') . "</option><option value='not_done'>" . lang('not_done') . "</option>";
                } else {
                    $status_dropdown .= "<option value='done'>" . lang('done') . "</option><option value='not_done' selected>" . lang('not_done') . "</option>";
                }
                $status_dropdown .= "</select>";
                
                // Enhanced status badge with result-based styling - use result_status instead of test_status
                if ($result_status == 'pending') {
                    $status_badge = '<span class="status-badge pending"><i class="fas fa-clock me-1"></i>Pending Results</span>';
                } else if ($result_status == 'critical') {
                    $status_badge = '<span class="status-badge critical"><i class="fas fa-exclamation-triangle me-1"></i>Critical Results</span>';
                } else if ($result_status == 'abnormal') {
                    $status_badge = '<span class="status-badge abnormal"><i class="fas fa-exclamation-circle me-1"></i>Abnormal</span>';
                } else if ($result_status == 'normal') {
                    $status_badge = '<span class="status-badge completed"><i class="fas fa-check-circle me-1"></i>Normal</span>';
                } else {
                    // result_status is 'done' - has results but no specific status
                    $status_badge = '<span class="status-badge completed"><i class="fas fa-check me-1"></i>Results Available</span>';
                }

                // Report status with enhanced styling
                $report_status = "";
                if ($lab->status == "pending") {
                    $report_status = '<span class="badge bg-danger"><i class="fas fa-hourglass-half me-1"></i>' . lang('pending') . '</span>';
                } else if ($lab->status == "drafted") {
                    $report_status = '<span class="badge bg-warning"><i class="fas fa-edit me-1"></i>' . lang('drafted') . '</span>';
                } else {
                    $report_status = '<span class="badge bg-success"><i class="fas fa-check-double me-1"></i>' . lang('completed') . '</span>';
                }

                // Enhanced Options buttons with modern styling
                $options = '';
                if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) {
                    $options = '<div class="btn-group" role="group">';
                    $options .= '<a class="btn action-btn btn-info btn-sm" href="labworkflow/writeReport/' . $lab->invoice_id . '" title="Write Report">';
                    $options .= '<i class="fas fa-edit me-1"></i>Report</a>';
                    $options .= '<a class="btn action-btn btn-success btn-sm" href="labworkflow/generateTestPdf/' . $lab->id . '" target="_blank" title="Download PDF">';
                    $options .= '<i class="fas fa-download me-1"></i>PDF</a>';
                    
                    // Add quick status change buttons
                    if ($lab->test_status == "not_done") {
                        $options .= '<button class="btn action-btn btn-primary btn-sm quick-complete" data-id="' . $lab->id . '" title="Mark as Done">';
                        $options .= '<i class="fas fa-check me-1"></i>Complete</button>';
                    }
                    
                    $options .= '</div>';
                }

                $info[] = array(
                    '', // Empty patient ID for test rows
                    '<div class="test-row ms-4" data-invoice="' . $invoice_id . '"><i class="fas fa-flask text-muted me-2"></i>' . $test_name . '</div>', // Indented test name with invoice data
                    '', // Empty invoice date for test rows
                    '',
                    $status_badge, // Use status badge instead of dropdown
                    '', // Empty bill status for individual tests (billing is per invoice)
                    $options
                );
            }
        }

        if (!empty($data['labs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($this->getLabTestStatusAll($status, $category, $from, $to)),
                "recordsFiltered" => $i,
                "data" => $info
            );
        } else {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        header('Content-Type: application/json');
        echo json_encode($output);
    }

    // Helper methods for lab test status queries
    private function getLabTestStatusAll($status, $category, $from, $to) {
        if ($category != 'all') {
            $this->db->where('payment_category', $category);
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        } else {
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        }

        if($from) {
            $this->db->where('date >=', strtotime($from));
        }
        if($to) {
            $this->db->where('date <=', strtotime($to));
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        
        if ($status == 'all') {
            $this->db->group_start();
            $this->db->where('test_status', 'done');
            $this->db->or_where('test_status', 'not_done');
            $this->db->group_end();
        } else if ($status == 'pending') {
            // Filter for tests without results - check both template results and clinical reports
            $pending_test_ids = $this->getPendingTestIds();
            if (!empty($pending_test_ids)) {
                $this->db->where_in('id', $pending_test_ids);
            } else {
                // If no pending tests found, return empty result
                $this->db->where('id', 0);
            }
        } else if ($status == 'critical') {
            // Filter for tests with critical results
            $this->db->where('test_status', 'done');
            $this->db->where('id IN (SELECT DISTINCT lab_id FROM lab_result_values WHERE status = "critical" AND hospital_id = ' . $this->session->userdata('hospital_id') . ')');
        } else {
            $this->db->where('test_status', $status);
        }

        if ($category != 'all' && count($array) > 0) {
            $this->db->where_in('category_id', $array);
        } else if($category != 'all' && count($array) == 0) {
            $this->db->where('category_id', 0);
        }

        $query = $this->db->get('lab');
        return $query->result();
    }

    private function getLabTestStatusWithoutSearch($order, $dir, $status, $category, $from, $to) {
        if ($category != 'all') {
            $this->db->where('payment_category', $category);
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        } else {
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        }
        
        if($from) {
            $this->db->where('date >=', strtotime($from));
        }
        if($to) {
            $this->db->where('date <=', strtotime($to));
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        
        if ($status == 'all') {
            $this->db->group_start();
            $this->db->where('test_status', 'done');
            $this->db->or_where('test_status', 'not_done');
            $this->db->group_end();
        } else if ($status == 'pending') {
            // Filter for tests without results - check both template results and clinical reports
            $pending_test_ids = $this->getPendingTestIds();
            if (!empty($pending_test_ids)) {
                $this->db->where_in('id', $pending_test_ids);
            } else {
                // If no pending tests found, return empty result
                $this->db->where('id', 0);
            }
        } else if ($status == 'critical') {
            $this->db->where('test_status', 'done');
            $this->db->where('id IN (SELECT DISTINCT lab_id FROM lab_result_values WHERE status = "critical" AND hospital_id = ' . $this->session->userdata('hospital_id') . ')');
        } else {
            $this->db->where('test_status', $status);
        }

        if ($category != 'all' && count($array) > 0) {
            $this->db->where_in('category_id', $array);
        } else if($category != 'all' && count($array) == 0) {
            $this->db->where('category_id', 0);
        }
        
        if ($order != null && $order != 'invoice_id') {
            $this->db->order_by('invoice_id', 'desc');
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('invoice_id', 'desc');
            $this->db->order_by('id', 'asc'); // Secondary sort by test ID within same invoice
        }
        
        $query = $this->db->get('lab');
        return $query->result();
    }

    private function getLabTestStatusBySearch($search, $order, $dir, $status, $category, $from, $to) {
        if ($category != 'all') {
            $this->db->where('payment_category', $category);
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        } else {
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        }

        if ($order != null && $order != 'invoice_id') {
            $this->db->order_by('invoice_id', 'desc');
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('invoice_id', 'desc');
            $this->db->order_by('id', 'asc'); // Secondary sort by test ID within same invoice
        }

        if ($status == 'all') {
            $this->db->group_start();
            $this->db->where('test_status', 'done');
            $this->db->or_where('test_status', 'not_done');
            $this->db->group_end();
        } else if ($status == 'pending') {
            // Filter for tests without results - check both template results and clinical reports
            $pending_test_ids = $this->getPendingTestIds();
            if (!empty($pending_test_ids)) {
                $this->db->where_in('id', $pending_test_ids);
            } else {
                // If no pending tests found, return empty result
                $this->db->where('id', 0);
            }
        } else if ($status == 'critical') {
            $this->db->where('test_status', 'done');
            $this->db->where('id IN (SELECT DISTINCT lab_id FROM lab_result_values WHERE status = "critical" AND hospital_id = ' . $this->session->userdata('hospital_id') . ')');
        } else {
            $this->db->where('test_status', $status);
        }

        if ($category != 'all' && count($array) > 0) {
            $this->db->where_in('category_id', $array);
        } else if($category != 'all' && count($array) == 0) {
            $this->db->where('category_id', 0);
        }

        if($from) {
            $this->db->where('date >=', strtotime($from));
        }
        if($to) {
            $this->db->where('date <=', strtotime($to));
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where("(id LIKE '%" . $search . "%' OR invoice_id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%'OR doctor_name LIKE '%" . $search . "%'OR date_string LIKE '%" . $search . "%')", NULL, FALSE);
        
        $query = $this->db->get('lab');
        return $query->result();
    }

    private function getLabTestStatusByLimit($limit, $start, $order, $dir, $status, $category, $from, $to) {
        if ($category != 'all') {
            $this->db->where('payment_category', $category);
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        } else {
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        }

        if($from) {
            $this->db->where('date >=', strtotime($from));
        }
        if($to) {
            $this->db->where('date <=', strtotime($to));
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        
        if ($status == 'all') {
            $this->db->group_start();
            $this->db->where('test_status', 'done');
            $this->db->or_where('test_status', 'not_done');
            $this->db->group_end();
        } else if ($status == 'pending') {
            // Filter for tests without results - check both template results and clinical reports
            $pending_test_ids = $this->getPendingTestIds();
            if (!empty($pending_test_ids)) {
                $this->db->where_in('id', $pending_test_ids);
            } else {
                // If no pending tests found, return empty result
                $this->db->where('id', 0);
            }
        } else if ($status == 'critical') {
            $this->db->where('test_status', 'done');
            $this->db->where('id IN (SELECT DISTINCT lab_id FROM lab_result_values WHERE status = "critical" AND hospital_id = ' . $this->session->userdata('hospital_id') . ')');
        } else {
            $this->db->where('test_status', $status);
        }

        if ($category != 'all' && count($array) > 0) {
            $this->db->where_in('category_id', $array);
        } else if($category != 'all' && count($array) == 0) {
            $this->db->where('category_id', 0);
        }

        if ($order != null && $order != 'invoice_id') {
            $this->db->order_by('invoice_id', 'desc');
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('invoice_id', 'desc');
            $this->db->order_by('id', 'asc'); // Secondary sort by test ID within same invoice
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->get('lab');
        return $query->result();
    }

    private function getLabTestStatusByLimitBySearch($limit, $start, $search, $order, $dir, $status, $category, $from, $to) {
        if ($category != 'all') {
            $this->db->where('payment_category', $category);
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        } else {
            $all_categories = $this->db->get('payment_category')->result();
            $array = array();
            foreach ($all_categories as $cat) {
                array_push($array, $cat->id);
            }
        }
        
        if ($order != null && $order != 'invoice_id') {
            $this->db->order_by('invoice_id', 'desc');
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('invoice_id', 'desc');
            $this->db->order_by('id', 'asc'); // Secondary sort by test ID within same invoice
        }
 
        if ($status == 'all') {
            $this->db->group_start();
            $this->db->where('test_status', 'done');
            $this->db->or_where('test_status', 'not_done'); 
            $this->db->group_end();
        } else if ($status == 'pending') {
            // Filter for tests without results - check both template results and clinical reports
            $pending_test_ids = $this->getPendingTestIds();
            if (!empty($pending_test_ids)) {
                $this->db->where_in('id', $pending_test_ids);
            } else {
                // If no pending tests found, return empty result
                $this->db->where('id', 0);
            }
        } else if ($status == 'critical') {
            $this->db->where('test_status', 'done');
            $this->db->where('id IN (SELECT DISTINCT lab_id FROM lab_result_values WHERE status = "critical" AND hospital_id = ' . $this->session->userdata('hospital_id') . ')');
        } else {
            $this->db->where('test_status', $status);
        }
        
        if ($category != 'all' && count($array) > 0) {
            $this->db->where_in('category_id', $array);
        } else if($category != 'all' && count($array) == 0) {
            $this->db->where('category_id', 0);
        }

        $this->db->limit($limit, $start);
        if($from) {
            $this->db->where('date >=', strtotime($from));
        }
        if($to) {
            $this->db->where('date <=', strtotime($to));
        }
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where("(id LIKE '%" . $search . "%' OR invoice_id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%'OR doctor_name LIKE '%" . $search . "%'OR date_string LIKE '%" . $search . "%')", NULL, FALSE);
        
        $query = $this->db->get('lab');
        return $query->result();
    }

    // Helper method to get test result status based on lab_result_values and clinical reports
    private function getTestResultStatus($lab_id) {
        // Check if there are any template field results in lab_result_values table
        $this->db->where('lab_id', $lab_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('result_value IS NOT NULL');
        $this->db->where('result_value !=', '');
        $result_values = $this->db->get('lab_result_values')->result();
        
        // Check if there are any clinical report fields filled in the lab table
        $this->db->where('id', $lab_id);
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $lab_test = $this->db->get('lab')->row();
        
        $has_template_results = !empty($result_values);
        $has_clinical_reports = false;
        
        if ($lab_test) {
            // Check if any of the clinical report fields have content
            $has_clinical_reports = !empty($lab_test->report) || 
                                   !empty($lab_test->interpretation) || 
                                   !empty($lab_test->critical_values);
        }
        
        // If either template results or clinical reports have data, status is 'done'
        if ($has_template_results || $has_clinical_reports) {
            // If we have results, check for critical values
            if ($has_template_results) {
                $has_critical = false;
                $has_abnormal = false;
                $has_normal = false;
                
                foreach ($result_values as $result) {
                    if ($result->status == 'critical') {
                        $has_critical = true;
                    } else if ($result->status == 'abnormal') {
                        $has_abnormal = true;
                    } else if ($result->status == 'normal') {
                        $has_normal = true;
                    }
                }
                
                // Priority: Critical > Abnormal > Normal
                if ($has_critical) {
                    return 'critical';
                } else if ($has_abnormal) {
                    return 'abnormal';
                } else if ($has_normal) {
                    return 'normal';
                } else {
                    return 'done'; // Has results but no specific status
                }
            } else {
                // Has clinical reports but no template results
                return 'done';
            }
        }
        
        // No results entered yet
        return 'pending';
    }
    
    // Helper method to get CSS class based on status
    private function getStatusClass($test_status, $result_status) {
        if ($test_status == 'not_done') {
            return 'pending';
        }
        
        switch ($result_status) {
            case 'critical':
                return 'critical';
            case 'abnormal':
                return 'abnormal';
            case 'normal':
                return 'completed';
            default:
                return 'in-progress';
        }
    }

    // Debug method to check invoice and lab data
    public function debugInvoice($invoice_id = null) {
        if (!$this->ion_auth->in_group('admin')) {
            show_404();
            return;
        }
        
        if (!$invoice_id) {
            echo "<h3>Debug Invoice Data</h3>";
            echo "<p>Please provide an invoice ID: <code>labworkflow/debugInvoice/330</code></p>";
            return;
        }
        
        echo "<h3>Debug Information for Invoice ID: $invoice_id</h3>";
        echo "<hr>";
        
        // Check if payment/invoice exists
        echo "<h4>1. Payment/Invoice Check:</h4>";
        $payment = $this->db->get_where('payment', array('id' => $invoice_id))->row();
        if ($payment) {
            echo "<p style='color: green;'>✓ Payment/Invoice found</p>";
            echo "<ul>";
            echo "<li>Patient ID: " . $payment->patient . "</li>";
            echo "<li>Date: " . date('Y-m-d H:i:s', $payment->date) . "</li>";
            echo "<li>Amount: " . $payment->gross_total . "</li>";
            echo "<li>Status: " . $payment->payment_status . "</li>";
            echo "</ul>";
        } else {
            echo "<p style='color: red;'>✗ No payment/invoice found with ID $invoice_id</p>";
        }
        
        // Check if lab table has invoice_id column
        echo "<h4>2. Lab Table Structure:</h4>";
        $lab_columns = $this->db->list_fields('lab');
        $has_invoice_id = in_array('invoice_id', $lab_columns);
        echo "<p>Has invoice_id column: " . ($has_invoice_id ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . "</p>";
        
        // Check for lab tests using different methods
        echo "<h4>3. Lab Tests Search:</h4>";
        
        if ($has_invoice_id) {
            echo "<h5>Method 1: Direct invoice_id search</h5>";
            $this->db->where('invoice_id', $invoice_id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $lab_tests_direct = $this->db->get('lab')->result();
            echo "<p>Found " . count($lab_tests_direct) . " tests using direct invoice_id</p>";
            
            if (!empty($lab_tests_direct)) {
                foreach ($lab_tests_direct as $test) {
                    echo "<li>Test ID: {$test->id}, Category: {$test->category}, Patient: {$test->patient}</li>";
                }
            }
        }
        
        if ($payment) {
            echo "<h5>Method 2: Patient + Date search</h5>";
            $this->db->where('patient', $payment->patient);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $payment_date = date('Y-m-d', $payment->date);
            $this->db->where('date_string', $payment_date);
            $lab_tests_date = $this->db->get('lab')->result();
            echo "<p>Found " . count($lab_tests_date) . " tests for patient on same date</p>";
            
            if (!empty($lab_tests_date)) {
                foreach ($lab_tests_date as $test) {
                    echo "<li>Test ID: {$test->id}, Category: {$test->category}, Date: {$test->date_string}</li>";
                }
            }
            
            echo "<h5>Method 3: Patient + Date range search (±3 days)</h5>";
            $this->db->where('patient', $payment->patient);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('date >=', $payment->date - (3 * 24 * 60 * 60));
            $this->db->where('date <=', $payment->date + (3 * 24 * 60 * 60));
            $lab_tests_range = $this->db->get('lab')->result();
            echo "<p>Found " . count($lab_tests_range) . " tests for patient within 3 days</p>";
            
            if (!empty($lab_tests_range)) {
                foreach ($lab_tests_range as $test) {
                    echo "<li>Test ID: {$test->id}, Category: {$test->category}, Date: " . date('Y-m-d', $test->date) . "</li>";
                }
            }
        }
        
        // Check recent lab tests for this hospital
        echo "<h4>4. Recent Lab Tests:</h4>";
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('date', 'DESC');
        $this->db->limit(10);
        $recent_tests = $this->db->get('lab')->result();
        echo "<p>Found " . count($recent_tests) . " recent lab tests:</p>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Category</th><th>Patient</th><th>Date</th><th>Invoice ID</th></tr>";
        foreach ($recent_tests as $test) {
            $invoice_display = isset($test->invoice_id) ? $test->invoice_id : 'N/A';
            echo "<tr>";
            echo "<td>{$test->id}</td>";
            echo "<td>{$test->category}</td>";
            echo "<td>{$test->patient}</td>";
            echo "<td>" . date('Y-m-d', $test->date) . "</td>";
            echo "<td>{$invoice_display}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<hr>";
        echo "<h4>Suggestions:</h4>";
        if (empty($lab_tests_direct) && empty($lab_tests_date) && empty($lab_tests_range)) {
            echo "<p style='color: orange;'>⚠ No lab tests found for invoice $invoice_id</p>";
            echo "<p>Possible solutions:</p>";
            echo "<ul>";
            echo "<li>Create lab tests for this invoice manually</li>";
            echo "<li>Check if the invoice has associated lab orders</li>";
            echo "<li>Verify the invoice ID is correct</li>";
            echo "</ul>";
        } else {
            echo "<p style='color: green;'>✓ Lab tests found - the writeReport should work</p>";
        }
        
        echo "<p><a href='labworkflow/writeReport/$invoice_id'>→ Try writeReport again</a></p>";
        echo "<p><a href='labworkflow/labTests'>← Back to Lab Tests</a></p>";
    }

    // Helper method to get test IDs that have no results (pending)
    private function getPendingTestIds() {
        $hospital_id = $this->session->userdata('hospital_id');
        
        // Get all lab test IDs for this hospital
        $this->db->select('id');
        $this->db->where('hospital_id', $hospital_id);
        $all_tests = $this->db->get('lab')->result();
        
        $pending_test_ids = array();
        
        foreach ($all_tests as $test) {
            // Check if this test has any template results
            $this->db->where('lab_id', $test->id);
            $this->db->where('hospital_id', $hospital_id);
            $this->db->where('result_value IS NOT NULL');
            $this->db->where('result_value !=', '');
            $template_results = $this->db->get('lab_result_values')->num_rows();
            
            // Check if this test has any clinical reports
            $this->db->where('id', $test->id);
            $this->db->where('hospital_id', $hospital_id);
            $this->db->group_start();
            $this->db->where('report IS NOT NULL');
            $this->db->where('report !=', '');
            $this->db->group_end();
            $this->db->or_group_start();
            $this->db->where('interpretation IS NOT NULL');
            $this->db->where('interpretation !=', '');
            $this->db->group_end();
            $this->db->or_group_start();
            $this->db->where('critical_values IS NOT NULL');
            $this->db->where('critical_values !=', '');
            $this->db->group_end();
            $clinical_reports = $this->db->get('lab')->num_rows();
            
            // If no template results and no clinical reports, it's pending
            if ($template_results == 0 && $clinical_reports == 0) {
                $pending_test_ids[] = $test->id;
            }
        }
        
        return $pending_test_ids;
    }

    // Debug method to test inventory functionality
    public function testInventory() {
        // Load inventory model
        $this->load->model('inventory/inventory_model');
        
        echo "<h3>Inventory System Test</h3>";
        
        // Test 1: Check if inventory tables exist
        echo "<h4>1. Database Tables Check:</h4>";
        $tables = ['inventory_items', 'inventory_usage', 'inventory_categories'];
        foreach ($tables as $table) {
            if ($this->db->table_exists($table)) {
                echo "✅ Table '$table' exists<br>";
            } else {
                echo "❌ Table '$table' missing<br>";
            }
        }
        
        // Test 2: Check inventory items
        echo "<h4>2. Inventory Items Check:</h4>";
        $items = $this->inventory_model->getActiveItems();
        echo "Found " . count($items) . " active items<br>";
        if (count($items) > 0) {
            echo "Sample item: " . json_encode($items[0]) . "<br>";
        }
        
        // Test 3: Test getActiveItems endpoint
        echo "<h4>3. getActiveItems Endpoint Test:</h4>";
        $active_items = $this->inventory_model->getActiveItems();
        echo "Active items response: " . json_encode($active_items) . "<br>";
        
        // Test 4: Test inventory usage insertion
        echo "<h4>4. Test Inventory Usage Insertion:</h4>";
        if (count($items) > 0) {
            $test_usage_data = array(
                'item_id' => $items[0]['id'],
                'quantity_used' => 1,
                'usage_date' => date('Y-m-d H:i:s'),
                'usage_type' => 'lab_test',
                'reference_id' => 999,
                'reference_type' => 'test',
                'used_by' => $this->session->userdata('user_id') ?: 1,
                'patient_id' => 1,
                'notes' => 'Test inventory usage',
                'batch_number' => 'TEST-BATCH'
            );
            
            try {
                $usage_id = $this->inventory_model->insertInventoryUsage($test_usage_data);
                if ($usage_id) {
                    echo "✅ Test inventory usage inserted with ID: $usage_id<br>";
                    
                    // Clean up - delete the test record
                    $this->db->delete('inventory_usage', array('id' => $usage_id));
                    echo "✅ Test record cleaned up<br>";
                } else {
                    echo "❌ Failed to insert test inventory usage<br>";
                }
            } catch (Exception $e) {
                echo "❌ Exception during inventory usage test: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "⚠️ No inventory items available for testing<br>";
        }
        
        // Test 5: Check hospital_id
        echo "<h4>5. Session Check:</h4>";
        echo "Hospital ID: " . $this->session->userdata('hospital_id') . "<br>";
        echo "User ID: " . $this->session->userdata('user_id') . "<br>";
        
        echo "<br><a href='" . base_url('labworkflow/labTests') . "'>Back to Lab Tests</a>";
    }

    // Debug method to check inventory usage in database
    public function debugInventoryUsage($invoice_id = null) {
        if (!$this->ion_auth->in_group('admin')) {
            show_404();
            return;
        }
        
        echo "<h3>Inventory Usage Debug</h3>";
        
        if (!$invoice_id) {
            echo "<p>Usage: labworkflow/debugInventoryUsage/330</p>";
            return;
        }
        
        $hospital_id = $this->session->userdata('hospital_id');
        echo "<p><strong>Invoice ID:</strong> $invoice_id</p>";
        echo "<p><strong>Hospital ID:</strong> $hospital_id</p>";
        echo "<hr>";
        
        // Check all inventory usage records
        echo "<h4>All Inventory Usage Records:</h4>";
        $this->db->where('hospital_id', $hospital_id);
        $all_usage = $this->db->get('inventory_usage')->result();
        echo "<p>Total records: " . count($all_usage) . "</p>";
        
        if (count($all_usage) > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Item ID</th><th>Quantity</th><th>Reference ID</th><th>Reference Type</th><th>Usage Date</th><th>Notes</th></tr>";
            foreach ($all_usage as $usage) {
                echo "<tr>";
                echo "<td>{$usage->id}</td>";
                echo "<td>{$usage->item_id}</td>";
                echo "<td>{$usage->quantity_used}</td>";
                echo "<td>{$usage->reference_id}</td>";
                echo "<td>{$usage->reference_type}</td>";
                echo "<td>{$usage->usage_date}</td>";
                echo "<td>{$usage->notes}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        echo "<hr>";
        
        // Check records for specific invoice
        echo "<h4>Records for Invoice $invoice_id:</h4>";
        $this->db->where('reference_id', $invoice_id);
        $this->db->where('hospital_id', $hospital_id);
        $invoice_usage = $this->db->get('inventory_usage')->result();
        echo "<p>Records found: " . count($invoice_usage) . "</p>";
        
        if (count($invoice_usage) > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Item ID</th><th>Quantity</th><th>Reference Type</th><th>Usage Date</th><th>Notes</th></tr>";
            foreach ($invoice_usage as $usage) {
                echo "<tr>";
                echo "<td>{$usage->id}</td>";
                echo "<td>{$usage->item_id}</td>";
                echo "<td>{$usage->quantity_used}</td>";
                echo "<td>{$usage->reference_type}</td>";
                echo "<td>{$usage->usage_date}</td>";
                echo "<td>{$usage->notes}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        echo "<hr>";
        
        // Test the model method
        echo "<h4>Testing Model Method:</h4>";
        $this->load->model('inventory/inventory_model');
        $model_result = $this->inventory_model->getInventoryUsageByReference($invoice_id, 'lab_test');
        echo "<p>Model returned: " . count($model_result) . " records</p>";
        
        if (count($model_result) > 0) {
            echo "<pre>" . json_encode($model_result, JSON_PRETTY_PRINT) . "</pre>";
        }
        
        echo "<p><a href='labworkflow/writeReport/$invoice_id'>→ Try writeReport</a></p>";
        echo "<p><a href='labworkflow/getInventoryUsage?invoice_id=$invoice_id'>→ Test AJAX endpoint</a></p>";
        echo "<p><a href='labworkflow/showLogs'>→ View Recent Logs</a></p>";
    }

    // Debug method to show recent logs
    public function showLogs() {
        if (!$this->ion_auth->in_group('admin')) {
            show_404();
            return;
        }
        
        echo "<h3>Recent Application Logs</h3>";
        
        $log_file = APPPATH . 'logs/log-' . date('Y-m-d') . '.php';
        
        if (file_exists($log_file)) {
            $logs = file_get_contents($log_file);
            
            // Get recent inventory-related logs
            $lines = explode("\n", $logs);
            $recent_logs = array_slice($lines, -100); // Last 100 lines
            
            echo "<h4>Last 100 log entries:</h4>";
            echo "<pre style='background: #f5f5f5; padding: 10px; max-height: 500px; overflow-y: auto;'>";
            
            foreach ($recent_logs as $line) {
                if (strpos($line, 'inventory') !== false || strpos($line, 'SaveReport') !== false) {
                    echo "<strong style='color: blue;'>" . htmlspecialchars($line) . "</strong>\n";
                } else {
                    echo htmlspecialchars($line) . "\n";
                }
            }
            
            echo "</pre>";
        } else {
            echo "<p>Log file not found: $log_file</p>";
        }
        
        echo "<p><a href='javascript:history.back()'>← Back</a></p>";
    }

    // Save inventory usage immediately (called from modal)
    public function saveInventoryUsage() {
        $inventory_usage = $this->input->post('inventory_usage');
        $invoice_id = $this->input->post('invoice_id');
        $patient_id = $this->input->post('patient_id');
        
        log_message('debug', 'saveInventoryUsage called with invoice_id: ' . $invoice_id);
        log_message('debug', 'saveInventoryUsage inventory_usage: ' . json_encode($inventory_usage));
        
        if (!$invoice_id) {
            echo json_encode(['success' => false, 'message' => 'Invoice ID required']);
            return;
        }
        
        if (empty($inventory_usage) || !is_array($inventory_usage)) {
            echo json_encode(['success' => false, 'message' => 'No inventory items provided']);
            return;
        }
        
        // Load inventory model
        try {
            $this->load->model('inventory/inventory_model');
            log_message('debug', 'Inventory model loaded successfully');
        } catch (Exception $e) {
            log_message('error', 'Failed to load inventory model: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Inventory system unavailable']);
            return;
        }
        
        $hospital_id = $this->session->userdata('hospital_id');
        $user_id = $this->session->userdata('user_id');
        $inventory_usage_count = 0;
        $errors = array();
        
        // First, delete existing inventory usage for this invoice to avoid duplicates
        $this->db->where('reference_id', $invoice_id);
        $this->db->where('reference_type', 'lab_test');
        $this->db->where('hospital_id', $hospital_id);
        $existing_usage = $this->db->get('inventory_usage')->result();
        
        // Restore stock for existing usage before deleting
        foreach ($existing_usage as $usage) {
            $this->inventory_model->updateItemStock($usage->item_id, $usage->quantity_used, 'add');
            log_message('debug', 'Restored ' . $usage->quantity_used . ' units to item ' . $usage->item_id);
        }
        
        // Delete existing records
        $this->db->where('reference_id', $invoice_id);
        $this->db->where('reference_type', 'lab_test');
        $this->db->where('hospital_id', $hospital_id);
        $deleted_count = $this->db->delete('inventory_usage');
        log_message('debug', 'Deleted ' . $deleted_count . ' existing inventory usage records');
        
        // Process each inventory item
        foreach ($inventory_usage as $index => $usage_data) {
            log_message('debug', 'Processing inventory item ' . ($index + 1) . ': ' . json_encode($usage_data));
            
            if (empty($usage_data['item_id']) || empty($usage_data['quantity_used'])) {
                $errors[] = 'Item ' . ($index + 1) . ': Missing item ID or quantity';
                continue;
            }
            
            // Validate that item exists and has sufficient stock
            $item = $this->db->get_where('inventory_items', array(
                'id' => $usage_data['item_id'],
                'hospital_id' => $hospital_id
            ))->row();
            
            if (!$item) {
                $errors[] = 'Item ' . ($index + 1) . ': Item not found';
                continue;
            }
            
            if ($item->current_stock < $usage_data['quantity_used']) {
                $errors[] = 'Item ' . ($index + 1) . ': Insufficient stock (Available: ' . $item->current_stock . ', Requested: ' . $usage_data['quantity_used'] . ')';
                continue;
            }
            
            // Prepare inventory usage data
            $inventory_usage_data = array(
                'item_id' => $usage_data['item_id'],
                'quantity_used' => $usage_data['quantity_used'],
                'usage_date' => date('Y-m-d H:i:s'),
                'usage_type' => $usage_data['usage_type'] ?: 'lab_test',
                'reference_id' => $usage_data['reference_id'] ?: $invoice_id,
                'reference_type' => $usage_data['reference_type'] ?: 'lab_test',
                'used_by' => $user_id,
                'patient_id' => $usage_data['patient_id'] ?: $patient_id,
                'notes' => $usage_data['notes'] ?: 'Used for lab test invoice #' . $invoice_id,
                'batch_number' => $usage_data['batch_number'] ?: '',
                'hospital_id' => $hospital_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            
            // Insert inventory usage record
            try {
                $usage_id = $this->inventory_model->insertInventoryUsage($inventory_usage_data);
                log_message('debug', 'Inventory usage record inserted with ID: ' . $usage_id);
                
                if ($usage_id) {
                    // Update item stock
                    $this->inventory_model->updateItemStock($usage_data['item_id'], $usage_data['quantity_used'], 'subtract');
                    $inventory_usage_count++;
                    log_message('debug', 'Successfully recorded inventory usage for item ' . $usage_data['item_id'] . ' (Usage ID: ' . $usage_id . ')');
                } else {
                    $errors[] = 'Item ' . ($index + 1) . ': Failed to record usage';
                    log_message('error', 'Failed to record inventory usage for item ' . $usage_data['item_id']);
                }
            } catch (Exception $e) {
                $errors[] = 'Item ' . ($index + 1) . ': ' . $e->getMessage();
                log_message('error', 'Exception while recording inventory usage for item ' . $usage_data['item_id'] . ': ' . $e->getMessage());
            }
        }
        
        // Prepare response
        if ($inventory_usage_count > 0) {
            $message = $inventory_usage_count . ' inventory item(s) saved successfully';
            if (!empty($errors)) {
                $message .= ' (with ' . count($errors) . ' error(s))';
            }
            
            echo json_encode([
                'success' => true,
                'message' => $message,
                'count' => $inventory_usage_count,
                'errors' => $errors
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No inventory items were saved. ' . implode('; ', $errors),
                'errors' => $errors
            ]);
        }
    }

    // Get existing inventory usage for an invoice
    public function getInventoryUsage() {
        $invoice_id = $this->input->get('invoice_id');
        $reference_type = $this->input->get('reference_type') ?: 'lab_test';
        
        log_message('debug', 'getInventoryUsage called with invoice_id: ' . $invoice_id . ', reference_type: ' . $reference_type);
        log_message('debug', 'Hospital ID: ' . $this->session->userdata('hospital_id'));
        
        if (!$invoice_id) {
            log_message('debug', 'No invoice ID provided');
            echo json_encode(['success' => false, 'message' => 'Invoice ID required']);
            return;
        }
        
        // Load inventory model
        $this->load->model('inventory/inventory_model');
        
        try {
            // Debug: Check if there are any inventory usage records at all
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $total_usage = $this->db->count_all_results('inventory_usage');
            log_message('debug', 'Total inventory usage records in hospital: ' . $total_usage);
            
            // Debug: Check records for this specific invoice
            $this->db->where('reference_id', $invoice_id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $invoice_usage = $this->db->count_all_results('inventory_usage');
            log_message('debug', 'Inventory usage records for invoice ' . $invoice_id . ': ' . $invoice_usage);
            
            // Get inventory usage records for this invoice
            $usage_records = $this->inventory_model->getInventoryUsageByReference($invoice_id, $reference_type);
            
            log_message('debug', 'getInventoryUsageByReference returned ' . count($usage_records) . ' records');
            log_message('debug', 'First record: ' . json_encode(isset($usage_records[0]) ? $usage_records[0] : 'none'));
            
            echo json_encode([
                'success' => true,
                'data' => $usage_records,
                'count' => count($usage_records),
                'debug' => [
                    'invoice_id' => $invoice_id,
                    'reference_type' => $reference_type,
                    'hospital_id' => $this->session->userdata('hospital_id'),
                    'total_usage_records' => $total_usage,
                    'invoice_usage_records' => $invoice_usage
                ]
            ]);
            
        } catch (Exception $e) {
            log_message('error', 'Error fetching inventory usage: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error fetching inventory usage: ' . $e->getMessage()
            ]);
        }
    }

} 