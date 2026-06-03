<?php
require_once "../../includes/conn.php";
session_start();

if (!isset($_GET['id'])) {
    die("Task not found.");
}

$task_id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT *
    FROM tasks_tbl
    WHERE task_id = '$task_id'
");

$task = mysqli_fetch_assoc($query);

if (!$task) {
    die("Task not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Submission</title>

    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body class="p-5">

    <div class="container">

        <h2 class="mb-4">
            Submit Task
        </h2>

        <form
            action="ctrl/ctrl.add.submission.php?id=<?php echo $task_id; ?>"
            method="POST"
            enctype="multipart/form-data">

            <div class="mb-3">

                <label class="form-label">
                    Submission Text
                </label>

                <textarea
                    name="submission_text"
                    class="form-control"
                    rows="5"></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Attachment
                </label>

                <input
                    type="file"
                    name="submission_attachment"
                    class="form-control">

            </div>

            <button type="submit" name="submit" class="btn btn-primary">
                Submit Task
            </button>

        </form>

    </div>

</body>
</html>