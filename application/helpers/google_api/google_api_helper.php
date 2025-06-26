<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Google API Helper for Module
 * 
 * This helper provides functions to work with Google API client in CodeIgniter
 * specifically for the Google API module
 */

if (!function_exists('load_google_api')) {
    /**
     * Load Google API client
     * 
     * @return Google_Client A configured Google API client
     */
    function load_google_api() {
        // Load the Composer autoloader first
        require_once FCPATH . 'vendor/autoload.php';
        log_message('debug', 'Loaded Composer autoloader');
        
        // Load the core Service class first (parent of Drive service)
        $service_class = FCPATH . 'vendor/google/apiclient/src/Service.php';
        if (file_exists($service_class)) {
            require_once $service_class;
            log_message('debug', 'Loaded core Service class: ' . $service_class);
        } else {
            log_message('error', 'Core Service class not found: ' . $service_class);
        }
        
        // Manually load the Drive service class
        $drive_service_file = FCPATH . 'vendor/google/apiclient-services/src/Drive.php';
        if (file_exists($drive_service_file)) {
            require_once $drive_service_file;
            log_message('debug', 'Loaded Drive service class: ' . $drive_service_file);
        } else {
            log_message('error', 'Drive service class not found: ' . $drive_service_file);
        }
        
        // Manually load the DriveFile class
        $drive_file_class = FCPATH . 'vendor/google/apiclient-services/src/Drive/DriveFile.php';
        if (file_exists($drive_file_class)) {
            require_once $drive_file_class;
            log_message('debug', 'Loaded DriveFile class: ' . $drive_file_class);
        } else {
            log_message('error', 'DriveFile class not found: ' . $drive_file_class);
        }
        
        // Load additional Drive-related classes
        $drive_base_path = FCPATH . 'vendor/google/apiclient-services/src/Drive/';
        $additional_drive_files = [
            $drive_base_path . 'DriveFileCapabilities.php',
            $drive_base_path . 'DriveFileContentHints.php',
            $drive_base_path . 'ContentRestriction.php',
        ];
        
        foreach ($additional_drive_files as $file) {
            if (file_exists($file)) {
                require_once $file;
                log_message('debug', 'Loaded additional Drive class: ' . $file);
            } else {
                log_message('debug', 'Additional Drive class not found (not critical): ' . $file);
            }
        }
        
        // Load core Google API client classes if needed
        $core_base_path = FCPATH . 'vendor/google/apiclient/src/';
        $core_files = [
            $core_base_path . 'Client.php',
            $core_base_path . 'AccessToken/Revoke.php',
            $core_base_path . 'AccessToken/Verify.php',
            $core_base_path . 'Model.php',
            $core_base_path . 'Utils/UriTemplate.php',
            $core_base_path . 'AuthHandler/Guzzle6AuthHandler.php',
            $core_base_path . 'AuthHandler/Guzzle7AuthHandler.php',
            $core_base_path . 'AuthHandler/AuthHandlerFactory.php',
            $core_base_path . 'Http/Batch.php',
            $core_base_path . 'Http/MediaFileUpload.php',
            $core_base_path . 'Http/REST.php',
            // Load Exception.php before Task/Exception.php
            $core_base_path . 'Exception.php',
            $core_base_path . 'Task/Retryable.php',
            $core_base_path . 'Task/Exception.php',
            $core_base_path . 'Task/Runner.php',
        ];
        
        foreach ($core_files as $file) {
            if (file_exists($file)) {
                require_once $file;
                log_message('debug', 'Loaded core Google API class: ' . $file);
            } else {
                log_message('debug', 'Core Google API class not found (not critical): ' . $file);
            }
        }
        
        // Now it's safe to require the aliases file
        $aliases_file = FCPATH . 'vendor/google/apiclient/src/aliases.php';
        if (file_exists($aliases_file)) {
            require_once $aliases_file;
            log_message('debug', 'Loaded Google API aliases file');
        } else {
            log_message('error', 'Google API aliases file not found: ' . $aliases_file);
        }
        
        // Create and configure the Google API client
        try {
            // Try with legacy class name first
            if (class_exists('Google_Client')) {
                $client = new Google_Client();
                $client->setApplicationName('Klinicx');
                log_message('debug', 'Created Google_Client instance');
                return $client;
            } 
            // If that fails, try with namespaced class
            else if (class_exists('\Google\Client')) {
                $client = new \Google\Client();
                $client->setApplicationName('Klinicx');
                log_message('debug', 'Created \Google\Client instance');
                return $client;
            } 
            // If both fail, log error and throw exception
            else {
                log_message('error', 'Neither Google_Client nor \Google\Client class found after loading files');
                throw new Exception('Google Client class not found');
            }
        } catch (Exception $e) {
            log_message('error', 'Failed to create Google Client: ' . $e->getMessage());
            throw new Exception('Failed to create Google Client: ' . $e->getMessage());
        }
    }
}

