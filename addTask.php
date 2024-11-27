<?php
require 'database.php'; // Include the database connection file

// Fetch all students from the database for the dropdown list
$sql = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS full_name FROM students";
$stmt = $pdo->query($sql);
$students = $stmt->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $taskname = $_POST['taskname'];
    $assignTo = $_POST['assignTo'];
    $status = $_POST['status'];

    // If assigned to a student, we need the student_id
    if ($assignTo === 'student') {
        $student_id = $_POST['student_id'];
        // Insert task into studentTask table
        $sql = "INSERT INTO studentTask (taskname, assignTo, status, student_id) 
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$taskname, $assignTo, $status, $student_id]);
    } else {
        // If assigned to all students, insert into studentsAlltask table
        $sql = "INSERT INTO studentsAlltask (taskname, assignTo, status) 
                VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$taskname, $assignTo, $status]);
    }

    // Redirect or display success message
    echo "Task added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Add Task</h1>

    <form method="POST" action="addTask.php">
        <div class="mb-3">
            <label for="taskname" class="form-label">Task Name</label>
            <input type="text" class="form-control" id="taskname" name="taskname" required>
        </div>
        
        <div class="mb-3">
            <label for="assignTo" class="form-label">Assign To</label>
            <select class="form-select" id="assignTo" name="assignTo" required>
                <option value="student">Student</option>
                <option value="allstudents">All Students</option>
            </select>
        </div>

        <!-- Show Student Dropdown when 'Assign To' is 'Student' -->
        <div class="mb-3" id="studentIdField" style="display: none;">
            <label for="student_id" class="form-label">Select Student</label>
            <select class="form-select" id="student_id" name="student_id">
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['student_id']; ?>"><?= $student['full_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="start">Start</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS and jQuery to handle dynamic field display -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle the student_id field based on assignTo selection
    document.getElementById('assignTo').addEventListener('change', function () {
        var studentIdField = document.getElementById('studentIdField');
        if (this.value === 'student') {
            studentIdField.style.display = 'block';
        } else {
            studentIdField.style.display = 'none';
        }
    });
</script>
</body>
</html>
