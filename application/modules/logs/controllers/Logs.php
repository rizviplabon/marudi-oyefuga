<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logs extends MX_Controller {

    function __construct() {
        parent::__construct();
       
        $this->load->model('logs_model');
        if(!$this->ion_auth->in_group(array('admin','superadmin'))){
            redirect('home/permission');
        }
    }
    function index(){
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('logs');
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('logs');
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard');
        $this->load->view('logs');
        $this->load->view('home/footer');
            }
    }
    function getLogs(){
     
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "name",
            "2" => "email",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];
        if($this->ion_auth->in_group(array('admin'))){
        if ($limit == -1) {
            if (!empty($search)) {
                $data['logs'] = $this->logs_model->getLogsBysearch($search, $order, $dir);
            } else {
                $data['logs'] = $this->logs_model->getLogsWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['logs'] = $this->logs_model->getLogsByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['logs'] = $this->logs_model->getLogsWithoutSearch($order, $dir);
                //$data['logs'] = $this->logs_model->getLogsByLimit($limit, $start, $order, $dir);
            }
        }
    }else{
        if ($limit == -1) {
            if (!empty($search)) {
                $data['logs'] = $this->logs_model->getLogsBysearchForSuperadmin($search, $order, $dir);
            } else {
                $data['logs'] = $this->logs_model->getLogsWithoutSearchForSuperadmin($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['logs'] = $this->logs_model->getLogsByLimitBySearchForSuperadmin($limit, $start, $search, $order, $dir);
            } else {
                $data['logs'] = $this->logs_model->getLogsWithoutSearchForSuperadmin($order, $dir);
                //$data['logs'] = $this->logs_model->getLogsByLimitForSuperadmin($limit, $start, $order, $dir);
            }
        }
       
    }
    $count=count($data['logs']);
        $i = 0;
        foreach ($data['logs'] as $log) {
            $i = $i + 1;

            $info[] = array(
                
                $log->name,
                $log->email,
                $log->role,
                $log->ip_address,
                $log->date_time
            );

           
        }

        if (!empty($data['logs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $count,
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
    function transactionLogs(){
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('transaction_logs');
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('transaction_logs');
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard');
        $this->load->view('transaction_logs');
        $this->load->view('home/footer');
            }
    }
    function getTransaction(){
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "id",
            "1" => "date_time",
            "2" => "deposit_type",
        );
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];
        
        if ($limit == -1) {
            if (!empty($search)) {
                $data['logs'] = $this->logs_model->getTransactionLogsBysearch($search, $order, $dir);
            } else {
                $data['logs'] = $this->logs_model->getTransactionLogsWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['logs'] = $this->logs_model->getTransactionLogsByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['logs'] = $this->logs_model->getTransactionLogsWithoutSearch( $order, $dir);
            }
        }
  
    $count=count($data['logs']);
        $i = 0;
        foreach ($data['logs'] as $log) {
            $i = $i + 1;
    if($log->action=='Added'){
      $action='<span class="badge bg-success">'.lang('added').'</span>';
    }elseif($log->action=='Added/Deposited'){
        $action='<span class="badge bg-success">'.lang('added').' ' .lang('deposited').'</span>';
    }elseif($log->action=='Updated'){
        $action='<span class="badge bg-success">'.lang('updated').'</span>';
    }elseif($log->action=='deleted_deposit'){
        $action='<span class="badge bg-danger">'.lang('deleted').' '.'Deposit'.'</span>';
    }
    elseif($log->action=='deleted'){
        $action='<span class="badge bg-danger">'.lang('deleted').'</span>';
    }else{
    $action='<span class="badge bg-info">'.lang('updated').' ' .lang('deposited').'</span>';
    }
    $user_name=$this->db->get_where('users',array('id'=>$log->user))->row()->username;
            $info[] = array(
                
                $log->date_time,
                $log->invoice_id,
                $log->patientname,
                $log->deposit_type,
                $log->amount,
                // $values[0],
                $user_name,
                $action
            );

           
        }

        if (!empty($data['logs'])) {
            $output = array(
                "draw" => $requestData['draw'],
                "recordsTotal" => count($this->db->get_where('transaction_logs',array('hospital_id'=> $this->session->userdata('hospital_id')))->result()),
                "recordsFiltered" => $count,
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
}