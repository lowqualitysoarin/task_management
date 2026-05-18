<?php
include "../../includes/conn.php";

$task_id = $_POST['task_id'];
$status_id = $_POST['status_id'];

mysqli_query($conn, "
    UPDATE task_tbl 
    SET status_id = '$status_id'
    WHERE task_id = '$task_id'
");
?>