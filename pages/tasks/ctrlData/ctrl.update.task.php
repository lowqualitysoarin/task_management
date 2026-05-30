<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_POST['submit']) || !isset($_GET['task_id'])) {
    header("location: ../list.task.php");
    exit();
}

$task_id = $_GET['task_id'];

$task_name = $_POST['taskname'];
$task_description = mysqli_real_escape_string($conn, $_POST['taskdescription']);
$assigned_member = isset($_POST['assignedmember']) ? $_POST['assignedmember'] : 0;
$task_status = $_POST['taskstatus'];
$assignees = isset($_POST['assignees']) ? $_POST['assignees'] : [];

mysqli_query(
    $conn,
    "UPDATE tasks_tbl
     SET task_name = '$task_name',
         task_description = '$task_description',
         assigned_user_id = '$assigned_member',
         task_status = '$task_status'
     WHERE task_id = '$task_id'"
);

mysqli_query($conn, "DELETE FROM task_members_tbl WHERE task_id = '$task_id'");
foreach ($assignees as $user_id) {
    mysqli_query($conn, "INSERT INTO task_members_tbl (task_id, user_id) VALUES ('$task_id', '$user_id')");
}

$_SESSION['success'] = "Task updated successfully.";

header("location: ../list.task.php");
exit();
?>