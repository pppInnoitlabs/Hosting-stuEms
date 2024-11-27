<?php
// Include the database connection file
require_once 'database.php';

session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: studentLogin.php");
    exit();
}

// Get the logged-in user's ID
$userId = $_SESSION['user_id'];

try {
    // Retrieve the student's `student_id` from the `students` table
    $stmt = $pdo->prepare("SELECT student_id FROM students WHERE id = :userId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$studentData) {
        die("Student record not found.");
    }

    $studentId = $studentData['student_id'];

    // Fetch tasks assigned to the logged-in student
    $studentTasksStmt = $pdo->prepare("SELECT id, taskname, assignedTime, lastupdatedTime, status 
                                       FROM studentTask 
                                       WHERE student_id = :studentId");
    $studentTasksStmt->bindParam(':studentId', $studentId, PDO::PARAM_STR);
    $studentTasksStmt->execute();
    $studentTasks = $studentTasksStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch tasks assigned to all students
    $allTasksStmt = $pdo->query("SELECT id, taskname, assignedTime, lastupdatedTime, status 
                                 FROM studentsAllTask");
    $allTasks = $allTasksStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching tasks: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>

        <!-- Table for Individual Student Tasks -->
        <h3 class="mt-4">Tasks Assigned to You</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task Name</th>
                    <th>Assigned Time</th>
                    <th>Last Updated Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($studentTasks)): ?>
                    <?php foreach ($studentTasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['id']); ?></td>
                            <td><?= htmlspecialchars($task['taskname']); ?></td>
                            <td><?= htmlspecialchars($task['assignedTime']); ?></td>
                            <td><?= htmlspecialchars($task['lastupdatedTime']); ?></td>
                            <td><?= htmlspecialchars($task['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No tasks assigned to you.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Table for All Students' Tasks -->
        <h3 class="mt-4">Tasks Assigned to All Students</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task Name</th>
                    <th>Assigned Time</th>
                    <th>Last Updated Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($allTasks)): ?>
                    <?php foreach ($allTasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['id']); ?></td>
                            <td><?= htmlspecialchars($task['taskname']); ?></td>
                            <td><?= htmlspecialchars($task['assignedTime']); ?></td>
                            <td><?= htmlspecialchars($task['lastupdatedTime']); ?></td>
                            <td><?= htmlspecialchars($task['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No tasks assigned to all students.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
