<?php
session_start();
require_once "../../../includes/conn.php";

if (!isset($_POST['submit'])) {
    header("location: ../list.task.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = mysqli_real_escape_string($conn, $_GET['id']);

$submission_text = mysqli_real_escape_string($conn, $_POST['submission_text'] ?? '');

/*
| GET USER FULL NAME
*/
$user_query = mysqli_query($conn, "
    SELECT full_name
    FROM users_tbl
    WHERE user_id = '$user_id'
");

$user = mysqli_fetch_assoc($user_query);
$full_name = $user['full_name'] ?? '';

/*
| GET EXISTING TASK DATA (IMPORTANT)
*/
$task_query = mysqli_query($conn, "
    SELECT task_submit
    FROM tasks_tbl
    WHERE task_id = '$task_id'
");

$task_data = mysqli_fetch_assoc($task_query);
$existing_file = $task_data['task_submit'] ?? null;

/*
| FILE UPLOAD
*/
$attachment = null;

if (
    isset($_FILES['submission_attachment']) &&
    $_FILES['submission_attachment']['error'] == 0
) {

    $allowed = ['jpg','jpeg','png','gif','pdf','doc','docx','xls','xlsx'];

    $fileName = $_FILES['submission_attachment']['name'];
    $tmpName = $_FILES['submission_attachment']['tmp_name'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {

        $attachment = time() . '_' . preg_replace('/\s+/', '_', $fileName);

        move_uploaded_file(
            $tmpName,
            "../../../uploads/submissions/" . $attachment
        );
    }
}

/*
| FINAL FILE (KEEP OLD IF NO NEW UPLOAD)
*/
$final_file = $attachment ? $attachment : $existing_file;

/*
| UPDATE TASK SUBMISSION (MAIN CHANGE)
*/
$update = mysqli_query($conn, "
    UPDATE tasks_tbl
    SET
        task_submit = " . ($final_file ? "'$final_file'" : "NULL") . ",
        submission_text = '$submission_text',
        submitted_by = '$full_name',
        submitted_at = NOW()
    WHERE task_id = '$task_id'
");

/*
| ERROR CHECK (IMPORTANT FOR DEBUGGING)
*/
if (!$update) {
    die("SQL Error: " . mysqli_error($conn));
}

/*
| SUCCESS
*/
$_SESSION['success'] = "Task submitted successfully.";
header("location: ../task.view.php?id=$task_id");
exit();
?>