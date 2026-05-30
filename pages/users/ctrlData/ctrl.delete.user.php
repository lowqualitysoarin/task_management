<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_GET['user_id'])) {
    header("location: ../list.user.php");
    exit();
}

$user_id = $_GET['user_id'];

mysqli_query($conn, "DELETE FROM users_tbl WHERE user_id = '$user_id'");

$_SESSION['success'] = "User deleted successfully.";

header("location: ../list.user.php");
exit();
?>