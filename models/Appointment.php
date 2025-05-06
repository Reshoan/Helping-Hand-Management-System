<?php
// models/Appointment.php
require_once __DIR__ . '/../config/db.php';

class Appointment {
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO appointments (user_id, provider_id, service_id, scheduled_at, status) VALUES (:user_id, :provider_id, :service_id, :scheduled_at, :status)");
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':provider_id', $data['provider_id']);
        $stmt->bindParam(':service_id', $data['service_id']);
        $stmt->bindParam(':scheduled_at', $data['scheduled_at']);
        $stmt->bindParam(':status', $data['status']);
        return $stmt->execute();
    }

    public static function findByUser($userId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM appointments WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByProvider($providerId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM appointments WHERE provider_id = :provider_id");
        $stmt->bindParam(':provider_id', $providerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($id, $status) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE appointments SET status = :status WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
}
