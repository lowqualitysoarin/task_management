<?php
require_once '../../../includes/conn.php';
include_once '../../../includes/session.start.php';

if (!isset($_POST['submit'])) return;

$full_name = $_POST['fullname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$user_check = mysqli_query($conn, "SELECT * FROM users_tbl WHERE username = '$username'");
if (mysqli_num_rows($user_check)) {
    $_SESSION['error_username'] = true;
    header("Location: ../register.php");
    exit();
}

$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

mysqli_query($conn, "INSERT INTO users_tbl (full_name, username, email, password) VALUES ('$full_name', '$username', '$email', '$hashed_pass')");
$_SESSION['register_success'] = true;
header("Location: ../../login/login.php");
exit();