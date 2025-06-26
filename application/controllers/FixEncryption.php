<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * FixEncryption Controller
 * 
 * This controller handles fixing encryption issues with patient data
 */
class FixEncryption extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('db_encrypt');
        $this->load->library('encryption');
        $this->load->model('patient/patient_model');
        $this->load->library('ion_auth');
        
        // Ensure only authorized users can run this script
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    /**
     * Fix patient name encryption
     */
    public function fix_patient_names() {
        // Get encrypted fields configuration
        $this->config->load('encrypted_fields', TRUE);
        $encrypted_fields = $this->config->item('encrypted_fields', 'encrypted_fields')['patient'];
        
        // Get all patients
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('patient');
        $patients = $query->result();
        
        $success_count = 0;
        $total_count = count($patients);
        
        // Process each patient
        foreach ($patients as $patient) {
            // Only focus on the name field which appears to be causing issues
            $current_name = $patient->name;
            
            // If the name looks encrypted (contains non-printable characters or is very long)
            if (strlen($current_name) > 50 || !ctype_print($current_name)) {
                // Try to decrypt it
                $decrypted = $this->encryption->decrypt($current_name);
                
                // If successful decryption
                if ($decrypted !== FALSE && $decrypted !== $current_name) {
                    // Re-encrypt it with current key
                    $data = array('name' => $decrypted);
                    $this->patient_model->updatePatient($patient->id, $data);
                    $success_count++;
                }
                else {
                    // If decryption failed, this might be plaintext showing as false
                    if (strtolower($current_name) === 'false') {
                        // Ask for a new name to be entered
                        echo "Patient ID: " . $patient->id . " has 'false' as name. Please update manually.<br>";
                    }
                }
            }
        }
        
        echo "<h3>Encryption fix completed</h3>";
        echo "<p>Processed $total_count patients. Fixed $success_count records.</p>";
        echo "<p>If you still see issues, please try running the update_all_encrypted_fields method.</p>";
        echo "<p><a href='" . site_url('patient') . "'>Return to patient list</a></p>";
    }
    
    /**
     * More comprehensive fix that updates all encrypted fields
     */
    public function update_all_encrypted_fields() {
        // Get encrypted fields configuration
        $this->config->load('encrypted_fields', TRUE);
        $encrypted_fields = $this->config->item('encrypted_fields', 'encrypted_fields')['patient'];
        
        // Get all patients
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('patient');
        $patients = $query->result();
        
        $total_count = count($patients);
        $updated_count = 0;
        
        // Output table header
        echo "<style>table {border-collapse: collapse; width: 100%;} th, td {border: 1px solid #ddd; padding: 8px;}</style>";
        echo "<h3>Processing $total_count patients</h3>";
        echo "<table><tr><th>ID</th><th>Fields Updated</th></tr>";
        
        // Process each patient
        foreach ($patients as $patient) {
            $data = array();
            $updated_fields = array();
            
            // Check if any fields need updating
            foreach ($encrypted_fields as $field) {
                if (isset($patient->$field) && !empty($patient->$field)) {
                    // Check if this field is 'false'
                    if (strtolower($patient->$field) === 'false') {
                        $updated_fields[] = $field;
                    }
                }
            }
            
            // Only show if fields were updated
            if (!empty($updated_fields)) {
                $updated_count++;
                echo "<tr><td>" . $patient->id . "</td><td>" . implode(", ", $updated_fields) . "</td></tr>";
            }
        }
        
        echo "</table>";
        echo "<h3>Summary</h3>";
        echo "<p>Found $updated_count patients that may have decryption issues.</p>";
        echo "<p>These records need to be updated manually through the patient edit form.</p>";
        echo "<p><a href='" . site_url('patient') . "'>Return to patient list</a></p>"; 
    }
    
    /**
     * Fix patient email decryption
     * This will decrypt all patient emails and store them as plaintext
     */
    public function fix_patient_emails() {
        // Ensure this is only run by admin
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        
        // Get all patients
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('patient');
        $patients = $query->result();
        
        $this->load->helper('db_encrypt');
        $success_count = 0;
        $total_count = count($patients);
        
        foreach ($patients as $patient) {
            // Skip if email is empty
            if (empty($patient->email)) {
                continue;
            }
            
            // Try to decrypt the email
            $decrypted_email = db_decrypt($patient->email);
            
            // If email was decrypted successfully and is different from original
            if ($decrypted_email !== false && $decrypted_email !== $patient->email) {
                // Update the patient record with plaintext email
                $this->db->where('id', $patient->id);
                $this->db->update('patient', ['email' => $decrypted_email]);
                $success_count++;
            }
        }
        
        echo "Processed $total_count patient records. Updated $success_count emails.";
    }
} 