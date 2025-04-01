<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check admin access
if (!isset($_SESSION['email']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied! Only admins can register users.'); window.location.href = '../index.php';</script>";
    exit;
}

// Include database connection
include('../includes/connection.php');

// Verify connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
    echo "<p>Database connection successful.</p>"; // Debug
}

if (isset($_POST['userRegistration'])) {
    // Debug: Show raw POST data
    echo "<pre>POST Data Received:\n";
    print_r($_POST);
    echo "</pre>";

    // Sanitize inputs
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);

    // Construct and debug query
    $query = "INSERT INTO users (name, email, password, mobile, role) VALUES ('$name', '$email', '$password', '$mobile', '$role')";
    echo "<pre>Executing Query:\n$query</pre>";

    // Execute query with error checking
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
        echo "<script>alert('User registered successfully.'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        // Show detailed error
        $error = mysqli_error($connection);
        echo "<p>Query Failed: $error</p>";
        echo "<script>alert('Error: $error'); window.location.href = 'register.php';</script>";
    }
} else {
    echo "<p>No POST data received. Waiting for form submission...</p>"; // Debug
}
?>

<html>
<head>
    <title>Admin - Register User</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="row">
        <div class="col-md-4 m-auto" id="register_home_page">
            <center><h3 style="background-color: #5A8F7B;padding: 5px;width: 20vw;">Admin - Add User/Team Lead</h3></center>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="mobile" placeholder="Mobile No." required>
                </div>
                <div class="form-group">
                    <label for="role">Select Role:</label>
                    <select class="form-control" name="role" required>
                        <option value="user">User</option>
                        <option value="teamlead">Team Lead</option>
                    </select>
                </div>
                <div class="form-group">
                    <center><input type="submit" class="btn btn-warning" name="userRegistration" value="Register"></center>
                </div>
            </form>
            <center><a href="admin_dashboard.php" class="btn btn-danger">Go to Admin Dashboard</a></center>
        </div>
    </div>
</body>
</html>