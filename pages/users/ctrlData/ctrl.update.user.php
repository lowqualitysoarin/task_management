<?php
session_start();
require_once "../../../includes/conn.php";
include "../../../includes/session.start.php";

if (!isset($_GET['user_id'])) {
    header('../list.user.php');
    exit();
}

$user_id = $_GET['user_id'];

if (isset($_POST['submit'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
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
            $_SESSION['success'] = "User updated successfully.";
            header("location: ../list.user.php");
            exit();

        } else {
            $_SESSION['success'] = "Profile updated successfully.";
            header("location: ../../dashboard/dashboard.php");
            exit();

        }

    } else {

        echo "Failed to update user: " . mysqli_error($conn);
    }
} 

if (isset($_POST['submitprofile'])) {
    $file = $_FILES['profileimage'];

    if (!is_file_valid($file)) {
        header('../edit.user.php?user_id=' . (string) $user_id);
        exit();
    }

    $file_name = $file['name'];
    $file_temp_name = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    $new_file_name = "user_" . $user_id . "_" . time() . "." . $file_ext;

    $upload_file_path = $_SERVER['DOCUMENT_ROOT'] . '/task_management/uploads/' . $new_file_name;
    $file_path = "uploads/" . $new_file_name;

    if (move_uploaded_file($file_temp_name, $upload_file_path)) {
        $query = mysqli_query($conn, "UPDATE users_tbl SET profile = '$file_path' WHERE user_id = '$user_id'");
        if ($query) {
            header("Location: ../list.user.php");
            exit();
        } else {
            echo "Database error.";
        }
    } else {
        echo "Failed to move uploaded file.";
    }
}

if (isset($_POST['deleteprofile'])) {
    $select_user = mysqli_query($conn, "SELECT * FROM users_tbl WHERE user_id = '$user_id'");
    $user = mysqli_fetch_array($select_user);

    $abs_file_path = $_SERVER['DOCUMENT_ROOT'] . '/task_management/' . $user['profile'];
    if (isset($user['profile']) && file_exists($abs_file_path)) {
        unlink($abs_file_path);
    }

    mysqli_query($conn, "UPDATE users_tbl SET profile = null WHERE user_id = '$user_id'");
    header("Location: ../list.user.php");
    exit();
}

function is_file_valid($file) : bool {
    if (!isset($file)) return false;

    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if ($file_error !== 0) return false;
    if (!in_array($file_ext, $allowed_ext)) return false;
    if ($file_size > 2097152) return false;

    return true;
}
?>