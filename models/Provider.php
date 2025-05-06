<?php
// models/Provider.php
require_once __DIR__ . '/../config/db.php';

class Provider {
    public static function findByService($serviceId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM providers WHERE service_id = :service_id");
        $stmt->bindParam(':service_id', $serviceId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM providers WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE providers SET name = :name, address = :address, phone = :phone, email = :email, experience = :experience, gender = :gender, dob = :dob, nid = :nid, rate = :rate, education = :education, certifications = :certifications, references = :references, hours = :hours WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':experience', $data['experience']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':dob', $data['dob']);
        $stmt->bindParam(':nid', $data['nid']);
        $stmt->bindParam(':rate', $data['rate']);
        $stmt->bindParam(':education', $data['education']);
        $stmt->bindParam(':certifications', $data['certifications']);
        $stmt->bindParam(':references', $data['references']);
        $stmt->bindParam(':hours', $data['hours']);
        return $stmt->execute();
    }

    public static function getJobOffers($providerId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM job_offers WHERE provider_id = :provider_id");
        $stmt->bindParam(':provider_id', $providerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function filter($criteria) {
        $db = Database::getConnection();
        $query = "SELECT * FROM providers WHERE 1=1";

        if (!empty($criteria['gender'])) {
            $query .= " AND gender = :gender";
        }
        if (!empty($criteria['age'])) {
            $query .= " AND TIMESTAMPDIFF(YEAR, dob, CURDATE()) = :age";
        }
        if (!empty($criteria['experience'])) {
            $query .= " AND experience >= :experience";
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