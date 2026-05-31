<?php

include "../../includes/conn.php";

if(isset($_POST['upload_attachment']))
{
    $task_id = mysqli_real_escape_string($conn,$_POST['task_id']);

    if(isset($_FILES['attachment']) && $_FILES['attachment']['error']==0)
    {
        $allowed = [
            'jpg','jpeg','png','gif','webp',
            'pdf','doc','docx','xls','xlsx'
        ];

        $fileName = $_FILES['attachment']['name'];
        $tmpName = $_FILES['attachment']['tmp_name'];

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if(!in_array($extension,$allowed))
        {
            die("Invalid file type.");
        }

        $newFileName = time().'_'.$fileName;

        $uploadPath = "../../uploads/".$newFileName;

        if(move_uploaded_file($tmpName,$uploadPath))
        {
            $old = mysqli_query($conn,"
                SELECT task_image
                FROM tasks_tbl
                WHERE task_id='$task_id'
            ");

            $oldFile = mysqli_fetch_assoc($old);

            if(!empty($oldFile['task_image']))
            {
                $oldPath = "../../uploads/".$oldFile['task_image'];

                if(file_exists($oldPath))
                {
                    unlink($oldPath);
                }
            }

            mysqli_query($conn,"
                UPDATE tasks_tbl
                SET task_image='$newFileName'
                WHERE task_id='$task_id'
            ");
        }
    }

    header("Location: task.view.php?id=".$task_id);
    exit();
}