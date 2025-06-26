<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prescription extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('prescription_model');
        $this->load->model('medicine/medicine_model');
        $this->load->model('patient/patient_model');
        $this->load->model('doctor/doctor_model');
        if (!$this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Patient', 'Nurse'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        if ($this->ion_auth->in_group(array('Doctor'))) {
            $current_user = $this->ion_auth->get_user_id();
            $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
        }
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByDoctorId($doctor_id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); 
        $this->load->view('prescription', $data);
        $this->load->view('home/footer'); 
    }

    function all() {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor', 'Pharmacist'))) {
            redirect('home/permission');
        }

        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescription();
        $data['settings'] = $this->settings_model->getSettings();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('all_prescription', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('all_prescription', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard', $data); 
        $this->load->view('all_prescription', $data);
        $this->load->view('home/footer'); 
            }
    }

    public function addPrescriptionView() {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor'))) {
            redirect('home/permission');
        }

        $data = array();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();

        $data['settings'] = $this->settings_model->getSettings();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('add_new_prescription_view', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('add_new_prescription_view', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard', $data); 
        $this->load->view('add_new_prescription_view', $data);
        $this->load->view('home/footer'); 
            }
    }

    public function addNewPrescription() {
        if (!$this->ion_auth->in_group(array('admin', 'Doctor'))) {
            redirect('home/permission');
        }

        $id = $this->input->post('id');
        $tab = $this->input->post('tab');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        }

        $patient = $this->input->post('patient');
        $doctor = $this->input->post('doctor');
        $symptom = $this->input->post('symptom');
        $medicine = $this->input->post('medicine');
        $dosage = $this->input->post('dosage');
        $frequency = $this->input->post('frequency');
        $days = $this->input->post('days');
        $instruction = $this->input->post('instruction');
        $note = $this->input->post('note');
        $admin = $this->input->post('admin');
        $advice = $this->input->post('advice');

        $report = array();
        $medicine_names = array();

        if (!empty($medicine)) {
            foreach ($medicine as $key => $value) {
                // Split the medicine value to get ID and name
                $med_parts = explode('*', $value);
                $med_id = $med_parts[0];
                
                $report[$med_id] = array(
                    'dosage' => $dosage[$key],
                    'frequency' => $frequency[$key],
                    'days' => $days[$key],
                    'instruction' => $instruction[$key],
                );
                
                // Get medicine name from database
                $med = $this->medicine_model->getMedicineById($med_id);
                if ($med) {
                    $medicine_names[] = $med->name;
                }
            }

            foreach ($report as $key1 => $value1) {
                $final[] = $key1 . '***' . implode('***', $value1);
            }
            $final_report = implode('###', $final);
            
            // Check for drug interactions
            $this->load->helper('drug_interaction');
            $interaction_results = check_drug_interactions($medicine_names);
            
            // If interactions found, store them in session for display
            if (!empty($interaction_results['interactions']) || !empty($interaction_results['warnings'])) {
                $this->session->set_flashdata('drug_interactions', $interaction_results);
            }
        } else {
            $final_report = '';
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        
        // Validating Date Field
        $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Doctor Field
        $this->form_validation->set_rules('doctor', 'Doctor', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Advice Field
        $this->form_validation->set_rules('symptom', 'History', 'trim|min_length[1]|max_length[1000]|xss_clean');
        // Validating Do And Dont Name Field
        $this->form_validation->set_rules('note', 'Note', 'trim|min_length[1]|max_length[1000]|xss_clean');

        // Validating Advice Field
        $this->form_validation->set_rules('advice', 'Advice', 'trim|min_length[1]|max_length[1000]|xss_clean');

        // Validating Validity Field
        $this->form_validation->set_rules('validity', 'Validity', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect('prescription/editPrescription?id=' . $id);
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['medicines'] = $this->medicine_model->getMedicine();
                $data['patients'] = $this->patient_model->getPatient();
                $data['doctors'] = $this->doctor_model->getDoctor();
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); 
                $this->load->view('add_new_prescription_view', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $data = array();
            $patientname = $this->patient_model->getPatientById($patient)->name;
            $doctorname = $this->doctor_model->getDoctorById($doctor)->name;
            $data = array(
                'date' => $date,
                'patient' => $patient,
                'doctor' => $doctor,
                'symptom' => $symptom,
                'medicine' => $final_report,
                'note' => $note,
                'advice' => $advice,
                'patientname' => $patientname,
                'doctorname' => $doctorname
            );
            
            if (empty($id)) {
                $this->prescription_model->insertPrescription($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->prescription_model->updatePrescription($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            
            // If there are interactions, redirect to show them
            if ($this->session->flashdata('drug_interactions')) {
                redirect('prescription/showInteractions');
            } else {
                redirect('prescription');
            }
        }
    }

    public function showInteractions() {
        if (!$this->ion_auth->in_group(array('admin', 'Doctor'))) {
            redirect('home/permission');
        }

        $data['interactions'] = $this->session->flashdata('drug_interactions');
        if (empty($data['interactions'])) {
            redirect('prescription');
        }

        // Add summary message based on number of interactions
        $interaction_count = count($data['interactions']['interactions']);
        $warning_count = count($data['interactions']['warnings']);
        
        $summary = array();
        if ($interaction_count > 0) {
            $summary[] = $interaction_count . ' drug-to-drug interaction' . ($interaction_count > 1 ? 's' : '') . ' found';
        }
        if ($warning_count > 0) {
            $summary[] = $warning_count . ' individual drug warning' . ($warning_count > 1 ? 's' : '') . ' found';
        }
        
        $data['interaction_summary'] = !empty($summary) ? implode(' and ', $summary) : '';

        $data['settings'] = $this->settings_model->getSettings();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('drug_interactions', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('drug_interactions', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard', $data);
        $this->load->view('drug_interactions', $data);
        $this->load->view('home/footer');
            }
    }

    function viewPrescription() {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);

        if (!empty($data['prescription']->hospital_id)) {
            if ($data['prescription']->hospital_id != $this->session->userdata('hospital_id')) {
                $this->load->view('home/permission');
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                if ($this->ion_auth->in_group(array('Patient'))) {

                    $current_user_id = $this->ion_auth->user()->row()->id;
                    $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
                    $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
                    $group_name = strtolower($group_name);
                    $user_theme = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->dashboard_theme;
                    if ($user_theme == 'main') {
                        $this->load->view('patient/layout/header');
                        $this->load->view('prescription_view_1', $data);
                        $this->load->view('patient/layout/footer');
                    } else {
                        $this->load->view('home/dashboard', $data); 
                $this->load->view('prescription_view_1', $data);
                $this->load->view('home/footer'); 
                    }
                }elseif($this->ion_auth->in_group(array('admin'))){
                    if($this->settings->dashboard_theme == 'main'){
                        $this->load->view('home/layout/header'); 
                        $this->load->view('prescription_view_1', $data);
                        $this->load->view('home/layout/footer'); 
                    }else{
                        $this->load->view('home/dashboard', $data); 
                $this->load->view('prescription_view_1', $data);
                $this->load->view('home/footer'); 
                    }
                } else {
                $this->load->view('home/dashboard', $data); 
                $this->load->view('prescription_view_1', $data);
                $this->load->view('home/footer'); 
                }
            }
        } else {
            $this->load->view('home/permission');
        }
    }

    function viewPrescriptionPrint() {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);

        if (!empty($data['prescription']->hospital_id)) {
            if ($data['prescription']->hospital_id != $this->session->userdata('hospital_id')) {
                $this->load->view('home/permission');
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                if($this->ion_auth->in_group('admin')){                
                    if($this->settings->dashboard_theme == 'main'){
                        $this->load->view('home/layout/header'); 
                        $this->load->view('prescription_view_print', $data);
                        $this->load->view('home/layout/footer'); 
                    }else{
                        $this->load->view('home/dashboard', $data); 
                        $this->load->view('prescription_view_print', $data);
                        $this->load->view('home/footer');
                    }}else{
                $this->load->view('home/dashboard', $data); 
                $this->load->view('prescription_view_print', $data);
                $this->load->view('home/footer'); 
                    }
            }
        } else {
            $this->load->view('home/permission');
        }
    }

    function editPrescription() {
        $data = array();
        $id = $this->input->get('id');
        // $data['patients'] = $this->patient_model->getPatient();
        // $data['doctors'] = $this->doctor_model->getDoctor();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatientById($data['prescription']->patient);
        $data['doctors'] = $this->doctor_model->getDoctorById($data['prescription']->doctor);
        if (!empty($data['prescription']->hospital_id)) {
            if ($data['prescription']->hospital_id != $this->session->userdata('hospital_id')) {
                $this->load->view('home/permission');
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                if($this->ion_auth->in_group('admin')){                
                    if($this->settings->dashboard_theme == 'main'){
                        $this->load->view('home/layout/header'); 
                        $this->load->view('add_new_prescription_view', $data);
                        $this->load->view('home/layout/footer'); 
                    }else{
                        $this->load->view('home/dashboard'); 
                        $this->load->view('add_new_prescription_view', $data);
                        $this->load->view('home/footer');
                    }}else{
                $this->load->view('home/dashboard', $data); 
                $this->load->view('add_new_prescription_view', $data);
                $this->load->view('home/footer'); // just the footer file 
                    }
            }
        } else {
            $this->load->view('home/permission');
        }
    }

    function continue_anyway(){
        if($this->ion_auth->in_group('Doctor')){ 
            redirect('prescription');
        }else{
        redirect('prescription/all');
        }
    }

    function editPrescriptionByJason() {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        echo json_encode($data);
    }

    function getPrescriptionByPatientIdByJason() {
        $id = $this->input->get('id');
        $prescriptions = $this->prescription_model->getPrescriptionByPatientId($id);
        foreach ($prescriptions as $prescription) {
            $lists[] = ' <div class="pull-left prescription_box" style = "padding: 10px; background: #fff;"><div class="prescription_box_title">Prescription Date</div> <div>' . date('d-m-Y', $prescription->date) . '</div> <div class="prescription_box_title">Medicine</div> <div>' . $prescription->medicine . '</div> </div> ';
        }
        $data['prescription'] = $lists;
        $lists = NULL;
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $admin = $this->input->get('admin');
        $patient = $this->input->get('patient');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        if (!empty($data['prescription']->hospital_id)) {
            if ($data['prescription']->hospital_id != $this->session->userdata('hospital_id')) {
                $this->load->view('home/permission');
            } else {
                $this->prescription_model->deletePrescription($id);
                $this->session->set_flashdata('feedback', lang('deleted'));
                if (!empty($patient)) {
                    redirect('patient/caseHistory?patient_id=' . $patient);
                } elseif (!empty($admin)) {
                    redirect('prescription/all');
                } else {
                    redirect('prescription');
                }
            }
        } else {
            $this->load->view('home/permission');
        }
    }

    public function prescriptionCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['categories'] = $this->prescription_model->getPrescriptionCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); 
        $this->load->view('prescription_category', $data);
        $this->load->view('home/footer'); 
    }

    public function addCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); 
        $this->load->view('add_new_category_view');
        $this->load->view('home/footer'); 
    }

    public function addNewCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); 
            $this->load->view('add_new_category_view');
            $this->load->view('home/footer'); 
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->prescription_model->insertPrescriptionCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->prescription_model->updatePrescriptionCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('prescription/prescriptionCategory');
        }
    }

    function edit_category() {
        $data = array();
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionCategoryById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); 
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPrescriptionCategoryByJason() {
        $id = $this->input->get('id');
        $data['prescriptioncategory'] = $this->prescription_model->getPrescriptionCategoryById($id);
        echo json_encode($data);
    }

    function deletePrescriptionCategory() {
        $id = $this->input->get('id');
        $this->prescription_model->deletePrescriptionCategory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('prescription/prescriptionCategory');
    }

    function getPrescriptionListByDoctor() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        
        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];
        
        $doctor_ion_id = $this->ion_auth->get_user_id();
        $doctor = $this->db->get_where('doctor', array('ion_user_id' => $doctor_ion_id))->row()->id;
        if ($limit == -1) {
            if (!empty($search)) {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionBysearchByDoctor($doctor, $search, $order, $dir);
            } else {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionByDoctorWithoutSearch($doctor, $order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionByLimitBySearchByDoctor($doctor, $limit, $start, $search, $order, $dir);
            } else {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionByLimitByDoctor($doctor, $limit, $start, $order, $dir);
            }
        }


        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $option1 = '';
        $option2 = '';
        $option3 = '';
        foreach ($data['prescriptions'] as $prescription) {
            //$i = $i + 1;
            $settings = $this->settings_model->getSettings();

            $option1 = '<a class="btn btn-soft-info btn-xs btn_width" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye">' . lang('view') . ' ' . lang('prescription') . ' </i></a>';
            $option3 = '<a class="btn btn-soft-info btn-xs btn_width" href="prescription/editPrescription?id=' . $prescription->id . '" data-id="' . $prescription->id . '"><i class="fa fa-edit"></i> ' . lang('edit') . ' ' . lang('prescription') . '</a>';
            $option2 = '<a class="btn btn-soft-danger btn-xs btn_width delete_button" href="prescription/delete?id=' . $prescription->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i></a>';
            $options4 = '<a class="btn btn-soft-warning btn-xs invoicebutton" title="' . lang('print') . '" style="color: #fff;" href="prescription/viewPrescriptionPrint?id=' . $prescription->id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . '</a>';

            if (!empty($prescription->medicine)) {
                $medicine = explode('###', $prescription->medicine);
                $medicinelist = '';
                foreach ($medicine as $key => $value) {
                    $medicine_id = explode('***', $value);
                    $medicine_name_with_dosage = $this->medicine_model->getMedicineById($medicine_id[0])->name . ' -' . $medicine_id[1];
                    $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                    rtrim($medicine_name_with_dosage, ',');
                    $medicinelist .= '<p>' . $medicine_name_with_dosage . '</p>';
                }
            } else {
                $medicinelist = '';
            }
            $patientdetails = $this->patient_model->getPatientById($prescription->patient);
            if (!empty($patientdetails)) {
                $patientname = $patientdetails->name;
            } else {
                $patientname = $prescription->patientname;
            }
            $info[] = array(
                $prescription->id,
                date('d-m-Y', $prescription->date),
                $patientname,
                $prescription->patient,
                $medicinelist,
                $option1 . ' ' . $option3 . ' ' . $option2 . ' ' . $options4
            );
            $i = $i + 1;
        }

        if ($data['prescriptions']) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($this->prescription_model->getPrescriptionByDoctorId($doctor)),
                "recordsFiltered" => $i,
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

    function getPrescriptionList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        
        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionBysearch($search, $order, $dir);
            } else {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionByLimit($limit, $start, $order, $dir);
            }
        }


        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $option1 = '';
        $option2 = '';
        $option3 = '';
        foreach ($data['prescriptions'] as $prescription) {
            //$i = $i + 1;
            $settings = $this->settings_model->getSettings();

            $option1 = '<a title="' . lang('view') . ' ' . lang('prescription') . '" class="btn btn-soft-info btn-xs btn_width" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> ' . lang('view') . ' ' . lang('prescription') . ' </i></a>';
            $option3 = '<a class="btn btn-soft-info btn-xs btn_width" href="prescription/editPrescription?id=' . $prescription->id . '" data-id="' . $prescription->id . '"><i class="fa fa-edit"></i> ' . lang('edit') . ' ' . lang('prescription') . '</a>';
            $option2 = '<a class="btn btn-soft-danger btn-xs btn_width delete_button" href="prescription/delete?id=' . $prescription->id . '&admin=' . $prescription->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i></a>';
            $options4 = '<a class="btn btn-soft-warning btn-xs invoicebutton" title="' . lang('print') . '" href="prescription/viewPrescriptionPrint?id=' . $prescription->id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . '</a>';

            if (!empty($prescription->medicine)) {
                $medicine = explode('###', $prescription->medicine);
                $medicinelist = '';
                foreach ($medicine as $key => $value) {
                    $medicine_id = explode('***', $value);
                    $medicine_name_with_dosage = $this->medicine_model->getMedicineById($medicine_id[0])->name . ' -' . $medicine_id[1];
                    $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                    rtrim($medicine_name_with_dosage, ',');
                    $medicinelist .= '<p>' . $medicine_name_with_dosage . '</p>';
                }
            } else {
                $medicinelist = '';
            }
            $patientdetails = $this->patient_model->getPatientById($prescription->patient);
            if (!empty($patientdetails)) {
                $patientname = $patientdetails->name;
            } else {
                $patientname = $prescription->patientname;
            }
            $doctordetails = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctordetails)) {
                $doctorname = $doctordetails->name;
            } else {
                $doctorname = $prescription->doctorname;
            }

            if ($this->ion_auth->in_group(array('Pharmacist', 'Receptionist'))) {
                $option2 = '';
                $option3 = '';
            }

            if($this->ion_auth->in_group('admin')){
                if($this->settings->dashboard_theme =='main'){
                    $all_options = '<div class="btn-group">
                    <a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                    <div class="dropdown-menu">';
      
                   $all_options.= '<a class="dropdown-item editbutton" href="prescription/viewPrescription?id=' . $prescription->id . '">'. lang('view'). '</a>
                   <a class="dropdown-item editbutton" href="prescription/viewPrescriptionPrint?id=' . $prescription->id . '"target="_blank">'. lang('print'). '</a>
                      <a class="dropdown-item editbutton" href="prescription/editPrescription?id=' . $prescription->id . '" data-id="' . $prescription->id . '">'. lang('edit'). '</a>
                      <a class="dropdown-item" href="prescription/delete?id=' . $prescription->id . '&admin=' . $prescription->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');">'. lang('delete'). '</a>';
              
               $all_options.= '</div>
                  </div>';
            }else{
                $all_options = $option1 . ' ' . $option3 . ' ' . $options4 . ' ' . $option2;
            }}else{
                $all_options = $option1 . ' ' . $option3 . ' ' . $options4 . ' ' . $option2;
            }

            $info[] = array(
                $prescription->id,
                date('d-m-Y', $prescription->date),
                $doctorname,
                $patientname,
                $medicinelist,
                $all_options
            );
            $i = $i + 1;
        }

        if ($data['prescriptions']) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($this->prescription_model->getPrescription()),
                "recordsFiltered" => $i,
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

    /**
     * AJAX endpoint to check drug interactions
     */
    public function checkDrugInteractions() { 
        // Verify this is an AJAX request
        if (!$this->input->is_ajax_request()) {
            redirect('home');
        }
        
        // Get medicines from POST
        $medicines = $this->input->post('medicines');
        
        if (empty($medicines) || count($medicines) < 2) {
            // Not enough medicines to check interactions
            echo json_encode(array(
                'success' => false,
                'message' => 'Not enough medicines to check interactions',
                'interactions' => array(),
                'warnings' => array()
            ));
            return;
        }
        
        // Load drug interaction helper
        $this->load->helper('drug_interaction');
        
        // Check for interactions
        $interaction_results = check_drug_interactions($medicines);
        
        // Return results as JSON
        echo json_encode(array(
            'success' => true,
            'interactions' => $interaction_results['interactions'],
            'warnings' => $interaction_results['warnings']
        ));
    }

    public function encrypt_prescription_data() {
        // Check if the user is an admin
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('home/permission');
        }
         
        // Load the db_encrypt helper
        $this->load->helper('db_encrypt');
        
        // Get all prescriptions
        $this->db->where('hospital_id', $this->session->userdata('hospital_id')); 
        $query = $this->db->get('prescription');
        $prescriptions = $query->result();
        
        $encrypted_fields = $this->prescription_model->encrypted_fields;
        $total_count = count($prescriptions);
        $success_count = 0;
        $encrypted_fields_count = array_fill_keys($encrypted_fields, 0);
        
        // Re-encrypt all prescription data with our approach
        foreach ($prescriptions as $prescription) {
            if (empty($prescription->id)) {
                continue;
            }
            
            $updated = false;
            $update_data = array();
            
            // Process each encrypted field
            foreach ($encrypted_fields as $field) {
                if (!empty($prescription->$field)) {
                    // Try to decrypt first (in case it's already encrypted)
                    $value = db_decrypt($prescription->$field);
                    
                    // Then re-encrypt with our new approach
                    $update_data[$field] = db_encrypt($value);
                    $encrypted_fields_count[$field]++;
                    $updated = true;
                }
            }
            
            // Update the record if we have changes
            if ($updated) {
                $this->db->where('id', $prescription->id);
                $this->db->update('prescription', $update_data);
                
                if ($this->db->affected_rows() > 0) {
                    $success_count++;
                }
            }
        }
        
        // Output the results
        echo "<h2>Prescription Data Encryption Results</h2>";
        echo "<p>Successfully updated {$success_count} out of {$total_count} prescriptions.</p>";
        
        echo "<h3>Fields Encrypted:</h3>";
        echo "<ul>";
        foreach ($encrypted_fields_count as $field => $count) {
            echo "<li>{$field}: {$count} values</li>";
        }
        echo "</ul>";
    }

}

/* End of file prescription.php */
/* Location: ./application/modules/prescription/controllers/prescription.php */
