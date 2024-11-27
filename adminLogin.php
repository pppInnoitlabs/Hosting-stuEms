<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve input data
    $login_id = htmlspecialchars(trim($_POST['login_id'])); // Email or Mobile
    $password = trim($_POST['password']); // Password entered by admin

    // Validation check
    if (empty($login_id) || empty($password)) {
        echo "<div class='alert alert-danger'>Please enter both email/mobile and password.</div>";
    } else {
        try {
            // Prepare SQL query to fetch admin by email or mobile
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = :email OR mobile = :mobile LIMIT 1");

            // Debugging: Show the SQL query and parameters
            echo "SQL Query: SELECT * FROM admins WHERE email = :email OR mobile = :mobile LIMIT 1<br>";
            echo "Binding email: $login_id<br>";
            echo "Binding mobile: $login_id<br>";

            // Bind the parameters
            $stmt->bindParam(':email', $login_id);
            $stmt->bindParam(':mobile', $login_id);
            $stmt->execute();

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if admin is found and verify the password
            if ($admin && password_verify($password, $admin['password'])) {
                // Start session and store admin data
                session_start();
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];

                // Redirect to admin dashboard
                header("Location: adminDashboard.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Invalid email/mobile or password.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Login</h2>
        <form action="adminLogin.php" method="POST">
            <!-- Login ID (Email or Mobile) -->
            <div class="mb-3">
                <label for="login_id" class="form-label">Email or Mobile</label>
                <input type="text" class="form-control" id="login_id" name="login_id" placeholder="Enter your email or mobile number" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="adminRegistration.php" class="btn btn-success ms-2">Create New Account</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
