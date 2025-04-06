<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: user_login.php');
    exit();
}

include('includes/connection.php');

// Check if user is admin (assuming role is set during login)
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Handle new task creation (moved to separate file ideally, but kept here for now)
if ($is_admin && isset($_POST['create_task'])) {
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $priority = $_POST['priority'];
    $uid = $_POST['user_id'];

    $query = "INSERT INTO tasks (uid, description, start_date, end_date, priority, status, created_by) 
              VALUES ('$uid', '$description', '$start_date', '$end_date', '$priority', 'Not Started', {$_SESSION['uid']})";
    mysqli_query($connection, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .urgent { background-color: #ffe6e6; }
        .normal { background-color: whitesmoke; }
    </style>
</head>
<body>
    <?php if ($is_admin) { ?>
    <!-- Admin Task Creation Form -->
    <div class="container mt-4">
        <h3>Create New Task</h3>
        <form method="POST">
            <div class="form-group">
                <label>User ID</label>
                <input type="number" name="user_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="priority" class="form-control">
                    <option value="normal">Normal</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>
            <button type="submit" name="create_task" class="btn btn-primary mt-2">Create Task</button>
        </form>
    </div>
    <?php } ?>

    <center><h3>Your Task List</h3></center><br>
    <table class="table" style="width: 75vw;">
        <tr>
            <th>S.No</th>
            <th>Task ID</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        $sno = 1;
        $query = "SELECT * FROM tasks WHERE uid = {$_SESSION['uid']}
                  ORDER BY 
                  CASE WHEN priority = 'urgent' THEN 0 ELSE 1 END,
                  CASE WHEN priority = 'urgent' THEN created_at ELSE tid END ASC";
        
        $query_run = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($query_run)) {
            $row_class = $row['priority'] === 'urgent' ? 'urgent' : 'normal';
        ?>
            <tr class="<?php echo $row_class; ?>">
                <td><?php echo $sno; ?></td>
                <td><?php echo $row['tid']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['start_date']; ?></td>
                <td><?php echo $row['end_date']; ?></td>
                <td><?php echo ucfirst($row['priority']); ?></td>
                <td><center><?php echo $row['status']; ?></center></td>
                <td><a href="update_status.php?id=<?php echo $row['tid']; ?>">Update</a></td>
            </tr>
        <?php
            $sno++;
        }
        ?>
    </table>
</body>
</html>