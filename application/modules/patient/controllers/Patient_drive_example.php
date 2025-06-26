<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Patient Drive Example
 * 
 * This is an example of how to modify the Patient controller to use Google Drive for file uploads
 * This is NOT a complete controller, just examples of methods that would be modified
 */
class Patient_drive_example extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('patient_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('upload_drive_helper'); // Load the upload drive helper
        $this->load->config('google_drive'); // Load Google Drive config
    }
    
    /**
     * Example of how to modify the addNew method to use Google Drive
     */
    public function addNew() {
        // Form validation and other code...
        
        // Check if image upload is requested
        if (isset($_FILES['img_url']) && $_FILES['img_url']['name'] != '') {
            // Set up upload configuration (same as in original method)
            $config = array(
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => FALSE,
                'max_size' => "10000000",
                'max_height' => "10000",
                'max_width' => "10000"
            );
            
            // Use the upload_to_drive function instead of the CI upload library directly
            $upload_result = upload_to_drive('img_url', $config, 'patient', $patient_id);
            
            if ($upload_result['status']) {
                // Upload was successful, use the img_url from the result
                $img_url = $upload_result['img_url'];
                
                // Add it to the data array
                $data = array(
                    'patient_id' => $patient_id,
                    'img_url' => $img_url,
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'doctor' => $doctor,
                    'phone' => $phone,
                    'sex' => $sex,
                    'birthdate' => $birthdate,
                    'bloodgroup' => $bloodgroup,
                    'add_date' => $add_date
                );
            } else {
                // Handle upload error
                $this->session->set_flashdata('feedback', $upload_result['error']);
                redirect('patient/addNew');
            }
        } else {
            // No image uploaded, proceed without image
            $data = array(
                'patient_id' => $patient_id,
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'doctor' => $doctor,
                'phone' => $phone,
                'sex' => $sex,
                'birthdate' => $birthdate,
                'bloodgroup' => $bloodgroup,
                'add_date' => $add_date
            );
        }
        
        // Insert patient data
        $this->patient_model->insertPatient($data);
        
        // Rest of the code...
    }
    
    /**
     * Example of how to modify the addPatientMaterial method to use Google Drive
     */
    public function addPatientMaterial() {
        // Form validation and other code...
        
        // Check if image upload is requested
        if (isset($_FILES['img_url']) && $_FILES['img_url']['name'] != '') {
            // Set up upload configuration (same as in original method)
            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./uploads/documents/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf|docx|doc|odt",
                'overwrite' => FALSE,
                'max_size' => "48000000",
                'max_height' => "10000",
                'max_width' => "10000"
            );
            
            // Use the upload_to_drive function instead of the CI upload library directly
            $upload_result = upload_to_drive('img_url', $config, 'patient_document', $patient_id);
            
            if ($upload_result['status']) {
                // Upload was successful, use the img_url from the result
                $img_url = $upload_result['img_url'];
                
                // Add it to the data array
                $data = array(
                    'date' => $date,
                    'type' => $type,
                    'folder' => $folder,
                    'title' => $title,
                    'url' => $img_url,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date),
                    'google_drive_file_id' => $upload_result['file_id'] // Store the Google Drive file ID
                );
            } else {
                // Handle upload error
                $data = array(
                    'date' => $date,
                    'title' => $title,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date),
                );
                $this->session->set_flashdata('feedback', $upload_result['error']);
            }
        } else {
            // No image uploaded, proceed without image
            $data = array(
                'date' => $date,
                'title' => $title,
                'patient' => $patient_id,
                'patient_name' => $patient_name,
                'patient_address' => $patient_address,
                'patient_phone' => $patient_phone,
                'date_string' => date('d-m-y', $date),
            );
        }
        
        // Insert patient material data
        $this->patient_model->insertPatientMaterial($data);
        
        // Rest of the code...
    }
    
    /**
     * Example of how to modify views to display Google Drive files
     */
    public function displayPatientFiles() {
        // Get patient files data
        $patient_id = $this->input->get('id');
        $patient_files = $this->patient_model->getPatientMaterialByPatient($patient_id);
        
        // Load the helper for displaying files
        $this->load->helper('upload_drive_helper');
        
        // Loop through files and display them
        foreach ($patient_files as $file) {
            // For files that are stored in Google Drive
            if (isset($file->google_drive_file_id) && !empty($file->google_drive_file_id)) {
                // Display the file using the helper
                echo display_drive_file($file->google_drive_file_id, array(
                    'class' => 'img-thumbnail',
                    'alt' => $file->title
                ));
            } else {
                // For legacy files that are stored locally
                echo '<img src="'.base_url($file->url).'" class="img-thumbnail" alt="'.$file->title.'">';
            }
        }
    }
    
    /**
     * Example of how to delete files from Google Drive
     */
    public function deletePatientFile() {
        $id = $this->input->get('id');
        
        // Get the file information
        $file = $this->patient_model->getPatientMaterialById($id);
        
        // Check if this is a Google Drive file
        if (isset($file->google_drive_file_id) && !empty($file->google_drive_file_id)) {
            // Load the helper for deleting files
            $this->load->helper('upload_drive_helper');
            
            // Delete from Google Drive
            delete_drive_file($file->google_drive_file_id);
        } else {
            // Legacy file deletion - delete the local file
            if (file_exists($file->url)) {
                unlink($file->url);
            }
        }
        
        // Delete from database
        $this->patient_model->deletePatientMaterial($id);
        
        // Redirect to appropriate page
        redirect('patient/medicalHistory?id='.$file->patient);
    }
} 