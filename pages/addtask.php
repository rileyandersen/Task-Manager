<?php
// addtask.php

// Start the session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../server/db_connection.php';

$conn = OpenCon();
$error = false;
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    
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
    }

    // Check if user_id is set in the session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($user_id !== null) {
        // Insert the task into the database
        $query = "INSERT INTO tasks (user_id, title, description, status, due_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "issss", $user_id, $title, $description, $status, $due_date);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: tasks.php'); // Redirect to the tasks page after successful insertion
            exit();
        } else {
            $error = true;
            $error_message = "Error adding the task. Please try again.";
        }

        mysqli_stmt_close($stmt);
    } else {
        // Handle the case where user_id is not set
        echo "User is not logged in.";
    }
}

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='../styles/main/styles.css'>
    <script src="../scripts/add_task.js" defer></script>
    <title>Add Task</title>
</head>
<body>
    <main>
        <?php include("../components/header.php"); ?>
        <form method="post" action="addtask.php" onsubmit="return validateForm()" class="input-form">
            <div class="input-field">
                <label>
                    <h5>Title *</h5>
                    <input class="mar-bottom-8" type="text" name="title" id="title" placeholder="Task title">
                </label>
                <p id="title-error" class="error"></p>
            </div>

            <div class="input-field">
                <label>
                    <h5>Description</h5>
                    <textarea class="mar-bottom-8" name="description" id="description" placeholder="Task description"></textarea>
                </label>
            </div>

            <div class="input-field">
                <label>
                    <h5>Status *</h5>
                    <select class="mar-bottom-8" name="status" id="status">
                        <option value="not started">Not Started</option>
                        <option value="in progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="on hold">On Hold</option>
                    </select>
                </label>
            </div>

            <div class="input-field">
                <label>
                    <h5>Due Date</h5>
                    <input class="mar-bottom-8" type="datetime-local" name="due_date" id="due_date" placeholder="YYYY-MM-DDTHH:MM">
                </label>
                <p id="due_date-error" class="error"></p>
            </div>

            <p id="errorMessage" class="error mar-bottom-8"><?php echo $error ? $error_message : ''; ?></p>
            <button class="anti-default-white-btn">
                <h5>ADD TASK</h5>
            </button>
        </form>
    </main>
</body>
</html>