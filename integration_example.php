<?php
/**
 * Google Drive Integration Example
 * 
 * This file demonstrates how to integrate Google Drive file uploads
 * into your existing modules.
 */

// This is a simple implementation in this file
// If you want to test the functionality directly, you can uncomment the code below
/*
require_once APPPATH . '../vendor/autoload.php';
require_once APPPATH . 'helpers/google_drive_helper.php';

// Load Google Drive credentials
$keyFilePath = APPPATH . 'config/google-drive-credentials.json';
if (!file_exists($keyFilePath)) {
    die("Google Drive credentials file not found: " . $keyFilePath);
}

// Test file to upload
$filePath = './uploads/test.jpg';  // Replace with an actual file path
if (!file_exists($filePath)) {
    die("Test file not found: " . $filePath);
}

// Upload to Google Drive
$fileId = upload_to_google_drive($filePath, 'Test Upload.jpg', 'image/jpeg');

if ($fileId) {
    echo "File uploaded successfully to Google Drive!<br>";
    echo "File ID: " . $fileId . "<br>";
    
    // Get file info
    $fileInfo = get_file_from_google_drive($fileId);
    if ($fileInfo) {
        echo "File Name: " . $fileInfo['name'] . "<br>";
        echo "View Link: <a href='" . $fileInfo['viewLink'] . "' target='_blank'>View File</a><br>";
        echo "Download Link: <a href='" . $fileInfo['downloadLink'] . "'>Download File</a><br>";
    }
} else {
    echo "Failed to upload file to Google Drive.";
}
*/

/**
 * Example 1: Add a link to Google Drive File Manager in a view
 */
?>

<!-- Add this button in your view file -->
<a href="<?php echo site_url('GoogleDriveFile?module=patient&reference_id=' . $patient->id); ?>" class="btn btn-info">
    <i class="fa fa-cloud-upload"></i> Manage Files on Google Drive
</a>

<?php
/**
 * Example 2: Use the Google Drive helper functions directly in a controller
 */
?>

<!-- PHP Example 2 -->
<pre>
&lt;?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('google_drive_helper');
    }
    
    public function upload_to_drive() {
        // Get the local file path
        $file_path = '/path/to/local/file.pdf';
        $file_name = 'Document Name.pdf';
        $mime_type = 'application/pdf';
        
        // Upload to Google Drive
        $google_file_id = upload_to_google_drive($file_path, $file_name, $mime_type);
        
        if ($google_file_id) {
            // Get the file info from Google Drive
            $file_data = get_file_from_google_drive($google_file_id);
            
            // Save the link to your database
            $this->db->insert('your_table', array(
                'google_file_id' => $google_file_id,
                'file_name' => $file_name,
                'view_link' => $file_data['viewLink'],
                'download_link' => $file_data['downloadLink'],
                'date_added' => date('Y-m-d H:i:s')
            ));
            
            echo "File uploaded successfully!";
        } else {
            echo "Upload failed.";
        }
    }
}
?&gt;
</pre>

<?php
/**
 * Example 3: Using the Google Drive File model in a controller
 */
?>

<!-- PHP Example 3 -->
<pre>
&lt;?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Another_Example extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Google_drive_file_model', 'google_drive_file');
    }
    
    public function show_files() {
        // Get files for a specific module/reference
        $module = 'patient';
        $patient_id = 123;
        
        $files = $this->google_drive_file->get_by_module_reference($module, $patient_id);
        
        // Display the files
        foreach ($files as $file) {
            echo "&lt;p&gt;File: {$file->original_filename}&lt;/p&gt;";
            echo "&lt;p&gt;View: &lt;a href='{$file->view_link}' target='_blank'&gt;View&lt;/a&gt;&lt;/p&gt;";
            echo "&lt;p&gt;Download: &lt;a href='{$file->download_link}'&gt;Download&lt;/a&gt;&lt;/p&gt;";
            echo "&lt;hr&gt;";
        }
    }
    
    public function delete_file($id) {
        if ($this->google_drive_file->delete($id)) {
            echo "File deleted successfully!";
        } else {
            echo "Failed to delete file.";
        }
    }
}
?&gt;
</pre>

<?php
/**
 * Example 4: Custom file upload form with Google Drive integration
 */
?>

<!-- Custom Form -->
<form action="<?php echo site_url('your_controller/process_upload'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <input type="hidden" name="patient_id" value="123">
    <button type="submit">Upload to Google Drive</button>
</form>

<!-- PHP Example 4 -->
<pre>
&lt;?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Your_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('google_drive_helper');
        $this->load->model('Google_drive_file_model', 'google_drive_file');
        $this->load->library('upload');
    }
    
    public function process_upload() {
        // Get patient ID
        $patient_id = $this->input->post('patient_id');
        
        // Set upload configuration
        $config = array(
            'upload_path' => './temp/',
            'allowed_types' => 'gif|jpg|jpeg|png|pdf|doc|docx',
            'max_size' => 20480, // 20MB
            'encrypt_name' => TRUE,
        );
        
        $this->upload->initialize($config);
        
        // Attempt to upload file
        if (!$this->upload->do_upload('file')) {
            $error = $this->upload->display_errors();
            echo $error;
            return;
        }
        
        // Get uploaded file info
        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];
        $file_name = $upload_data['file_name'];
        $original_name = $upload_data['orig_name'];
        $file_type = $upload_data['file_type'];
        $file_size = $upload_data['file_size'];
        
        // Upload to Google Drive
        $google_file_id = upload_to_google_drive($file_path, $original_name, $file_type);
        
        if (!$google_file_id) {
            unlink($file_path); // Delete temp file
            echo "Failed to upload file to Google Drive.";
            return;
        }
        
        // Get file info from Google Drive
        $google_file = get_file_from_google_drive($google_file_id);
        
        if (!$google_file) {
            unlink($file_path); // Delete temp file
            echo "Failed to get file info from Google Drive.";
            return;
        }
        
        // Save file record to database
        $file_data = array(
            'google_file_id' => $google_file_id,
            'filename' => $file_name,
            'original_filename' => $original_name,
            'file_type' => $file_type,
            'file_size' => $file_size,
            'view_link' => $google_file['viewLink'],
            'download_link' => $google_file['downloadLink'],
            'module' => 'patient',
            'reference_id' => $patient_id,
            'user_id' => $this->ion_auth->get_user_id(),
            'hospital_id' => $this->session->userdata('hospital_id'),
        );
        
        $file_id = $this->google_drive_file->save($file_data);
        
        // Delete temp file
        unlink($file_path);
        
        if (!$file_id) {
            echo "Failed to save file record to database.";
        } else {
            echo "File uploaded successfully to Google Drive!";
        }
    }
}
?&gt;
</pre> 