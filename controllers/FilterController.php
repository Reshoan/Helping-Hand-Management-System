<?php
// controllers/FilterController.php
require_once __DIR__ . '/../models/Provider.php';

class FilterController {
    public function filter($criteria) {
        $providers = Provider::filter($criteria);
        echo json_encode($providers);
    }
}
