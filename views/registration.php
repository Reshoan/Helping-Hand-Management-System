<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Registration - Helping Hand System</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <a href="index.html" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">Helping Hand System</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.html" class="nav-item nav-link">Home</a>
                    <a href="about.html" class="nav-item nav-link">About</a>
                    <a href="contact.html" class="nav-item nav-link">Contact</a>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Registration Form Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                            <h2 class="text-center mb-4">Apply for Service Position</h2>
                            <h3 class="text-center mb-4">Register</h3>
                            <form action="../controllers/RegisterController.php" method="POST" id="registrationForm">
                                <div class="mb-3">
                                    <label for="us_id" class="form-label">User ID</label>
                                    <input type="text" class="form-control" id="us_id" name="us_id" required>
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
                                    <input type="text" class="form-control" id="us_address" name="us_address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="us_phone_no" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="us_phone_no" name="us_phone_no" required>
                                </div>
                                <div class="mb-3">
                                    <label for="us_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="us_email" name="us_email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="us_type" class="form-label">User Type</label>
                                    <select class="form-control" id="us_type" name="us_type" required onchange="toggleServiceProviderFields()">
                                        <option value="general_user">General User</option>
                                        <option value="service_provider">Service Provider</option>
                                    </select>
                                </div>

                                <!-- Service Provider Fields -->
                                <div id="serviceProviderFields" style="display: none;">
                                    <div class="mb-3">
                                        <label for="sp_experience" class="form-label">Experience (Years)</label>
                                        <input type="number" class="form-control" id="sp_experience" name="sp_experience">
                                    </div>
                                    <div class="mb-3">
                                        <label for="sp_gender" class="form-label">Gender</label>
                                        <select class="form-control" id="sp_gender" name="sp_gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sp_dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="sp_dob" name="sp_dob">
                                    </div>
                                    <div class="mb-3">
                                        <label for="sp_nid_no" class="form-label">NID Number</label>
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
                                    <div class="mb-3">
                                        <label for="sp_type" class="form-label">Service Type</label>
                                        <input type="text" class="form-control" id="sp_type" name="sp_type">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3">Register</button>
                            </form>
                            <p class="text-center mt-3">Already have an account? <a href="login.html" class="text-primary">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Registration Form End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
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

    <script>
        function toggleServiceProviderFields() {
            const userType = document.getElementById('us_type').value;
            const serviceProviderFields = document.getElementById('serviceProviderFields');
            if (userType === 'service_provider') {
                serviceProviderFields.style.display = 'block';
            } else {
                serviceProviderFields.style.display = 'none';
            }
        }
    </script>
</body>

</html>