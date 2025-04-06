<?php
include('includes/connection.php');
$query = "SELECT t.*, u.name 
          FROM tasks t 
          LEFT JOIN users u ON t.assigned_to = u.uid 
          WHERE t.created_by = ? 
          ORDER BY t.priority ASC, t.end_date ASC";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['uid']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="container">
    <h4>Team Tasks</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Priority</th>
                <th>Description</th>
                <th>Assigned To</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($task = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $task['priority']; ?></td>
                    <td><?php echo $task['description']; ?></td>
                    <td><?php echo $task['name']; ?></td>
                    <td><?php echo $task['start_date']; ?></td>
                    <td><?php echo $task['end_date']; ?></td>
                    <td><?php echo $task['status']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>