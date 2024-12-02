<?php



$config['default_vars'] = [
    'dateFormat' => 'd-m-Y',
    'max_upload_size' => 1024 * ( 1024 * 2) // 2MB 

];
$config['document_path'] = 'd';
$config['theme_id'] = '1'; 
$config['theme'] = 'theme-02';
//Notice : Please Do Not Change Any Config ⚙️Setting
$config['duration_type'] = [
    'year' => 'Year',
    'semester' => 'Semester',
    'month' => 'Month'
];
$config['upload_ducuments'] = ['admission_form' => 'Admission Form','family_id_document' => 'Famly Id Document','tenth_marksheet' => '10th Marksheet','tenth_plus_marksheet' => '10th+ Marksheet'];

$config['mobile_types'] = ['self' => 'Self','brother' => 'Brother','sister' => 'Sister','mother' => 'Mother','husband' => 'Husband','father' => 'Father','guardian' => 'Guardian'];
$config['open_links'] = [
    'admit_card' => 'admit-card',
    'marksheet'  => 'marksheet',
    'certificate'  => 'certificate',
    'center_certificate' => 'franchise-certificate'
];