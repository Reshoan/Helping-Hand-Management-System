<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database configuration
require_once '../config/db.php';
$conn = Database::getConnection();

// Initialize an array to hold query conditions and parameters
$conditions = [];
$params = [];

// Build filters from GET
if (!empty($_GET['sp_type'])) {
    $conditions[] = "sp.sp_type = :sp_type";
    $params[':sp_type'] = $_GET['sp_type'];
}
if (!empty($_GET['min_experience'])) {
    $conditions[] = "sp.sp_experience >= :min_exp";
    $params[':min_exp'] = $_GET['min_experience'];
}
if (!empty($_GET['max_experience'])) {
    $conditions[] = "sp.sp_experience <= :max_exp";
    $params[':max_exp'] = $_GET['max_experience'];
}
if (!empty($_GET['max_salary'])) {
    $conditions[] = "sp.sp_expected_salary <= :max_salary";
    $params[':max_salary'] = $_GET['max_salary'];
}
if (!empty($_GET['sp_gender'])) {
    $conditions[] = "sp.sp_gender = :sp_gender";
    $params[':sp_gender'] = $_GET['sp_gender'];
}

// Base query
$sql = "SELECT sp.sp_type, sp.sp_experience, sp.sp_expected_salary, sp.sp_gender, u.us_name 
        FROM Service_Provider sp
        JOIN Users u ON sp.sp_id = u.us_id";

if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Execute query based on connection type
$providers = [];

if ($conn instanceof PDO) {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif (is_resource($conn) && get_resource_type($conn) === 'oci8 connection') {
    $ociParams = $params;
    foreach ($ociParams as $key => $value) {
        $ociParams[trim($key, ':')] = $value;
        unset($ociParams[$key]);
    }

    $stid = oci_parse($conn, $sql);
    foreach ($ociParams as $key => $value) {
        oci_bind_by_name($stid, ":$key", $ociParams[$key]);
    }

    oci_execute($stid);
    while ($row = oci_fetch_assoc($stid)) {
        $providers[] = $row;
    }
    oci_free_statement($stid);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Providers</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Providers for <?php echo htmlspecialchars($_GET['service_id']); ?></h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Experience</th>
                    <th>Expected Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($providers as $index => $provider): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($provider['sp_name']); ?></td>
                        <td><?php echo htmlspecialchars($provider['sp_phone_no']); ?></td>
                        <td><?php echo htmlspecialchars($provider['sp_email']); ?></td>
                        <td><?php echo htmlspecialchars($provider['sp_address']); ?></td>
                        <td><?php echo htmlspecialchars($provider['sp_experience']); ?> years</td>
                        <td><?php echo htmlspecialchars($provider['sp_expected_salary']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
