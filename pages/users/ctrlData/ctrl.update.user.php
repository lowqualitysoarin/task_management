<?php
require_once "../../../includes/conn.php";

if (!isset($_POST['submit']) || !isset($_GET['user_id'])) {
    header("location: ../list.user.php");
    exit();
}

$user_id = $_GET['user_id'];

$full_name = $_POST['fullname'];
$username = $_POST['username'];
$email = $_POST['email'];

$password = $_POST['password'];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

$role = $_POST['role'];

mysqli_query($conn, "UPDATE users_tbl SET full_name = '$full_name', username = '$username', email = '$email', password = '$hashed_pass', role = '$role' WHERE user_id = '$user_id'");
header("location: ../list.user.php");
exit();