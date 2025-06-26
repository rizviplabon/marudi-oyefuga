<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;

if (!function_exists('get_google_drive_service')) {
    function get_google_drive_service() {
        $CI =& get_instance();
        $CI->load->model('storage/storage_model');
        
        // Get service account from database
        $account = $CI->storage_model->get_googledrive_settings();
        
        if (!$account) {
            throw new Exception('No active Google service account found in database');
        }
        
        $now = time();
        $jwt_claims = [
            'iss' => $account->client_email,
            'scope' => 'https://www.googleapis.com/auth/drive',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];
        
        $privatekey = $account->private_key;
$fixedKey = str_replace("-----BEGINPRIVATEKEY-----", "-----BEGIN PRIVATE KEY-----", $privatekey);
$fixedKey = str_replace("-----ENDPRIVATEKEY-----", "-----END PRIVATE KEY-----", $fixedKey);

// 2. Convert literal "\n" into actual newlines
$fixedKey = str_replace("\\n", "\n", $fixedKey);

// 3. Use the key with OpenSSL
$private_key = openssl_pkey_get_private($fixedKey);
        // $private_key = "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCTbE2+6SdumPI4\ni0/fRX/Zl2lhmsxbSXkKqZ+qLgJds27w/1Fn2GltcdyoMXBVJwe62159niZNn+cc\njyCYLeRwqEd9TvfE1XO4CW4Fb0mj/hAmQBOW7JpD3EK+J0kTEePV2GXlUESuE962\n/O8DV7Z+wu1M66rFAWu62q+xE865jyf8bxvotD/DsM4J1pM32IcfjnSsO1c0Cgcf\nil9PZChpNGfyR2DC1uHTj7hI8ifdenpEi23RjewfydPYDg4VspRg/hLzS3sC1Mpd\n+eomiYzcvs0woo76DIfYEZZ5XL0CWDKmof0CApKPNbrLPSQ7ckjoU68/6KvlHAhR\nT1jSRSh3AgMBAAECggEANd9VBdfT5hGUKl+WX4PZNZ2kD9vuo8lUpzXXN+w6Rx2E\nBCN5DxbBaBI8zWXLpAJwS7NQc10wqBsv7HrNMW9L1HNaNIt/9Xj/IZiokOnbIkd8\nhU3TGsr5kKTT6wMWLBbUiFfc3JCZmHeAYqRJf5I1CVuYNgzEyds8D/tMSsxvNdVx\ncRyHNYhp7TOK3k6pPouofuFau8MWWYdcCP7oATyT3oryyxc5g0ojthBjmbshPhhq\nha4rZEOzzeYSwH/2UGXLLufb6G8pXc09+JMGv/+mf4vx4eCEfqc5i4OLH6nqDngK\nPIcBU1f/k3eujYKCUd0qIqzwQLJcw5SqbaMKfRJJcQKBgQDKNt6yAUWwYuiSHt2R\nk48RYsAXXGaA57bcIGsWsaOiy2gev+4fSak5zYjSxdGx6cwP8HL4bAKyldt1eOdo\nIGnns9z2cMnGF1iXLT9AOtOgFDeqKdo3Qldj8+y0LXYG0XZZUCAw6vUt5GqzUa8v\nXaLeuy8TmcYACB+VKCEK1qjzXwKBgQC6opl206vWXs9wHZ++gp3PM68wDT/IfddY\nyTzW/I+FS1/GQFdC1gpsk+U1CjjarO6TvPYwChAoPKitd4wU8TBOpR9e+SW6Clw6\n/tz74D9SKMfxJBwndAaBcowNErvnWOm1dVJpq0+CBqIslhgxg5YvDhmpsCJVxYSy\nVPWmSWC56QKBgQCzfI6gm4Z68OAUSvdKLxqvSOLOGYMWahYiP1gudZCUgE2z9ZJs\nDRr7JpeK1nGxpJ8virLSFDU0xNVd6Oolv5ehRUIdMLG4daJ51XyuC0kqbqeWD74U\njHs7ShjROQTpOmT9E6TvJq5nhLa84gVIWqmlX6qCkFxyTMOTxmHF2BFwqwKBgBWF\nTFbkX4svkZHnCJWKMDJFTm0nCfTPdfZ59fcAVnhTUa7lmmpNjhQpFaQBEr88c6I7\nhtPRRT2uiPC/uTps+VoINk7YQd5q9WmkG807dXG+3BdVR53RBjMFB1s2js5FdWWE\nKsWeiGOA6lBj2lRTTQ0N/i2P7tWfGgcKPu02xt2JAoGBAKEvQgmHTlxLp/fBVbQV\nLnw5CIH2bRUXPw5U0IXLI+tHDItoOCwoTqGmBPVvoNnO/JgEd3jHK18Am6QYtjCS\nOg3in6mw9QWTG0vTZtTjQk10n0rJr3ntOAbVTQGTorUZdqBdOGknWiYtC4Z4siFq\nOMUr2TmeiaW4E7vPJweRywzX\n-----END PRIVATE KEY-----\n";
        // Format private key correctly
        // $account_private_key = "nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCTbE2+6SdumPI4\ni0/fRX/Zl2lhmsxbSXkKqZ+qLgJds27w/1Fn2GltcdyoMXBVJwe62159niZNn+cc\njyCYLeRwqEd9TvfE1XO4CW4Fb0mj/hAmQBOW7JpD3EK+J0kTEePV2GXlUESuE962\n/O8DV7Z+wu1M66rFAWu62q+xE865jyf8bxvotD/DsM4J1pM32IcfjnSsO1c0Cgcf\nil9PZChpNGfyR2DC1uHTj7hI8ifdenpEi23RjewfydPYDg4VspRg/hLzS3sC1Mpd\n+eomiYzcvs0woo76DIfYEZZ5XL0CWDKmof0CApKPNbrLPSQ7ckjoU68/6KvlHAhR\nT1jSRSh3AgMBAAECggEANd9VBdfT5hGUKl+WX4PZNZ2kD9vuo8lUpzXXN+w6Rx2E\nBCN5DxbBaBI8zWXLpAJwS7NQc10wqBsv7HrNMW9L1HNaNIt/9Xj/IZiokOnbIkd8\nhU3TGsr5kKTT6wMWLBbUiFfc3JCZmHeAYqRJf5I1CVuYNgzEyds8D/tMSsxvNdVx\ncRyHNYhp7TOK3k6pPouofuFau8MWWYdcCP7oATyT3oryyxc5g0ojthBjmbshPhhq\nha4rZEOzzeYSwH/2UGXLLufb6G8pXc09+JMGv/+mf4vx4eCEfqc5i4OLH6nqDngK\nPIcBU1f/k3eujYKCUd0qIqzwQLJcw5SqbaMKfRJJcQKBgQDKNt6yAUWwYuiSHt2R\nk48RYsAXXGaA57bcIGsWsaOiy2gev+4fSak5zYjSxdGx6cwP8HL4bAKyldt1eOdo\nIGnns9z2cMnGF1iXLT9AOtOgFDeqKdo3Qldj8+y0LXYG0XZZUCAw6vUt5GqzUa8v\nXaLeuy8TmcYACB+VKCEK1qjzXwKBgQC6opl206vWXs9wHZ++gp3PM68wDT/IfddY\nyTzW/I+FS1/GQFdC1gpsk+U1CjjarO6TvPYwChAoPKitd4wU8TBOpR9e+SW6Clw6\n/tz74D9SKMfxJBwndAaBcowNErvnWOm1dVJpq0+CBqIslhgxg5YvDhmpsCJVxYSy\nVPWmSWC56QKBgQCzfI6gm4Z68OAUSvdKLxqvSOLOGYMWahYiP1gudZCUgE2z9ZJs\nDRr7JpeK1nGxpJ8virLSFDU0xNVd6Oolv5ehRUIdMLG4daJ51XyuC0kqbqeWD74U\njHs7ShjROQTpOmT9E6TvJq5nhLa84gVIWqmlX6qCkFxyTMOTxmHF2BFwqwKBgBWF\nTFbkX4svkZHnCJWKMDJFTm0nCfTPdfZ59fcAVnhTUa7lmmpNjhQpFaQBEr88c6I7\nhtPRRT2uiPC/uTps+VoINk7YQd5q9WmkG807dXG+3BdVR53RBjMFB1s2js5FdWWE\nKsWeiGOA6lBj2lRTTQ0N/i2P7tWfGgcKPu02xt2JAoGBAKEvQgmHTlxLp/fBVbQV\nLnw5CIH2bRUXPw5U0IXLI+tHDItoOCwoTqGmBPVvoNnO/JgEd3jHK18Am6QYtjCS\nOg3in6mw9QWTG0vTZtTjQk10n0rJr3ntOAbVTQGTorUZdqBdOGknWiYtC4Z4siFq\nOMUr2TmeiaW4E7vPJweRywzX";
        // $private_key = "-----BEGIN PRIVATE KEY-----$account_private_key\n-----END PRIVATE KEY-----\n";
        // $private_key = $account->private_key;
        
         
        
        $jwt = JWT::encode($jwt_claims, $private_key, 'RS256');
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://oauth2.googleapis.com/token',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']
        ]);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $token_data = json_decode($response, true);
        
        if (isset($token_data['error'])) {
            throw new Exception('Google Auth Error: ' . $token_data['error_description']);
        }
        
        return $token_data['access_token'];
    }
}

