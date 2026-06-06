<?php
require_once "../../../includes/conn.php";
include_once "../../../includes/session.start.php";
include_once "../../../includes/utils/db.utils.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login/login.php");
    exit();
}

if (!isset($_POST['submit'])) {
    header("Location: ../compose.mail.php");
    exit();
}

$sender_id = (int) $_SESSION['user_id'];
$receiver_id = isset($_POST['receiver_id']) ? (int) $_POST['receiver_id'] : 0;
$task_id = isset($_POST['task_id']) ? (int) $_POST['task_id'] : 0;
$message = mysqli_real_escape_string($conn, trim($_POST['message'] ?? ''));
$role = $_SESSION['role'];

if ($receiver_id <= 0 || $task_id <= 0 || $message === '') {
    $_SESSION['error'] = "Please complete all mail fields.";
    header("Location: ../compose.mail.php?task_id=" . $task_id);
    exit();
}

if (!can_view_task($conn, $task_id, $sender_id, $role)) {
    $_SESSION['error'] = "You cannot send mail for this task.";
    header("Location: ../compose.mail.php");
    exit();
}

$receiver_check = mysqli_query($conn, "
    SELECT users_tbl.user_id
    FROM users_tbl
    LEFT JOIN task_members_tbl
        ON task_members_tbl.user_id = users_tbl.user_id
        AND task_members_tbl.task_id = '$task_id'
    WHERE users_tbl.user_id = '$receiver_id'
    AND (
        task_members_tbl.task_id IS NOT NULL
        OR users_tbl.role = 1
    )
");

if (!$receiver_check || mysqli_num_rows($receiver_check) == 0) {
    $_SESSION['error'] = "Receiver must be an admin or assigned to the selected task.";
    header("Location: ../compose.mail.php?task_id=" . $task_id);
    exit();
}

mysqli_query($conn, "
    INSERT INTO mails_tbl
    (
        sender_id,
        receiver_id,
        task_id,
        message
    )
    VALUES
    (
        '$sender_id',
        '$receiver_id',
        '$task_id',
        '$message'
    )
");

$_SESSION['success'] = "Mail sent successfully.";
header("Location: ../sent.php");
exit();
?>
