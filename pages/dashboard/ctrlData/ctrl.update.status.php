<?php
require_once "../../../includes/conn.php";

if (!isset($_POST['submit']) || !isset($_GET['task_id'])) {
    header("location: ../dashboard.php");
    exit();
}

$task_id = $_GET['task_id'];
$task_status = $_POST['taskstatus'];

mysqli_query($conn, "UPDATE tasks_tbl SET task_status = '$task_status' WHERE task_id = '$task_id'");
header("location: ../dashboard.php");