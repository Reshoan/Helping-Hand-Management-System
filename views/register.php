<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register - Helping Hand Management System</title>
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

    <script>
        function toggleSPFields() {
            var type = document.getElementById('us_type').value;
            document.getElementById('sp_fields').style.display = (type === 'service_provider') ? 'block' : 'none';
        }
    </script>
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
                    <a href="register.php" class="nav-item nav-link active">Registration</a>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Registration Form Start -->
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-light rounded p-4 p-sm-5">
                        <h2 class="text-center mb-4">User Registration</h2>
                        <?php if (isset($_GET['success'])) echo "<p class='text-success text-center'>Registration Successful!</p>"; ?>
                        <form method="post" action="../controllers/RegisterController.php">
                            <div class="mb-3">
                                <label for="us_id" class="form-label">User ID</label>
                                <input type="number" class="form-control" id="us_id" name="us_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="us_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="us_name" name="us_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="us_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="us_password" name="us_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="us_address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="us_address" name="us_address">
                            </div>
                            <div class="mb-3">
                                <label for="us_phone_no" class="form-label">Phone No</label>
                                <input type="text" class="form-control" id="us_phone_no" name="us_phone_no">
                            </div>
                            <div class="mb-3">
                                <label for="us_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="us_email" name="us_email">
                            </div>
                            <div class="mb-3">
                                <label for="us_type" class="form-label">Type</label>
                                <select class="form-select" id="us_type" name="us_type" onchange="toggleSPFields()">
                                    <option value="customer">Customer</option>
                                    <option value="service_provider">Service Provider</option>
                                </select>
                            </div>
                            <div id="sp_fields" style="display:none;">
                                <h4 class="mt-4">Service Provider Details</h4>
                                <div class="mb-3">
                                    <label for="sp_type" class="form-label">Service Type</label>
                                    <select class="form-select" id="sp_type" name="sp_type">
                                        <option value="cook">Cook</option>
                                        <option value="chauffer">Chauffer</option>
                                        <option value="security guard">Security Guard</option>
                                        <option value="relocators">Relocators</option>
                                        <option value="cleaners">Cleaners</option>
                                        <option value="baby sitter">Babysitter</option>
                                        <option value="masseuse">Masseuse</option>
                                        <option value="plumber">Plumber</option>
                                        <option value="electrician">Electrician</option>
                                        <option value="gardener">Gardener</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="sp_experience" class="form-label">Experience</label>
                                    <input type="number" class="form-control" id="sp_experience" name="sp_experience">
                                </div>
                                <div class="mb-3">
                                    <label for="sp_gender" class="form-label">Gender</label>
                                    <select class="form-select" id="sp_gender" name="sp_gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="sp_dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="sp_dob" name="sp_dob">
                                </div>
                                <div class="mb-3">
                                    <label for="sp_nid_no" class="form-label">NID No</label>
                                    <input type="text" class="form-control" id="sp_nid_no" name="sp_nid_no">
                                </div>
                                <div class="mb-3">
                                    <label for="sp_expected_salary" class="form-label">Expected Salary</label>
                                    <input type="number" class="form-control" id="sp_expected_salary" name="sp_expected_salary">
                                </div>
                                <div class="mb-3">
                                    <label for="sp_education" class="form-label">Education</label>
                                    <input type="text" class="form-control" id="sp_education" name="sp_education">
                                </div>
                                <div class="mb-3">
                                    <label for="sp_certification" class="form-label">Certification</label>
                                    <input type="text" class="form-control" id="sp_certification" name="sp_certification">
                                </div>
                                
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Registration Form End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer mt-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="text-white" href="#">Helping Hand Management System</a>, All Rights Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="#">Home</a>
                            <a href="#">Privacy</a>
                            <a href="#">Terms</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
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
