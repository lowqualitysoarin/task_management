<?php
session_start();
require_once '../../../includes/conn.php';

if (!isset($_GET['task_id'])) {
    header("location: ../list.task.php");
    exit();
}

$task_id = $_GET['task_id'];

mysqli_query($conn, "DELETE FROM tasks_tbl WHERE task_id = '$task_id'");

$_SESSION['success'] = "Task deleted successfully";

header("location: ../list.task.php");
exit();
?>