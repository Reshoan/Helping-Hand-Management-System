<?php
// RegisterController.php
require_once '../models/UserModel.php';

class RegisterController
{
    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'name' => $_POST['name'],
                'password' => $_POST['password'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'type' => $_POST['type']
            ];

            $spData = null;
            $spTypeData = null;

            if ($userData['type'] === 'service_provider') {
                $spData = [
                    'experience' => $_POST['experience'],
                    'gender' => $_POST['gender'],
                    'dob' => $_POST['dob'],
                    'nid' => $_POST['nid'],
                    'expected_salary' => $_POST['expected_salary'],
                    'education' => $_POST['education'],
                    'certification' => $_POST['certification'],
                    'sp_type' => $_POST['sp_type']
                ];

                switch ($spData['sp_type']) {
                    case 'cook':
                        $spTypeData = [
                            'cuisine_expertise' => $_POST['cuisine_expertise'],
                            'max_people_served' => $_POST['max_people_served']
                        ];
                        break;
                    case 'chauffer':
                        $spTypeData = [
                            'vehicle_types' => $_POST['vehicle_types'],
                            'licence_doc' => $_POST['licence_doc'],
                            'licence_valid_until' => $_POST['licence_valid_until']
                        ];
                        break;
                    case 'cleaners':
                        $spTypeData = [
                            'employment_type' => $_POST['employment_type']
                        ];
                        break;
                    // Add other service provider types similarly
                }
            }

            $userModel = new UserModel();
            $result = $userModel->register($userData, $spData, $spTypeData);

            if ($result) {
                echo "Registration successful!";
            } else {
                echo "Registration failed.";
            }
        }
    }
}

// Usage (if this file is hit directly)
$controller = new RegisterController();
$controller->registerUser();
