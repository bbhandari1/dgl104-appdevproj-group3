<?php
session_start();
if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
    include('../includes/connection.php');

    if (isset($_POST['submit_leave'])) {
        $query = "INSERT INTO leaves VALUES (null, 1, '$_POST[subject]', '$_POST[message]', 'No Action')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            echo "<script>alert('Form submitted successfully....'); window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error...Plz try again.'); window.location.href = 'admin_dashboard.php';</script>";
        }
    }

    if (isset($_POST['create_task'])) {
        $query = "INSERT INTO tasks VALUES (null, $_POST[id], '$_POST[description]', '$_POST[start_date]', '$_POST[end_date]', 'Not Started')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            echo "<script>alert('Task created successfully....'); window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error...Plz try again.'); window.location.href = 'admin_dashboard.php';</script>";
        }
    }
?>

<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Use jQuery CDN for reliability -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/527a10858c.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // Existing click handlers
            $("#create_task").click(function(){ 
                $("#right_sidebar").load("create_task.php", function(response, status, xhr) {
                    if (status == "error") {
                        console.log("Error loading create_task.php: " + xhr.status + " " + xhr.statusText);
                    }
                }); 
            });
            $("#manage_task").click(function(){ 
                $("#right_sidebar").load("manage_task.php", function(response, status, xhr) {
                    if (status == "error") {
                        console.log("Error loading manage_task.php: " + xhr.status + " " + xhr.statusText);
                    }
                }); 
            });
            $("#view_leave").click(function(){ 
                $("#right_sidebar").load("view_leave.php", function(response, status, xhr) {
                    if (status == "error") {
                        console.log("Error loading view_leave.php: " + xhr.status + " " + xhr.statusText);
                    }
                }); 
            });
            // Register User handler with debugging
            $("#register_user").click(function(){ 
                console.log("Register User button clicked"); // Debug click event
                $("#right_sidebar").load("register.php", function(response, status, xhr) {
                    if (status == "error") {
                        console.log("Error loading register.php: " + xhr.status + " " + xhr.statusText);
                    } else {
                        console.log("register.php loaded successfully");
                    }
                }); 
            });
        });
    </script>
</head>
<body>
    <div class="row" id="header">
        <div class="col-md-12">
            <h3><i class="fa fa-solid fa-list" style="padding-right: 15px;"></i> Task Management System</h3>
        </div>
    </div>
    <div class="row">
        <div id="left_sidebar" class="col-md-2">
            <table class="table">
                <tr><td style="text-align: center;"><a type="button" id="create_task">Create Task</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" id="manage_task">Manage Task</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" id="view_leave">Leave Applications</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" id="register_user">Register User</a></td></tr>
                <tr><td style="text-align: center;"><a type="button" href="../logout.php">Logout</a></td></tr>
            </table>
        </div>
        <div id="right_sidebar" class="col-md-10">
            <h4>Instructions for Employees</h4>
            <ul style="line-height: 3em;font-size: 1.2em;list-style-type: none;">
                <li>1. All employees should mark their attendance daily.</li>
                <li>2. Everyone must complete the tasks assigned to them.</li>
                <li>3. Kindly maintain decorum of the office.</li>
                <li>4. Keep office and your area neat and clean.</li>
            </ul>
        </div>
    </div>
</body>
</html>
<?php
} else {
    header('Location: admin_login.php');
}
?>