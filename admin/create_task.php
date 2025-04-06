<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: admin_login.php');
    exit();
}

include('../includes/connection.php');

// Check user role
$role = $_SESSION['role'] ?? 'user';
$is_admin = $role === 'admin';
$is_team_lead = $role === 'team_lead';

// Handle task creation
if (isset($_POST['create_task']) && ($is_admin || $is_team_lead)) {
    $uid = mysqli_real_escape_string($connection, $_POST['id']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $priority = $_POST['priority'] ?? 'normal';
	$admin_id = $_SESSION['id'];

    if (strtotime($end_date) >= strtotime($start_date)) {
        $query = "INSERT INTO tasks (
										uid,
										description, 
										start_date,
										end_date, 
										priority, 
										status, 
										created_by
									) 
                  			VALUES
									 (
									 	'$uid',
										'$description',
										'$start_date',
										'$end_date', 
										'$priority', 
										'Not Started',
										'3'
									)";
        $result = mysqli_query($connection, $query);
        if ($result) {
            		echo "<script>alert('Task created successfully.'); window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error creating task: " . mysqli_error($connection) . "');</script>";
        }
    } else {
        echo "<script>alert('End date must be after start date');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <style>
        .form-container { max-width: 600px; margin: 20px auto; }
    </style>
</head>
<body>
    <div class="container">
        <h3>Create a New Task</h3><br>
        <?php if ($is_admin || $is_team_lead) { ?>
        <div class="form-container">
            <form action="create_task.php" method="post">
                <div class="form-group">
                    <label>Select Assignee:</label>
                    <select name="id" class="form-control" required>
                        <option value="">-Select-</option>
                        <?php

						
                        if ($is_admin) {
                             $query = "SELECT uid, name, role FROM users";
                        } else { // team_lead
                            $query = "SELECT uid, name FROM users WHERE role = 'user'";
                        }
                        $query_run = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            $display_name = $is_admin ? "{$row['name']} ({$row['role']})" : $row['name'];
                            echo "<option value='{$row['uid']}'>$display_name</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea class="form-control" rows="3" name="description" placeholder="Mention the task" required></textarea>
                </div>
                <div class="form-group">
                    <label>Start Date:</label>
                    <input type="date" class="form-control" name="start_date" required />
                </div>
                <div class="form-group">
                    <label>End Date:</label>
                    <input type="date" class="form-control" name="end_date" required />
                </div>
                <div class="form-group">
                    <label>Priority:</label>
                    <select name="priority" class="form-control">
                        <option value="normal">Normal</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-warning" name="create_task" value="Create" />
            </form>
        </div>
        <?php } else { ?>
            <div class="alert alert-danger">You don't have permission to create tasks.</div>
        <?php } ?>
    </div>
</body>
</html>