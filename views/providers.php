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
    <meta charset="utf-8">
    <title>Service Provider Filter</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <a href="index.html" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary fs-4">HELPING HAND MANAGEMENT SYSTEM</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.html" class="nav-item nav-link">Home</a>
                    <a href="register.php" class="nav-item nav-link">Registration</a>
                    <a href="providers.php" class="nav-item nav-link active">Providers</a>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Filter Form Start -->
        <div class="container py-5">
            <h1 class="text-center mb-5">Filter Service Providers</h1>
            <form method="GET" action="providers.php" class="row g-3">
                <div class="col-md-4">
                    <label for="sp_type" class="form-label">Service Type</label>
                    <select name="sp_type" id="sp_type" class="form-select">
                        <option value="">--Select--</option>
                        <?php
                        $types = ['cook', 'chauffer', 'security guard', 'relocators', 'cleaners', 'baby sitter', 'masseuse', 'plumber', 'electrician', 'gardener'];
                        foreach ($types as $type) {
                            $selected = (isset($_GET['sp_type']) && $_GET['sp_type'] == $type) ? 'selected' : '';
                            echo "<option value=\"$type\" $selected>" . ucfirst($type) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="min_experience" class="form-label">Minimum Experience (years)</label>
                    <input type="number" name="min_experience" id="min_experience" class="form-control" value="<?= htmlspecialchars(isset($_GET['min_experience']) ? $_GET['min_experience'] : '') ?>">
                </div>
                <div class="col-md-4">
                    <label for="max_experience" class="form-label">Maximum Experience (years)</label>
                    <input type="number" name="max_experience" id="max_experience" class="form-control" value="<?= htmlspecialchars(isset($_GET['max_experience']) ? $_GET['max_experience'] : '') ?>">
                </div>
                <div class="col-md-4">
                    <label for="max_salary" class="form-label">Maximum Expected Salary</label>
                    <input type="number" name="max_salary" id="max_salary" class="form-control" value="<?= htmlspecialchars(isset($_GET['max_salary']) ? $_GET['max_salary'] : '') ?>">
                </div>
                <div class="col-md-4">
                    <label for="sp_gender" class="form-label">Gender</label>
                    <select name="sp_gender" id="sp_gender" class="form-select">
                        <option value="">--Select--</option>
                        <option value="Male" <?= (isset($_GET['sp_gender']) && $_GET['sp_gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= (isset($_GET['sp_gender']) && $_GET['sp_gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
        <!-- Filter Form End -->

        <!-- Providers List Start -->
        <div class="container py-5">
            <h2 class="text-center mb-5">Service Providers</h2>
            <div class="row g-4">
                <?php if ($providers): ?>
                    <?php foreach ($providers as $provider): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="provider-card bg-light rounded p-4">
                                <h5 class="mb-3"><?= htmlspecialchars(isset($provider['US_NAME']) ? $provider['US_NAME'] : (isset($provider['us_name']) ? $provider['us_name'] : 'N/A')) ?></h5>
                                <p><strong>Type:</strong> <?= htmlspecialchars(isset($provider['SP_TYPE']) ? $provider['SP_TYPE'] : (isset($provider['sp_type']) ? $provider['sp_type'] : 'N/A')) ?></p>
                                <p><strong>Experience:</strong> <?= htmlspecialchars(isset($provider['SP_EXPERIENCE']) ? $provider['SP_EXPERIENCE'] : (isset($provider['sp_experience']) ? $provider['sp_experience'] : 'N/A')) ?> years</p>
                                <p><strong>Expected Salary:</strong> <?= htmlspecialchars(isset($provider['SP_EXPECTED_SALARY']) ? $provider['SP_EXPECTED_SALARY'] : (isset($provider['sp_expected_salary']) ? $provider['sp_expected_salary'] : 'N/A')) ?></p>
                                <p><strong>Gender:</strong> <?= htmlspecialchars(isset($provider['SP_GENDER']) ? $provider['SP_GENDER'] : (isset($provider['sp_gender']) ? $provider['sp_gender'] : 'N/A')) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No service providers found matching the selected criteria.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Providers List End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Company</h5>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Quick Links</h5>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Contact</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Newsletter</h5>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>