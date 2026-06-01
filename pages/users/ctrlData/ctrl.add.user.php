<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_POST['submit'])) {
    header("location: ../add.user.php");
    exit();
}

$full_name = mysqli_real_escape_string($conn, $_POST["fullname"]);
$username = mysqli_real_escape_string($conn, $_POST["username"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);

$password = $_POST["password"];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

$role = mysqli_real_escape_string($conn, $_POST["role"]);

/* Default bio for newly created users */
$bio = "";

$insert_user = mysqli_query($conn, "
    INSERT INTO users_tbl (
        full_name,
        username,
        email,
        password,
        bio,
        role
    WHERE user_id = '$user_id'
    )
    VALUES (
        '$full_name',
        '$username',
        '$email',
        '$hashed_pass',
        '$bio',
        '$role'
    
    )
");

if ($insert_user) {
    $_SESSION['success'] = "User added successfully.";
} else {
    $_SESSION['error'] = "Failed to add user.";
}

header("location: ../list.user.php");
exit();
?>