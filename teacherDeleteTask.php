<?php
require '../database/database.php'; // Include the database connection file

// Check if the ID is passed via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer to prevent SQL injection

    // Prepare the delete query
    $deleteSQL = "DELETE FROM tasks WHERE id = ?";
    $stmt = $pdo->prepare($deleteSQL);

    if ($stmt->execute([$id])) {
        // Redirect back to the editTasks.php with success message
        header("Location: editTasks.php?message=Task deleted successfully");
        exit;
    } else {
        // Redirect back with an error message
        header("Location: editTasks.php?error=Failed to delete the task");
        exit;
    }
} else {
    // Redirect back with an error message if no ID is provided
    header("Location: editTasks.php?error=No task ID provided");
    exit;
}
