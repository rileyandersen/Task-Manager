<?php
session_start();

include "../server/db_connection.php";
include "../server/functions.php";

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = OpenCon();

// Check if task ID is provided in the URL
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Fetch task details based on task ID
    $query = "SELECT * FROM tasks WHERE task_id = $task_id AND user_id = {$_SESSION['user_id']}";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Task details found
        $title = $row['title'];
        $description = $row['description'];
        $status = $row['status'];
        $due_date = $row['due_date'];
    } else {
        // Task not found or unauthorized access
        header("Location: tasks.php");
        exit();
    }
} else {
    // Task ID not provided in the URL
    header("Location: tasks.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main/styles.css">
    <title>Task Details</title>
</head>
<body>
    <?php include('../components/header.php');
    [$dateElem, $state] = getDateElem($due_date);
    ?>
    <main>
        <div class="default-page">
            <h1 class='mar-bottom-16'>Task Details</h1>
            <div class=" flex align-center justify-center" >
            <div class="task-details task">
                <div class="mar-bottom-16">
                    <div class="flex flex-column ">
                        <div class="mar-bottom-8 flex justify-end">
                        <?php
                        echo getTimeStateElem($state);
                        ?>
                        </div>
                <h2 class='mar-bottom-4'><?php echo $title; ?></h2>

                    </div>
                    <div class="mar-bottom-16"></div>
                <p class='mar-bottom-16'><?php echo $description; ?></p>
                <p class='mar-bottom-8'> <b> <?php echo $status; ?> </b></p>

                    <?php
                    echo $dateElem;
                    ?>
                </div>
                <!-- Edit and Delete options -->
                <div class="flex">
                    <!-- Link to Edit Task -->
                    <div class="mar-right-16">

                        <a href="./edit_task.php?id=<?php echo $task_id; ?>" class=" icon">
                            <img src = '../images/icons/edit.svg' alt = 'edit' />
                        </a>
                    </div>

                    <!-- Link to Delete Task -->
                    <div class=" mar-right-8 icon">
                    <a href="./delete_task.php?id=<?php echo $task_id; ?>">
                        <img src="../images/icons/delete.svg" alt="delete">


                    </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </main>
</body>
</html>