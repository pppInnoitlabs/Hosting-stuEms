<?php
// Include the database connection file
require_once 'database.php';

// Fetch students for dropdown list
$stmt = $pdo->query("SELECT student_id, name FROM students");
$students = $stmt->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $taskname = $_POST['taskname'];
    $assignTo = $_POST['assignTo']; // Whether to assign to a student or all students
    $status = 'start'; // Status is always "start" when creating the task

    if ($assignTo == 'student') {
        $student_id = $_POST['student_id'];
        // Insert the task into the studentTask table
        $sql = "INSERT INTO studentTask (taskname, assignTo, student_id, status) 
                VALUES (:taskname, :assignTo, :student_id, :status)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':taskname', $taskname);
        $stmt->bindParam(':assignTo', $assignTo);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Task created successfully for the student!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error creating task. Please try again.</div>";
        }
    } else if ($assignTo == 'allstudents') {
        // Insert the task into the studentsAllTask table
        $sql = "INSERT INTO studentsAllTask (taskname, assignTo, status) 
                VALUES (:taskname, :assignTo, :status)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':taskname', $taskname);
        $stmt->bindParam(':assignTo', $assignTo);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Task created successfully for all students!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error creating task. Please try again.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create New Task</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="taskname" class="form-label">Task Name</label>
                <input type="text" class="form-control" id="taskname" name="taskname" required>
            </div>
            <div class="mb-3">
                <label for="assignTo" class="form-label">Assign To</label>
                <select class="form-select" id="assignTo" name="assignTo" required>
                    <option value="allstudents">All Students</option>
                    <option value="student">Single Student</option>
                </select>
            </div>
            <div class="mb-3" id="studentSelectDiv" style="display: none;">
                <label for="student_id" class="form-label">Select Student</label>
                <select class="form-select" id="student_id" name="student_id">
                    <?php foreach ($students as $student): ?>
                        <option value="<?= $student['student_id']; ?>"><?= $student['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Task</button>
            <a href="teacherViewTask.php">view tasks</a>
        </form>
    </div>

    <script>
        // Show or hide the student selection based on the "Assign To" value
        document.getElementById('assignTo').addEventListener('change', function() {
            var assignToValue = this.value;
            if (assignToValue === 'student') {
                document.getElementById('studentSelectDiv').style.display = 'block';
            } else {
                document.getElementById('studentSelectDiv').style.display = 'none';
            }
        });
    </script>
</body>
</html>
