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

// Prepare SQL query to fetch task details based on task ID and user ID
$query = "SELECT * FROM tasks WHERE task_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $task_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch the task data if available
if ($row = mysqli_fetch_assoc($result)) {
    // Store task details in variables
    $title = $row['title'];
    $description = $row['description'];
    $status = $row['status'];
    $due_date = $row['due_date'];

    // Format the due_date for the datetime-local input
    $due_date_value = date('Y-m-d\TH:i', strtotime($due_date));
} else {
    // Display an error message and exit if the task is not found
    echo "Task not found.";
    exit();
}

// Close the statement and the database connection
mysqli_stmt_close($stmt);
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main/styles.css">
    <title>Edit Task</title>
</head>
<body>
    <!-- Include the header component -->
    <?php include('../components/header.php'); ?>

    <main>
        <div class="default-page">
            <h1 class="mar-bottom-16">Edit Task</h1>
            <div class="flex justify-center">


            <!-- Form for editing the task -->
            <form action="update_task.php" method="post" class="task task-center">
                <!-- Hidden input to pass the task ID -->
                <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task_id); ?>">

                <!-- Input field for task title -->
                <div class="input-field">
                    <h5 class = 'mar-bottom-8'>
                        <label>
                            Title
                        </label>
                    </h5>

                    <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
                </div>

                <!-- Textarea for task description -->
                <div class="input-field">
                    <h5 class="mar-bottom-8">
                        <label>Description</label>
                    </h5>

                    <textarea name="description"><?php echo htmlspecialchars($description); ?></textarea>
                </div>

                <!-- Dropdown for task status -->
                <div class="input-field">
                    <h5 class="mar-bottom-8">
                        <label>Status</label>
                    </h5>

                    <select name="status">
                        <!-- Options for task status, with the current status selected -->
                        <option value="not started" <?php echo ($status == 'not started') ? 'selected' : ''; ?>>Not Started</option>
                        <option value="in progress" <?php echo ($status == 'in progress') ? 'selected' : ''; ?>>In Progress</option>
                        <option value="completed" <?php echo ($status == 'completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="on hold" <?php echo ($status == 'on hold') ? 'selected' : ''; ?>>On Hold</option>
                    </select>
                </div>

                <!-- Input field for due date -->
                <div class="input-field">
                    <h5 class="mar-bottom-8">
                        <label>Due Date</label>
                    </h5>

                    <input type="datetime-local" name="due_date" value="<?php echo htmlspecialchars($due_date_value); ?>">
                </div>

                <!-- Submit button for the form -->
                <button type="submit" class="anti-default-white-btn">
                    <h5>
                        Save Changes
                    </h5>

                </button>
            </form>
            </div>
        </div>
    </main>
</body>
</html>