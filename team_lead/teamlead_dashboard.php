<?php
include('connection.php');
session_start();
// Check if team lead is logged in
if (!isset($_SESSION['teamlead_id'])) {
    header("Location: teamlead_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Lead Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Welcome, Team Lead</h2>

    <!-- Create Task Form -->
    <div class="card mt-4">
        <div class="card-header">Create & Assign Task</div>
        <div class="card-body">
            <form action="teamlead_create_task.php" method="POST">
                <div class="form-group">
                    <label>Task Title</label>
                    <input type="text" name="task_title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Task Description</label>
                    <textarea name="task_desc" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Assign to User</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">Select User</option>
                        <?php
                        $result = mysqli_query($connection, "SELECT id, name FROM users");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deadline</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>
                <input type="submit" name="create_task" value="Create Task" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
</body>
</html>