if (!function_exists('get_google_drive_service')) {
    /**
     * Get Google Drive service
     * 
     * @return Google_Service_Drive Google Drive service
     */
    function get_google_drive_service() {
        $client = load_google_api();
        
        // Add Drive scope
        try {
            if (class_exists('Google_Service_Drive')) {
                $client->addScope(Google_Service_Drive::DRIVE);
                log_message('debug', 'Added Drive scope using Google_Service_Drive');
            } else if (class_exists('\Google\Service\Drive')) {
                $client->addScope(\Google\Service\Drive::DRIVE);
                log_message('debug', 'Added Drive scope using \Google\Service\Drive');
            } else {
                // Hardcode the scope if class is not available
                $client->addScope('https://www.googleapis.com/auth/drive');
                log_message('debug', 'Added Drive scope using hardcoded string');
            }
        } catch (Exception $e) {
            log_message('error', 'Failed to add Drive scope: ' . $e->getMessage());
            // Try hardcoded scope as fallback
            try {
                $client->addScope('https://www.googleapis.com/auth/drive');
                log_message('debug', 'Added Drive scope using hardcoded string (fallback)');
            } catch (Exception $e) {
                log_message('error', 'Failed to add hardcoded Drive scope: ' . $e->getMessage());
                throw new Exception('Failed to add Drive scope: ' . $e->getMessage());
            }
        }
        
        // Load settings from database
        $CI =& get_instance();
        $CI->load->model('google_api/google_drive_settings_model');
        $settings = $CI->google_drive_settings_model->getSettings();
        
        if (!$settings) {
            throw new Exception('Google Drive settings not found');
        }
        
        // Set authentication credentials
        $auth = array(
            'type' => 'service_account',
            'project_id' => $settings->project_id,
            'client_id' => $settings->client_id,
            'client_email' => $settings->client_email,
            'private_key_id' => $settings->private_key_id,
            'private_key' => $settings->private_key,
        );
        
        $client->setAuthConfig($auth);
        
        // Create and return the Drive service
        try {
            if (class_exists('Google_Service_Drive')) {
                $service = new Google_Service_Drive($client);
                log_message('debug', 'Created Google_Service_Drive instance');
                return $service;
            } else if (class_exists('\Google\Service\Drive')) {
                $service = new \Google\Service\Drive($client);
                log_message('debug', 'Created \Google\Service\Drive instance');
                return $service;
            } else {
                log_message('error', 'Neither Google_Service_Drive nor \Google\Service\Drive class found');
                throw new Exception('Drive service class not found');
            }
        } catch (Exception $e) {
            log_message('error', 'Failed to create Drive service: ' . $e->getMessage());
            throw new Exception('Failed to create Drive service: ' . $e->getMessage());
        }
    }
}

if (!function_exists('list_drive_files')) {
    function list_drive_files($pageSize = 10, $query = '') {
        $service = get_google_drive_service();
        
        // Prepare the query parameters
        $params = array(
            'pageSize' => $pageSize,
            'fields' => 'files(id, name, mimeType, webViewLink, createdTime, size)',
        );
        
        if (!empty($query)) {
            $params['q'] = $query;
        }
        
        // Execute the query
        $results = $service->files->listFiles($params);
        
        return $results->getFiles();
    }
}

if (!function_exists('upload_file_to_drive')) {
    function upload_file_to_drive($filePath, $fileName, $mimeType = null, $folderId = null) {
        $service = get_google_drive_service();
        
        // Create file metadata
        if (class_exists('Google_Service_Drive_DriveFile')) {
            $fileMetadata = new Google_Service_Drive_DriveFile(array(
                'name' => $fileName
            ));
        } else if (class_exists('\Google\Service\Drive\DriveFile')) {
            $fileMetadata = new \Google\Service\Drive\DriveFile(array(
                'name' => $fileName
            ));
        } else {
            throw new Exception('DriveFile class not found');
        }
        
        // Set parent folder if provided
        if ($folderId) {
            $fileMetadata->setParents(array($folderId));
        }
        
        // Determine MIME type if not provided
        if (!$mimeType) {
            $mimeType = mime_content_type($filePath);
        }
        
        // Create file
        $content = file_get_contents($filePath);
        $file = $service->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id, name, mimeType, webViewLink, createdTime, size'
        ));
        
        return $file;
    }
}

if (!function_exists('create_drive_folder')) {
    function create_drive_folder($folderName, $parentId = null) {
        $service = get_google_drive_service();
        
        // Create folder metadata
        if (class_exists('Google_Service_Drive_DriveFile')) {
            $folderMetadata = new Google_Service_Drive_DriveFile(array(
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder'
            ));
        } else if (class_exists('\Google\Service\Drive\DriveFile')) {
            $folderMetadata = new \Google\Service\Drive\DriveFile(array(
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder'
            ));
        } else {
            throw new Exception('DriveFile class not found');
        }
        
        // Set parent folder if provided
        if ($parentId) {
            $folderMetadata->setParents(array($parentId));
        }
        
        // Create folder
        $folder = $service->files->create($folderMetadata, array(
            'fields' => 'id, name, mimeType, webViewLink, createdTime'
        ));
        
        return $folder;
    }
}

if (!function_exists('get_drive_file')) {
    function get_drive_file($fileId) {
        $service = get_google_drive_service();
        
        return $service->files->get($fileId, array(
            'fields' => 'id, name, mimeType, webViewLink, createdTime, size'
        ));
    }
}

if (!function_exists('download_drive_file')) {
    function download_drive_file($fileId) {
        $service = get_google_drive_service();
        
        $response = $service->files->get($fileId, array(
            'alt' => 'media'
        ));
        
        return $response->getBody()->getContents();
    }
}

if (!function_exists('delete_drive_file')) {
    function delete_drive_file($fileId) {
        $service = get_google_drive_service();
        
        $service->files->delete($fileId);
        
        return true;
    }
}