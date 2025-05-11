<?php
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../models/UserModel.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new UserModel();

    $data = [
        'id' => $_POST['us_id'],
        'name' => $_POST['us_name'],
        'password' => $_POST['us_password'],
        'address' => $_POST['us_address'],
        'phone' => $_POST['us_phone_no'],
        'email' => $_POST['us_email'],
        'type' => $_POST['us_type'],
        'experience' => isset($_POST['sp_experience']) ? $_POST['sp_experience'] : null,
        'gender' => isset($_POST['sp_gender']) ? $_POST['sp_gender'] : null,
        'dob' => isset($_POST['sp_dob']) ? $_POST['sp_dob'] : null,
        'nid' => isset($_POST['sp_nid_no']) ? $_POST['sp_nid_no'] : null,
        'salary' => isset($_POST['sp_expected_salary']) ? $_POST['sp_expected_salary'] : null,
        'education' => isset($_POST['sp_education']) ? $_POST['sp_education'] : null,
        'certification' => isset($_POST['sp_certification']) ? $_POST['sp_certification'] : null,
        'sp_type' => isset($_POST['sp_type']) ? $_POST['sp_type'] : null
    ];

    $user->registerUser($data);
    header("Location: ../views/register.php?success=1");
    exit;
}
