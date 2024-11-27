<?php
// Include the database connection file
require_once 'database.php';


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $student_id = htmlspecialchars($_POST['student_id']);

    // Validation checks
    $errors = [];

    // Check if name is not empty
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    // Validate mobile (10 digits and numeric)
    if (empty($mobile) || !preg_match('/^\d{10}$/', $mobile)) {
        $errors[] = "Mobile number must be exactly 10 digits.";
    }

 

    // If no errors, proceed with registration
    if (empty($errors)) {
        try {
           

            // Prepare the SQL statement to insert data
            $stmt = $pdo->prepare("INSERT INTO teachers (name, email, mobile, teacher_id) 
                                    VALUES (:name, :email, :mobile, :student_id)");

            // Bind parameters to the statement
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mobile', $mobile);
            $stmt->bindParam(':student_id', $student_id);

            // Execute the statement
            $stmt->execute();
            header("Location: adminDashboard.php");


            echo "<div class='alert alert-success'>Teacher registered successfully!</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Registration Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    // Function to generate a random unique student ID
    function generateStudentId() {
      const randomId = "teac" + Math.floor(100 + Math.random() * 900); // Generates a number like std100-std999
      document.getElementById("student_id").value = randomId; // Assigns the generated ID to the student_id field
    }

    // Generate the ID when the page loads
    window.onload = generateStudentId;
  </script>
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Creating Teacher Account</h2>
    <form action="adminCreateTeacher.php" method="POST">
      <!-- Name Field -->
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
      </div>

      <!-- Email Field -->
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
      </div>

      <!-- Mobile Number Field -->
      <div class="mb-3">
        <label for="mobile" class="form-label">Mobile Number</label>
        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
      </div>
      <!-- Student ID Field (Read-only) -->
      <div class="mb-3">
        <label for="student_id" class="form-label">Teacher ID</label>
        <input type="text" class="form-control" id="student_id" name="student_id" readonly>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Register</button>
      <a href="teacherLogin.php" class="btn btn-success ms-2">if already have account Login here...</a>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
