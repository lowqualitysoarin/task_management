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

mysqli_query(
    $conn,
    "INSERT INTO tasks_tbl (task_name, task_description, assigned_user_id)
     VALUES ('$task_name', '$task_description', '$assigned_member')"
);

$_SESSION['success'] = "Task added successfully.";

header("location: ../list.task.php");
exit();
?>