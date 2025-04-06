<?php
session_start();
include('includes/connection.php');  // Ensure the path to connection.php is correct

// Handle task status update
if (isset($_POST['update_status']) && $_POST['update_status'] == 1) {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['status'];

    // Update task status in the database
    $update_query = "UPDATE tasks SET status = ? WHERE tid = ?";
    $stmt = mysqli_prepare($connection, $update_query);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $task_id);
    $update_result = mysqli_stmt_execute($stmt);

    if ($update_result) {
        echo "<script>alert('Task status updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating task status');</script>";
    }
}

// Fetch tasks assigned to the current user (team member)
$query = "SELECT * FROM tasks WHERE uid = ? ORDER BY priority ASC, end_date ASC";  // Updated column name
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['uid']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="container">
    <h4>My Assigned Tasks</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Priority</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($task = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['priority']); ?></td>
                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                    <td><?php echo htmlspecialchars($task['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($task['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($task['status']); ?></td>
                    <td>
                        <form method="POST" action="teamlead_dashboard.php" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?php echo $task['tid']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="Not Started" <?php echo $task['status'] == 'Not Started' ? 'selected' : ''; ?>>Not Started</option>
                                <option value="In Progress" <?php echo $task['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Complete" <?php echo $task['status'] == 'Complete' ? 'selected' : ''; ?>>Complete</option>
                            </select>
                            <input type="hidden" name="update_status" value="1">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
