<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('site_model');
        $this->load->model('site/slide_model');
        $this->load->model('site/service_model');
        $this->load->model('site/featured_model');
        $this->load->model('site/review_model');
        $this->load->model('site/gallery_model');
        $this->load->model('site/gridsection_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        $this->load->model('pgateway/pgateway_model');
        
    }

    public function index()
    {
        $hospital_username = $this->uri->segment(2);
        $hospital = $this->db->get_where('hospital', array('username' => $hospital_username))->row();
        
        if (!empty($hospital)) {
            $hospital_id = $hospital->id;
            $newdata = array(
                'site_id' => $hospital_id,
                'site_name' => $hospital_username
            );
            $this->session->set_userdata($newdata);
        } else {
            redirect('home/permission');
        }

        $data = array();
        $data['doctors'] = $this->site_model->getDoctor();
        $data['slides'] = $this->slide_model->getActiveSlide();
        $data['services'] = $this->service_model->getActiveService();
        $data['featureds'] = $this->featured_model->getActiveFeatured();
        $data['reviews'] = $this->review_model->getActiveReview();
        $data['images'] = $this->gallery_model->getActiveImages();
        $data['gridsections'] = $this->gridsection_model->getGridsection();
        $data['settings'] = $this->site_model->getSettingsBySiteId($hospital_id);
        $data['settings1'] = $this->settings_model->getSettings();
        $data['gateway'] = $this->pgateway_model->getPaymentGatewaySettingsByName($data['settings1']->payment_gateway);

        // Load theme based on settings theme selection
        $theme = $data['settings1']->theme;
        if (!empty($theme) && file_exists(APPPATH . 'modules/site/views/themes/' . $theme . '.php')) {
            $this->load->view('themes/' . $theme, $data);
        } else {
            // Default to theme1 if no theme is set or theme file doesn't exist
            $this->load->view('themes/ripple', $data);
        }
    }

    public function two()
    {
        $data = array();
        $data['doctors'] = $this->site_model->getDoctor();
        $data['slides'] = $this->slide_model->getSlide();
        $data['services'] = $this->service_model->getService();
        $data['featureds'] = $this->featured_model->getFeatured();
        $this->load->view('site_backup', $data);
    }

    public function addNew()
    {
        $id = $this->input->post('id');

        $patient = $this->input->post('patient');

        $doctor = $this->input->post('doctor');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        }



        $time_slot = $this->input->post('time_slot');

        $time_slot_explode = explode('To', $time_slot);



        if (array_key_exists("0", $time_slot_explode)) {
            $s_time = trim($time_slot_explode[0]);
        } else {
            $s_time = '';
        }

        if (array_key_exists("1", $time_slot_explode)) {
            $e_time = trim($time_slot_explode[1]);
        } else {
            $e_time  = '';
        }




        $remarks = $this->input->post('remarks');

        $sms = $this->input->post('sms');

        $status = 'Requested';

        $redirect = 'site';

        $request = 'Yes';




        $user = '';




        if ((empty($id))) {
            $add_date = date('m/d/y');
            $registration_time = time();
            $patient_add_date = $add_date;
            $patient_registration_time = $registration_time;
        }

        $s_time_key = $this->getArrayKey($s_time);


        $p_name = $this->input->post('p_name');
        $p_email = $this->input->post('p_email');
        if (empty($p_email)) {
            $p_email = $p_name . '-' . rand(1, 1000) . '-' . $p_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($p_name)) {
            $password = $p_name . '-' . rand(1, 100000000);
        }
        $p_phone = $this->input->post('p_phone');
        $p_age = $this->input->post('p_age');
        $p_gender = $this->input->post('p_gender');
        $patient_id = rand(10000, 1000000);


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');


        if ($patient == 'add_new') {
            $this->form_validation->set_rules('p_name', 'Patient Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('p_phone', 'Patient Phone', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }

        if ($patient == 'patient_id') {
            $this->form_validation->set_rules('patient_id', 'Patient Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }


        // Validating Name Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Doctor Field
        $this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Date Field
        $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|min_length[1]|max_length[1000]|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('warning', lang('form_validation_errorrr'));
            redirect("site");
        } else {


            if ($patient == 'patient_id') {
                $new_id = $this->input->post('patient_id');
                $patient = $this->site_model->getPatientByNewId($new_id)->id;
                // $patient = $this->input->post('patient_id');

                if (!empty($patient)) {
                    $patient_exist = $this->site_model->getPatientById($patient)->id;
                }

                if (empty($patient_exist)) {
                    $this->session->set_flashdata('warning', lang('invalid_patient_id'));
                    redirect("site");
                }
            }

            if ($patient == 'add_new') {
                $data_p = array(
                    'patient_id' => $patient_id,
                    'name' => $p_name,
                    'email' => $p_email,
                    'phone' => $p_phone,
                    'sex' => $p_gender,
                    'age' => $p_age,
                    'add_date' => $patient_add_date,
                    'registration_time' => $patient_registration_time,
                    'how_added' => 'from_appointment'
                );
                $username = $this->input->post('p_name');
                // Adding New Patient
                if ($this->ion_auth->email_check($p_email)) {
                    $this->session->set_flashdata('warning', lang('this_email_address_is_already_registered'));
                    redirect($redirect);
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $p_email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $p_email))->row()->id;
                    $this->site_model->insertPatient($data_p);
                    $patient_user_id = $this->db->get_where('patient', array('email' => $p_email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->site_model->updatePatient($patient_user_id, $id_info);
                }

                $patient = $patient_user_id;


                $mail_provider = $this->site_model->getSettings()->emailtype;
                $email_settings = $this->site_model->getEmailSettingsByType($mail_provider);
                $settngsname = $this->site_model->getSettings()->system_vendor;
                $base_url = str_replace(array('http://', 'https://', '/'), '', base_url());
                $subject = $base_url . ' - Patient Registration Details';
                $message = 'Dear ' . $p_name . ',<br> Thank you for the registration. <br><br> Here is your login details.<br>  Link: ' . base_url() . 'auth/login <br> Username: ' . $p_email . ' <br> Password: ' . $password . '<br><br> Thank You, <br>' . $this->settings->title;
                if ($mail_provider == 'Domain Email') {
                    $this->email->from($email_settings->admin_email, $settngsname);
                }
                if ($mail_provider == 'Smtp') {
                    $this->email->from($email_settings->user, $settngsname);
                }
                $this->email->to($p_email);
                $this->email->subject($subject);
                $this->email->message($message);


                $this->email->send();
            }

            $data = array();
            $patientname = $this->site_model->getPatientById($patient)->name;
            $patient_phone = $this->site_model->getPatientById($patient)->phone;
            $doctorname = $this->site_model->getDoctorById($doctor)->name;
            $room_id = 'hms-meeting-' . $patient_phone . '-' . rand(10000, 1000000);
            $live_meeting_link = 'https://meet.jit.si/' . $room_id;
            $app_time = strtotime(date('d-m-Y', $date) . ' ' . $s_time);
            $app_time_full_format = date('d-m-Y', $date) . ' ' . $s_time . '-' . $e_time;
            $patient_details = $this->site_model->getPatientById($patient);
            $consultant_fee = $this->input->post('visit_charges');
            $data = array(
                'patient' => $patient,
                'patientname' => $patientname,
                'doctor' => $doctor,
                'doctorname' => $doctorname,
                'date' => $date,
                's_time' => $s_time,
                'e_time' => $e_time,
                'time_slot' => $time_slot,
                'remarks' => $remarks,
                'add_date' => $add_date,
                'registration_time' => $registration_time,
                'status' => $status,
                's_time_key' => $s_time_key,
                'user' => $user,
                'request' => $request,
                'room_id' => $room_id,
                'live_meeting_link' => $live_meeting_link,
                'app_time' => $app_time,
                'app_time_full_format' => $app_time_full_format,
                'visit_description' => $this->input->post('visit_description'),
                'visit_charges' => $this->input->post('visit_charges'),
                'discount' => $this->input->post('discount'),
                'grand_total' => $consultant_fee,
            );
            $data_appointment = array(
                'category_name' => 'Consultant Fee',
                'patient' => $patient,
                'amount' => $consultant_fee,
                'doctor' => $doctor,
                'discount' => $this->input->post('discount'),
                'flat_discount' => '0',
                'gross_total' => $consultant_fee,
                'status' => 'unpaid',
                'hospital_amount' => '0',
                'doctor_amount' => $consultant_fee,
                'user' => $user,
                'patient_name' => $patient_details->name,
                'patient_phone' => $patient_details->phone,
                'patient_address' => $patient_details->address,
                'doctor_name' => $doctorname,
                'remarks' => $remarks,
                'payment_from' => 'appointment'
            );
            $username = $this->input->post('name');

            if (empty($id)) {     // Adding New department
                $data['payment_status'] = 'unpaid';

                $this->site_model->insertAppointment($data);
                $appointment_id = $this->db->insert_id('appointment');
                // $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add New Appointment with ' . $doctorname . ' (id=' . $appointment_id . ' )', $appointment_id);
                $data_appointment['appointment_id'] = $appointment_id;
                $data_appointment['date'] = time();
                $data_appointment['date_string'] = date('d-m-Y');
                $this->site_model->insertPayment($data_appointment);
                $inserted_id = $this->db->insert_id('payment');

                $data_update_payment_id_in_appointment = array('payment_id' => $inserted_id);
                $this->site_model->updateAppointment($appointment_id, $data_update_payment_id_in_appointment);

                if (!empty($sms)) {
                    $this->sms->sendSmsDuringAppointment($patient, $doctor, $date, $s_time, $e_time);
                }

                $patient_doctor = $this->site_model->getPatientById($patient)->doctor;

                $patient_doctors = explode(',', $patient_doctor);



                if (!in_array($doctor, $patient_doctors)) {
                    $patient_doctors[] = $doctor;
                    $doctorss = implode(',', $patient_doctors);
                    $data_d = array();
                    $data_d = array('doctor' => $doctorss);
                    $this->site_model->updatePatient($patient, $data_d);
                }
                $pay_now_appointment = $this->input->post('pay_now_appointment');
                $redirectlink = $this->input->post('redirectlink');
                if (!empty($pay_now_appointment)) {

                    $data_for_payment = array();
                    $data_for_payment = array(
                        'card_type' => $this->input->post('card_type'),
                        'card_number' => $this->input->post('card_number'),
                        'expire_date' => $this->input->post('expire_date'),
                        'cardHoldername' => $this->input->post('cardholder'),
                        'cvv' => $this->input->post('cvv'),
                        'token' => $this->input->post('token'),
                        'discount' => $this->input->post('discount'),
                        'grand_total' => $consultant_fee,
                    );
                    $date = time();
                    $this->appointmentPayment($data_for_payment, $patient, $doctor, $consultant_fee, $date, $inserted_id, $redirectlink);
                } else {
                    $this->session->set_flashdata('success', lang('added'));
                    // $this->session->set_flashdata('success', lang('appointment_added_successfully_please_wait_you_will_get_a_confirmation_sms'));
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }

            // if (!empty($redirect)) {
            //     redirect($redirect);
            // } else {
            //     redirect('appointment');
            // }
        }
    }
    public function appointmentPayment($data, $patient, $doctor, $consultant_fee, $date, $inserted_id, $redirectlink)
    {

        $patient_details = $this->site_model->getPatientById($patient);
        $user = $this->ion_auth->get_user_id();
        $doctorname = $this->site_model->getDoctorById($doctor)->name;

        $gateway = $this->settings_model->getSettings()->payment_gateway;
        if ($gateway == 'PayPal') {

            $card_type = $data['cardtype'];
            $card_number = $data['card_number'];
            $expire_date = $data['expire_date'];
            $cardHoldername = $data['cardHoldername'];
            $cvv = $data['cvv'];

            $all_details = array(
                'patient' => $patient,
                'date' => $date,
                'amount' => $consultant_fee,
                'doctor' => $doctor,
                'gross_total' => $data['grand_total'],
                //'hospital_amount' => $hospital_amount,
                // 'doctor_amount' => $doctor_amount,
                'patient_name' => $patient_details->name,
                'patient_phone' => $patient_details->phone,
                'patient_address' => $patient_details->address,
                'doctor_name' => $doctorname,
                'date_string' => date('d-m-y', $date),
                'deposited_amount' => $data['grand_total'],
                'payment_id' => $inserted_id,
                'card_type' => $card_type,
                'card_number' => $card_number,
                'expire_date' => $expire_date,
                'cvv' => $cvv,
                'from' => 'appointment',
                'user' => $this->ion_auth->get_user_id(),
                'cardholdername' => $cardHoldername,
                'from' => $redirectlink
            );

            $this->paypal->paymentPaypal($all_details);
        } elseif ($gateway == 'Stripe') {

            $card_number = $data['card_number'];
            $expire_date = $data['expire_date'];

            $cvv = $data['cvv'];

            $token = $data['token'];
            $stripe = $this->pgateway_model->getPaymentGatewaySettingsByName('Stripe');
            \Stripe\Stripe::setApiKey($stripe->secret);
            $charge = \Stripe\Charge::create(array(
                "amount" => $data['grand_total'] * 100, 
                "currency" => "usd",
                "source" => $token
            ));
            $chargeJson = $charge->jsonSerialize();
            if ($chargeJson['status'] == 'succeeded') {
                $data1 = array(
                    'date' => $date,
                    'patient' => $patient,
                    'payment_id' => $inserted_id,
                    'deposited_amount' => $data['grand_total'],
                    'amount_received_id' => $inserted_id . '.' . 'gp',
                    'gateway' => 'Stripe',
                    'user' => $user,
                    'payment_from' => 'appointment'
                );
                $this->site_model->insertDeposit($data1);
                $data_payment = array('amount_received' => $data['grand_total'], 'deposit_type' => $deposit_type, 'status' => 'paid', 'date' => time(), 'date_string' => date('d-m-y', time()));
                $this->site_model->updatePayment($inserted_id, $data_payment);
                $appointment_id = $this->site_model->getPaymentById($inserted_id)->appointment_id;

                $appointment_details = $this->site_model->getAppointmentById($appointment_id);
                if ($appointment_details->status == 'Requested') {
                    $data_appointment_status = array('status' => 'Confirmed', 'payment_status' => 'paid');
                } else {
                    $data_appointment_status = array('payment_status' => 'paid');
                }

                $this->site_model->updateAppointment($appointment_id, $data_appointment_status);
                $this->session->set_flashdata('feedback', lang('payment_successful'));
            } else {
                $this->session->set_flashdata('feedback', lang('transaction_failed'));
            }
        } elseif ($gateway == 'Pay U Money') {
            redirect("payu/check4?deposited_amount=" . $data['grand_total'] . '&payment_id=' . $inserted_id . '&redirectlink=' . $redirectlink);
        } elseif ($gateway == 'Paystack') {

            $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m');
            $amount_in_kobo = $data['grand_total'];
            $this->load->module('paystack');
            $this->paystack->paystack_standard($amount_in_kobo, $ref, $patient, $inserted_id, $this->ion_auth->get_user_id(), $redirectlink);

            // $email=$patient_email;
        } elseif ($gateway == 'Paytm') {
            $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m') . '-site';

            $amount = $data['grand_total'];
            $this->load->module('paytm');

            $datapayment = array(
                'ref' => $ref,
                'amount' => $amount,
                'patient' => $patient,
                'insertid' => $inserted_id,
                'channel_id' => 'WEB',
                'industry_type' => 'Retail',
                'email' => $patient_details->email,
            );

            $this->paytm->PaytmGateway($datapayment);
        } elseif ($gateway == 'Authorize.Net') {

            $card_type = $data['cardtype'];
            $card_number = $data['card_number'];
            $expire_date = $data['expire_date'];

            $cvv = $data['cvv'];
            $ref = date('Y') . rand() . date('d');
            $amount = $data['grand_total'];

            $card_number = base64_encode($card_number);
            $cvv = base64_encode($cvv);
            //     if ($configuration) {
            $datapayment = array(
                'ref' => $ref,
                'amount' => $amount,
                'patient' => $patient,
                'insertid' => $inserted_id,
                'card_type' => $card_type,
                'card_number' => $card_number,
                'expire_date' => $expire_date,
                'cvv' => $cvv,
            );

            $this->load->module('authorizenet');
            $response = $this->authorizenet->paymentAuthorize($datapayment, $redirectlink);
        } elseif ($gateway == '2Checkout') {

            $card_type = $data['cardtype'];
            $card_number = $data['card_number'];
            $expire_date = $data['expire_date'];
            $cardHoldername = $data['cardHoldername'];
            $cvv = $data['cvv'];
            $ref = date('Y') . rand() . date('d');
            $amount = $data['grand_total'];
            $token = $this->input->post('token');

            $datapayment = array(
                'ref' => $ref,
                'amount' => $data['grand_total'],
                'patient' => $patient,
                'insertid' => $inserted_id,
                'card_type' => $card_type,
                'card_number' => $card_number,
                'expire_date' => $expire_date,
                'cvv' => $cvv,
                'cardholder' => $cardHoldername
            );

            $this->load->module('twocheckoutpay');
            $charge = $this->twocheckoutpay->createCharge($ref, $token, $amount, $datapayment);

            if ($charge['response']['responseCode'] == 'APPROVED') {
                $data1 = array(
                    'date' => $date,
                    'patient' => $patient,
                    'deposited_amount' => $data['grand_total'],
                    'payment_id' => $inserted_id,
                    'amount_received_id' => $inserted_id . '.' . 'gp',
                    'deposit_type' => $deposit_type,
                    'user' => $user,
                    'payment_from' => 'appointment'
                );
                $this->site_model->insertDeposit($data1);

                $data_payment = array('amount_received' => $data['grand_total'], 'deposit_type' => $deposit_type, 'status' => 'paid', 'date' => time(), 'date_string' => date('d-m-y', time()));
                $this->site_model->updatePayment($inserted_id, $data_payment);
                $appointment_id = $this->site_model->getPaymentById($inserted_id)->appointment_id;
                $appointment_details = $this->site_model->getAppointmentById($appointment_id);
                if ($appointment_details->status == 'Requested') {
                    $data_appointment_status = array('status' => 'Confirmed', 'payment_status' => 'paid');
                } else {
                    $data_appointment_status = array('payment_status' => 'paid');
                }
                $this->site_model->updateAppointment($appointment_id, $data_appointment_status);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->session->set_flashdata('feedback', lang('transaction_failed'));
            }
        } elseif ($gateway == 'SSLCOMMERZ') {

            //   $SSLCOMMERZ = $this->db->get_where('paymentGateway', array('name =' => 'SSLCOMMERZ'))->row();


            $this->load->module('sslcommerzpayment');

            $this->sslcommerzpayment->request_api_hosted($data['grand_total'], $patient, $inserted_id, $this->ion_auth->get_user_id(), $redirectlink);
        } else {
            $this->session->set_flashdata('feedback', lang('payment_failed_no_gateway_selected'));
            $appointment_id = $this->site_model->getPaymentById($inserted_id)->appointment_id;
            $data_appointment_status = array('payment_status' => 'unpaid');
            $this->site_model->updateAppointment($appointment_id, $data_appointment_status);
        }
        redirect("site");
    }
    function getArrayKey($s_time)
    {
        $all_slot = array(
            '0' => '12:00 AM',
            '1' => '12:05 AM',
            '2' => '12:10 AM',
            '3' => '12:15 AM',
            '4' => '12:20 AM',
            '5' => '12:25 AM',
            '6' => '12:30 AM',
            '7' => '12:35 AM',
            '8' => '12:40 PM',
            '9' => '12:45 AM',
            '10' => '12:50 AM',
            '11' => '12:55 AM',
            '12' => '01:00 AM',
            '13' => '01:05 AM',
            '14' => '01:10 AM',
            '15' => '01:15 AM',
            '16' => '01:20 AM',
            '17' => '01:25 AM',
            '18' => '01:30 AM',
            '19' => '01:35 AM',
            '20' => '01:40 AM',
            '21' => '01:45 AM',
            '22' => '01:50 AM',
            '23' => '01:55 AM',
            '24' => '02:00 AM',
            '25' => '02:05 AM',
            '26' => '02:10 AM',
            '27' => '02:15 AM',
            '28' => '02:20 AM',
            '29' => '02:25 AM',
            '30' => '02:30 AM',
            '31' => '02:35 AM',
            '32' => '02:40 AM',
            '33' => '02:45 AM',
            '34' => '02:50 AM',
            '35' => '02:55 AM',
            '36' => '03:00 AM',
            '37' => '03:05 AM',
            '38' => '03:10 AM',
            '39' => '03:15 AM',
            '40' => '03:20 AM',
            '41' => '03:25 AM',
            '42' => '03:30 AM',
            '43' => '03:35 AM',
            '44' => '03:40 AM',
            '45' => '03:45 AM',
            '46' => '03:50 AM',
            '47' => '03:55 AM',
            '48' => '04:00 AM',
            '49' => '04:05 AM',
            '50' => '04:10 AM',
            '51' => '04:15 AM',
            '52' => '04:20 AM',
            '53' => '04:25 AM',
            '54' => '04:30 AM',
            '55' => '04:35 AM',
            '56' => '04:40 AM',
            '57' => '04:45 AM',
            '58' => '04:50 AM',
            '59' => '04:55 AM',
            '60' => '05:00 AM',
            '61' => '05:05 AM',
            '62' => '05:10 AM',
            '63' => '05:15 AM',
            '64' => '05:20 AM',
            '65' => '05:25 AM',
            '66' => '05:30 AM',
            '67' => '05:35 AM',
            '68' => '05:40 AM',
            '69' => '05:45 AM',
            '70' => '05:50 AM',
            '71' => '05:55 AM',
            '72' => '06:00 AM',
            '73' => '06:05 AM',
            '74' => '06:10 AM',
            '75' => '06:15 AM',
            '76' => '06:20 AM',
            '77' => '06:25 AM',
            '78' => '06:30 AM',
            '79' => '06:35 AM',
            '80' => '06:40 AM',
            '81' => '06:45 AM',
            '82' => '06:50 AM',
            '83' => '06:55 AM',
            '84' => '07:00 AM',
            '85' => '07:05 AM',
            '86' => '07:10 AM',
            '87' => '07:15 AM',
            '88' => '07:20 AM',
            '89' => '07:25 AM',
            '90' => '07:30 AM',
            '91' => '07:35 AM',
            '92' => '07:40 AM',
            '93' => '07:45 AM',
            '94' => '07:50 AM',
            '95' => '07:55 AM',
            '96' => '08:00 AM',
            '97' => '08:05 AM',
            '98' => '08:10 AM',
            '99' => '08:15 AM',
            '100' => '08:20 AM',
            '101' => '08:25 AM',
            '102' => '08:30 AM',
            '103' => '08:35 AM',
            '104' => '08:40 AM',
            '105' => '08:45 AM',
            '106' => '08:50 AM',
            '107' => '08:55 AM',
            '108' => '09:00 AM',
            '109' => '09:05 AM',
            '110' => '09:10 AM',
            '111' => '09:15 AM',
            '112' => '09:20 AM',
            '113' => '09:25 AM',
            '114' => '09:30 AM',
            '115' => '09:35 AM',
            '116' => '09:40 AM',
            '117' => '09:45 AM',
            '118' => '09:50 AM',
            '119' => '09:55 AM',
            '120' => '10:00 AM',
            '121' => '10:05 AM',
            '122' => '10:10 AM',
            '123' => '10:15 AM',
            '124' => '10:20 AM',
            '125' => '10:25 AM',
            '126' => '10:30 AM',
            '127' => '10:35 AM',
            '128' => '10:40 AM',
            '129' => '10:45 AM',
            '130' => '10:50 AM',
            '131' => '10:55 AM',
            '132' => '11:00 AM',
            '133' => '11:05 AM',
            '134' => '11:10 AM',
            '135' => '11:15 AM',
            '136' => '11:20 AM',
            '137' => '11:25 AM',
            '138' => '11:30 AM',
            '139' => '11:35 AM',
            '140' => '11:40 AM',
            '141' => '11:45 AM',
            '142' => '11:50 AM',
            '143' => '11:55 AM',
            '144' => '12:00 PM',
            '145' => '12:05 PM',
            '146' => '12:10 PM',
            '147' => '12:15 PM',
            '148' => '12:20 PM',
            '149' => '12:25 PM',
            '150' => '12:30 PM',
            '151' => '12:35 PM',
            '152' => '12:40 PM',
            '153' => '12:45 PM',
            '154' => '12:50 PM',
            '155' => '12:55 PM',
            '156' => '01:00 PM',
            '157' => '01:05 PM',
            '158' => '01:10 PM',
            '159' => '01:15 PM',
            '160' => '01:20 PM',
            '161' => '01:25 PM',
            '162' => '01:30 PM',
            '163' => '01:35 PM',
            '164' => '01:40 PM',
            '165' => '01:45 PM',
            '166' => '01:50 PM',
            '167' => '01:55 PM',
            '168' => '02:00 PM',
            '169' => '02:05 PM',
            '170' => '02:10 PM',
            '171' => '02:15 PM',
            '172' => '02:20 PM',
            '173' => '02:25 PM',
            '174' => '02:30 PM',
            '175' => '02:35 PM',
            '176' => '02:40 PM',
            '177' => '02:45 PM',
            '178' => '02:50 PM',
            '179' => '02:55 PM',
            '180' => '03:00 PM',
            '181' => '03:05 PM',
            '182' => '03:10 PM',
            '183' => '03:15 PM',
            '184' => '03:20 PM',
            '185' => '03:25 PM',
            '186' => '03:30 PM',
            '187' => '03:35 PM',
            '188' => '03:40 PM',
            '189' => '03:45 PM',
            '190' => '03:50 PM',
            '191' => '03:55 PM',
            '192' => '04:00 PM',
            '193' => '04:05 PM',
            '194' => '04:10 PM',
            '195' => '04:15 PM',
            '196' => '04:20 PM',
            '197' => '04:25 PM',
            '198' => '04:30 PM',
            '199' => '04:35 PM',
            '200' => '04:40 PM',
            '201' => '04:45 PM',
            '202' => '04:50 PM',
            '203' => '04:55 PM',
            '204' => '05:00 PM',
            '205' => '05:05 PM',
            '206' => '05:10 PM',
            '207' => '05:15 PM',
            '208' => '05:20 PM',
            '209' => '05:25 PM',
            '210' => '05:30 PM',
            '211' => '05:35 PM',
            '212' => '05:40 PM',
            '213' => '05:45 PM',
            '214' => '05:50 PM',
            '215' => '05:55 PM',
            '216' => '06:00 PM',
            '217' => '06:05 PM',
            '218' => '06:10 PM',
            '219' => '06:15 PM',
            '220' => '06:20 PM',
            '221' => '06:25 PM',
            '222' => '06:30 PM',
            '223' => '06:35 PM',
            '224' => '06:40 PM',
            '225' => '06:45 PM',
            '226' => '06:50 PM',
            '227' => '06:55 PM',
            '228' => '07:00 PM',
            '229' => '07:05 PM',
            '230' => '07:10 PM',
            '231' => '07:15 PM',
            '232' => '07:20 PM',
            '233' => '07:25 PM',
            '234' => '07:30 PM',
            '235' => '07:35 PM',
            '236' => '07:40 PM',
            '237' => '07:45 PM',
            '238' => '07:50 PM',
            '239' => '07:55 PM',
            '240' => '08:00 PM',
            '241' => '08:05 PM',
            '242' => '08:10 PM',
            '243' => '08:15 PM',
            '244' => '08:20 PM',
            '245' => '08:25 PM',
            '246' => '08:30 PM',
            '247' => '08:35 PM',
            '248' => '08:40 PM',
            '249' => '08:45 PM',
            '250' => '08:50 PM',
            '251' => '08:55 PM',
            '252' => '09:00 PM',
            '253' => '09:05 PM',
            '254' => '09:10 PM',
            '255' => '09:15 PM',
            '256' => '09:20 PM',
            '257' => '09:25 PM',
            '258' => '09:30 PM',
            '259' => '09:35 PM',
            '260' => '09:40 PM',
            '261' => '09:45 PM',
            '262' => '09:50 PM',
            '263' => '09:55 PM',
            '264' => '10:00 PM',
            '265' => '10:05 PM',
            '266' => '10:10 PM',
            '267' => '10:15 PM',
            '268' => '10:20 PM',
            '269' => '10:25 PM',
            '270' => '10:30 PM',
            '271' => '10:35 PM',
            '272' => '10:40 PM',
            '273' => '10:45 PM',
            '274' => '10:50 PM',
            '275' => '10:55 PM',
            '276' => '11:00 PM',
            '277' => '11:05 PM',
            '278' => '11:10 PM',
            '279' => '11:15 PM',
            '280' => '11:20 PM',
            '281' => '11:25 PM',
            '282' => '11:30 PM',
            '283' => '11:35 PM',
            '284' => '11:40 PM',
            '285' => '11:45 PM',
            '286' => '11:50 PM',
            '287' => '11:55 PM',
        );

        $key = array_search($s_time, $all_slot);
        return $key;
    }

    public function settings()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        if (!$this->ion_auth->in_group(array('admin'))) {
            redirect('home');
        }
        $data = array();
        $data['settings'] = $this->site_model->getSettings();
        $data['settings1'] = $this->settings_model->getSettings();
        if($this->ion_auth->in_group('admin')){                
            if($data['settings1']->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('site/settings', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('site/settings', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('site/settings', $data);
        $this->load->view('home/footer'); // just the footer file
            }
    }

    public function update()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $emergency = $this->input->post('emergency');
        $support = $this->input->post('support');
        $currency = $this->input->post('currency');
        $logo = $this->input->post('logo');
        $twitter_username = $this->input->post('twitter_username');

        $block_1_text_under_title = $this->input->post('block_1_text_under_title');
        $service_block_text_under_title = $this->input->post('service_block__text_under_title');
        $doctor_block_text_under_title = $this->input->post('doctor_block__text_under_title');
        $appointment_block_text_under_title = $this->input->post('appointment_block_text_under_title');

        $facebook_id = $this->input->post('facebook_id');
        $twitter_id = $this->input->post('twitter_id');
        $google_id = $this->input->post('google_id');
        $youtube_id = $this->input->post('youtube_id');
        $skype_id = $this->input->post('skype_id');

        $appointment_title = $this->input->post('appointment_title');
        $appointment_subtitle = $this->input->post('appointment_subtitle');
        $appointment_description = $this->input->post('appointment_description');

        $language = $this->input->post('language');
        $footer_text = $this->input->post('footer_text');
        $coordinates = $this->input->post('coordinates');
        $youtube_video_link = $this->input->post('youtube_video_link');
        
        $years_of_experience = $this->input->post('years_of_experience');
        $happy_patients = $this->input->post('happy_patients');
        $qualified_doctors = $this->input->post('qualified_doctors');
        $hospital_rooms = $this->input->post('hospital_rooms');
        $website_video_link = $this->input->post('website_video_link');
        $gallery_text_under_title = $this->input->post('gallery_text_under_title');



        if (!empty($email)) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // Validating Title Field
            $this->form_validation->set_rules('title', 'Title', 'rtrim|min_length[1]|max_length[100]|xss_clean');
            // Validating Email Field
            $this->form_validation->set_rules('email', 'Email', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Address Field   
            $this->form_validation->set_rules('address', 'Address', 'trim|min_length[1]|max_length[1000]|xss_clean');
            // Validating Phone Field           
            $this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('currency', 'Currency', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('logo', 'Logo', 'trim|min_length[1]|max_length[1000]|xss_clean');

            $this->form_validation->set_rules('description', 'Footer Description', 'trim|min_length[1]|max_length[1000]|xss_clean');

            // Validating Currency Field   
            $this->form_validation->set_rules('emergency', 'Emergency', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('support', 'Support', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('block_1_text_under_title', 'Block 1 Text Under Title', 'trim|min_length[1]|max_length[500]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('service_block__text_under_title', 'Service Block Text Under Title', 'trim|min_length[1]|max_length[500]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('doctor_block__text_under_title', 'Doctor Block Text Under Title', 'trim|min_length[1]|max_length[500]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('facebook_id', 'Facebook Id', 'trim|min_length[1]|max_length[1000]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('twitter_id', 'Twitter Id', 'trim|min_length[1]|max_length[1000]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('google_id', 'Google Id', 'trim|min_length[1]|max_length[1000]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('youtube_id', 'Youtube Id', 'trim|min_length[1]|max_length[1000]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('skype_id', 'Skype Id', 'trim|min_length[1]|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('twitter_username', 'Twitter Username', 'trim|min_length[1]|max_length[100]|xss_clean');

            $this->form_validation->set_rules('appointment_title', 'Appointment Title', 'trim|min_length[1]|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('appointment_subtitle', 'Appointment Subtitle', 'trim|min_length[1]|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('appointment_description', 'Appointment Description', 'trim|min_length[1]|max_length[1000]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data = array();
                $data['settings'] = $this->site_model->getSettings();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('settings', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {

                $file_name = $_FILES['img_url']['name'];
                $file_name_pieces = explode('_', $file_name);
                $new_file_name = '';
                $count = 1;
                foreach ($file_name_pieces as $piece) {
                    if ($count !== 1) {
                        $piece = ucfirst($piece);
                    }

                    $new_file_name .= $piece;
                    $count++;
                }
                $config = array(
                    'file_name' => $new_file_name,
                    'upload_path' => "./uploads/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => False,
                    'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "10000",
                    'max_width' => "10000"
                );
                $this->load->library('Upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('img_url')) {
                    $path = $this->upload->data();
                    $img_url = "uploads/" . $path['file_name'];
                    $data = array();
                    $data = array(
                        'title' => $title,
                        'description' => $description,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email,
                        'currency' => $currency,
                        'emergency' => $emergency,
                        'support' => $support,
                        'block_1_text_under_title' => $block_1_text_under_title,
                        'service_block__text_under_title' => $service_block_text_under_title,
                        'doctor_block__text_under_title' => $doctor_block_text_under_title,
                        'facebook_id' => $facebook_id,
                        'twitter_id' => $twitter_id,
                        'google_id' => $google_id,
                        'youtube_id' => $youtube_id,
                        'skype_id' => $skype_id,
                        'logo' => $img_url,
                        'twitter_username' => $twitter_username,
                        'appointment_title' => $appointment_title,
                        'appointment_subtitle' => $appointment_subtitle,
                        'appointment_description' => $appointment_description,
                        'language' => $language,
                        'footer_text' => $footer_text,
                        'coordinates' => $coordinates,
                        'appointment_block_text_under_title' => $appointment_block_text_under_title,
                        'youtube_video_link' => $youtube_video_link,
                        'years_of_experience' => $years_of_experience,
                        'happy_patients' => $happy_patients,
                        'qualified_doctors' => $qualified_doctors,
                        'hospital_rooms' => $hospital_rooms,
                        'website_video_link' => $website_video_link,
                        'gallery_text_under_title' => $gallery_text_under_title,
                        
                    );
                } else {
                    $data = array();
                    $data = array(
                        'title' => $title,
                        'description' => $description,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email,
                        'currency' => $currency,
                        'emergency' => $emergency,
                        'support' => $support,
                        'block_1_text_under_title' => $block_1_text_under_title,
                        'service_block__text_under_title' => $service_block_text_under_title,
                        'doctor_block__text_under_title' => $doctor_block_text_under_title,
                        'facebook_id' => $facebook_id,
                        'twitter_id' => $twitter_id,
                        'google_id' => $google_id,
                        'youtube_id' => $youtube_id,
                        'skype_id' => $skype_id,
                        'twitter_username' => $twitter_username,
                        'appointment_title' => $appointment_title,
                        'appointment_subtitle' => $appointment_subtitle,
                        'appointment_description' => $appointment_description,
                        'language' => $language,
                        'footer_text' => $footer_text,
                        'coordinates' => $coordinates,
                        'appointment_block_text_under_title' => $appointment_block_text_under_title,
                        'youtube_video_link' => $youtube_video_link,
                        'years_of_experience' => $years_of_experience,
                        'happy_patients' => $happy_patients,
                        'qualified_doctors' => $qualified_doctors,
                        'hospital_rooms' => $hospital_rooms,
                        'website_video_link' => $website_video_link,
                        'gallery_text_under_title' => $gallery_text_under_title,
                    );
                }

                if (empty($id)) {
                    $this->site_model->addSettings($data);
                    $id = $this->db->insert_id();
                } {
                    $this->site_model->updateSettings($id, $data);
                }
                
                $data2 = array();
                $file_name = $_FILES['appointment_img_url']['name'];
                $file_name_pieces = explode('_', $file_name);
                $new_file_name = '';
                $count = 1;
                foreach ($file_name_pieces as $piece) {
                    if ($count !== 1) {
                        $piece = ucfirst($piece);
                    }

                    $new_file_name .= $piece;
                    $count++;
                }
                $config = array(
                    'file_name' => $new_file_name,
                    'upload_path' => "./uploads/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => False,
                    'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "10000",
                    'max_width' => "10000"
                );

                $this->load->library('Upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('appointment_img_url')) {
                    $path = $this->upload->data();
                    $img_url = "uploads/" . $path['file_name'];

                    $data2 = array(
                        'appointment_img_url' => $img_url
                    );
                    $this->site_model->updateSettings($id, $data2);
                }
                
                
                $datav = array();
                $file_name = $_FILES['video_image']['name'];
                $file_name_pieces = explode('_', $file_name);
                $new_file_name = '';
                $count = 1;
                foreach ($file_name_pieces as $piece) {
                    if ($count !== 1) {
                        $piece = ucfirst($piece);
                    }

                    $new_file_name .= $piece;
                    $count++;
                }
                $config = array(
                    'file_name' => $new_file_name,
                    'upload_path' => "./uploads/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => False,
                    'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "10000",
                    'max_width' => "10000"
                );

                $this->load->library('Upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('video_image')) {
                    $path = $this->upload->data();
                    $img_url = "uploads/" . $path['file_name'];

                    $datav = array(
                        'video_image' => $img_url
                    );
                    $this->site_model->updateSettings($id, $datav);
                }


                $this->session->set_flashdata('feedback', lang('updated'));
                // Loading View
                redirect('site/settings');
            }
        } else {
            $this->session->set_flashdata('feedback', lang('email_required'));
            redirect('site/settings', 'refresh');
        }
    }

    function getAvailableSlotByDoctorByDateByJason()
    {
        $data = array();
        $date = $this->input->get('date');
        if (!empty($date)) {
            $date = strtotime($date);
        }
        $doctor = $this->input->get('doctor');
        if (!empty($date) && !empty($doctor)) {
            $data['aslots'] = $this->site_model->getAvailableSlotByDoctorByDate($date, $doctor);
        }
        echo json_encode($data);
    }
    public function getDoctorVisit()
    {
        $id = $this->input->get('id');
        // $description = $this->input->get('description');
        $visits = $this->site_model->getDoctorVisitByDoctorId($id);
        $option = '<option>' . lang('select') . '</option>';
        foreach ($visits as $visit) {
            $option .= '<option value="' . $visit->id . '">' . $visit->visit_description . '</option>';
        }
        $data['response'] = $option;
        echo json_encode($data);
    }

    public function getDoctorVisitCharges()
    {
        $id = $this->input->get('id');
        $data['response'] = $this->site_model->getDoctorvisitById($id);
        echo json_encode($data);
    }


}

/* End of file appointment.php */
    /* Location: ./application/modules/appointment/controllers/appointment.php */
