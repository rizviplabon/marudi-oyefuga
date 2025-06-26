<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Migrate_encryption extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load necessary models and helpers
        $this->load->helper('db_encrypt');
        
        // Only admins can run this
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    /**
     * Index page
     */
    public function index() {
        $data = array();
        $data['title'] = 'Data Encryption Migration';
        
        $this->load->view('home/dashboard');
        $this->load->view('migrate_encryption', $data);
        $this->load->view('home/footer');
    } 
    
    /**
     * Run the encryption migration for all tables
     */
    public function run_migration() {
        // Load the encrypted fields configuration
        $this->load->config('encrypted_fields', TRUE);
        $encrypted_fields = $this->config->item('encrypted_fields', 'encrypted_fields');
        
        // Initialize results array
        $results = array();
        
        // Process each table
        foreach ($encrypted_fields as $table => $fields) {
            $result = $this->encrypt_table_data($table, $fields);
            $results[$table] = $result;
        }
        
        // Output results as JSON
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Encryption migration completed',
            'results' => $results
        ));
    }
    
    /**
     * Encrypt data in a specific table
     * 
     * @param string $table Table name
     * @param array $fields Fields to encrypt
     * @return array Result statistics
     */
    private function encrypt_table_data($table, $fields) {
        // Check if the table exists
        if (!$this->db->table_exists($table)) {
            return array(
                'status' => 'error',
                'message' => 'Table does not exist',
                'table' => $table
            );
        }
        
        // Initialize counters
        $total = 0;
        $encrypted = 0;
        $errors = 0;
        
        // Get all records
        $query = $this->db->get($table);
        $records = $query->result();
        $total = count($records);
        
        // Get primary key
        $primary_key = $this->db->list_fields($table)[0]; // Assume first field is primary key
        
        // Process each record
        foreach ($records as $record) {
            $updates = array();
            $should_update = false;
            
            // Check each field that should be encrypted
            foreach ($fields as $field) {
                if (isset($record->$field) && !empty($record->$field)) {
                    // Try to decrypt first (in case it's already encrypted)
                    $value = db_decrypt($record->$field);
                    
                    // Encrypt the value
                    $encrypted_value = db_encrypt($value);
                    
                    // Check if encryption actually changed the value
                    if ($encrypted_value !== $record->$field) {
                        $updates[$field] = $encrypted_value;
                        $should_update = true;
                    }
                }
            }
            
            // Update if needed
            if ($should_update) {
                try {
                    $this->db->where($primary_key, $record->$primary_key);
                    $this->db->update($table, $updates);
                    $encrypted++;
                } catch (Exception $e) {
                    $errors++;
                }
            }
        }
        
        return array(
            'status' => 'success',
            'table' => $table,
            'total' => $total,
            'encrypted' => $encrypted,
            'errors' => $errors,
            'fields' => $fields
        );
    }
    
    /**
     * Encrypt data for a specific table only
     */
    public function encrypt_table($table) {
        // Load the encrypted fields configuration
        $this->load->config('encrypted_fields', TRUE);
        $encrypted_fields = $this->config->item('encrypted_fields', 'encrypted_fields');
        
        if (!isset($encrypted_fields[$table])) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Table not found in encryption configuration',
                'table' => $table
            ));
            return;
        }
        
        $fields = $encrypted_fields[$table];
        $result = $this->encrypt_table_data($table, $fields);
        
        // Output result as JSON
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Encryption completed for table: ' . $table,
            'result' => $result
        ));
    }
    
    /**
     * Test encryption on a sample string
     */
    public function test() {
        $this->load->helper('db_encrypt');
        
        $test_string = 'Test String ' . date('Y-m-d H:i:s');
        $encrypted = db_encrypt($test_string);
        $decrypted = db_decrypt($encrypted);
        
        echo "<h2>Encryption Test</h2>";
        echo "<p><strong>Original:</strong> " . $test_string . "</p>";
        echo "<p><strong>Encrypted:</strong> " . htmlspecialchars($encrypted) . "</p>";
        echo "<p><strong>Decrypted:</strong> " . $decrypted . "</p>";
        
        if ($test_string === $decrypted) {
            echo "<p style='color:green'>Test successful! Encryption and decryption are working properly.</p>";
        } else {
            echo "<p style='color:red'>Test failed! The decrypted value does not match the original.</p>";
        }
    }
    
    /**
     * Debug endpoint for troubleshooting patient and doctor encryption
     */
    public function debug() {
        $this->load->model('patient/patient_model');
        $this->load->model('doctor/doctor_model');
        $this->load->helper('db_encrypt');
        
        echo "<h2>Encryption Debugging Tool</h2>";
        
        // Test simple encryption
        $test_string = 'Test String ' . date('Y-m-d H:i:s');
        $encrypted = db_encrypt($test_string);
        $decrypted = db_decrypt($encrypted);
        
        echo "<h3>Simple Encryption Test</h3>";
        echo "<p><strong>Original:</strong> " . $test_string . "</p>";
        echo "<p><strong>Encrypted:</strong> " . htmlspecialchars($encrypted) . "</p>";
        echo "<p><strong>Decrypted:</strong> " . $decrypted . "</p>";
        
        if ($test_string === $decrypted) {
            echo "<p style='color:green'>Base encryption/decryption is working properly!</p>";
        } else {
            echo "<p style='color:red'>Base encryption/decryption is NOT working!</p>";
        }
        
        // Test Patient model encryption
        echo "<h3>Patient Model Test</h3>";
        
        // Create test data
        $patient_data = array(
            'name' => 'Test Patient ' . date('Y-m-d H:i:s'),
            'email' => 'test@example.com',
            'phone' => '123-456-7890',
            'address' => 'Test Address'
        );
        
        // Get encrypted data
        $encrypted_data = $this->patient_model->encrypt_data($patient_data);
        
        echo "<p><strong>Original patient name:</strong> " . $patient_data['name'] . "</p>";
        echo "<p><strong>Encrypted patient name:</strong> " . htmlspecialchars($encrypted_data['name']) . "</p>";
        
        // Test decryption
        $decrypted_data = $this->patient_model->decrypt_data((object)$encrypted_data);
        
        echo "<p><strong>Decrypted patient name:</strong> " . $decrypted_data->name . "</p>";
        
        if ($patient_data['name'] === $decrypted_data->name) {
            echo "<p style='color:green'>Patient model encryption/decryption is working properly!</p>";
        } else {
            echo "<p style='color:red'>Patient model encryption/decryption is NOT working!</p>";
        }
        
        // Test Doctor model encryption
        echo "<h3>Doctor Model Test</h3>";
        
        // Create test data
        $doctor_data = array(
            'name' => 'Test Doctor ' . date('Y-m-d H:i:s'),
            'email' => 'doctor@example.com',
            'phone' => '987-654-3210',
            'address' => 'Doctor Address'
        );
        
        // Get encrypted data
        $encrypted_data = $this->doctor_model->encrypt_data($doctor_data);
        
        echo "<p><strong>Original doctor name:</strong> " . $doctor_data['name'] . "</p>";
        echo "<p><strong>Encrypted doctor name:</strong> " . htmlspecialchars($encrypted_data['name']) . "</p>";
        
        // Test decryption
        $decrypted_data = $this->doctor_model->decrypt_data((object)$encrypted_data);
        
        echo "<p><strong>Decrypted doctor name:</strong> " . $decrypted_data->name . "</p>";
        
        if ($doctor_data['name'] === $decrypted_data->name) {
            echo "<p style='color:green'>Doctor model encryption/decryption is working properly!</p>";
        } else {
            echo "<p style='color:red'>Doctor model encryption/decryption is NOT working!</p>";
        }
        
        echo "<p>Check server logs for any encryption/decryption errors</p>";
    }
} 