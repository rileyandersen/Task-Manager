<?php
// Start a new or resume the existing session
session_start();

// Include the database connection file
include '../server/db_connection.php';
$conn = OpenCon();

// Check if the user is logged in and if a task ID is provided in the URL
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    // Redirect to login page if not logged in or if task ID is not provided
    header("Location: login.php");
    exit();
}

// Retrieve the task ID from the URL
$task_id = $_GET['id'];
// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Prepare the SQL query for deleting the task
$query = "DELETE FROM tasks WHERE task_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);

// Bind the task ID and user ID to the prepared statement
mysqli_stmt_bind_param($stmt, "ii", $task_id, $user_id);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close the database connection
CloseCon($conn);

// Redirect the user to the tasks page after deletion
header("Location: tasks.php");
exit();
?>
