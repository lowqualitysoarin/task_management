<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_POST['submit'])) {
    header("location: ../add.task.php");
    exit();
}

$task_name = mysqli_real_escape_string($conn, $_POST['taskname']);
$task_description = mysqli_real_escape_string($conn, $_POST['taskdescription']);

$assignees = isset($_POST['assignees']) ? $_POST['assignees'] : [];


$task_status = 1;

/*
| UPLOAD ATTACHMENT
*/
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

/*
| GET NEXT TASK ID
*/
$next_id = 1;

$id_query = mysqli_query(
    $conn,
    "SELECT AUTO_INCREMENT
     FROM information_schema.TABLES
     WHERE TABLE_SCHEMA = 'task_management'
     AND TABLE_NAME = 'tasks_tbl'"
);

if ($id_query) {
    $id_row = mysqli_fetch_array($id_query);
    $next_id = (int)$id_row['AUTO_INCREMENT'];
}

/*
| INSERT TASK
*/
mysqli_query(
    $conn,
    "INSERT INTO tasks_tbl
    (
        task_name,
        task_description,
        task_status,
        task_image,
        task_submit
    )
    VALUES
    (
        '$task_name',
        '$task_description',
        '$task_status',
        '$attachment',
        0
    )"
);
/*
| INSERT TASK MEMBERS
*/
foreach ($assignees as $user_id) {

    mysqli_query(
        $conn,
        "INSERT INTO task_members_tbl
        (
            task_id,
            user_id
        )
        VALUES
        (
            '$next_id',
            '$user_id'
        )"
    );
}

/*
| SUCCESS MESSAGE
*/
$_SESSION['success'] = "Task added successfully.";

header("location: ../list.task.php");
exit();
?>