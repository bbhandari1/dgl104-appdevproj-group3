<?php
include('includes/connection.php');

// Ensure session is active
session_start();

// Debug session UID
echo "<p>Session UID: " . $_SESSION['uid'] . "</p>";  // REMOVE this after debugging

// Prepare query to fetch tasks created by the team lead (using session UID)
$query = "SELECT t.*, u.name 
          FROM tasks t 
          LEFT JOIN users u ON t.uid = u.uid 
          WHERE t.created_by = ? 
          ORDER BY t.priority ASC, t.end_date ASC";

// Prepare and bind the statement
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['uid']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Count rows for debugging
$row_count = mysqli_num_rows($result);
echo "<p>Total rows fetched: $row_count</p>";  // REMOVE this after debugging

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
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($task = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['priority']); ?></td>
                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                        <td><?php echo htmlspecialchars($task['name']); ?></td>
                        <td><?php echo $task['start_date']; ?></td>
                        <td><?php echo $task['end_date']; ?></td>
                        <td><?php echo $task['status']; ?></td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr><td colspan="6">No tasks found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
