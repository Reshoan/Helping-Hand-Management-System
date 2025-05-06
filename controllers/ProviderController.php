<?php
// controllers/ProviderController.php
require_once __DIR__ . '/../models/Provider.php';

class ProviderController {
    public function dashboard($providerId) {
        $provider = Provider::find($providerId);
        $jobs = Provider::getJobOffers($providerId);
        include __DIR__ . '/../views/provider/dashboard.php';
    }

    public function updateProfile($providerId, $data) {
        $result = Provider::update($providerId, $data);
        if ($result) {
            header('Location: /views/provider/dashboard.php');
        } else {
            echo "Update failed.";
        }
    }
}
