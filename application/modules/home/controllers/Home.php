<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('finance/finance_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('notice/notice_model');
        $this->load->model('logs/logs_model');
        $this->load->model('home_model');
        $this->load->model('finance/pharmacy_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model'); 
        $this->load->model('bed/bed_model');
        $this->load->helper('db_encrypt'); // Load encryption helper
    }

    /**
     * Safe decrypt method to handle both encrypted and plaintext values
     */
    private function safe_decrypt($value) {
        if (empty($value)) {
            return $value;
        }
        
        // Try to decrypt
        $decrypted = db_decrypt($value);
        
        // If decryption fails or returns same value, it might not be encrypted
        // In that case, return the original value
        return $decrypted === false ? $value : $decrypted; 
    }
    public function test(){
        $this->load->view('dashboard'); // just the header file
        $this->load->view('feedback');
        $this->load->view('footer');
    }
 
    public function index() {
        $data = array();

        if (!$this->ion_auth->in_group(array('superadmin'))) {

            $date = date('d-m-Y');
            $clock_in = date('h:i A');
            $clock_out = "";
            $late = "";
            $halfday = "";
            $work_from = "";
            $details = array();
            $month = date('F', strtotime($date));
            $year = date('Y', strtotime($date));
            $day = explode('-', $date);

            $result = $this->db->get_where('attendance', array('staff' => $this->ion_auth->user()->row()->id, 'month' => $month, 'year' => $year))->row();
            if (!empty($result->details)) {
                $details = explode('#', $result->details);

                $detail = explode('_', $details[$day[0] - 1]);
            }

            $finalDetail = ($clock_in != '' ? $clock_in : 'NONE') . '_' . ($clock_out != '' ? $clock_out : 'NONE') . '_' . ($late == 'late' ? $late : 'NONE') . '_' . ($halfday == 'halfday' ? $halfday : 'NONE') . '_' . ($work_from == '' ? 'office' : $work_from);

            $details[$day[0] - 1] = $finalDetail;

            $detail = implode('#', $details);
            if (!empty($result->log)) {
                $logs = explode("_", $result->log);
                $checkAdded = "";

                if ($clock_in != '') {
                    $checkAdded = $logs[$day[0] - 1];
                    $logs[$day[0] - 1] = 'yes';
                }

                $log = implode('_', $logs);
            } else {
                $log = '';
                $checkAdded = '';
            }


            $data = array(
                'log' => $log,
                'details' => $detail
            );
            if (!empty($result->id)) {
                if ($checkAdded != 'yes') {
                    $this->db->where('id', $result->id);
                    $this->db->update('attendance', $data);
                }
            }

            $data['sum'] = $this->home_model->getSum('gross_total', 'payment');
            $data['payments'] = $this->finance_model->getPayment();
            $data['notices'] = $this->notice_model->getNotice();
            $data['this_month'] = $this->finance_model->getThisMonth();
           
            $data['expenses'] = $this->finance_model->getExpense();

            if ($this->ion_auth->in_group(array('Doctor'))) {
                redirect('doctor/details');
            } else {
                $data['appointments'] = $this->appointment_model->getAppointment();
            }

            if ($this->ion_auth->in_group(array('Accountant', 'Receptionist'))) {
                redirect('finance/addPaymentView');
            }

            if ($this->ion_auth->in_group(array('Pharmacist'))) {
                redirect('finance/pharmacy/home');
            }

            if ($this->ion_auth->in_group(array('Patient'))) {
                redirect('patient/medicalHistory');
            }
            if ($this->ion_auth->in_group(array('Laboratorist'))) {
                // Redirect to dedicated laboratorist dashboard
                redirect('home/laboratoristDashboard');
            }

            if (!$this->ion_auth->in_group(array('Patient', 'Pharmacist', 'Accountant', 'Receptionist', 'Doctor'))) {
                $data['this_month']['payment'] = $this->finance_model->thisMonthPayment();
                $data['this_month']['expense'] = $this->finance_model->thisMonthExpense();
                $data['this_month']['appointment'] = $this->finance_model->thisMonthAppointment();

                $data['this_day']['payment'] = $this->finance_model->thisDayPayment();
                $data['this_day']['expense'] = $this->finance_model->thisDayExpense();
                $data['this_day']['appointment'] = $this->finance_model->thisDayAppointment();
                $data['paymentda']=$this->finance_model->getThisMonthPayments();
                
                $data['logs_useraccess']=$this->logs_model->getThisLogsTodays();
                $data['expenseda']=$this->finance_model->getThisMonthExpense();
                $data['this_year']['payment'] = $this->finance_model->thisYearPayment();
                $data['this_year']['expense'] = $this->finance_model->thisYearExpense();
                $data['this_year']['appointment'] = $this->finance_model->thisYearAppointment();

                $data['this_month']['appointment'] = $this->finance_model->thisMonthAppointment();
                $data['this_month']['appointment_treated'] = $this->finance_model->thisMonthAppointmentTreated();
                $data['this_month']['appointment_cancelled'] = $this->finance_model->thisMonthAppointmentCancelled();

                $data['this_year']['payment_per_month'] = $this->finance_model->getPaymentPerMonthThisYear();

                $data['this_year']['expense_per_month'] = $this->finance_model->getExpensePerMonthThisYear();
                $data['settings'] = $this->settings_model->getSettings();
                $data['transaction_logs']=$this->home_model->getTransactionLogs();
                $data['salesbycategory']['appointment']=$this->finance_model->thisYearPaymentByCategory('appointment');
                $data['salesbycategory']['bed']=$this->finance_model->thisYearPaymentByCategory('admitted_patient_bed_medicine');
                $data['salesbycategory']['payment']=$this->finance_model->thisYearPaymentByCategory('payment');
                $data['salesbycategory']['pharmacy']=$this->pharmacy_model->thisYearPaymentByCategory();
                $data['salesbycategory']['total']=array_sum($data['salesbycategory']);
                $tes='';
                foreach($data['transaction_logs'] as $logs){
                    if (!isset($logs->date_time)) continue;
                    
                    $time_diff = time() - strtotime($logs->date_time);
                    $days = floor($time_diff / (60 * 60 * 24));

                    if ($days <= 0) {
                        // Calculate hours
                        $hours = floor($time_diff / (60 * 60));
                        $h = $hours . ' hours ago';
                    } else {
                        $h = $days . ' days ago';
                    }

                    // Get payment info safely
                    $payment = $this->finance_model->getPaymentById($logs->invoice_id ?? 0);
                    $payment_from = $payment ? $payment->payment_from : 'Unknown';
                    
                    // Format amount safely
                    $amount = !empty($logs->amount) ? number_format($logs->amount, 2, '.', ',') : '0.00';
                    $currency = !empty($data['settings']->currency) ? $data['settings']->currency : '';
                    $patientname = !empty($logs->patientname) ? $logs->patientname : 'Unknown';

                    $tes .= '<li class="feed-item">
                        <div class="d-flex justify-content-between feed-item-list">
                            <div>
                                <h5 class="font-size-15 mb-1">' . $payment_from . '</h5>
                                <p class="text-muted mt-0 mb-0">' . $patientname . '<br>' . $currency . ' ' . $amount . '</p>
                            </div>
                            <div>
                                <p class="text-muted mb-0">' . $h . '</p>
                            </div>
                        </div>
                    </li>';
                }
                $data['options_log']=$tes;
               
                $data['login_logs']=$this->logs_model->frequentLogin();

                $data['sub']['appointment']=$this->finance_model->thismonthPaymentByCategory('appointment');
                $data['sub']['bed']=$this->finance_model->thismonthPaymentByCategory('admitted_patient_bed_medicine');
                $data['sub']['payment']=$this->finance_model->thismonthPaymentByCategory('payment');
                $data['sub']['pharmacy']=$this->pharmacy_model->thismonthPaymentByCategory();
                $data['patients'] = $this->patient_model->getPatient();
                $data['doctors'] = $this->doctor_model->getDoctor();
                $settings = $this->settings_model->getSettings();
                // $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to);
                if($settings->dashboard_theme == 'main'){
                    $this->load->view('home/layout/header'); // just the header file
                    $this->load->view('home/layout/main', $data);
                    $this->load->view('home/layout/footer', $data);
                }else{
                $this->load->view('dashboard'); // just the header file
                $this->load->view('home', $data);
                $this->load->view('footer', $data);
            }
            }
        } else {
            $data['hospitals'] = $this->hospital_model->getHospital();
            $data['this_month']['payment'] = $this->hospital_model->thisMonthlyDepositCount();
            $data['this_yearly']['payment'] = $this->hospital_model->thisYearlyDepositCount();
            $data['this_year']['payment_per_month'] = $this->hospital_model->getPaymentPerMonthThisYear();
            $data['this_monthly']['payment'] = $this->hospital_model->thisMonthlyDeposit();
            $data['this_year']['payment'] = $this->hospital_model->thisYearlyDeposit();
            $data['this_day']['payment'] = $this->hospital_model->thisDayMonthlyPayment();
            $data['this_day']['payment_yearly'] = $this->hospital_model->thisDayYearlyPayment();
            $data['this_year_payment']['payment'] = $this->hospital_model->thisYearYearlyPayment();
            $data['this_month_payment']['payment'] = $this->hospital_model->thisYearMonthlyPayment();
            $data['hospitals'] = $this->hospital_model->getHospital();
            $data['settings'] = $this->settings_model->getSettings();


           
            // $data['packages'] = $this->package_model->getPackage();
           
            // $data['gateway'] = $this->db->get_where('paymentGateway', array('name' => $data['settings']->payment_gateway, 'hospital_id' => 'superadmin'))->row();
            $this->load->view('dashboard'); // just the header file
            $this->load->view('home', $data);
            $this->load->view('footer');
        }
    }

    public function laboratoristDashboard() {
        // Check if user is laboratorist
        if (!$this->ion_auth->in_group(array('Laboratorist'))) {
            redirect('home/permission');
        }

        $data = array();
        
        // Load required models
        $this->load->model('inventory/inventory_model');
        $this->load->model('labworkflow/labworkflow_model');
        $this->load->model('lab/lab_model');
        $this->load->model('settings/settings_model');
        $this->load->model('patient/patient_model');
        
        // Get settings
        $data['settings'] = $this->settings_model->getSettings();
        
        // === LAB WORKFLOW STATISTICS ===
        $data['lab_stats'] = array();
        
        // Pending tests
        $pending_tests = $this->lab_model->getTestStatusLab('not_done', 'all', null, null);
        $data['lab_stats']['pending_tests'] = count($pending_tests);
        
        // Tests completed today
        $today = date('Y-m-d');
        $completed_today = $this->lab_model->getLabByDate($today, $today);
        $data['lab_stats']['completed_today'] = count($completed_today);
        
        // Specimens collected today
        $specimens_today = $this->labworkflow_model->getLabTestsByDateRange($today, $today);
        $data['lab_stats']['specimens_today'] = count($specimens_today);
        
        // Tests awaiting verification
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('test_status', 'done');
        $this->db->where('(verified_by IS NULL OR verified_by = "")');
        $awaiting_verification = $this->db->count_all_results('lab');
        $data['lab_stats']['awaiting_verification'] = $awaiting_verification;
        
        // Recent lab tests (last 10) - with proper status based on actual results
        $this->db->select('lab.*, patient.name as patient_name, patient.id as patient_id, payment_category.category as test_name, 
                          CASE 
                              WHEN lab.test_status = "done" AND (
                                  lab.report IS NOT NULL AND lab.report != "" OR
                                  lab.critical_values IS NOT NULL AND lab.critical_values != "" OR
                                  lab.interpretation IS NOT NULL AND lab.interpretation != "" OR
                                  EXISTS(SELECT 1 FROM lab_result_values lrv WHERE lrv.lab_id = lab.id AND lrv.result_value IS NOT NULL AND lrv.result_value != "")
                              ) THEN "completed"
                              WHEN lab.test_status = "done" THEN "done_no_results"
                              ELSE lab.test_status
                          END as actual_status');
        $this->db->from('lab');
        $this->db->join('patient', 'patient.id = lab.patient', 'left');
        $this->db->join('payment_category', 'payment_category.id = lab.category_id', 'left');
        $this->db->where('lab.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('lab.date', 'desc');
        $this->db->limit(10);
        $recent_lab_tests = $this->db->get()->result();
        
        // Decrypt patient names
        foreach ($recent_lab_tests as $test) {
            if (!empty($test->patient_name)) {
                $test->patient_name = $this->safe_decrypt($test->patient_name);
            }
        }
        
        $data['recent_lab_tests'] = $recent_lab_tests;
        
        // Recent specimens (last 5)
        $data['recent_specimens'] = array_slice($this->labworkflow_model->getLabSpecimens(), 0, 5);
        
        // Quality control statistics
        $data['lab_stats']['qc_records_today'] = 0;
        if ($this->db->table_exists('lab_quality_control')) {
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('DATE(control_date)', $today);
            $data['lab_stats']['qc_records_today'] = $this->db->count_all_results('lab_quality_control');
        }
        
        // === INVENTORY STATISTICS ===
        $data['inventory_stats'] = array();
        
        // Total inventory value
        $data['inventory_stats']['total_value'] = $this->inventory_model->getTotalStockValue();
        
        // Low stock items count
        $data['inventory_stats']['low_stock_count'] = $this->inventory_model->getLowStockCount();
        
        // Total active items
        $data['inventory_stats']['total_items'] = count($this->inventory_model->getInventoryItems());
        
        // Recent inventory usage (last 5)
        $recent_usage = $this->inventory_model->getInventoryUsage();
        $data['recent_inventory_usage'] = array_slice($recent_usage, 0, 5);
        
        // Stock alerts (unread)
        $data['stock_alerts'] = $this->inventory_model->getStockAlerts(0);
        $data['inventory_stats']['unread_alerts'] = count($data['stock_alerts']);
        
        // Items expiring soon (next 30 days) - check purchases table
        $this->db->select('DISTINCT item_id');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('expiry_date <=', date('Y-m-d', strtotime('+30 days')));
        $this->db->where('expiry_date >=', date('Y-m-d'));
        $expiring_items = $this->db->count_all_results('inventory_purchases');
        $data['inventory_stats']['expiring_soon'] = $expiring_items;
        
        // Category-wise inventory distribution
        $categories = $this->inventory_model->getInventoryCategories();
        $data['category_distribution'] = array();
        foreach ($categories as $category) {
            $this->db->select('COUNT(*) as item_count, SUM(current_stock) as total_stock, SUM(current_stock * unit_cost) as total_value');
            $this->db->where('category_id', $category->id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('status', 'active');
            $result = $this->db->get('inventory_items')->row();
            
            if ($result && $result->item_count > 0) {
                $data['category_distribution'][] = array(
                    'category' => $category->name,
                    'item_count' => $result->item_count,
                    'total_stock' => $result->total_stock ?: 0,
                    'total_value' => $result->total_value ?: 0
                );
            }
        }
        
        // === WEEKLY STATISTICS ===
        $week_start = date('Y-m-d', strtotime('monday this week'));
        $week_end = date('Y-m-d', strtotime('sunday this week'));
        
        // Tests completed this week
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('test_status', 'done');
        $this->db->where('DATE(FROM_UNIXTIME(date)) >=', $week_start);
        $this->db->where('DATE(FROM_UNIXTIME(date)) <=', $week_end);
        $data['lab_stats']['week_completed'] = $this->db->count_all_results('lab');
        
        // Inventory usage this week
        $week_usage = $this->inventory_model->getUsageReport($week_start, $week_end);
        $data['inventory_stats']['week_usage_count'] = count($week_usage);
        $week_usage_value = 0;
        foreach ($week_usage as $usage) {
            $item = $this->inventory_model->getInventoryItemById($usage->item_id);
            if ($item) {
                $week_usage_value += ($usage->quantity_used * $item->unit_cost);
            }
        }
        $data['inventory_stats']['week_usage_value'] = $week_usage_value;
        
        // === QUICK ACTIONS DATA ===
        // Get pending lab tests for quick access
        $data['pending_lab_tests'] = array_slice($pending_tests, 0, 5);
        
        // Get critical stock alerts
        $data['critical_alerts'] = $this->inventory_model->getStockAlerts(0);
        foreach ($data['critical_alerts'] as $key => $alert) {
            if ($alert->alert_level !== 'critical') {
                unset($data['critical_alerts'][$key]);
            }
        }
        $data['critical_alerts'] = array_values($data['critical_alerts']);
        
        // === CHARTS DATA ===
        // Daily test completion for the last 7 days
        $data['daily_test_completion'] = array();
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('test_status', 'done');
            $this->db->where('DATE(FROM_UNIXTIME(date))', $date);
            $count = $this->db->count_all_results('lab');
            
            $data['daily_test_completion'][] = array(
                'date' => $date,
                'count' => $count,
                'day' => date('D', strtotime($date))
            );
        }
        
        // Test status distribution
        $test_statuses = array('not_done', 'done', 'pending');
        $data['test_status_distribution'] = array();
        foreach ($test_statuses as $status) {
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('test_status', $status);
            $count = $this->db->count_all_results('lab');
            
            $data['test_status_distribution'][] = array(
                'status' => ucfirst(str_replace('_', ' ', $status)),
                'count' => $count
            );
        }
        
        // Page metadata
        $data['page'] = 'Laboratorist Dashboard';
        $data['page_title'] = 'Laboratory & Inventory Management';
        
        // Load the view
        if($this->ion_auth->in_group('admin') || isset($data['settings']->dashboard_theme) && $data['settings']->dashboard_theme == 'main'){
            $this->load->view('home/layout/header');
            $this->load->view('laboratorist_dashboard', $data);
            $this->load->view('home/layout/footer');
        } else {
            $this->load->view('dashboard');
            $this->load->view('laboratorist_dashboard', $data);
            $this->load->view('footer');
        }
    }

    public function permission() {
        $this->load->view('permission');
    }
     public function navBarColor(){
        $color=$this->input->get('color');
        $user=$this->ion_auth->get_user_id();
      
        $update=$this->db->where('id', $user)->update('users',array('color'=>$color));

        echo json_encode($update);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
