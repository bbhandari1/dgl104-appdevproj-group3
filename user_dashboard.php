<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: user_login.php');
    exit();
}

include('includes/connection.php');

if (isset($_POST['submit_leave'])) {
    $query = "INSERT INTO leaves VALUES (null, ?, ?, ?, 'No Action')";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "iss", $_SESSION['uid'], $_POST['subject'], $_POST['message']);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Form submitted successfully....'); window.location.href = 'user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connection) . "....'); window.location.href = 'user_dashboard.php';</script>";
    }
    mysqli_stmt_close($stmt);
}
?>

<html>
<head>
    <title>User Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/527a10858c.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#manage_task").click(function(){
                $("#right_sidebar").load("task.php");
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
            <div class="col-md-4" style="display: inline-block;">
                <h3><i class="fa fa-solid fa-list" style="padding-right: 15px;"></i> Task Management System</h3>
            </div>
            <div class="col-md-6" style="text-align: right; display: inline-block;">
                <b>Name: </b><?php echo htmlspecialchars($_SESSION['name']); ?>
                <span style="margin-left:25px;"><b>Role: </b><?php echo htmlspecialchars($_SESSION['role']); ?></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="left_sidebar" class="col-md-2">
            <table class="table" style="width:100%;">
                <tr><td style="text-align: center;"><a href="user_dashboard.php" id="logout_link">Dashboard</a></td></tr>
                <tr><td style="text-align: center;"><a id="manage_task">Update Task</a></td></tr>
                <tr><td style="text-align: center;"><a id="apply_leave">Apply Leave</a></td></tr>
                <tr><td style="text-align: center;"><a id="view_leave">Leave Status</a></td></tr>
                <tr><td style="text-align: center;"><a href="logout.php" id="logout_link">Logout</a></td></tr>
            </table>
        </div>
        <div id="right_sidebar" class="col-md-10">
            <h4>Instructions for Employees</h4>
            <ul style="line-height: 3em; font-size: 1.2em; list-style-type: none;">
                <li>1. All the employee should mark their attendance daily.</li>
                <li>2. Everyone must complete the tasks assigned to them.</li>
                <li>3. Kindly maintain decorum of the office.</li>
                <li>4. Keep office and your area neat and clean.</li>
            </ul>
        </div>
    </div>
</body>
</html>