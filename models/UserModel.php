<?php
require_once(__DIR__ . '/../config/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class UserModel {
    private $conn;

    public function __construct() {
        // Initialize the database connection
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function registerUser($data) {
        try {
            // No password hashing, store plain text password
            $plainPassword = $data['password'];

            // Insert the user data into the Users table
            $query = "INSERT INTO Users (us_id, us_name, us_password, us_address, us_phone_no, us_email, us_type)
                      VALUES (:id, :name, :password, :address, :phone, :email, :type)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':password', $plainPassword); // Storing plain password
            $stmt->bindParam(':address', $data['address']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':type', $data['type']);

            $stmt->execute();

            if ($data['type'] === 'service_provider') {
                $spQuery = "INSERT INTO Service_Provider (
                    sp_id, sp_experience, sp_gender, sp_dob, sp_nid_no,
                    sp_expected_salary, sp_education, sp_certification, sp_type
                ) VALUES (
                    :id, :experience, :gender, TO_DATE(:dob, 'YYYY-MM-DD'), :nid, :salary,
                    :education, :certification, :sp_type)";

                $spStmt = $this->conn->prepare($spQuery);
                $spStmt->bindParam(':id', $data['id']);
                $spStmt->bindParam(':experience', $data['experience']);
                $spStmt->bindParam(':gender', $data['gender']);
                $spStmt->bindParam(':dob', $data['dob']);
                $spStmt->bindParam(':nid', $data['nid']);
                $spStmt->bindParam(':salary', $data['salary']);
                $spStmt->bindParam(':education', $data['education']);
                $spStmt->bindParam(':certification', $data['certification']);
                $spStmt->bindParam(':sp_type', $data['sp_type']);

                $spStmt->execute();
            }

            echo "User registration successful!";
        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("PDO Error: " . $e->getMessage());
        }
    }
    

}
