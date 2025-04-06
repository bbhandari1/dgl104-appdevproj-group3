<?php
// Example of login session setting
session_start();
$_SESSION['uid'] = $user_id;  // set session for user ID after successful login
$_SESSION['email'] = $user_email;  // set session for email


if (isset($_SESSION['email']) && isset($_SESSION['uid'])) {
    include('includes/connection.php');
?>
<html>
<body>
    <center><h3>Your leave applications</h3></center><br>
    <table class="table" style="background-color: whitesmoke;width: 75vw;">
        <tr>
            <th>S.No</th>
            <th>Subject</th>
            <th style="width:40%;">Message</th>
            <th>Status</th>
        </tr>
        <?php
            $sno = 1;  
            // Sanitize and prepare the query
            $uid = $_SESSION['uid'];
            $query = "SELECT * FROM leaves WHERE uid = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $uid);  // Bind the user ID to the query
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)){
        ?>
                <tr>
                    <td><?php echo $sno; ?></td>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
        <?php
                $sno++;
            }
        ?>
    </table>
</body>
</html>
<?php
} else {
    header('Location:teamlead_dashboard.php');
    exit();
}
?>