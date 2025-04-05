<?php
include('connection.php');
session_start();

if (isset($_POST['create_task'])) {
    $title = $_POST['task_title'];
    $desc = $_POST['task_desc'];
    $user_id = $_POST['user_id'];
    $deadline = $_POST['deadline'];
    $teamlead_id = $_SESSION['teamlead_id'];

    $query = "INSERT INTO tasks (title, description, user_id, deadline, created_by, status) 
              VALUES ('$title', '$desc', '$user_id', '$deadline', '$teamlead_id', 'Pending')";

    if (mysqli_query($connection, $query)) {
        echo "Task created successfully. <a href='teamlead_dashboard.php'>Go back</a>";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>
