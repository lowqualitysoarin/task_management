<?php
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

mysqli_query($conn, "UPDATE tasks_tbl SET task_name = '$task_name', task_description = '$task_description', assigned_user_id = '$assigned_member', task_status = '$task_status' WHERE task_id = '$task_id'");
header("location: ../list.task.php");
    exit();