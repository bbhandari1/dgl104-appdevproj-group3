<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: user_login.php');
    exit();
}

include('includes/connection.php');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid task ID....'); window.location.href = 'user_dashboard.php';</script>";
    exit();
}

if (isset($_POST['update'])) {
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $task_id = mysqli_real_escape_string($connection, $_GET['id']);
    
    $query = "UPDATE tasks SET status = ? WHERE tid = ? AND uid = ?";
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sii", $status, $task_id, $_SESSION['uid']);
        $query_run = mysqli_stmt_execute($stmt);
        
        if ($query_run) {
            echo "<script>alert('Status updated successfully....'); window.location.href = 'user_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($connection) . "....'); window.location.href = 'user_dashboard.php';</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ETMS</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <div class="row">
        <div class="col-md-3 m-auto" id="home_page">
            <center>
                <h3>Update Task Status</h3>
                <?php 
                    $task_id = mysqli_real_escape_string($connection, $_GET['id']);
                    $query = "SELECT * FROM tasks WHERE tid = ? AND uid = ?";
                    $stmt = mysqli_prepare($connection, $query);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "ii", $task_id, $_SESSION['uid']);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($row = mysqli_fetch_assoc($result)) {
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $task_id); ?>" method="post">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="">-Select-</option>
                            <option value="Complete" <?php echo $row['status'] == 'Complete' ? 'selected' : ''; ?>>Complete</option>
                            <option value="In-Progress" <?php echo $row['status'] == 'In-Progress' ? 'selected' : ''; ?>>In-Progress</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger" name="update">Update</button>
                    <a href="user_dashboard.php" class="btn btn-primary">Dashboard</a>
                </form>
                <?php
                        } else {
                            echo "<p>Task not found or you don’t have permission!</p>";
                        }
                        mysqli_stmt_close($stmt);
                    }
                    mysqli_close($connection);
                ?>
            </center>
        </div>
    </div>
</body>
</html>