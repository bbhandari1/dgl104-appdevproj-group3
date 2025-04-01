<?php
$connection = mysqli_connect("localhost", "root", "", "tms_db");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>