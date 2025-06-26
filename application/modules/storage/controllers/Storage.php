<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    require_once 'vendor/autoload.php';
/**
 * Storage Module Main Controller
 * 
 * This controller serves as the main entry point for the storage module
 * and handles settings operations.
 */
class Storage extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('ion_auth');
        
        // Load models
        $this->load->model('storage/storage_model');
        
        // Create database tables if they don't exist
        $this->storage_model->create_tables();
        
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh'); 
        }
    }
    
    /**
     * Default index page - redirects to settings page 
     */
    public function index() {
        redirect('storage/settings');
    }
    
    /**
     * Settings page for storage providers
     */
    public function settings() {
        if (!$this->ion_auth->in_group(array('admin', 'superadmin'))) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('home');
        }
        
        // Get all providers
        $providers = $this->storage_model->get_providers();
        
        // Get storage statistics
        $storage_stats = array();
        foreach ($providers as $provider) {
            // Get file count and total size for each provider
            $this->db->select('COUNT(*) as file_count, SUM(file_size) as total_size');
            $this->db->where('provider', $provider->name);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $stats = $this->db->get('storage_files')->row();
            
            $storage_stats[$provider->name] = array(
                'display_name' => $provider->display_name,
                'file_count' => $stats->file_count ?? 0,
                'total_size' => $stats->total_size ?? 0,
            );
        }
        
        // Load Google Drive settings for the modal
        $googledrive_settings = $this->storage_model->get_googledrive_settings();
        
        $data = array(
            'title' => lang('storage_settings'),
            'providers' => $providers,
            'storage_stats' => $storage_stats,
            'googledrive_settings' => $googledrive_settings,
            'current_storage_type' => $this->storage_model->get_storage_type()
        );

        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('storage/storage', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard', $data);
                $this->load->view('storage/storage', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard', $data);
        $this->load->view('storage/storage', $data);
        $this->load->view('home/footer');
            }
        

    }
    
    /**
     * Set Default Provider
     * 
     * Set a storage provider as the default
     * 
     * @param string $provider Provider name (optional)
     * @return void
     */
    public function set_default_provider($provider = NULL) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
        if (!$this->ion_auth->in_group(array('admin', 'superadmin'))) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('storage/settings');
        }
        
        // If no provider is specified, get it from POST data
        if ($provider === NULL) {
            $provider = $this->input->post('default_provider');
        }
        
        // Make sure provider exists
        if (!$provider || !$this->storage_model->get_providers($provider)) {
            $this->session->set_flashdata('error', lang('invalid_provider'));
            redirect('storage/settings');
        }
        
        $this->storage_model->set_default_provider($provider);
        
        $this->session->set_flashdata('feedback', lang('default_provider_set'));
        redirect('storage/settings');
    }
    
    /**
     * Save Google Drive settings
     */
    public function googledrive_save_settings() {
        if (!$this->ion_auth->in_group(array('admin', 'superadmin'))) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('storage/settings');
        }
        
        // Validate form data
        $this->form_validation->set_rules('project_id', lang('project_id'), 'required|trim');
        $this->form_validation->set_rules('client_id', lang('client_id'), 'required|trim');
        $this->form_validation->set_rules('client_email', lang('client_email'), 'required|valid_email|trim');
        $this->form_validation->set_rules('private_key_id', lang('private_key_id'), 'required|trim');
        $this->form_validation->set_rules('private_key', lang('private_key'), 'required|trim');
        $this->form_validation->set_rules('default_folder_id', lang('default_folder_id'), 'trim');
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('storage/settings');
        }
        $private_key = $this->input->post('private_key');
    
        
        // Get form data
        $settings = array(
            'project_id' => $this->input->post('project_id'),
            'client_id' => $this->input->post('client_id'),
            'client_email' => $this->input->post('client_email'),
            'private_key_id' => $this->input->post('private_key_id'),
            'private_key' => $private_key,
            'default_folder_id' => $this->input->post('default_folder_id'),
        );
        
        // Save settings
        $this->storage_model->save_googledrive_settings($settings);
        
        $this->session->set_flashdata('success', lang('settings_updated'));
        redirect('storage/settings');
    }
    

    /**
     * Add New File Upload
     * 
     * Process the file upload form submission and save the file
     */
    public function addNew() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
        // Validate form data
        $this->form_validation->set_rules('title', lang('name'), 'required|trim');
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('storage/fileUploads');
        }
        
        // Check if file was uploaded
        if (empty($_FILES['file']['name'])) {
            $this->session->set_flashdata('error', lang('please_select_a_file'));
            redirect('storage/fileUploads');
        }
        
        // Get form data
        $data = array(
            'title' => $this->input->post('title'),
        );
        
        // Upload file
        $file_id = $this->storage_model->upload_test_file($data, $_FILES);
        
        if ($file_id) {
            $this->session->set_flashdata('success', lang('file_uploaded_successfully'));
        } else {
            $this->session->set_flashdata('error', lang('file_upload_failed'));
        }
        
        redirect('storage/fileUploads');
    }
    
    /**
     * Set storage type (local or drive)
     */
    public function set_storage_type() {
        if (!$this->ion_auth->in_group(array('admin', 'superadmin'))) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('storage/settings');
        }
        
        $storage_type = $this->input->post('storage_type');
        
        if (in_array($storage_type, ['local', 'drive'])) {
            if ($this->storage_model->set_storage_type($storage_type)) {
                $this->session->set_flashdata('success', 'Storage type updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to update storage type');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid storage type');
        }
        
        redirect('storage/settings');
    }
    
    /**
     * Update test_file table structure
     */
    public function update_table_structure() {
        if (!$this->ion_auth->in_group(array('admin', 'superadmin'))) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('storage/settings');
        }
        
        $this->storage_model->update_test_file_table();
        $this->session->set_flashdata('success', 'Table structure updated successfully');
        redirect('storage/settings');
    }
    
    /**
     * Test Google Drive connection via AJAX
     */
    public function googledrive_test_connection_ajax() {
        // Check if request is AJAX
        if (!$this->input->is_ajax_request()) {
            redirect('storage/settings');
        }
        
        try {
            // Initialize Google Drive client
            $client = $this->initialize_googledrive_client();
            
            if ($client === FALSE) {
                // Get detailed error information from logs
                $log_file = APPPATH . 'logs/log-' . date('Y-m-d') . '.php';
                $log_content = '';
                
                if (file_exists($log_file)) {
                    $log_content = file_get_contents($log_file);
                    // Extract the last few Google Drive related log entries
                    preg_match_all('/ERROR.*Google.*Drive.*/', $log_content, $matches);
                    if (!empty($matches[0])) {
                        $error_logs = array_slice($matches[0], -3);
                        $log_content = implode("\n", $error_logs);
                    }
                }
                
                // Check for alternative log files if today's log is not found
                if (empty($log_content)) {
                    // Try to find the most recent log file
                    $log_dir = APPPATH . 'logs/';
                    $log_files = glob($log_dir . 'log-*.php');
                    if (!empty($log_files)) {
                        // Sort by modification time, newest first
                        usort($log_files, function($a, $b) {
                            return filemtime($b) - filemtime($a);
                        });
                        
                        // Get content from the most recent log file
                        $recent_log = $log_files[0];
                        $log_content = file_get_contents($recent_log);
                        preg_match_all('/ERROR.*Google.*Drive.*/', $log_content, $matches);
                        if (!empty($matches[0])) {
                            $error_logs = array_slice($matches[0], -3);
                            $log_content = implode("\n", $error_logs);
                        }
                    }
                }
                
                $error_message = 'Failed to initialize Google Drive client. Please check if Google API libraries are properly installed.';
                if (!empty($log_content)) {
                    $error_message .= "\n\nError details from logs:\n" . $log_content;
                } else {
                    // If no logs found, provide more diagnostic information
                    $error_message .= "\n\nNo specific error logs found. Please check:\n";
                    $error_message .= "1. Database connection is working\n";
                    $error_message .= "2. Google Drive credentials are properly configured\n";
                    $error_message .= "3. PHP has the required extensions (curl, json)\n";
                    
                    // Check if credentials file exists
                    $credentials_file = APPPATH . 'config/google-drive-credentials.json';
                    if (file_exists($credentials_file)) {
                        $error_message .= "\nCredentials file exists at: " . $credentials_file;
                    } else {
                        $error_message .= "\nCredentials file NOT found at: " . $credentials_file;
                    }
                }
                
                $this->output->set_output(json_encode(array(
                    'status' => 'error', 
                    'message' => $error_message
                )));
                return;
            }
            
            // Create Drive service instance - try both namespaced and non-namespaced versions
            if (class_exists('Google\\Service\\Drive')) {
                $service = new \Google\Service\Drive($client);
                log_message('debug', 'Using namespaced Google\\Service\\Drive class');
            } elseif (class_exists('Google_Service_Drive')) {
                $service = new \Google_Service_Drive($client);
                log_message('debug', 'Using non-namespaced Google_Service_Drive class');
            } else {
                throw new Exception('Neither Google\\Service\\Drive nor Google_Service_Drive class found');
            }
            
            // Try to list files to verify connection
            log_message('debug', 'Attempting to list files from Google Drive');
            $files = $service->files->listFiles(array(
                'pageSize' => 1,
                'fields' => 'files(id, name)'
            ));
            
            // Log successful API call
            log_message('debug', 'Successfully listed files from Google Drive');
            log_message('info', 'Google Drive connection test successful');
            
            $this->output->set_output(json_encode(array(
                'status' => 'success', 
                'message' => lang('connection_successful')
            )));
            
        } catch (Exception $e) {
            $error_message = 'Connection failed: ' . $e->getMessage();
            $stack_trace = $e->getTraceAsString();
            
            log_message('error', 'Google Drive service error: ' . $error_message);
            log_message('error', 'Stack trace: ' . $stack_trace);
            
            $this->output->set_output(json_encode(array(
                'status' => 'error', 
                'message' => $error_message,
                'trace' => $stack_trace
            )));
        }
    }


    /**
     * Initialize Google Drive client
     * 
     * @return object|bool Client object on success, FALSE on failure
     */
    private function initialize_googledrive_client() {
        // Load the Google API PHP Client Library
        try {
            if (!file_exists(FCPATH . 'vendor/autoload.php')) {
                log_message('error', 'Google API PHP Client Library not found: ' . FCPATH . 'vendor/autoload.php');
                return FALSE;
            }
            
            require_once FCPATH . 'vendor/autoload.php';
            
            // Register a custom autoloader for the Google namespace
            // This is needed because the PSR-4 autoloader doesn't include the base Google namespace
            $googleSrcDir = FCPATH . 'vendor/google/apiclient/src';
            spl_autoload_register(function ($class) use ($googleSrcDir) {
                if (strpos($class, 'Google\\') === 0) {
                    $classPath = str_replace('\\', '/', substr($class, 7)) . '.php';
                    $file = $googleSrcDir . '/' . $classPath;
                    if (file_exists($file)) {
                        require_once $file;
                        return true;
                    }
                }
                return false;
            });
            
            // Load the Storage model if not already loaded
            if (!isset($this->storage_model)) {
                $this->load->model('storage/storage_model');
            }
            
            // Get credentials from database
            try {
                $db_credentials = $this->storage_model->get_googledrive_settings();
                log_message('debug', 'Attempting to get Google Drive credentials from database');
            } catch (Exception $e) {
                log_message('error', 'Error retrieving Google Drive credentials from database: ' . $e->getMessage());
                $db_credentials = FALSE;
            }
            
            if (!$db_credentials) {
                log_message('debug', 'Google Drive credentials not found in database, falling back to file-based credentials');
                
                // Fallback to file-based credentials if database credentials not found
                $credentials_file = APPPATH . 'config/google-drive-credentials.json';
                
                if (!file_exists($credentials_file)) {
                    log_message('error', 'Google Drive credentials file not found: ' . $credentials_file);
                    return FALSE;
                }
                
                // Verify credentials file is valid JSON
                $credentials_content = file_get_contents($credentials_file);
                $credentials_json = json_decode($credentials_content);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    log_message('error', 'Google Drive credentials file contains invalid JSON: ' . json_last_error_msg());
                    return FALSE;
                }
                
                // Check required fields in credentials file
                $required_fields = ['type', 'project_id', 'private_key_id', 'private_key', 'client_email', 'client_id'];
                foreach ($required_fields as $field) {
                    if (!isset($credentials_json->$field) || empty($credentials_json->$field)) {
                        log_message('error', 'Google Drive credentials file missing required field: ' . $field);
                        return FALSE;
                    }
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
            
            // Log available classes for debugging
            log_message('debug', 'Checking if Google\\Client class exists: ' . (class_exists('Google\\Client') ? 'Yes' : 'No'));
            log_message('debug', 'Checking if Google_Client class exists: ' . (class_exists('Google_Client') ? 'Yes' : 'No'));
            
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
            
            // Set auth config based on source type
            $client->setAuthConfig($credentials_source);
            
            return $client;
        } catch (Exception $e) {
            log_message('error', 'Google Drive client initialization error: ' . $e->getMessage() . '\nStack trace: ' . $e->getTraceAsString());
            return FALSE;
        }
    }

    /**
     * Display file uploads page
     */
    public function fileUploads(){
        // Get all uploaded files to display in the view
        $data['files'] = $this->storage_model->get_test_files();
        
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('storage/test_file', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard');
                $this->load->view('storage/test_file', $data);
                $this->load->view('home/footer');
            }}else{
        $this->load->view('home/dashboard');
        $this->load->view('storage/test_file', $data);
        $this->load->view('home/footer');
            }
    }

    /**
     * Download a file
     * 
     * @param int $id File ID
     */
    public function downloadFile($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
        // Get file information
        $file = $this->storage_model->get_test_file($id);
        
        if (!$file) {
            $this->session->set_flashdata('error', lang('file_not_found'));
            redirect('storage/fileUploads');
        }
        
        $file_path = './uploads/' . $file->file;
        
        if (!file_exists($file_path)) {
            $this->session->set_flashdata('error', lang('file_not_found'));
            redirect('storage/fileUploads');
        }
        
        // Force download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file->file) . '"');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    }

    /**
     * Delete a file
     * 
     * @param int $id File ID
     */
    public function deleteFile($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
        if ($this->storage_model->delete_test_file($id)) {
            $this->session->set_flashdata('success', lang('file_deleted_successfully'));
        } else {
            $this->session->set_flashdata('error', lang('file_delete_failed'));
        }
        
        redirect('storage/fileUploads');
    }
}