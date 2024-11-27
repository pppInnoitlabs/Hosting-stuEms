<?php
require 'database.php'; // Include the database connection file using the relative path

// Fetch all tasks
$sql = "SELECT * FROM tasks";
$stmt = $pdo->query($sql);
$tasks = $stmt->fetchAll();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update query
    $updateSQL = "UPDATE tasks SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($updateSQL);

    if ($stmt->execute([$status, $id])) {
        $message = "Task status updated successfully!";
    } else {
        $error = "Error updating task status.";
    }

    // Refresh task data after update
    $stmt = $pdo->query($sql);
    $tasks = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tasks</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Edit Tasks</h1>

    <!-- Display success or error messages -->
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Task Name</th>
                <th>Assigned Time</th>
                <th>Last Updated</th>
                <th>Assign To</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['id']); ?></td>
                    <td><?= htmlspecialchars($task['taskname']); ?></td>
                    <td><?= htmlspecialchars($task['assignedTime']); ?></td>
                    <td><?= htmlspecialchars($task['lastupdatedTime']); ?></td>
                    <td><?= htmlspecialchars($task['assignTo']); ?></td>
                    <td>
                        <form method="POST" action="editTasks.php" class="d-inline">
                            <input type="hidden" name="id" value="<?= $task['id']; ?>">
                            <select name="status" class="form-select" style="width: auto; display: inline-block;" required>
                                <option value="start" <?= $task['status'] === 'start' ? 'selected' : ''; ?>>Start</option>
                                <option value="processing" <?= $task['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                            <button type="submit" name="update" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td>
                        <a href="teacherDeleteTask.php?id=<?= $task['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
