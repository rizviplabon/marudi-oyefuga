<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Database Encryption Helper
 * 
 * This helper provides functions to encrypt and decrypt data for database storage
 */

/**
 * Simple encryption key that works reliably
 * This uses a fixed key for consistency
 */
function get_encryption_key() {
    // Use a fixed encryption key - hardcoded for reliability
    // In production, this should be in config but for now we need stability
    return hash('sha256', 'MarudiOyefugaSecureEncryptionKey2023');
}

/**
 * Simple encryption using openssl
 * 
 * @param string $data Data to encrypt
 * @return string Base64-encoded encrypted string
 */
function db_encrypt($data) {
    if (empty($data)) {
        return $data;
    }
    
    try {
        $key = get_encryption_key();
        $method = 'aes-256-cbc';
        $iv = substr($key, 0, 16); // Use first 16 bytes of key as IV
        
        $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
        if ($encrypted === false) {
            error_log('OpenSSL encryption failed: ' . openssl_error_string());
            return $data;
        }
        
        return $encrypted;
    } catch (Exception $e) {
        error_log('Exception during encryption: ' . $e->getMessage());
        return $data;
    }
}

/**
 * Simple decryption using openssl
 * 
 * @param string $data Base64-encoded encrypted string
 * @return string Decrypted data
 */
function db_decrypt($data) {
    if (empty($data)) {
        return $data;
    }
    
    // Try to detect if this is plaintext
    // if (preg_match('/^[a-zA-Z0-9\s\-_.,!?@#$%^&*()+=<>:;"\'\/\\]+$/', $data)) {
    //     // Very likely plaintext, return as is
    //     return $data;
    // }
    if (preg_match('/^[a-zA-Z0-9\s\-_.,!?@#$%^&*()\+=<>:;"\'\\/\\\]]+$/', $data)) {
        // Very likely plaintext, return as is
        return $data;
    }
    
    try {
        $key = get_encryption_key();
        $method = 'aes-256-cbc';
        $iv = substr($key, 0, 16); // Use first 16 bytes of key as IV
        
        $decrypted = openssl_decrypt($data, $method, $key, 0, $iv);
        if ($decrypted === false) {
            error_log('OpenSSL decryption failed: ' . openssl_error_string() . ' for data: ' . substr($data, 0, 30) . '...');
            return $data; // Return original if decryption fails
        }
        
        return $decrypted;
    } catch (Exception $e) {
        error_log('Exception during decryption: ' . $e->getMessage() . ' for data: ' . substr($data, 0, 30) . '...');
        return $data;
    }
}

/**
 * Encrypt specific fields in an associative array
 * 
 * @param array $data Data array
 * @param array $fields Fields to encrypt
 * @return array Data with encrypted fields
 */
function encrypt_fields($data, $fields) {
    if (!is_array($data) || !is_array($fields)) {
        return $data;
    }
    
    foreach ($fields as $field) {
        if (isset($data[$field])) {
            $data[$field] = db_encrypt($data[$field]);
        }
    }
    
    return $data;
}

/**
 * Decrypt specific fields in an associative array
 * 
 * @param array $data Data array
 * @param array $fields Fields to decrypt
 * @return array Data with decrypted fields
 */
function decrypt_fields($data, $fields) {
    if (!is_array($data) || !is_array($fields)) {
        return $data;
    }
    
    foreach ($fields as $field) {
        if (isset($data[$field])) {
            $data[$field] = db_decrypt($data[$field]);
        }
    }
    
    return $data;
}

/**
 * Decrypt specific fields in an array of objects or associative arrays
 * 
 * @param array $data_array Array of data objects/arrays
 * @param array $fields Fields to decrypt
 * @return array Data with decrypted fields
 */
function decrypt_fields_in_array($data_array, $fields) {
    if (!is_array($data_array) || !is_array($fields)) {
        return $data_array;
    }
    
    foreach ($data_array as $key => $data) {
        if (is_object($data)) {
            foreach ($fields as $field) {
                if (isset($data->$field)) {
                    $data->$field = db_decrypt($data->$field);
                }
            }
        } elseif (is_array($data)) {
            $data_array[$key] = decrypt_fields($data, $fields);
        }
    }
    
    return $data_array;
} 