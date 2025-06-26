# Storage Module

This module provides a unified file storage system that can store files either in the local filesystem or in Google Drive.

## Features

- Multiple storage providers (local filesystem, Google Drive)
- Storage API settings to configure which provider to use
- Configurable Google Drive integration with service account authentication
- Storage statistics to track file usage
- View and download files

## Usage in Other Modules

The storage module is designed to be used programmatically by other modules. Manual upload and deletion of files is disabled.

### Uploading a File

To upload a file to the current default storage provider from another module:

```php
// In your controller:
public function save_document() {
    // Setup configuration for file upload
    $config['upload_path'] = './uploads/temp/';  // Temporary path before moving to storage
    $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
    $config['max_size'] = 2000; // KB
    
    $this->load->library('upload', $config);
    
    if ($this->upload->do_upload('document')) {
        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];
        
        // Prepare data for the storage module
        $_POST['programmatic_access'] = TRUE;
        $_POST['module'] = 'your_module_name';
        $_POST['reference_id'] = $this->input->post('record_id'); // ID of the record this file belongs to
        $_FILES['file']['name'] = $upload_data['file_name'];
        $_FILES['file']['type'] = $upload_data['file_type'];
        $_FILES['file']['tmp_name'] = $file_path;
        $_FILES['file']['error'] = 0;
        $_FILES['file']['size'] = $upload_data['file_size'];
        
        // Call the storage module to handle the file
        $this->load->module('storage/storage');
        $file_id = $this->storage->upload();
        
        // Store the file ID in your module's database if needed
        if ($file_id) {
            $this->your_model->save_file_reference($this->input->post('record_id'), $file_id);
        }
        
        // Clean up the temporary file
        unlink($file_path);
    }
}
```

### Displaying Files

To display files associated with a record in your module:

```php
// In your controller:
public function view_files($record_id) {
    // Load the storage module
    $this->load->module('storage/storage');
    
    // Redirect to the storage files page with your module and record ID as filters
    redirect('storage/files?module=your_module_name&reference_id=' . $record_id);
}
```

### Deleting Files Programmatically

To delete a file programmatically:

```php
// In your controller:
public function delete_file($file_id) {
    // Load the storage module
    $this->load->module('storage/storage');
    
    // Delete the file with programmatic access flag
    redirect('storage/delete/' . $file_id . '?programmatic_access=true&module=your_module_name&reference_id=' . $record_id);
}
```

## Storage API Settings

The storage settings page allows administrators to:

1. Select the default storage provider (Local or Google Drive)
2. Configure Google Drive API settings
3. View storage statistics for each provider

## Contributing

To add a new storage provider:

1. Create controller and model files in the storage module
2. Implement the required methods: upload, download, view, delete
3. Register the provider in the storage_providers table 