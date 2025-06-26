<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Drive Model
 * 
 * This model handles Google Drive operations
 */
class Drive_model extends CI_Model {
    
    private $service;
    
    function __construct() {
        parent::__construct();
        $this->load->helper('drive_helper');
    }
    
    /**
     * Initialize Google Drive service
     */
    private function init_service() {
        if (!$this->service) {
            // Force garbage collection to free memory
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
            
            $this->service = get_drive_service();
        }
        return $this->service;
    }
    
    /**
     * Upload a file to Google Drive
     * 
     * @param string $file_path Local file path
     * @param string $file_name Original file name
     * @param string $mime_type File MIME type
     * @param string $folder_id Optional folder ID
     * @return array|bool File metadata or false on failure
     */
    public function upload_file($file_path, $file_name, $mime_type = null, $folder_id = null) {
        try {
            // Force garbage collection to free memory
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
            
            $service = $this->init_service();
            
            // If no mime type provided, try to detect it
            if (empty($mime_type)) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file_path);
                finfo_close($finfo);
            }
            
            // Create file metadata
            $file_metadata = new Google_Service_Drive_DriveFile([
                'name' => $file_name
            ]);
            
            // Set parent folder if provided
            if (!empty($folder_id)) {
                $file_metadata->setParents([$folder_id]);
            }
            
            // Use file handle instead of loading entire file into memory
            $file_handle = fopen($file_path, 'r');
            
            // Upload the file
            $file = $service->files->create($file_metadata, [
                'data' => $file_handle,
                'mimeType' => $mime_type,
                'uploadType' => 'multipart',
                'fields' => 'id,name,mimeType,webViewLink,size'
            ]);
            
            // Close the file handle
            fclose($file_handle);
            
            // Force garbage collection to free memory
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
            
            // Log the upload
            $this->log_activity('upload', $file->getId(), $file->getName());
            
            return $file;
        } catch (Exception $e) {
            log_message('error', 'Google Drive upload error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log file activity
     * 
     * @param string $action Action performed
     * @param string $file_id Google Drive file ID
     * @param string $file_name File name
     */
    private function log_activity($action, $file_id, $file_name) {
        $data = [
            'user_id' => $this->ion_auth->user()->row()->id,
            'action' => $action,
            'file_id' => $file_id,
            'file_name' => $file_name,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        // If you have a logs table, you can insert the data
        // $this->db->insert('drive_logs', $data);
        
        // For now, just log to system log
        log_message('info', "Drive {$action}: {$file_name} ({$file_id}) by user {$data['user_id']}");
    }
}