<?php
session_start();
if (isset($_SESSION['email']) && $_SESSION['role'] === 'teamlead') {
    include('includes/connection.php');

    // Create Task
    if (isset($_POST['create_task_teamlead'])) {
        $priority = intval($_POST['priority']);
        $query = "INSERT INTO tasks (tid, created_by, assigned_to, description, start_date, end_date, status, priority) 
                  VALUES s(null, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        $status = 'Not Started';
        mysqli_stmt_bind_param($stmt, "iissssi", $_SESSION['uid'], $_POST['assigned_user'], $_POST['description'], 
            $_POST['start_date'], $_POST['end_date'], $status, $priority);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Task created successfully....'); window.location.href = 'teamlead_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error creating task...'); window.location.href = 'teamlead_dashboard.php';</script>";
        }
    }

    // Update Task Status
    if (isset($_POST['update_status'])) {
        $query = "UPDATE tasks SET status = ? WHERE tid = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "si", $_POST['status'], $_POST['task_id']);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Task status updated....'); window.location.href = 'teamlead_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating status...'); window.location.href = 'teamlead_dashboard.php';</script>";
        }
    }

    // Apply Leave
    if (isset($_POST['submit_leave'])) {
        $query = "INSERT INTO leaves (lid, uid, subject, message, status) VALUES (null, ?, ?, ?, 'No Action')";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "iss", $_SESSION['uid'], $_POST['subject'], $_POST['message']);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Leave application submitted successfully....'); window.location.href = 'teamlead_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error submitting leave...Plz try again.'); window.location.href = 'teamlead_dashboard.php';</script>";
        }
    }
?>

<html>
<head>
    <title>Team Lead Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/527a10858c.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#create_task").click(function(){ 
                $("#right_sidebar").load("create_task_teamlead.php"); 
            });
            
            $("#view_tasks").click(function(){ 
                $("#right_sidebar").load("view_tasks_teamlead.php"); 
            });
            
            $("#assigned_tasks").click(function(){ 
                $("#right_sidebar").load("assigned_tasks_teamlead.php"); 
            });
            
            $("#apply_leave").click(function(){ 
                $("#right_sidebar").load("leaveForm.php"); 
            });
            
            $("#view_leave").click(function(){ 
                $("#right_sidebar").load("leave_status.php"); 
            });
        });
    </script>
</head>
<body>
    <div class="row" id="header">
        <div class="col-md-12">
            <h3><i class="fa fa-solid fa-list" style="padding-right: 15px;"></i> Task Management System</h3>
            <div style="text-align: right;">
                <b>Name:</b> <?php echo $_SESSION['name']; ?>
                <span style="margin-left:25px;"><b>Role:</b> <?php echo $_SESSION['role']; ?></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div id="left_sidebar" class="col-md-2">
            <table class="table">
                <tr><td style="text-align: center;"><a type="button" id="create_task">Create Task</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" id="view_tasks">Team Tasks</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" id="assigned_tasks">My Assigned Tasks</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" id="apply_leave">Apply Leave</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" id="view_leave">Leave Status</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" href="logout.php">Logout</a></td></tr>
            </table>
        </div>
        
        <div id="right_sidebar" class="col-md-10">
            <h4>Welcome, Team Lead!</h4>
            <p>Use the sidebar to manage tasks, view assignments, and handle leave requests.</p>
            <ul style="line-height: 2em; font-size: 1.1em; list-style-type: none;">
                <li>Create and assign tasks to team members with priority levels</li>
                <li>Monitor team tasks and update status of assigned tasks</li>
                <li>Apply for leaves and check leave status</li>
            </ul>
        </div>
    </div>
</body>
</html>

<?php
} else {
    header('Location: login.php');
}
?>