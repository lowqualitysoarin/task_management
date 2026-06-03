<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_POST['submit'])) {
    header("location: ../add.user.php");
    exit();
}

/* INPUTS */
$full_name = mysqli_real_escape_string($conn, $_POST["fullname"]);
$username  = mysqli_real_escape_string($conn, $_POST["username"]);
$email     = mysqli_real_escape_string($conn, $_POST["email"]);
$role      = mysqli_real_escape_string($conn, $_POST["role"]);

$password = $_POST["password"];
$hashed_pass = password_hash($password, PASSWORD_DEFAULT);

/* DEFAULT VALUES */
$bio = "";

/* INSERT QUERY */
$query = "
    INSERT INTO users_tbl (
        full_name,
        username,
        email,
        password,
        bio,
        role
    )
    VALUES (
        '$full_name',
        '$username',
        '$email',
        '$hashed_pass',
        '$bio',
        '$role'
    )
";

$insert_user = mysqli_query($conn, $query);

/* RESULT */
if ($insert_user) {
    $_SESSION['success'] = "User added successfully.";
} else {
    $_SESSION['error'] = "Failed to add user: " . mysqli_error($conn);
}

header("location: ../list.user.php");
exit();
?>