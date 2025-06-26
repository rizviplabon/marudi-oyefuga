<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Drive extends MX_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->helper('drive_helper');
        $this->load->model('storage/storage_model');
        
    }

    public function upload_form() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $storage_type = $this->storage_model->get_storage_type();
                $temp_dir = 'uploads/';
                
                // Create upload directory if it doesn't exist
                if (!is_dir($temp_dir)) {
                    mkdir($temp_dir, 0755, true);
                }
    
                // Common upload configuration
                $config = [
                    'upload_path'   => $temp_dir,
                    'allowed_types' => '*',
                    'max_size'      => 10240, // 10MB
                    'encrypt_name'  => true
                ];
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                if (!$this->upload->do_upload('userfile')) {
                    throw new Exception($this->upload->display_errors());
                }
                
                $upload_data = $this->upload->data();
                $file_path = $upload_data['full_path'];
                
                if ($storage_type == "drive") {
                    // Google Drive Upload
                    $access_token = get_google_drive_service();
                    $account = $this->storage_model->get_googledrive_settings();
                    $parent_folder_id = $account->default_folder_id;
                    
                    $result = upload_to_google_drive($access_token, $file_path, $parent_folder_id);
                    
                    // Delete local temp file after Drive upload
                    unlink($file_path);
                    
                    if ($result['status'] !== 'success') {
                        throw new Exception('Google Drive upload failed: ' . print_r($result['response'], true));
                    }
                    
                    $file_id = $result['response']['id'];
                    $unique_name = $result['unique_name'];
                    
                    // Store Drive file reference in database if needed
                    // $this->storage_model->save_file_reference([
                    //     'file_id' => $file_id,
                    //     'original_name' => $upload_data['client_name'],
                    //     'storage_type' => 'drive',
                    //     'uploaded_at' => date('Y-m-d H:i:s')
                    // ]);
                } else {
                    // Local Storage
                    $file_id = $upload_data['file_name']; // Using encrypted name as ID
                    $unique_name = $upload_data['file_name'];
                    
                    // Store local file reference in database if needed
                    // $this->storage_model->save_file_reference([
                    //     'file_id' => $file_id,
                    //     'original_name' => $upload_data['client_name'],
                    //     'storage_type' => 'local',
                    //     'uploaded_at' => date('Y-m-d H:i:s')
                    // ]);
                }
                
                // Show success (same view for both storage types)
                $this->load->view('upload_success', [
                    'original_name' => $upload_data['client_name'],
                    'unique_name' => $unique_name,
                    'file_id' => $file_id,
                    'storage_type' => $storage_type
                ]);
                
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
                $this->load->view('upload_form', $data);
            }
        } else {
            $this->load->view('upload_form');
        }
    }
    
    
   
}