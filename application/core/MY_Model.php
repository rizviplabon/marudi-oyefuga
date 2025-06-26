<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Model
 * 
 * An extension of CI_Model that provides automatic encryption/decryption
 * for sensitive fields based on configuration.
 */
class MY_Model extends CI_Model {
    
    // Table name for this model
    protected $table = '';
    
    // Flag to enable/disable encryption for this model
    protected $use_encryption = false;
    
    // Cached encrypted fields for this model
    protected $encrypted_fields = array();
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        
        // Load database
        $this->load->database();
        
        // Load encryption helper
        $this->load->helper('db_encrypt');
        
        // If using encryption, load the encrypted fields config
        if ($this->use_encryption && !empty($this->table)) {
            $this->load->config('encrypted_fields', TRUE);
            
            // Get encrypted fields for this model's table
            $encrypted_fields_config = $this->config->item('encrypted_fields', 'encrypted_fields');
            if (isset($encrypted_fields_config[$this->table])) {
                $this->encrypted_fields = $encrypted_fields_config[$this->table];
            }
        }
    }
    
    /**
     * Encrypt data before inserting/updating
     * 
     * @param array $data Data to encrypt
     * @return array Encrypted data
     */
    protected function encrypt_data($data) {
        if (!$this->use_encryption || empty($this->encrypted_fields)) {
            return $data;
        }
        
        foreach ($this->encrypted_fields as $field) {
            if (isset($data[$field])) {
                $data[$field] = db_encrypt($data[$field]);
            }
        }
        
        return $data;
    }
    
    /**
     * Decrypt data after fetching from database
     * 
     * @param array|object $data Data to decrypt
     * @return array|object Decrypted data
     */
    protected function decrypt_data($data) {
        if (!$this->use_encryption || empty($this->encrypted_fields) || empty($data)) {
            return $data;
        }
        
        // Handle object
        if (is_object($data)) {
            foreach ($this->encrypted_fields as $field) {
                if (isset($data->$field)) {
                    $data->$field = db_decrypt($data->$field);
                }
            }
            return $data;
        }
        
        // Handle array of objects or arrays
        if (is_array($data)) {
            // Check if this is a single associative array
            if (isset($data[key($data)]) && !is_array($data[key($data)]) && !is_object($data[key($data)])) {
                // Single associative array
                foreach ($this->encrypted_fields as $field) {
                    if (isset($data[$field])) {
                        $data[$field] = db_decrypt($data[$field]);
                    }
                }
                return $data;
            }
            
            // Array of records
            foreach ($data as $key => $record) {
                $data[$key] = $this->decrypt_data($record);
            }
        }
        
        return $data;
    }
    
    /**
     * Insert data with encryption
     * 
     * @param array $data Data to insert
     * @return mixed Insert ID or FALSE
     */
    public function insert_encrypted($data) {
        $data = $this->encrypt_data($data);
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Update data with encryption
     * 
     * @param array $where Where condition
     * @param array $data Data to update
     * @return bool Success/failure
     */
    public function update_encrypted($where, $data) {
        $data = $this->encrypt_data($data);
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Get data with decryption
     * 
     * @param array $where Where condition
     * @return array|object Decrypted data
     */
    public function get_decrypted($where = array()) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($this->table);
        $result = $query->result();
        return $this->decrypt_data($result);
    }
    
    /**
     * Get single row with decryption
     * 
     * @param array $where Where condition
     * @return object Decrypted data
     */
    public function get_decrypted_row($where = array()) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($this->table);
        $result = $query->row();
        return $this->decrypt_data($result);
    }
    
    /**
     * Encrypt all existing data in the table
     * 
     * @return array Result with counts
     */
    public function encrypt_existing_data() {
        if (!$this->use_encryption || empty($this->encrypted_fields)) {
            return array('status' => 'error', 'message' => 'Encryption not enabled for this model');
        }
        
        $total = 0;
        $encrypted = 0;
        $processed = 0;
        
        // Get all records
        $query = $this->db->get($this->table);
        $records = $query->result();
        $total = count($records);
        
        // Process each record
        foreach ($records as $record) {
            $updates = array();
            $should_update = false;
            
            // Check each field that should be encrypted
            foreach ($this->encrypted_fields as $field) {
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
                $id_field = $this->db->list_fields($this->table)[0]; // Assume first field is ID
                $this->db->where($id_field, $record->$id_field);
                $this->db->update($this->table, $updates);
                $encrypted++; 
            }
            
            $processed++;
        }
        
        return array(
            'status' => 'success',
            'message' => 'Processed ' . $processed . ' records. Encrypted fields in ' . $encrypted . ' records.',
            'total' => $total,
            'encrypted' => $encrypted
        );
    }
} 