if (!function_exists('generate_unique_filename')) {
    function generate_unique_filename($original_name) {
        $extension = pathinfo($original_name, PATHINFO_EXTENSION);
        $name_without_ext = pathinfo($original_name, PATHINFO_FILENAME);
        
        // Create a unique filename with timestamp and random string
        $unique_string = date('YmdHis') . '_' . bin2hex(random_bytes(4));
        return $name_without_ext . '_' . $unique_string . ($extension ? '.' . $extension : '');
    }
}

if (!function_exists('upload_to_google_drive')) {
    function upload_to_google_drive($access_token, $file_path, $parent_folder_id = null, $original_name = null) {
        $original_name = $original_name ?: basename($file_path);
        $unique_name = generate_unique_filename($original_name);
        $mime_type = mime_content_type($file_path);
        
        $metadata = [
            'name' => $unique_name,  // Using the unique filename here
            'mimeType' => $mime_type
        ];
        
        if ($parent_folder_id) {
            $metadata['parents'] = [$parent_folder_id];
        }
        
        $boundary = '-------' . uniqid();
        $post_data = "--$boundary\r\n" .
            "Content-Type: application/json; charset=UTF-8\r\n\r\n" .
            json_encode($metadata) . "\r\n" .
            "--$boundary\r\n" .
            "Content-Type: $mime_type\r\n\r\n" .
            file_get_contents($file_path) . "\r\n" .
            "--$boundary--";
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $access_token,
                "Content-Type: multipart/related; boundary=$boundary",
                'Content-Length: ' . strlen($post_data)
            ],
            CURLOPT_POSTFIELDS => $post_data
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return [
            'status' => ($http_code == 200) ? 'success' : 'error',
            'response' => json_decode($response, true),
            'http_code' => $http_code,
            'original_name' => $original_name,
            'unique_name' => $unique_name
        ];
    }
}