<?php 
session_start();

include '../../../includes/conn.php';



if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $check_username = mysqli_query($conn, "SELECT * FROM users_tbl LEFT JOIN roles_tbl ON users_tbl.role = roles_tbl.role_id 
    WHERE username = '$username'");

     if (!$check_username) {
        die("Query failed: " . mysqli_error($conn));
    }

    $result = mysqli_num_rows($check_username);

    if ($result == 1) {
        $row = mysqli_fetch_array($check_username);
 
        $check_pass = password_verify($password, $row['password']);

    if  ($check_pass) {
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['id'] = $row['user_id'];

        $_SESSION['success_login'] = true;
        header("location: ../../dashboard/dashboard.php");
        exit();


    } else {
        $_SESSION['error_password'] = true;
        header("location: ../login.php");
        exit();
    }

    } else {
        $_SESSION['error_username'] = true;
        header("location: ../login.php");
        exit();

    }
    }

?>
