<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Database Field Encryption Configuration
|--------------------------------------------------------------------------
|
| This file defines which fields should be encrypted in each database table.
| Each table is listed as an array key, and the value is an array of field names
| that should be encrypted.
|
*/

$config['encrypted_fields'] = array(
    // Patient table - personal and sensitive information
    'patient' => array(
        'name',
        'phone',
        'address',
        'birthdate',
        'bloodgroup',
        'sex',
        'add_date',
        'registration_time', 
        'social_history',
        'family_history',
        'medical_history',
        'other_history',
        'id_number'
    ),
    
    // Doctor table
    'doctor' => array(
        'name',
        'email',
        'phone',
        'address',
        'profile'
    ),
    
    // Medical history
    'medical_history' => array(
        'description',
        'patient_name',
        'patient_address',
        'patient_phone',
        'patient_email'
    ),
    
    // Prescription
    'prescription' => array(
        'symptom',
        'diagnosis',
        'medicine',
        'note'
    ),
    
    // Lab
    'lab' => array(
        'report',
        'test_status'
    ),
    
    // Payment
    'payment' => array(
        'patient_name',
        'patient_phone',
        'patient_address',
        'doctor_name',
        'remarks'
    ),
    
    // Appointment
    'appointment' => array(
        'remarks',
        'status',
        'patient_name',
        'patient_phone',
        'patient_address'
    ),
    
    // Add more tables and fields as needed
); 