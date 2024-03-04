<!--Tasks.php -->
<?php
session_start();
include "../server/db_connection.php";
include "../server/functions.php";

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // if user is not logged in, redirect to the login page
    exit();
}

$conn = OpenCon();
// check if user logged in
$pastDueTasks = "";
$upcomingTasks = "";
$todayTasks = "";
if(isset($_SESSION['user_id'])) {
    // initializing variables

    // get user id
    $user_id = $_SESSION['user_id'];
    // fetch all users tasks
    $query = "SELECT * FROM tasks WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if($result) {
        // iterate over tasks, add styling and add to tasks string
        while($row = mysqli_fetch_assoc($result)) {
            // returns the colored date and state of the date (today, normal, passed)
            [$dateElem, $state] = getDateElem($row['due_date']);
            // date element
            $task_id = $row['task_id'];
            $task = "
           
            <a href='./task.php?id=$task_id' class='no-underline'>
            <div class = 'task'>
                <h4 class = 'mar-bottom-8'>
                {$row['title']}
                </h4>
                
                <p class='mar-bottom-8 task-text'>
                {$row['description']}
                </p>
            <div>
                   <div>
                    $dateElem
                    </div>
                </div>
            </div>
            </a>
            ";
            // push into today, upcoming or pastDue based on date
            switch($state) {
                case "date-today":
                    $todayTasks .= $task;
                    break;
                case "date-upcoming":
                    $upcomingTasks .= $task;
                    break;
                case "date-passed":
                    $pastDueTasks .= $task;
                    break;
                default:
                    break;
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../styles/main/styles.css">

        <title>Tasks Page</title>
    </head>
    <body>
        <main>
        <?php
        include('../components/header.php');
        ?>
            <div class="default-page">
        <h1 class ='mar-bottom-16'>Your tasks</h1>
        <div class="flex justify-end mar-bottom-32">
        <div class="anti-default-btn">
            <h5>

                <a href="./addtask.php">
                    Add Task
                </a>
            </h5>

        </div>

            </div>
                <!-- Task section -->
                <div class="task-section">
            <div class="task-holder">
                <div class="task-header">
                    <div class="circle-red"></div>
                     <h3>Past Due</h3>
                </div>
                <?php
                echo $pastDueTasks;
                ?>
            </div>

                <div class="task-holder">
                    <div class="task-header">
                        <div class="circle-yellow"></div>
                    <h3>Upcoming</h3>
                    </div>
                    <?php
                    echo $upcomingTasks;
                    ?>
                </div>

                <div class="task-holder">
                    <div class="task-header">
                        <div class="circle-green"></div>
                    <h3>Today</h3>
                    </div>
                    <?php
                    echo $todayTasks;
                    ?>
                </div>

                </div>
                <!-- End of task section -->
            </div>
        </main>
    </body>
</html>
