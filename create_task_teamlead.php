<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'teamlead') {
    header('Location: login.php');
    exit();
}

include('includes/connection.php');

// Handle task creation
if (isset($_POST['create_task'])) {
    $uid = mysqli_real_escape_string($connection, $_POST['assigned_user']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $priority = $_POST['priority'] ?? 'normal';

    if (strtotime($end_date) >= strtotime($start_date)) {
        $query = "INSERT INTO tasks (uid, description, start_date, end_date, priority, status, created_by) 
                  VALUES ('$uid', '$description', '$start_date', '$end_date', '$priority', 'Not Started', '" . $_SESSION['uid'] . "')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            echo "<script>alert('Task created successfully....'); window.location.href = 'teamlead_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error creating task: " . mysqli_error($connection) . "....'); window.location.href = 'teamlead_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('End date must be after start date....'); window.location.href = 'teamlead_dashboard.php';</script>";
    }
    exit();
}

// Fetch users for the dropdown
$users_query = "SELECT uid, name FROM users WHERE role = 'user'";
$users_result = mysqli_query($connection, $users_query);
if (!$users_result) {
    echo "<script>alert('Error fetching users: " . mysqli_error($connection) . "....'); window.location.href = 'teamlead_dashboard.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task - Team Lead</title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h4>Create New Task</h4>
        <form method="POST" action="">
            <div class="form-group">
                <label>Assign To:</label>
                <select name="assigned_user" class="form-control" required>
                    <option value="">-Select-</option>
                    <?php while ($user = mysqli_fetch_assoc($users_result)) { ?>
                        <option value="<?php echo $user['uid']; ?>">
                            <?php echo htmlspecialchars($user['name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Priority:</label>
                <select name="priority" class="form-control">
                    <option value="normal">Normal</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>
            <input type="submit" name="create_task" value="Create Task" class="btn btn-primary">
        </form>
    </div>
</body>
</html>