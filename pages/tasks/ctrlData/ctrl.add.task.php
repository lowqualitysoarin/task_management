<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_POST['submit'])) {
    header("location: ../add.task.php");
    exit();
}

$task_name = $_POST['taskname'];
$task_description = mysqli_real_escape_string($conn, $_POST['taskdescription']);
$assigned_member = isset($_POST['assignedmember']) ? $_POST['assignedmember'] : 0;
$assignees = isset($_POST['assignees']) ? $_POST['assignees'] : [];

$next_id = 1;
$id_query = mysqli_query($conn, "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'task_management' AND TABLE_NAME = 'tasks_tbl'");
if ($id_query) {
    $id_row = mysqli_fetch_array($id_query);
    $next_id = (int)$id_row['AUTO_INCREMENT'];
}

// Save task
mysqli_query(
    $conn,
    "INSERT INTO tasks_tbl (task_name, task_description, assigned_user_id)
     VALUES ('$task_name', '$task_description', '$assigned_member')"
);

foreach ($assignees as $user_id) {
    mysqli_query($conn, "INSERT INTO task_members_tbl (task_id, user_id) VALUES ('$next_id', '$user_id')");
}

$_SESSION['success'] = "Task added successfully.";

header("location: ../list.task.php");
exit();
?>