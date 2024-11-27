<?php
// Include the database connection file
require_once 'database.php';


// Check if an 'id' is provided in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare and execute the DELETE statement
        $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirect back to the dashboard with a success message
            header("Location: adminDashboard.php?message=TeacherDeleted");
            exit;
        } else {
            // Redirect with an error message if the query fails
            header("Location: adminDashboard.php?error=DeleteFailed");
            exit;
        }
    } catch (PDOException $e) {
        die("Error deleting student: " . $e->getMessage());
    }
} else {
    // Redirect back to the dashboard if no 'id' is provided
    header("Location: adminDashboard.php?error=NoTeacherID");
    exit;
}
