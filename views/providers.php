<!-- filepath: c:\xampp\htdocs\HHMS\views\services\providers.php -->
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