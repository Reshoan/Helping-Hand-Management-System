<?php
// models/Service.php
require_once __DIR__ . '/../config/db.php';

class Service {
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM services");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
