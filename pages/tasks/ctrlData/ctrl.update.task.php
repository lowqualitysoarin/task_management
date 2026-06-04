<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_GET['task_id'])) {
    header("location: ../list.task.php");
    exit();
}
$task_id = $_GET['task_id'];

if (isset($_POST['submit'])) {
    $task_name = $_POST['taskname'];
    $task_description = mysqli_real_escape_string($conn, $_POST['taskdescription']);
    $assigned_member = isset($_POST['assignedmember']) ? $_POST['assignedmember'] : 0;
    $task_status = $_POST['taskstatus'];
    $assignees = isset($_POST['assignees']) ? $_POST['assignees'] : [];
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

    mysqli_query(
        $conn,
        "UPDATE tasks_tbl
     SET task_name = '$task_name',
         task_description = '$task_description',
         task_status = '$task_status'
     WHERE task_id = '$task_id'"
    );

    mysqli_query($conn, "DELETE FROM task_members_tbl WHERE task_id = '$task_id'");
    foreach ($assignees as $user_id) {
        mysqli_query($conn, "INSERT INTO task_members_tbl (task_id, user_id) VALUES ('$task_id', '$user_id')");
    }

    mysqli_query($conn, "DELETE FROM task_tags_tbl WHERE task_id = '$task_id'");
    foreach ($tags as $tag_id) {
        mysqli_query($conn, "INSERT INTO task_tags_tbl (task_id, tag_id) VALUES ('$task_id', '$tag_id')");
    }
 
    $_SESSION['success'] = "Task updated successfully.";

    header("location: ../list.task.php");
    exit();
}

if (isset($_POST['submitattachment'])) {
    $attachment = NULL;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $allowed = [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'pdf',
            'doc',
            'docx',
            'xls',
            'xlsx'
        ];

        $fileName = $_FILES['attachment']['name'];
        $tmpName = $_FILES['attachment']['tmp_name'];

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($extension, $allowed)) {

            $attachment = time() . '_' . $fileName;

            move_uploaded_file(
                $tmpName,
                "../../../uploads/attachments/" . $attachment
            );
        }
    }

    mysqli_query(
        $conn,
        "UPDATE tasks_tbl SET
        task_attachment = '$attachment'
        WHERE task_id = '$task_id'"
    );

    header("Location: ../edit.task.php?task_id=" . $task_id);
    exit();
}
?>