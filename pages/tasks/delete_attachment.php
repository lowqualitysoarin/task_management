<?php

include "../../includes/conn.php";

if(isset($_GET['id']))
{
    $task_id = mysqli_real_escape_string($conn,$_GET['id']);

    $query = mysqli_query($conn,"
        SELECT task_image
        FROM tasks_tbl
        WHERE task_id='$task_id'
    ");

    $row = mysqli_fetch_assoc($query);

    if(!empty($row['task_image']))
    {
        $file = "../../uploads/".$row['task_image'];

        if(file_exists($file))
        {
            unlink($file);
        }

        mysqli_query($conn,"
            UPDATE tasks_tbl
            SET task_image=NULL
            WHERE task_id='$task_id'
        ");
    }

    header("Location: task.view.php?id=".$task_id);
    exit();
}