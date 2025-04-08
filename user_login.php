<?php
session_start();
include('includes/connection.php'); // Adjusted path from ../ to ./ since it's in the root

if (isset($_POST['userlogin'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $query = "SELECT name, email, role FROM users WHERE email = '$email' AND password = '$password'";
    $query_run = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_run)) {
        $_SESSION['email'] = $email;
        while ($row = mysqli_fetch_assoc($query_run)) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];
        }
        if ($_SESSION['role'] === 'teamlead') {
            echo "<script>window.location.href = 'teamlead_dashboard.php';</script>";
        } else {
            echo "<script>window.location.href = 'user_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Please enter correct email and password.'); window.location.href = 'user_login.php';</script>";
    }
}
?>

<html>
<head>
    <title>User/Team Lead Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="row">
        <div class="col-md-3 m-auto" id="login_home_page">
            <center><h3>User/Team Lead Login</h3></center>
            <form action="" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <center><input type="submit" class="btn btn-warning" name="userlogin" value="Login"></center>
                </div>
            </form>
            <center><a href="index.php" class="btn btn-danger">Go to Home</a></center>
        </div>
    </div>
</body>
</html>