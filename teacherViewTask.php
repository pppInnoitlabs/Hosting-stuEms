<?php
// Include the database connection file
require_once 'database.php';

// Fetch tasks assigned to individual students
$studentTasksStmt = $pdo->query("SELECT t.id, t.taskname, t.assignedTime, t.lastupdatedTime, t.status, s.name AS student_name 
                                 FROM studentTask t 
                                 JOIN students s ON t.student_id = s.student_id");
$studentTasks = $studentTasksStmt->fetchAll();

// Fetch tasks assigned to all students
$allStudentTasksStmt = $pdo->query("SELECT id, taskname, assignedTime, lastupdatedTime, status 
                                    FROM studentsAllTask");
$allStudentTasks = $allStudentTasksStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Task Management</h2>

        <!-- Table for Tasks Assigned to Individual Students -->
        <h3>Tasks Assigned to Individual Students</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task Name</th>
                    <th>Assigned Time</th>
                    <th>Last Updated Time</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($studentTasks as $task): ?>
                    <tr>
                        <td><?= $task['id']; ?></td>
                        <td><?= $task['taskname']; ?></td>
                        <td><?= $task['assignedTime']; ?></td>
                        <td><?= $task['lastupdatedTime']; ?></td>
                        <td><?= $task['student_name']; ?></td>
                        <td><?= $task['status']; ?></td>
                        <td>
                            <a href="editTask.php?id=<?= $task['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="deleteTask.php?id=<?= $task['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Table for Tasks Assigned to All Students -->
        <h3>Tasks Assigned to All Students</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task Name</th>
                    <th>Assigned Time</th>
                    <th>Last Updated Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allStudentTasks as $task): ?>
                    <tr>
                        <td><?= $task['id']; ?></td>
                        <td><?= $task['taskname']; ?></td>
                        <td><?= $task['assignedTime']; ?></td>
                        <td><?= $task['lastupdatedTime']; ?></td>
                        <td><?= $task['status']; ?></td>
                        <td>
                            <a href="editTask.php?id=<?= $task['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="deleteTask.php?id=<?= $task['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
