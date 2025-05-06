<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login($email, $password) {
        $user = User::findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: /views/user/profile.php');
        } else {
            echo "Invalid credentials";
        }
    }

    public function register($data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['password'] = $hashedPassword;
        $result = User::create($data);
        if ($result) {
            header('Location: /views/auth/login.php');
        } else {
            echo "Registration failed.";
        }
    }
}