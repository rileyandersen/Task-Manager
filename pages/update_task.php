<?php
// Start a new or resume the existing session
session_start();

// Include the database connection file
include '../server/db_connection.php';
$conn = OpenCon();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the server request is POST, which indicates form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve task details from the form submission
    $task_id = $_POST['task_id']; // The ID of the task to be updated
    $title = $_POST['title'];     // The updated title of the task
    $description = $_POST['description']; // The updated description
    $status = $_POST['status'];   // The updated status
    
    // Check if due_date is set and not empty
    if (!empty($_POST['due_date'])) {
        $due_date = $_POST['due_date'];

        // Check if the time part is included in the due_date
        if (strlen($due_date) <= 10) {
        // If only date is provided, append the default time '23:59:00'
            $due_date .= ' 23:59:00';
        }

        // Convert the date and time to MySQL DATETIME format
        $due_date = date('Y-m-d H:i:s', strtotime($due_date));
    } else {
    // Handle the case where due_date is not provided
    // This depends on your application logic
    }

    // Prepare the SQL query for updating the task
    $query = "UPDATE tasks SET title=?, description=?, status=?, due_date=? WHERE task_id=? AND user_id=?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters to the prepared statement
    // "ssssii" denotes the types of the variables: s (string), i (integer)
    mysqli_stmt_bind_param($stmt, "ssssii", $title, $description, $status, $due_date, $task_id, $_SESSION['user_id']);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
CloseCon($conn);

// Redirect the user to the tasks page after the update operation
header("Location: tasks.php");
exit();
?>
