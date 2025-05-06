<?php
// controllers/ServiceController.php
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Provider.php';

class ServiceController {
    public function index() {
        $services = Service::all();
        include __DIR__ . '/../views/services/index.php';
    }

    public function showProviders($serviceId) {
        $providers = Provider::findByService($serviceId);
        include __DIR__ . '/../views/services/show.php';
    }
}
