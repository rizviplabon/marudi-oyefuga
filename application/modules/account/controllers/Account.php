<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('account_model');
        $this->load->model('patient/patient_model');
       
        // Only restrict certain methods from certain user groups
        // Allow admin, Accountant, Doctor, Receptionist for account overview functionality
        if ($this->ion_auth->in_group(array('pharmacist', 'Nurse', 'Laboratorist', 'Patient'))) {
            $method = $this->router->fetch_method();
            // Only restrict account management methods, not overview methods
            if (in_array($method, array('index', 'addNewView', 'addNew', 'editAccount', 'delete', 'getAccountList'))) {
                redirect('home/permission');
            }
        }
    }

    public function index() {
        $data['settings'] = $this->settings_model->getSettings();
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('account_balance', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('account_balance', $data);
                $this->load->view('home/footer'); // just the header file
            }}else{
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('account_balance', $data);
        $this->load->view('home/footer'); // just the header file
            }
    }

    public function addNewView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $id = $this->input->post('id');
        $patient = $this->input->post('patient');
        $date = $this->input->post('date');
        $deposit_amount = $this->input->post('deposit_amount');
        $balance_amount = $this->input->post('balance_amount');
        $deposit_type = $this->input->post('deposit_type');
        $account_no = $this->input->post('account_no');
        $transaction_id = $this->input->post('transaction_id');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Date Field
        $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Deposit Amount Field
        $this->form_validation->set_rules('deposit_amount', 'Deposit Amount', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Balance Amount Field
        // $this->form_validation->set_rules('balance_amount', 'Balance Amount', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("account/editAccount?id=" . $id);
            } else {
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array(
                'patient' => $patient,
                'date' => $date,
                'deposit_amount' => $deposit_amount,
                'balance_amount' => $deposit_amount,
                'deposit_type' => $deposit_type,
                'account_no' => $account_no,
                'transaction_id' => $transaction_id
            );

            if (empty($id)) {     // Adding New Account
                $this->account_model->insertAccount($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating Account
                $this->account_model->updateAccount($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('account');
        }
    }

    function getAccount() {
        $data['accounts'] = $this->account_model->getAccount();
        $this->load->view('account_balance', $data);
    }

    function editAccount() {
        $data = array();
        $id = $this->input->get('id');
        $data['account'] = $this->account_model->getAccountById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editAccountByJason() {
        $id = $this->input->get('id');
        $data['account'] = $this->account_model->getAccountById($id);
        $data['patient'] = $this->patient_model->getPatientById($data['account']->patient);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->account_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('account');
    }

    function getAccountList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "patient_name",
            "2" => "date",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['accounts'] = $this->account_model->getAccountBysearch($search, $order, $dir);
            } else {
                $data['accounts'] = $this->account_model->getAccountWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['accounts'] = $this->account_model->getAccountByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['accounts'] = $this->account_model->getAccountByLimit($limit, $start, $order, $dir);
            }
        }
       
        $options1 = '';
        $options5 = '';

        $i = 1;
        foreach ($data['accounts'] as $account) {
            if ($this->ion_auth->in_group(array('admin', 'Accountant'))) {
                $options1 = ' <a type="button" class="btn btn-soft-info editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $account->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }

            if ($this->ion_auth->in_group(array('admin', 'Accountant'))) {
                $options5 = '<a class="btn btn-soft-danger delete_button" title="' . lang('delete') . '" href="account/delete?id=' . $account->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            $settings = $this->settings_model->getSettings();
            if($this->ion_auth->in_group('admin')){
                if($this->settings->dashboard_theme =='main'){
                    $all_options = '<div class="btn-group">
                    <a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                    <div class="dropdown-menu">';
      
                   $all_options.= '
                      <a class="dropdown-item editbutton" data-toggle="modal" data-id="'. $account->id. '">'. lang('edit'). '</a>
                      <a class="dropdown-item" href="account/delete?id='. $account->id. '" onclick="return confirm(\'Are you sure you want to delete this item?\');">'. lang('delete'). '</a>';
              
               $all_options.= '</div>
                  </div>';
            }else{
                $all_options = $options1.''. $options5;
            }}else{
                $all_options = $options1.''. $options5;
            }
            $patient_info = $this->patient_model->getPatientById($account->patient);

            if ($this->ion_auth->in_group(array('admin', 'Accountant'))) {
                $info[] = array(
                    $i,
                    'Id : ' . $patient_info->id_new . '<br> Name : ' . $patient_info->name . '<br> Phone : ' . $patient_info->phone,
                    $account->date,
                    $settings->currency . ' ' . $account->deposit_amount,
                    $settings->currency . ' ' . $account->balance_amount,
                    $account->deposit_type,
                    $account->account_no,
                    $account->transaction_id,
                    $all_options
                );
                $i = $i + 1;
            }
        }

        if (!empty($data['accounts'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($data['accounts']),
                "recordsFiltered" => count($data['accounts']),
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
     * Account Overview - Shows all patients with their account balances
     */
    public function accountOverview()
    {
        if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Doctor', 'Receptionist'))) {
            $data = array();
            $data['settings'] = $this->settings_model->getSettings();
            
            $this->load->view('home/dashboard');
            $this->load->view('account/patient_account_overview', $data);
            $this->load->view('home/footer');
        } else {
            redirect('home/permission');
        }
    }
    
    /**
     * Get Account Overview Data for DataTables
     */
    public function getAccountOverviewData()
    {
        if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Doctor', 'Receptionist'))) {
            // DataTables parameters
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $order = $this->input->post("order");
            $search = $this->input->post("search");
            $search = $search['value'];

            // Get total count
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $total_patients = $this->db->count_all_results('patient');
            
            // Get patients with pagination
            if (!empty($search)) {
                $patients = $this->patient_model->getPatientByLimitBySearch($length, $start, $search, 'id', 'desc');
                $total_filtered = count($this->patient_model->getPatientBySearch($search, 'id', 'desc'));
            } else {
                $patients = $this->patient_model->getPatientByLimit($length, $start, 'id', 'desc');
                $total_filtered = $total_patients;
            }

            $data = array();
            $currency = $this->settings_model->getSettings()->currency;
            
            foreach ($patients as $patient) {
                // Get account balance for this patient
                $balance = $this->account_model->getTotalBalanceByPatient($patient->id);
                $balance_formatted = $currency . ' ' . number_format($balance, 2);
                $balance_class = $balance < 0 ? 'text-danger' : ($balance > 0 ? 'text-success' : 'text-muted');
                
                $balance_display = '<span class="fw-bold ' . $balance_class . '">' . $balance_formatted . '</span>';
                
                // View details button
                $action_buttons = '<button type="button" class="btn btn-sm btn-outline-primary" onclick="viewAccountDetails(' . $patient->id . ', \'' . htmlspecialchars($patient->name, ENT_QUOTES) . '\')" title="View Account Details">
                    <i class="fas fa-eye me-1"></i> Details
                </button>';
                
                $data[] = array(
                    $patient->id,
                    $patient->name,
                    $patient->phone,
                    $balance_display,
                    $action_buttons
                );
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => $total_patients,
                "recordsFiltered" => $total_filtered,
                "data" => $data
            );

            echo json_encode($output);
        }
    }
    
    /**
     * Get Patient Account Details for Modal
     */
    public function getPatientAccountDetails()
    {
        if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Doctor', 'Receptionist'))) {
            $patient_id = $this->input->post('patient_id');
            
            // Debug: Log all POST data
            log_message('debug', 'POST data: ' . print_r($_POST, true));
            log_message('debug', 'Patient ID received: ' . var_export($patient_id, true));
            
            if (empty($patient_id)) {
                echo json_encode(['success' => false, 'message' => 'Patient ID is required. Received: ' . var_export($patient_id, true)]);
                return;
            }
            
            $this->load->model('finance/finance_model');
            
            // Get patient details
            $patient = $this->patient_model->getPatientById($patient_id);
            if (!$patient) {
                echo json_encode(['success' => false, 'message' => 'Patient not found']);
                return;
            }
            
            // Get patient hierarchy to understand relationships
            $hierarchy = $this->patient_model->getPatientHierarchy($patient_id);
            $is_dependant = !empty($patient->parent_patient_id);
            $is_guardian = !empty($hierarchy['children']);
            
            // Get account balance entries
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('patient', $patient_id);
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('account_balance');
            $account_entries = $query->result();
            
            // Get deposit entries (account balance payments) based on patient type
            $deposit_entries = array();
            
            if ($is_dependant) {
                // For dependants: Show only expenses made for this specific dependant
                // AND only when payment was from their OWN account (not guardian's account)
                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                $this->db->where('patient', $patient_id);
                $this->db->where('deposit_type', 'Account Balance');
                $this->db->where('(payment_account_type != "guardian" OR payment_account_type IS NULL)', null, false);
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('patient_deposit');
                $deposit_entries = $query->result();
            } else if ($is_guardian) {
                // For guardians: Show all expenses where money was deducted from this guardian's account
                // This includes payments for the guardian themselves AND for their dependants
                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                $this->db->where('deposit_type', 'Account Balance');
                $this->db->where('(deducted_from_patient_id = ' . $patient_id . ' OR (patient = ' . $patient_id . ' AND (deducted_from_patient_id IS NULL OR deducted_from_patient_id = ' . $patient_id . ')))', null, false);
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('patient_deposit');
                $deposit_entries = $query->result();
            } else {
                // For regular patients (neither guardian nor dependant): Show their own expenses only
                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                $this->db->where('patient', $patient_id);
                $this->db->where('deposit_type', 'Account Balance');
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('patient_deposit');
                $deposit_entries = $query->result();
            }
            
            // Get total balance
            $total_balance = $this->account_model->getTotalBalanceByPatient($patient_id);
            $currency = $this->settings_model->getSettings()->currency;
            
            $response = [
                'success' => true,
                'patient' => [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'phone' => $patient->phone
                ],
                'total_balance' => $total_balance,
                'total_balance_formatted' => $currency . ' ' . number_format($total_balance, 2),
                'currency' => $currency,
                'is_dependant' => $is_dependant,
                'is_guardian' => $is_guardian,
                'account_entries' => [],
                'deposit_entries' => []
            ];
            
            // Format account entries (deposits into account)
            foreach ($account_entries as $entry) {
                $response['account_entries'][] = [
                    'id' => $entry->id,
                    'date' => $entry->date,
                    'deposit_amount' => number_format($entry->deposit_amount, 2),
                    'balance_amount' => number_format($entry->balance_amount, 2),
                    'deposit_type' => $entry->deposit_type,
                    'account_no' => $entry->account_no,
                    'transaction_id' => $entry->transaction_id
                ];
            }
            
            // Format deposit entries (payments from account)
            foreach ($deposit_entries as $entry) {
                // Get payment details
                $payment = $this->finance_model->getPaymentById($entry->payment_id);
                
                // Determine who the expense was for
                $expense_for_name = '';
                $account_type_display = '';
                
                if ($is_guardian) {
                    // For guardians, show which dependant the expense was for
                    if ($entry->patient != $patient_id) {
                        // This expense was for a dependant
                        $dependant = $this->patient_model->getPatientById($entry->patient);
                        if ($dependant) {
                            $expense_for_name = ' (for ' . $dependant->name . ')';
                        }
                    } else {
                        // This expense was for the guardian themselves
                        $expense_for_name = ' (for self)';
                    }
                    $account_type_display = 'Guardian Account';
                } else if ($is_dependant) {
                    // For dependants, since we only show payments from their own account
                    $account_type_display = 'Own Account';
                } else {
                    // For regular patients
                    $account_type_display = isset($entry->payment_account_type) ? ucfirst($entry->payment_account_type) : 'Patient';
                }
                
                $response['deposit_entries'][] = [
                    'id' => $entry->id,
                    'date' => date('d-M-Y', $entry->date),
                    'amount' => number_format($entry->deposited_amount, 2),
                    'payment_id' => $entry->payment_id,
                    'payment_type' => ($payment ? 'Payment Invoice #' . $payment->id : 'Payment') . $expense_for_name,
                    'account_type' => $account_type_display,
                    'deducted_from' => isset($entry->deducted_from_patient_id) ? $entry->deducted_from_patient_id : $patient_id
                ];
            }
            
            echo json_encode($response);
        }
    }
}

/* End of file account.php */
/* Location: ./application/modules/account/controllers/account.php */