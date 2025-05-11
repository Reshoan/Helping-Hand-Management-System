<!-- views/customer_dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['us_id']) || $_SESSION['us_type'] !== 'customer') {
    header("Location: login.php");
    exit;
}
echo "<h2>Welcome, " . htmlspecialchars($_SESSION['us_name']) . " (Customer)</h2>";
?>
<a href="../public/logout.php">Logout</a>
