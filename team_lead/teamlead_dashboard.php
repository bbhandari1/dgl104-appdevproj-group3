<?php
session_start();
if (isset($_SESSION['email']) && $_SESSION['role'] === 'teamlead') {
    include('../includes/connection.php');
?>

<html>
<head>
    <title>Team Lead Dashboard</title>
    <script src="../includes/jquery_latest.js"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/527a10858c.js" crossorigin="anonymous"></script>
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
                <tr><td style="text-align: center;"><a type="button" href="../logout.php">Logout</a></td></tr>
            </table>
        </div>
        <div id="right_sidebar" class="col-md-10">
            <h4>Welcome, Team Lead: <?php echo $_SESSION['name']; ?></h4>
            <p>This is the team lead dashboard. Add your features here (e.g., view team tasks, approve leaves).</p>
        </div>
    </div>
</body>
</html>
<?php
} else {
    header('Location: user_login.php');
}
?>