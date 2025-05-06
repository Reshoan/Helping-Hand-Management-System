<!-- filepath: c:\xampp\htdocs\HHMS\views\services\show.php -->
<?php
require_once __DIR__ . '/../../controllers/ServiceController.php';

if (isset($_GET['service_id'])) {
    $serviceId = $_GET['service_id'];
    $controller = new ServiceController();
    $controller->showProviders($serviceId);
} else {
    echo "Invalid service selected.";
}
?>