<?php

class PatientChat extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('patient_chat_model');
        $this->load->model('patient/patient_model');
        $this->load->model('receptionist/receptionist_model');
    }
    
    public function index() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
        $data = array();
        $current_user_id = $this->ion_auth->user()->row()->id;
        $data['current_user_id'] = $current_user_id;
        
        // Determine if user is a patient or receptionist
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        if (!$is_patient && !$is_receptionist) {
            redirect('home', 'refresh'); // Not authorized to use this chat
        }
        
        $data['is_patient'] = $is_patient;
        $data['is_receptionist'] = $is_receptionist;
        
        if ($is_patient) {
            // Get patient ID for current user
            $patient = $this->db->get_where('patient', array('ion_user_id' => $current_user_id))->row();
            if (!$patient) {
                redirect('home', 'refresh');
            }
            $patient_id = $patient->id;
            $data['patient_id'] = $patient_id;
            
            // Get receptionists the patient has chatted with
            $data['chat_receptionists'] = $this->patient_chat_model->getReceptionistsWithChats($patient_id);
            
            // Get all receptionists for the hospital
            $data['all_receptionists'] = $this->patient_chat_model->getAllReceptionists();
            
            // If no receptionist is selected, select the first one from chat history or all list
            if (count($data['chat_receptionists']) > 0) {
                $data['selected_receptionist_id'] = $data['chat_receptionists'][0]['id'];
            } elseif (count($data['all_receptionists']) > 0) {
                $data['selected_receptionist_id'] = $data['all_receptionists'][0]['id'];
            } else {
                $data['selected_receptionist_id'] = null;
            }
            
        } else { // Receptionist view
            // Get receptionist ID for current user
            $receptionist = $this->db->get_where('receptionist', array('ion_user_id' => $current_user_id))->row();
            if (!$receptionist) {
                redirect('home', 'refresh');
            }
            $receptionist_id = $receptionist->id;
            $data['receptionist_id'] = $receptionist_id;
            
            // Get patients the receptionist has chatted with
            $data['chat_patients'] = $this->patient_chat_model->getPatientsWithChats($receptionist_id);
            
            // Get all patients for the hospital
            $data['all_patients'] = $this->patient_chat_model->getAllPatients();
            
            // If no patient is selected, select the first one from chat history or all list
            if (count($data['chat_patients']) > 0) {
                $data['selected_patient_id'] = $data['chat_patients'][0]['id'];
            } elseif (count($data['all_patients']) > 0) {
                $data['selected_patient_id'] = $data['all_patients'][0]['id'];
            } else {
                $data['selected_patient_id'] = null;
            }
        }
        
        // Load chat messages if a chat partner is selected
        if ($is_patient && $data['selected_receptionist_id']) {
            $data['chat_messages'] = $this->patient_chat_model->getPatientChats($patient_id, $data['selected_receptionist_id']);
            $data['partner_name'] = $this->patient_chat_model->getReceptionistName($data['selected_receptionist_id']);
        } elseif ($is_receptionist && $data['selected_patient_id']) {
            $data['chat_messages'] = $this->patient_chat_model->getPatientChats($data['selected_patient_id'], $receptionist_id);
            $data['partner_name'] = $this->patient_chat_model->getPatientName($data['selected_patient_id']);
        } else {
            $data['chat_messages'] = array();
            $data['partner_name'] = '';
        }
        
        // Mark all received messages as read
        if (isset($data['chat_messages']) && !empty($data['chat_messages'])) {
            foreach ($data['chat_messages'] as $message) {
                if ($is_patient && $message['sender_type'] == 'receptionist' && $message['status'] == 'unread') {
                    $this->patient_chat_model->markAsRead($message['id']);
                } elseif ($is_receptionist && $message['sender_type'] == 'patient' && $message['status'] == 'unread') {
                    $this->patient_chat_model->markAsRead($message['id']);
                }
            }
        }
        
        // Load view
        $this->load->view('home/dashboard');
        $this->load->view('patient_chat', $data);
        $this->load->view('home/footer');
    }
    
    public function load_chat() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo json_encode(array('status' => 'error', 'message' => 'Not logged in'));
            return;
        }
        
        $current_user_id = $this->ion_auth->user()->row()->id;
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        if (!$is_patient && !$is_receptionist) {
            echo json_encode(array('status' => 'error', 'message' => 'Not authorized'));
            return;
        }
        
        $patient_id = $this->input->get('patient_id');
        $receptionist_id = $this->input->get('receptionist_id');
        
        if (!$patient_id || !$receptionist_id) {
            echo json_encode(array('status' => 'error', 'message' => 'Missing parameters'));
            return;
        }
        
        try {
            // Get chat messages
            $chat_messages = $this->patient_chat_model->getPatientChats($patient_id, $receptionist_id);
            
            if (!is_array($chat_messages)) {
                $chat_messages = array();
            }
            
            // Mark all received messages as read
            foreach ($chat_messages as $message) {
                if ($is_patient && $message['sender_type'] == 'receptionist' && $message['status'] == 'unread') {
                    $this->patient_chat_model->markAsRead($message['id']);
                } elseif ($is_receptionist && $message['sender_type'] == 'patient' && $message['status'] == 'unread') {
                    $this->patient_chat_model->markAsRead($message['id']);
                }
            }
            
            // Format messages for display
            $formatted_messages = array();
            foreach ($chat_messages as $message) {
                $is_sender = ($is_patient && $message['sender_type'] == 'patient') || 
                             ($is_receptionist && $message['sender_type'] == 'receptionist');
                
                $formatted_messages[] = array(
                    'id' => $message['id'],
                    'text' => htmlspecialchars($message['chat_text']),
                    'date_time' => date('M d, Y h:i A', strtotime($message['date_time'])),
                    'is_sender' => $is_sender
                );
            }
            
            // Get partner name
            $partner_name = $is_patient ? 
                            $this->patient_chat_model->getReceptionistName($receptionist_id) : 
                            $this->patient_chat_model->getPatientName($patient_id);
            
            echo json_encode(array(
                'status' => 'success',
                'messages' => $formatted_messages,
                'partner_name' => $partner_name
            ));
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()));
        }
    }
    
    public function send_message() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo json_encode(array('status' => 'error', 'message' => 'Not logged in'));
            return;
        }
        
        $current_user_id = $this->ion_auth->user()->row()->id;
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        if (!$is_patient && !$is_receptionist) {
            echo json_encode(array('status' => 'error', 'message' => 'Not authorized'));
            return;
        }
        
        // Debug information
        log_message('debug', 'POST data: ' . print_r($this->input->post(), true));
        
        $patient_id = $this->input->post('patient_id');
        $receptionist_id = $this->input->post('receptionist_id');
        $message = $this->input->post('message');
        
        if (!$patient_id || !$receptionist_id || !$message) {
            echo json_encode(array(
                'status' => 'error', 
                'message' => 'Missing parameters',
                'received' => array(
                    'patient_id' => $patient_id,
                    'receptionist_id' => $receptionist_id,
                    'message' => $message ? 'present' : 'missing'
                )
            ));
            return;
        }
        
        try {
            // Get user's actual ID (patient or receptionist)
            if ($is_patient) {
                $patient = $this->db->get_where('patient', array('ion_user_id' => $current_user_id))->row();
                if (!$patient) {
                    echo json_encode(array('status' => 'error', 'message' => 'Patient not found for current user'));
                    return;
                }
                if ($patient->id != $patient_id) {
                    echo json_encode(array('status' => 'error', 'message' => 'Invalid patient ID - not matching logged in user'));
                    return;
                }
            } else {
                $receptionist = $this->db->get_where('receptionist', array('ion_user_id' => $current_user_id))->row();
                if (!$receptionist) {
                    echo json_encode(array('status' => 'error', 'message' => 'Receptionist not found for current user'));
                    return;
                }
                if ($receptionist->id != $receptionist_id) {
                    echo json_encode(array('status' => 'error', 'message' => 'Invalid receptionist ID - not matching logged in user'));
                    return;
                }
            }
            
            // Insert message
            $data = array(
                'patient_id' => $patient_id,
                'receptionist_id' => $receptionist_id,
                'sender_type' => $is_patient ? 'patient' : 'receptionist',
                'date_time' => date('Y-m-d H:i:s'),
                'status' => 'unread',
                'chat_text' => $message,
                'hospital_id' => $this->session->userdata('hospital_id')
            );
            
            $message_id = $this->patient_chat_model->addMessage($data);
            
            if ($message_id) {
                echo json_encode(array(
                    'status' => 'success',
                    'message_id' => $message_id,
                    'date_time' => date('M d, Y h:i A')
                ));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to insert message in database'));
            }
        } catch (Exception $e) {
            log_message('error', 'Error in send_message: ' . $e->getMessage());
            echo json_encode(array('status' => 'error', 'message' => 'Server error: ' . $e->getMessage()));
        }
    }
    
    public function check_new_messages() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo json_encode(array('status' => 'error', 'message' => 'Not logged in'));
            return;
        }
        
        $current_user_id = $this->ion_auth->user()->row()->id;
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        if (!$is_patient && !$is_receptionist) {
            echo json_encode(array('status' => 'error', 'message' => 'Not authorized'));
            return;
        }
        
        $last_message_id = $this->input->get('last_message_id');
        $patient_id = $this->input->get('patient_id');
        $receptionist_id = $this->input->get('receptionist_id');
        
        if (!$patient_id || !$receptionist_id) {
            echo json_encode(array('status' => 'error', 'message' => 'Missing parameters'));
            return;
        }
        
        // Get new messages
        $this->db->where('id >', $last_message_id);
        $this->db->where('patient_id', $patient_id);
        $this->db->where('receptionist_id', $receptionist_id);
        
        if ($is_patient) {
            // For patient, get messages sent by receptionist
            $this->db->where('sender_type', 'receptionist');
        } else {
            // For receptionist, get messages sent by patient
            $this->db->where('sender_type', 'patient');
        }
        
        $this->db->order_by('date_time', 'asc');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $new_messages = $this->db->get('patient_chat')->result_array();
        
        // Mark messages as read
        foreach ($new_messages as $message) {
            $this->patient_chat_model->markAsRead($message['id']);
        }
        
        // Format messages for display
        $formatted_messages = array();
        foreach ($new_messages as $message) {
            $formatted_messages[] = array(
                'id' => $message['id'],
                'text' => $message['chat_text'],
                'date_time' => date('M d, Y h:i A', strtotime($message['date_time'])),
                'is_sender' => false // These are received messages
            );
        }
        
        echo json_encode(array(
            'status' => 'success',
            'messages' => $formatted_messages
        ));
    } 
    
    public function check_all_contacts() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo json_encode(array('status' => 'error', 'message' => 'Not logged in'));
            return;
        }
        
        $current_user_id = $this->ion_auth->user()->row()->id;
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        if (!$is_patient && !$is_receptionist) {
            echo json_encode(array('status' => 'error', 'message' => 'Not authorized'));
            return;
        }
        
        $contacts = array();
        $has_unread = false;
        
        if ($is_patient) {
            // Get patient ID for current user
            $patient = $this->db->get_where('patient', array('ion_user_id' => $current_user_id))->row();
            if (!$patient) {
                echo json_encode(array('status' => 'error', 'message' => 'Patient not found'));
                return;
            }
            $patient_id = $patient->id;
            
            // Get all receptionists
            $receptionists = $this->patient_chat_model->getAllReceptionists();
            
            foreach ($receptionists as $receptionist) {
                $has_unread_messages = $this->patient_chat_model->hasUnreadMessages($patient_id, $receptionist['id'], 'patient');
                
                $contacts[] = array(
                    'id' => $receptionist['id'],
                    'name' => $receptionist['name'],
                    'type' => 'receptionist',
                    'has_unread' => $has_unread_messages
                );
                
                if ($has_unread_messages) {
                    $has_unread = true;
                }
            }
        } else { // Receptionist view
            // Get receptionist ID for current user
            $receptionist = $this->db->get_where('receptionist', array('ion_user_id' => $current_user_id))->row();
            if (!$receptionist) {
                echo json_encode(array('status' => 'error', 'message' => 'Receptionist not found'));
                return;
            }
            $receptionist_id = $receptionist->id;
            
            // Get all patients
            $patients = $this->patient_chat_model->getAllPatients();
            
            foreach ($patients as $patient) {
                $has_unread_messages = $this->patient_chat_model->hasUnreadMessages($patient['id'], $receptionist_id, 'receptionist');
                
                $contacts[] = array(
                    'id' => $patient['id'],
                    'name' => $patient['name'],
                    'type' => 'patient',
                    'has_unread' => $has_unread_messages
                );
                
                if ($has_unread_messages) {
                    $has_unread = true;
                }
            }
        }
        
        echo json_encode(array(
            'status' => 'success',
            'contacts' => $contacts,
            'has_unread' => $has_unread
        ));
    }
    
    public function popup() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo '';
            return;
        }
        
        $data = array();
        $current_user_id = $this->ion_auth->user()->row()->id;
        
        // Determine if user is a patient or receptionist
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        if (!$is_patient && !$is_receptionist) {
            echo '';
            return;
        }
        
        $data['is_patient'] = $is_patient;
        $data['is_receptionist'] = $is_receptionist;
        $has_unread = false;
        
        if ($is_patient) {
            // Get patient ID for current user
            $patient = $this->db->get_where('patient', array('ion_user_id' => $current_user_id))->row();
            if (!$patient) {
                echo '';
                return;
            }
            $patient_id = $patient->id;
            $data['patient_id'] = $patient_id;
            
            // Get all receptionists for the hospital with unread status
            $receptionists = $this->patient_chat_model->getAllReceptionists();
            if (!is_array($receptionists)) {
                $receptionists = array();
            }
            
            foreach ($receptionists as &$receptionist) {
                $receptionist['has_unread'] = $this->patient_chat_model->hasUnreadMessages($patient_id, $receptionist['id'], 'patient');
                if ($receptionist['has_unread']) {
                    $has_unread = true;
                }
            }
            $data['receptionists'] = $receptionists;
        } else {
            // Get receptionist ID for current user
            $receptionist = $this->db->get_where('receptionist', array('ion_user_id' => $current_user_id))->row();
            if (!$receptionist) {
                echo '';
                return;
            }
            $receptionist_id = $receptionist->id;
            $data['receptionist_id'] = $receptionist_id;
            
            // Get all patients for the hospital with unread status
            $patients = $this->patient_chat_model->getAllPatients();
            if (!is_array($patients)) {
                $patients = array();
            }
            
            // Patients already have decrypted names from the model
            foreach ($patients as &$patient) {
                $patient_id = $patient['id'];
                $patient['has_unread'] = $this->patient_chat_model->hasUnreadMessages($patient_id, $receptionist_id, 'receptionist');
                
                // Ensure we have the patient ID format - if id_new is missing, use the same ID
                if (!isset($patient['id_new'])) {
                    $patient['id_new'] = $patient_id;
                }
                
                if ($patient['has_unread']) {
                    $has_unread = true;
                }
            }
            $data['patients'] = $patients;
        }
        
        $data['has_unread'] = $has_unread;
        
        // Load the view and get the content
        $output = $this->load->view('popup_chat', $data, true);
        
        // Return the HTML content
        echo $output;
    }
    
    // Method to handle typing indicator status
    public function typing_status() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo json_encode(array('status' => 'error', 'message' => 'Not logged in'));
            return;
        }
        
        $current_user_id = $this->ion_auth->user()->row()->id;
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        if (!$is_patient && !$is_receptionist) {
            echo json_encode(array('status' => 'error', 'message' => 'Not authorized'));
            return;
        }
        
        $patient_id = $this->input->post('patient_id');
        $receptionist_id = $this->input->post('receptionist_id');
        $is_typing = $this->input->post('is_typing') === 'true';
        
        if (!$patient_id || !$receptionist_id) {
            echo json_encode(array('status' => 'error', 'message' => 'Missing parameters'));
            return;
        }
        
        // Store typing status in session or database
        // For simplicity, we'll just echo back success here
        echo json_encode(array('status' => 'success'));
    }
    
    // Method to check if the other party is typing
    public function check_typing() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo json_encode(array('status' => 'error', 'message' => 'Not logged in'));
            return;
        }
        
        $current_user_id = $this->ion_auth->user()->row()->id;
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        if (!$is_patient && !$is_receptionist) {
            echo json_encode(array('status' => 'error', 'message' => 'Not authorized'));
            return;
        }
        
        $patient_id = $this->input->get('patient_id');
        $receptionist_id = $this->input->get('receptionist_id');
        
        if (!$patient_id || !$receptionist_id) {
            echo json_encode(array('status' => 'error', 'message' => 'Missing parameters'));
            return;
        }
        
        // Get typing status from session or database
        // For simplicity, we'll just echo back no typing here
        echo json_encode(array(
            'status' => 'success',
            'is_typing' => false
        ));
    }
    
    // Test method for sending messages - helps diagnose issues
    public function test_send_message() {
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo "Not logged in<br>";
            return;
        }
        
        $current_user_id = $this->ion_auth->user()->row()->id;
        $is_patient = $this->ion_auth->in_group('Patient');
        $is_receptionist = $this->ion_auth->in_group('Receptionist');
        
        echo "<h3>User Info</h3>";
        echo "User ID: " . $current_user_id . "<br>";
        echo "Is Patient: " . ($is_patient ? "Yes" : "No") . "<br>";
        echo "Is Receptionist: " . ($is_receptionist ? "Yes" : "No") . "<br>";
        
        if ($is_patient) {
            $patient = $this->db->get_where('patient', array('ion_user_id' => $current_user_id))->row();
            echo "<h3>Patient Info</h3>";
            echo "Patient ID: " . ($patient ? $patient->id : "Not found") . "<br>";
            
            // Find a receptionist to message
            $receptionist = $this->db->get('receptionist')->row();
            if ($receptionist) {
                echo "Found receptionist ID: " . $receptionist->id . "<br>";
                
                // Try sending a test message
                $data = array(
                    'patient_id' => $patient->id,
                    'receptionist_id' => $receptionist->id,
                    'sender_type' => 'patient',
                    'date_time' => date('Y-m-d H:i:s'),
                    'status' => 'unread',
                    'chat_text' => 'Test message from patient - ' . date('Y-m-d H:i:s'),
                    'hospital_id' => $this->session->userdata('hospital_id')
                );
                
                echo "<h3>Attempting to send test message</h3>";
                echo "Data: <pre>" . print_r($data, true) . "</pre>";
                
                $message_id = $this->patient_chat_model->addMessage($data);
                
                if ($message_id) {
                    echo "<h3>Success!</h3>";
                    echo "Message ID: " . $message_id . "<br>";
                } else {
                    echo "<h3>Failed to send message</h3>";
                    echo "Last DB Error: " . $this->db->_error_message() . "<br>";
                }
            } else {
                echo "No receptionists found<br>";
            }
        } else if ($is_receptionist) {
            $receptionist = $this->db->get_where('receptionist', array('ion_user_id' => $current_user_id))->row();
            echo "<h3>Receptionist Info</h3>";
            echo "Receptionist ID: " . ($receptionist ? $receptionist->id : "Not found") . "<br>";
            
            // Find a patient to message
            $patient = $this->db->get('patient')->row();
            if ($patient) {
                echo "Found patient ID: " . $patient->id . "<br>";
                
                // Try sending a test message
                $data = array(
                    'patient_id' => $patient->id,
                    'receptionist_id' => $receptionist->id,
                    'sender_type' => 'receptionist',
                    'date_time' => date('Y-m-d H:i:s'),
                    'status' => 'unread',
                    'chat_text' => 'Test message from receptionist - ' . date('Y-m-d H:i:s'),
                    'hospital_id' => $this->session->userdata('hospital_id')
                );
                
                echo "<h3>Attempting to send test message</h3>";
                echo "Data: <pre>" . print_r($data, true) . "</pre>";
                
                $message_id = $this->patient_chat_model->addMessage($data);
                
                if ($message_id) {
                    echo "<h3>Success!</h3>";
                    echo "Message ID: " . $message_id . "<br>";
                } else {
                    echo "<h3>Failed to send message</h3>";
                    echo "Last DB Error: " . $this->db->_error_message() . "<br>";
                }
            } else {
                echo "No patients found<br>";
            }
        } else {
            echo "User is neither patient nor receptionist<br>";
        }
    }
} 