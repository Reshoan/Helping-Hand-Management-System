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
    // === PDO EXECUTION ===
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} elseif (is_resource($conn) && get_resource_type($conn) === 'oci8 connection') {
    // === OCI8 EXECUTION ===
    $ociParams = $params;
    foreach ($ociParams as $key => $value) {
        $ociParams[trim($key, ':')] = $value; // Remove colon for oci_bind_by_name
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
<html>
<head>
    <title>Service Provider Filter</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .filter-form { margin-bottom: 20px; }
        .provider-card { border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Filter Service Providers</h1>

    <form method="GET" action="providers.php" class="filter-form">
        <label for="sp_type">Service Type:</label>
        <select name="sp_type" id="sp_type">
            <option value="">--Select--</option>
            <?php
            $types = ['cook', 'chauffer', 'security guard', 'relocators', 'cleaners', 'baby sitter', 'masseuse', 'plumber', 'electrician', 'gardener'];
            foreach ($types as $type) {
                $selected = (isset($_GET['sp_type']) && $_GET['sp_type'] == $type) ? 'selected' : '';
                echo "<option value=\"$type\" $selected>" . ucfirst($type) . "</option>";
            }
            ?>
        </select><br><br>

        <label for="min_experience">Minimum Experience (years):</label>
        <input type="number" name="min_experience" id="min_experience" value="<?= htmlspecialchars(isset($_GET['min_experience']) ? $_GET['min_experience'] : '') ?>"><br><br>

        <label for="max_experience">Maximum Experience (years):</label>
        <input type="number" name="max_experience" id="max_experience" value="<?= htmlspecialchars(isset($_GET['max_experience']) ? $_GET['max_experience'] : '') ?>"><br><br>

        <label for="max_salary">Maximum Expected Salary:</label>
        <input type="number" name="max_salary" id="max_salary" value="<?= htmlspecialchars(isset($_GET['max_salary']) ? $_GET['max_salary'] : '') ?>"><br><br>

        <label for="sp_gender">Gender:</label>
        <select name="sp_gender" id="sp_gender">
            <option value="">--Select--</option>
            <option value="Male" <?= (isset($_GET['sp_gender']) && $_GET['sp_gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (isset($_GET['sp_gender']) && $_GET['sp_gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
        </select><br><br>

        <button type="submit">Apply Filters</button>
    </form>

    <h2>Service Providers</h2>
    <?php if ($providers): ?>
        <?php foreach ($providers as $provider): ?>
            <div class="provider-card">
                <p><strong>Name:</strong> <?= htmlspecialchars(isset($provider['US_NAME']) ? $provider['US_NAME'] : (isset($provider['us_name']) ? $provider['us_name'] : 'N/A')) ?></p>
                <p><strong>Type:</strong> <?= htmlspecialchars(isset($provider['SP_TYPE']) ? $provider['SP_TYPE'] : (isset($provider['sp_type']) ? $provider['sp_type'] : 'N/A')) ?></p>
                <p><strong>Experience:</strong> <?= htmlspecialchars(isset($provider['SP_EXPERIENCE']) ? $provider['SP_EXPERIENCE'] : (isset($provider['sp_experience']) ? $provider['sp_experience'] : 'N/A')) ?> years</p>
                <p><strong>Expected Salary:</strong> <?= htmlspecialchars(isset($provider['SP_EXPECTED_SALARY']) ? $provider['SP_EXPECTED_SALARY'] : (isset($provider['sp_expected_salary']) ? $provider['sp_expected_salary'] : 'N/A')) ?></p>
                <p><strong>Gender:</strong> <?= htmlspecialchars(isset($provider['SP_GENDER']) ? $provider['SP_GENDER'] : (isset($provider['sp_gender']) ? $provider['sp_gender'] : 'N/A')) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No service providers found matching the selected criteria.</p>
    <?php endif; ?>
</body>
</html>
