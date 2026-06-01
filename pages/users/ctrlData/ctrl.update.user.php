<?php
session_start();
require_once "../../../includes/conn.php";
include "../../../includes/session.start.php";

if (!isset($_GET['user_id'])) {
    header("Location: ../list.user.php");
    exit();
}

$user_id = $_GET['user_id'];

/* =========================
   UPDATE USER INFO
========================= */
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

            $_SESSION['role'] = ($role == 1) ? 'Admin' : 'Member';
        }

        $_SESSION['success'] = "User updated successfully.";

        if ($_SESSION['role'] == 'Admin') {
            header("Location: ../list.user.php");
        } else {
            header("Location: ../../dashboard/dashboard.php");
        }
        exit();
    } else {
        echo "Failed to update user: " . mysqli_error($conn);
    }
}


/* =========================
   UPDATE PROFILE IMAGE
========================= */
if (isset($_POST['submitprofile'])) {

    $file = $_FILES['profileimage'];

    if (!is_file_valid($file)) {
        header("Location: ../edit.user.php?user_id=" . $user_id);
        exit();
    }

    $file_name = $file['name'];
    $file_temp_name = $file['tmp_name'];

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $new_file_name = "user_" . $user_id . "_" . time() . "." . $file_ext;

    $upload_file_path = $_SERVER['DOCUMENT_ROOT'] . '/task_management/uploads/profiles/' . $new_file_name;
    $file_path = "uploads/profiles/" . $new_file_name;

    if (move_uploaded_file($file_temp_name, $upload_file_path)) {

        $query = mysqli_query($conn, "
            UPDATE users_tbl 
            SET profile = '$file_path' 
            WHERE user_id = '$user_id'
        ");

        if ($query) {
            header("Location: ../edit.user.php?user_id=" . $user_id);
            exit();
        } else {
            echo "Database error.";
        }

    } else {
        echo "Failed to move uploaded file.";
    }
}


/* =========================
   DELETE PROFILE IMAGE
========================= */
if (isset($_POST['deleteprofile'])) {

    $select_user = mysqli_query($conn, "SELECT * FROM users_tbl WHERE user_id = '$user_id'");
    $user = mysqli_fetch_array($select_user);

    $abs_file_path = $_SERVER['DOCUMENT_ROOT'] . '/task_management/' . $user['profile'];

    if (!empty($user['profile']) && file_exists($abs_file_path)) {
        unlink($abs_file_path);
    }

    mysqli_query($conn, "UPDATE users_tbl SET profile = NULL WHERE user_id = '$user_id'");

    header("Location: ../edit.user.php?user_id=" . $user_id);
    exit();
}


/* =========================
   UPDATE BIO (FIXED)
   → THIS IS YOUR ISSUE FIX
========================= */
if (isset($_POST['submitbio'])) {

    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    $update_bio = mysqli_query($conn, "
        UPDATE users_tbl
        SET bio = '$bio'
        WHERE user_id = '$user_id'
    ");

    if ($update_bio) {
        $_SESSION['success'] = "Bio updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update bio.";
    }

    // IMPORTANT: redirect back to PROFILE (where alert should show)
    header("Location: ../../profile/profile.php?user_id=" . $user_id);
    exit();
}


/* =========================
   FILE VALIDATION
========================= */
function is_file_valid($file): bool
{
    if (!isset($file)) return false;

    $file_error = $file['error'];
    $file_size  = $file['size'];

    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if ($file_error !== 0) return false;
    if (!in_array($file_ext, $allowed_ext)) return false;
    if ($file_size > 2097152) return false;

    return true;
}
?>