<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Google Drive Configuration
|--------------------------------------------------------------------------
|
| This file contains the configuration settings for Google Drive integration.
|
*/

// Default folder ID where files will be uploaded if no specific folder is specified
$config['google_drive_default_folder_id'] = '';

// Whether to store files locally as well as on Google Drive
$config['google_drive_store_locally'] = TRUE;

// Whether to use Google Drive as the primary storage 
// If TRUE, files will be uploaded to Google Drive and links stored in the database
// If FALSE, files will be stored locally and only backed up to Google Drive
$config['google_drive_primary_storage'] = FALSE;

// Paths for local storage
$config['google_drive_local_upload_path'] = './uploads/';
$config['google_drive_temp_path'] = './temp/'; 