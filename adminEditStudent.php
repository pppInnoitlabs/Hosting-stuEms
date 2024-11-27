<?php
// Include the database connection file
require_once 'database.php';


// Fetch student details based on the provided ID
$studentData = [];
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Prepare the SQL query to fetch data
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the record
        $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$studentData) {
            echo "<div class='alert alert-danger'>No student found with ID: $id</div>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>No student ID provided!</div>";
    exit;
}

// Handle form submission to update the details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $student_id = htmlspecialchars($_POST['student_id']); // Hidden field

    // Validation checks
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    if (empty($mobile) || !preg_match('/^\d{10}$/', $mobile)) {
        $errors[] = "Mobile number must be exactly 10 digits.";
    }

    // If no errors, proceed with updating the record
    if (empty($errors)) {
        try {
            // Prepare the SQL statement to update data
            $stmt = $pdo->prepare("UPDATE students 
                                    SET name = :name, email = :email, mobile = :mobile 
                                    WHERE id = :id");
            
            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mobile', $mobile);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute the update
            $stmt->execute();

            echo "<div class='alert alert-success'>Student details updated successfully!</div>";
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
  <title>Edit Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Edit Student Details</h2>
    <form action="adminEditStudent.php?id=<?php echo $id; ?>" method="POST">
      <!-- Name Field -->
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($studentData['name']); ?>" required>
      </div>

      <!-- Email Field -->
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($studentData['email']); ?>" required>
      </div>

      <!-- Mobile Number Field -->
      <div class="mb-3">
        <label for="mobile" class="form-label">Mobile Number</label>
        <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo htmlspecialchars($studentData['mobile']); ?>" required>
      </div>

      <!-- Hidden Student ID Field -->
      <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($studentData['student_id']); ?>">

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
