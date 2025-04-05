<?php
include('../includes/connection.php');
$users_query = "SELECT uid, name FROM users WHERE role = 'user'";
$users_result = mysqli_query($connection, $users_query);
?>

<div class="container">
    <h4>Create New Task</h4>
    <form method="POST" action="teamlead_dashboard.php">
        <div class="form-group">
            <label>Assign To:</label>
            <select name="assigned_user" class="form-control" required>
                <?php while($user = mysqli_fetch_assoc($users_result)) { ?>
                    <option value="<?php echo $user['uid']; ?>">
                        <?php echo $user['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" required></textarea>
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
            <label>Priority (1-5, 1 being highest):</label>
            <input type="number" name="priority" class="form-control" min="1" max="5" required>
        </div>
        <input type="submit" name="create_task" value="Create Task" class="btn btn-primary">
    </form>
</div>