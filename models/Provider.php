<?php
// models/Provider.php
require_once __DIR__ . '/../config/db.php';

class Provider {
    public static function findByService($serviceId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM Service_Provider WHERE s_id = :service_id");
        $stmt->bindParam(':service_id', $serviceId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM Service_Provider WHERE sp_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE Service_Provider 
            SET sp_name = :name, sp_address = :address, sp_phone_no = :phone, sp_email = :email, 
                sp_experience = :experience, sp_gender = :gender, sp_dob = :dob, sp_nid_no = :nid, 
                sp_expected_salary = :salary, sp_education = :education, sp_certification = :certification 
            WHERE sp_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':experience', $data['experience']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':dob', $data['dob']);
        $stmt->bindParam(':nid', $data['nid']);
        $stmt->bindParam(':salary', $data['salary']);
        $stmt->bindParam(':education', $data['education']);
        $stmt->bindParam(':certification', $data['certification']);
        return $stmt->execute();
    }

    public static function getJobOffers($providerId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM job_offers WHERE sp_id = :provider_id");
        $stmt->bindParam(':provider_id', $providerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function filter($criteria) {
        $db = Database::getConnection();
        $query = "SELECT * FROM Service_Provider WHERE 1=1";

        if (!empty($criteria['gender'])) {
            $query .= " AND sp_gender = :gender";
        }
        if (!empty($criteria['age'])) {
            $query .= " AND TIMESTAMPDIFF(YEAR, sp_dob, CURDATE()) = :age";
        }
        if (!empty($criteria['experience'])) {
            $query .= " AND sp_experience >= :experience";
        }

        $stmt = $db->prepare($query);

        if (!empty($criteria['gender'])) {
            $stmt->bindParam(':gender', $criteria['gender']);
        }
        if (!empty($criteria['age'])) {
            $stmt->bindParam(':age', $criteria['age']);
        }
        if (!empty($criteria['experience'])) {
            $stmt->bindParam(':experience', $criteria['experience']);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}