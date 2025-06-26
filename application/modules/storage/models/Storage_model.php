<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Storage Model
 * 
 * This model handles database operations for the storage module
 * settings and provider management.
 */
class Storage_model extends CI_Model {
    
    // Table names
    private $files_table = 'storage_files';
    private $providers_table = 'storage_providers';
    private $settings_table = 'storage_settings';
    private $googledrive_table = 'storage_provider_googledrive';
    private $test_file_table = 'test_file';

    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Create database tables if they don't exist
     */
    public function create_tables() {
        // Check if storage_files table exists 
        if (!$this->db->table_exists($this->files_table)) {
            $this->load->dbforge();
            
            // Create storage_files table
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'provider' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                ),
                'provider_file_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ),
                'filename' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ),
                'original_filename' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ),
                'file_type' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ),
                'file_size' => array(
                    'type' => 'BIGINT',
                    'unsigned' => TRUE,
                ),
                'view_link' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '500',
                    'null' => TRUE,
                ),
                'download_link' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '500',
                    'null' => TRUE,
                ),
                'local_path' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '500',
                    'null' => TRUE,
                ),
                'module' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                    'null' => TRUE,
                ),
                'reference_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                    'null' => TRUE,
                ),
                'user_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                ),
                'hospital_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                ),
                'created_at' => array(
                    'type' => 'DATETIME',
                ),
                'updated_at' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ),
            );
            
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->files_table, TRUE);
            
            // Add indexes
            $this->db->query("ALTER TABLE {$this->files_table} ADD INDEX (provider)");
            $this->db->query("ALTER TABLE {$this->files_table} ADD INDEX (module, reference_id)");
            $this->db->query("ALTER TABLE {$this->files_table} ADD INDEX (hospital_id)");
        }
        
        // Check if storage_providers table exists
        if (!$this->db->table_exists($this->providers_table)) {
            $this->load->dbforge();
            
            // Create storage_providers table
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                ),
                'display_name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ),
                'description' => array(
                    'type' => 'TEXT',
                    'null' => TRUE,
                ),
                'is_active' => array(
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                ),
                'is_default' => array(
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                ),
                'created_at' => array(
                    'type' => 'DATETIME',
                ),
                'updated_at' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ),
            );
            
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->providers_table, TRUE);
            
            // Add default providers
            $this->db->insert($this->providers_table, array(
                'name' => 'googledrive',
                'display_name' => 'Google Drive',
                'description' => 'Store files in Google Drive cloud storage.',
                'is_active' => 1,
                'is_default' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ));
            
            $this->db->insert($this->providers_table, array(
                'name' => 'local',
                'display_name' => 'Local Storage',
                'description' => 'Store files on the local server.',
                'is_active' => 1,
                'is_default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
        
        // Check if storage_settings table exists
        if (!$this->db->table_exists($this->settings_table)) {
            $this->load->dbforge();
            
            // Create storage_settings table
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'provider' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                ),
                'hospital_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                ),
                'key' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ),
                'value' => array(
                    'type' => 'TEXT',
                ),
                'created_at' => array(
                    'type' => 'DATETIME',
                ),
                'updated_at' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ),
            );
            
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->settings_table, TRUE);
            
            // Add indexes
            $this->db->query("ALTER TABLE {$this->settings_table} ADD INDEX (provider, hospital_id)");
            $this->db->query("ALTER TABLE {$this->settings_table} ADD INDEX (hospital_id, key)");
        }
        
        // Create Google Drive settings table if it doesn't exist
        $this->create_googledrive_table();
        
        
       
    }
    
    /**
     * Create Google Drive settings table if it doesn't exist
     */
    public function create_googledrive_table() {
        if (!$this->db->table_exists($this->googledrive_table)) {
            $this->load->dbforge();
            
            // Create settings table 
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'hospital_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                ),
                'project_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ),
                'client_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ),
                'client_email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ),
                'private_key_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ),
                'private_key' => array(
                    'type' => 'TEXT',
                ),
                'default_folder_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => TRUE,
                ),
                'user_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                ),
                'created_at' => array(
                    'type' => 'DATETIME',
                ),
                'updated_at' => array(
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ),
            );
            
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->googledrive_table, TRUE);
            
            // Add indexes
            $this->db->query("ALTER TABLE {$this->googledrive_table} ADD INDEX (hospital_id)");
        }
    }
    
    /**
     * Get all providers or a specific provider
     * 
     * @param string $name Provider name (optional)
     * @return array|object Provider(s)
     */
    public function get_providers($name = NULL) {
        if ($name) {
            return $this->db->get_where($this->providers_table, array('name' => $name))->row();
        }
        
        // Only return Google Drive and Local storage providers
        $this->db->where_in('name', array('googledrive', 'local'));
        $this->db->group_by('name'); // Ensure only unique providers
        return $this->db->get($this->providers_table)->result();
    }
    
    /**
     * Get active providers
     * 
     * @return array Active providers
     */
    public function get_active_providers() {
        // Only return active Google Drive and Local storage providers
        $this->db->where('is_active', 1);
        $this->db->where_in('name', array('googledrive', 'local'));
        $this->db->group_by('name'); // Ensure only unique providers
        return $this->db->get($this->providers_table)->result();
    }
    
    /**
     * Get the default provider
     * 
     * @return string Default provider name
     */
    public function get_default_provider() {
        $default = $this->db->get_where($this->providers_table, array('is_default' => 1))->row();
        
        if ($default) {
            return $default->name;
        }
        
        // If no default is set, use the first active provider
        $first_active = $this->db->get_where($this->providers_table, array('is_active' => 1))->row();
        
        if ($first_active) {
            return $first_active->name;
        }
        
        return 'local'; // Fallback to local storage
    }
    
    /**
     * Check if a provider is active
     * 
     * @param string $provider Provider name
     * @return bool TRUE if active, FALSE otherwise
     */
    public function is_provider_active($provider) {
        $result = $this->db->get_where($this->providers_table, array('name' => $provider, 'is_active' => 1))->row();
        
        return ($result !== NULL);
    }
    
    /**
     * Update provider status (active/inactive)
     * 
     * @param string $provider Provider name
     * @param int $status 0 = inactive, 1 = active
     * @return bool TRUE if successful, FALSE otherwise
     */
    public function update_provider_status($provider, $status) {
        $this->db->where('name', $provider);
        $this->db->update($this->providers_table, array(
            'is_active' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ));
        
        return ($this->db->affected_rows() > 0);
    }
    
    /**
     * Set a provider as the default
     * 
     * @param string $provider Provider name
     * @return bool TRUE if successful, FALSE otherwise
     */
    public function set_default_provider($provider) {
        // First, make sure the provider is active
        $this->db->where('name', $provider);
        $this->db->update($this->providers_table, array(
            'is_active' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ));
        
        // Reset all providers to not default
        $this->db->update($this->providers_table, array(
            'is_default' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ));
        
        // Set the specified provider as default
        $this->db->where('name', $provider);
        $this->db->update($this->providers_table, array(
            'is_default' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ));
        
        return TRUE;
    }
    
    /**
     * Get Google Drive settings
     * 
     * @return object|boolean Settings object on success, FALSE if not found
     */
    public function get_googledrive_settings() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get($this->googledrive_table);
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return FALSE;
    }
    
    /**
     * Save Google Drive settings
     * 
     * @param array $data Settings data
     * @return int|boolean Inserted ID on success, FALSE on failure
     */
    public function save_googledrive_settings($data) {
        $hospital_id = $this->session->userdata('hospital_id');
        
        // Get existing settings
        $this->db->where('hospital_id', $hospital_id);
        $existing = $this->db->get($this->googledrive_table)->row();
        
        if ($existing) {
            // Update existing settings
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $existing->id);
            $this->db->update($this->googledrive_table, $data);
            return $existing->id;
        } else {
            // Insert new settings
            $data['hospital_id'] = $hospital_id;
            $data['user_id'] = $this->ion_auth->get_user_id();
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert($this->googledrive_table, $data);
            
            if ($this->db->affected_rows() > 0) {
                return $this->db->insert_id();
            }
        }
        
        return FALSE;
    }
    


    /**
     * Get storage type setting from database
     * 
     * @return string Storage type ('local' or 'drive')
     */
    public function get_storage_type() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('key', 'storage_type');
        $query = $this->db->get($this->settings_table);
        
        if ($query->num_rows() > 0) {
            return $query->row()->value;
        }
        
        return 'local'; // Default to local storage
    }
    
    /**
     * Set storage type setting in database
     * 
     * @param string $storage_type Storage type ('local' or 'drive')
     * @return bool TRUE on success, FALSE on failure
     */
    public function set_storage_type($storage_type) {
        $hospital_id = $this->session->userdata('hospital_id');
        
        // Check if setting exists
        $this->db->where('hospital_id', $hospital_id);
        $this->db->where('key', 'storage_type');
        $existing = $this->db->get($this->settings_table)->row();
        
        if ($existing) {
            // Update existing setting
            $this->db->where('id', $existing->id);
            return $this->db->update($this->settings_table, [
                'value' => $storage_type,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Insert new setting
            return $this->db->insert($this->settings_table, [
                'provider' => 'system',
                'hospital_id' => $hospital_id,
                'key' => 'storage_type',
                'value' => $storage_type,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    /**
     * Upload file to Google Drive
     * @param array $file_data File data from $_FILES
     * @param string $folder_id Optional Google Drive folder ID
     * @return array|boolean Array with file info on success, FALSE on failure
     */
    public function upload_to_google_drive($file_data, $folder_id = NULL) {
        // Load the Google API PHP Client Library
        require_once FCPATH . 'vendor/autoload.php';
        
        try {
            // Get credentials from database
            $db_credentials = $this->get_googledrive_settings();
            
            if (!$db_credentials) {
                log_message('error', 'Google Drive credentials not found in database');
                
                // Fallback to file-based credentials if database credentials not found
                $credentials_file = APPPATH . 'config/google-drive-credentials.json';
                
                if (!file_exists($credentials_file)) {
                    log_message('error', 'Google Drive credentials file not found: ' . $credentials_file);
                    return FALSE;
                }
                
                // Use file-based credentials
                $credentials_source = $credentials_file;
                log_message('debug', 'Using file-based Google Drive credentials');
            } else {
                // Create credentials array from database fields
                $credentials_array = array(
                    'type' => 'service_account',
                    'project_id' => $db_credentials->project_id,
                    'private_key_id' => $db_credentials->private_key_id,
                    'private_key' => $db_credentials->private_key,
                    'client_email' => $db_credentials->client_email,
                    'client_id' => $db_credentials->client_id,
                    'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                    'token_uri' => 'https://oauth2.googleapis.com/token',
                    'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                    'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/' . urlencode($db_credentials->client_email)
                );
                
                // Use database credentials
                $credentials_source = $credentials_array;
                log_message('debug', 'Using database Google Drive credentials for hospital_id: ' . $this->session->userdata('hospital_id'));
            }
            
            // Create and configure a new client - try both namespaced and non-namespaced versions
            if (class_exists('Google\\Client')) {
                $client = new \Google\Client();
                log_message('debug', 'Using namespaced Google\\Client class');
            } elseif (class_exists('Google_Client')) {
                $client = new \Google_Client();
                log_message('debug', 'Using non-namespaced Google_Client class');
            } else {
                log_message('error', 'Neither Google\\Client nor Google_Client class found');
                return FALSE;
            }
            
            $client->setApplicationName('Klinicx Storage');
            
            // Try both namespaced and non-namespaced versions for scope
            if (defined('\Google\Service\Drive::DRIVE_FILE')) {
                $client->setScopes(\Google\Service\Drive::DRIVE_FILE);
                log_message('debug', 'Using namespaced Google\\Service\\Drive::DRIVE_FILE scope');
            } elseif (defined('\Google_Service_Drive::DRIVE_FILE')) {
                $client->setScopes(\Google_Service_Drive::DRIVE_FILE);
                log_message('debug', 'Using non-namespaced Google_Service_Drive::DRIVE_FILE scope');
            } else {
                // Fallback to string scope if constants aren't available
                $client->setScopes('https://www.googleapis.com/auth/drive.file');
                log_message('debug', 'Using string scope https://www.googleapis.com/auth/drive.file');
            }
            
            $client->setAuthConfig($credentials_source);
            
            // Create Drive service instance - try both namespaced and non-namespaced versions
            if (class_exists('Google\\Service\\Drive')) {
                $service = new \Google\Service\Drive($client);
                log_message('debug', 'Using namespaced Google\\Service\\Drive class');
            } elseif (class_exists('Google_Service_Drive')) {
                $service = new \Google_Service_Drive($client);
                log_message('debug', 'Using non-namespaced Google_Service_Drive class');
            } else {
                log_message('error', 'Neither Google\\Service\\Drive nor Google_Service_Drive class found');
                return FALSE;
            }
            
            // Log which DriveFile class is available
            log_message('debug', 'Checking if Google\\Service\\Drive\\DriveFile class exists: ' . (class_exists('Google\\Service\\Drive\\DriveFile') ? 'Yes' : 'No'));
            log_message('debug', 'Checking if Google_Service_Drive_DriveFile class exists: ' . (class_exists('Google_Service_Drive_DriveFile') ? 'Yes' : 'No'));
            
            // Get settings
            $settings = $this->get_googledrive_settings();
            
            // If no folder ID provided, use default from settings
            if (empty($folder_id) && !empty($settings->default_folder_id)) {
                $folder_id = $settings->default_folder_id;
            }
            
            // Log which DriveFile class is available
            log_message('debug', 'Checking if Google\\Service\\Drive\\DriveFile class exists: ' . (class_exists('Google\\Service\\Drive\\DriveFile') ? 'Yes' : 'No'));
            log_message('debug', 'Checking if Google_Service_Drive_DriveFile class exists: ' . (class_exists('Google_Service_Drive_DriveFile') ? 'Yes' : 'No'));
            
            // Create file metadata - try both namespaced and non-namespaced versions
            if (class_exists('Google\\Service\\Drive\\DriveFile')) {
                $file_metadata = new \Google\Service\Drive\DriveFile([
                    'name' => $file_data['name'],
                    'parents' => $folder_id ? [$folder_id] : []
                ]);
                log_message('debug', 'Using namespaced Google\\Service\\Drive\\DriveFile class');
            } elseif (class_exists('Google_Service_Drive_DriveFile')) {
                $file_metadata = new \Google_Service_Drive_DriveFile([
                    'name' => $file_data['name'],
                    'parents' => $folder_id ? [$folder_id] : []
                ]);
                log_message('debug', 'Using non-namespaced Google_Service_Drive_DriveFile class');
            } else {
                log_message('error', 'Neither Google\\Service\\Drive\\DriveFile nor Google_Service_Drive_DriveFile class found');
                return FALSE;
            }
            
            // Upload file
            $content = file_get_contents($file_data['tmp_name']);
            $file = $service->files->create($file_metadata, [
                'data' => $content,
                'mimeType' => $file_data['type'],
                'uploadType' => 'multipart',
                'fields' => 'id,name,webViewLink,webContentLink'
            ]);
            
            // Return file info
            return [
                'file_id' => $file->id,
                'file_name' => $file->name,
                'view_link' => $file->webViewLink,
                'download_link' => $file->webContentLink
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Google Drive upload error: ' . $e->getMessage());
            return FALSE;
        }
    }
    
    /**
     * Upload test file
     * 
     * @param array $file_data File data from $_FILES
     * @param array $form_data Form data
     * @return boolean TRUE on success, FALSE on failure
     */
    public function upload_test_file($file_data, $form_data) {
        // Check if file was uploaded
        if (!isset($file_data['file']) || $file_data['file']['error'] != 0) {
            return FALSE;
        }
        
        $file = $file_data['file'];
        $storage_type = $this->get_storage_type();
        
        // Generate unique filename
        $filename = uniqid() . '_' . $file['name'];
        
        if ($storage_type == 'drive') {
            // Upload to Google Drive
            $drive_result = $this->upload_to_google_drive($file);
            
            if (!$drive_result) {
                return FALSE;
            }
            
            // Insert file info into database
            $data = array(
                'title' => $form_data['title'],
                'description' => $form_data['description'],
                'file_name' => $file['name'],
                'file_path' => '',  // No local path for Drive files
                'file_type' => $file['type'],
                'file_size' => $file['size'],
                'storage_type' => 'drive',
                'drive_file_id' => $drive_result['file_id'],
                'view_link' => $drive_result['view_link'],
                'download_link' => $drive_result['download_link'],
                'date_added' => date('Y-m-d H:i:s')
            );
            
        } else {
            // Upload to local storage
            $upload_path = './uploads/';
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }
            
            // Move uploaded file
            $destination = $upload_path . $filename;
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                return FALSE;
            }
            
            // Insert file info into database
            $data = array(
                'title' => $form_data['title'],
                'description' => $form_data['description'],
                'file_name' => $file['name'],
                'file_path' => 'uploads/' . $filename,
                'file_type' => $file['type'],
                'file_size' => $file['size'],
                'storage_type' => 'local',
                'drive_file_id' => NULL,
                'view_link' => NULL,
                'download_link' => NULL,
                'date_added' => date('Y-m-d H:i:s')
            );
        }
        
        // Insert into database
        return $this->db->insert('test_file', $data);
    }
    
    /**
     * Update test_file table structure to support Google Drive fields
     */
    public function update_test_file_table() {
        // Check if columns exist before adding them
        $fields = $this->db->field_data('test_file');
        $existing_fields = array();
        foreach ($fields as $field) {
            $existing_fields[] = $field->name;
        }
        
        // Add storage_type column if it doesn't exist
        if (!in_array('storage_type', $existing_fields)) {
            $this->db->query("ALTER TABLE test_file ADD COLUMN storage_type VARCHAR(20) DEFAULT 'local'");
        }
        
        // Add drive_file_id column if it doesn't exist
        if (!in_array('drive_file_id', $existing_fields)) {
            $this->db->query("ALTER TABLE test_file ADD COLUMN drive_file_id VARCHAR(255) NULL");
        }
        
        // Add view_link column if it doesn't exist
        if (!in_array('view_link', $existing_fields)) {
            $this->db->query("ALTER TABLE test_file ADD COLUMN view_link VARCHAR(500) NULL");
        }
        
        // Add download_link column if it doesn't exist
        if (!in_array('download_link', $existing_fields)) {
            $this->db->query("ALTER TABLE test_file ADD COLUMN download_link VARCHAR(500) NULL");
        }
    }
    
    /**
     * Get all files from test_file table
     * 
     * @return array List of files
     */
    public function get_test_files() {
        $query = $this->db->get('test_file');
        return $query->result();
    }
    



}