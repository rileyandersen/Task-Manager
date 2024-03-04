<?php
function OpenCon()
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'task_manager';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    // Check connection if (!$conn)
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function CloseCon($conn)
{
    $conn->close();
}