<?php
session_start();

require_once "../../../includes/conn.php";

if (!isset($_GET['id'])) {
    header("location: ../list.task.php");
    exit();
}

$task_id = mysqli_real_escape_string($conn, $_GET['id']);

/*
| GET FILE
*/
$query = mysqli_query($conn, "
    SELECT task_submit
    FROM tasks_tbl
    WHERE task_id = '$task_id'
");

$data = mysqli_fetch_assoc($query);

if (!empty($data['task_submit'])) {

    $file_path = "../../../uploads/submissions/" . $data['task_submit'];

    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

/*
| RESET SUBMISSION
*/
mysqli_query($conn, "
    UPDATE tasks_tbl
    SET
        task_submit = NULL,
        submission_text = NULL,
        submitted_by = NULL,
        submitted_at = NULL
    WHERE task_id = '$task_id'
");

$_SESSION['success'] = "Submission deleted successfully.";

header("location: ../task.view.php?id=$task_id");
exit();
?>