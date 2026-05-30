<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_POST['submit'])) {
    header("location: ../add.user.php");
    exit();
}

$full_name = $_POST["fullname"];
$username = $_POST["username"];
$email = $_POST["email"];

$password = $_POST["password"];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

$role = $_POST["role"];

mysqli_query($conn, "
    INSERT INTO users_tbl (full_name, username, email, password, role)
    VALUES ('$full_name', '$username', '$email', '$hashed_pass', '$role')
");

$_SESSION['success'] = "User added successfully.";

header("location: ../list.user.php");
exit();
?>