<?php

require_once "../../../includes/conn.php";
include "../../../includes/session.start.php";

if (isset($_POST['submit'])) {

    $user_id = $_GET['user_id'];

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  
    if ($_SESSION['role'] == 'Admin') {

        $role = $_POST['role'];

    } else {

        $get_role = mysqli_query($conn, "SELECT role FROM users_tbl WHERE user_id = '$user_id'");
        $role_data = mysqli_fetch_assoc($get_role);

        $role = $role_data['role'];
    }

    

    $update_user = mysqli_query($conn, "
        UPDATE users_tbl 
        SET 
            full_name = '$fullname',
            username  = '$username',
            email     = '$email',
            password  = '$password',
            role      = '$role'
        WHERE user_id = '$user_id'
    ");

    if ($update_user) {

        

        if ($_SESSION['user_id'] == $user_id) {

            $_SESSION['fullname'] = $fullname;

            // sync session role properly
            if ($role == 1) {
                $_SESSION['role'] = 'Admin';
            } else {
                $_SESSION['role'] = 'Member';
            }
        }


        if ($_SESSION['role'] == 'Admin') {

            header("location: ../list.user.php");
            exit();

        } else {

            header("location: ../../dashboard/dashboard.php");
            exit();

        }

    } else {

        echo "Failed to update user: " . mysqli_error($conn);
    }
}
?>