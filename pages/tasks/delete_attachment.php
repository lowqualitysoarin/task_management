<?php
include "../../includes/conn.php";

if(isset($_GET['id']))
{
    $task_id = mysqli_real_escape_string($conn,$_GET['id']);

    $query = mysqli_query($conn,"
        SELECT task_attachment
        FROM tasks_tbl
        WHERE task_id='$task_id'
    ");

    $row = mysqli_fetch_assoc($query);

    if(!empty($row['task_attachment']))
    {
        $file = "../../uploads/attachments/".$row['task_attachment'];

        if(file_exists($file))
        {
            unlink($file);
            echo 'deleted';
        }

        mysqli_query($conn,"
            UPDATE tasks_tbl
            SET task_attachment=NULL
            WHERE task_id='$task_id'
        ");
    }

    header("Location: edit.task.php?task_id=".$task_id);
    exit();
}