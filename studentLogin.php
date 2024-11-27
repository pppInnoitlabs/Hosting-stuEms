<?php
// Include the database connection file
require_once 'database.php';


session_start(); // Start the session to manage user login state

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $identifier = htmlspecialchars($_POST['identifier']); // This can be either student_id or email
    $password = $_POST['password']; // Plain password entered by the user

    // Validation check
    $errors = [];

    if (empty($identifier)) {
        $errors[] = "Student ID or Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If no validation errors, proceed with login
    if (empty($errors)) {
        try {
            // Prepare the SQL statement to fetch user details based on student_id or email
            $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = :student_id OR email = :email LIMIT 1");
            $stmt->bindParam(':student_id', $identifier, PDO::PARAM_STR); // Binding the same identifier for student_id
            $stmt->bindParam(':email', $identifier, PDO::PARAM_STR); // Binding the same identifier for email
            $stmt->execute();

            // Fetch the user data from the database
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the user exists
            if ($user) {
                // Verify the password using password_verify()
                if (password_verify($password, $user['password'])) {
                    // Password is correct, start session and redirect to user dashboard
                    $_SESSION['user_id'] = $user['id']; // Store the user ID in session
                    $_SESSION['username'] = $user['name']; // Store the username in session
                    header("Location: studentDashboard.php"); // Redirect to dashboard page
                    exit();
                } else {
                    $errors[] = "Incorrect password.";
                }
            } else {
                $errors[] = "No user found with that ID or email.";
            }
        } catch (PDOException $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Student Login</h2>

    <?php
    // Display error messages if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
    ?>

    <form action="studentLogin.php" method="POST">
      <!-- Identifier (Student ID or Email) Field -->
      <div class="mb-3">
        <label for="identifier" class="form-label">Student ID or Email</label>
        <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your Student ID or Email" value="<?php echo isset($identifier) ? $identifier : ''; ?>" required>
      </div>

      <!-- Password Field -->
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Login</button>
      <a href="studentRegister.php" class="btn btn-success ms-2">Create New Account</a>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
