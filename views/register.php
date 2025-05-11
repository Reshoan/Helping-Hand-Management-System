<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script>
        function toggleSPFields() {
            var type = document.getElementById('us_type').value;
            document.getElementById('sp_fields').style.display = (type === 'service_provider') ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h2>User Registration</h2>

    <?php if (isset($_GET['success'])) echo "<p style='color:green;'>Registration Successful!</p>"; ?>

    <form method="post" action="../controllers/RegisterController.php">
        <label>User ID:</label><input type="number" name="us_id" required><br>
        <label>Name:</label><input type="text" name="us_name" required><br>
        <label>Password:</label><input type="password" name="us_password" required><br>
        <label>Address:</label><input type="text" name="us_address"><br>
        <label>Phone No:</label><input type="text" name="us_phone_no"><br>
        <label>Email:</label><input type="email" name="us_email"><br>
        <label>Type:</label>
        <select name="us_type" id="us_type" onchange="toggleSPFields()">
            <option value="customer">Customer</option>
            <option value="service_provider">Service Provider</option>
        </select><br><br>

        <div id="sp_fields" style="display:none;">
            <h3>Service Provider Details</h3>
            <label>Experience:</label><input type="number" name="sp_experience"><br>
            <label>Gender:</label>
            <select name="sp_gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select><br>
            <label>Date of Birth:</label><input type="date" name="sp_dob"><br>
            <label>NID No:</label><input type="text" name="sp_nid_no"><br>
            <label>Expected Salary:</label><input type="number" name="sp_expected_salary"><br>
            <label>Education:</label><input type="text" name="sp_education"><br>
            <label>Certification:</label><input type="text" name="sp_certification"><br>
            <label>Service Type:</label>
            <select name="sp_type">
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
            </select><br>
        </div>

        <br><input type="submit" value="Register">
    </form>
</body>
</html>
