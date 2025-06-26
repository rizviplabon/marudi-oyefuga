<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Drive Helper
 * 
 * Helper functions for Google Drive integration
 */

// Load the Google API Client Library
require_once APPPATH . '../vendor/autoload.php';

if (!function_exists('load_google_client')) {
    /**
     * Load and configure Google API Client
     * 
     * @return Google_Client Configured client
     */
    function load_google_client() {
        // Force garbage collection to free memory
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
        
        $CI =& get_instance();
        $CI->load->model('drive/drive_model');
        
        // Get settings from database or use defaults
        $settings = $CI->drive_model->get_settings();
        
        $client = new Google_Client();
        $client->setApplicationName('KlinicX Google Drive Integration');
        $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
        
        // Disable gzip to reduce memory usage
        $client->setDecoderOptions(['decode_content' => false]);
        
        // Use service account if configured
        if (!empty($settings['service_account_path'])) {
            $service_account_file = APPPATH . 'config/' . $settings['service_account_path'];
            if (file_exists($service_account_file)) {
                $client->setAuthConfig($service_account_file);
                $client->useApplicationDefaultCredentials();
            } else {
                log_message('error', 'Google Drive service account file not found: ' . $service_account_file);
            }
        } else {
            // Use API key if configured
            if (!empty($settings['api_key'])) {
                $client->setDeveloperKey($settings['api_key']);
            }
            
            // Use OAuth credentials if configured
            if (!empty($settings['client_id']) && !empty($settings['client_secret'])) {
                $client->setClientId($settings['client_id']);
                $client->setClientSecret($settings['client_secret']);
                
                // Set access token if available
                if (!empty($settings['access_token'])) {
                    $client->setAccessToken($settings['access_token']);
                    
                    // Refresh token if expired
                    if ($client->isAccessTokenExpired()) {
                        if ($client->getRefreshToken()) {
                            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                            
                            // Save new access token
                            $CI->drive_model->update_settings([
                                'access_token' => json_encode($client->getAccessToken())
                            ]);
                        }
                    }
                }
            }
        }
        
        return $client;
    }
}

if (!function_exists('get_drive_service')) {
    /**
     * Get Google Drive service
     * 
     * @return Google_Service_Drive Drive service
     */
    function get_drive_service() {
        // Force garbage collection to free memory
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
        
        $client = load_google_client();
        return new Google_Service_Drive($client);
    }
}

if (!function_exists('format_file_size')) {
    /**
     * Format file size in human-readable format
     * 
     * @param int $bytes File size in bytes
     * @param int $precision Decimal precision
     * @return string Formatted file size
     */
    function format_file_size($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('format_drive_date')) {
    /**
     * Format Google Drive date in human-readable format
     * 
     * @param string $date_string Google Drive date string
     * @param string $format Date format
     * @return string Formatted date
     */
    function format_drive_date($date_string, $format = 'Y-m-d H:i:s') {
        $date = new DateTime($date_string);
        return $date->format($format);
    }
}