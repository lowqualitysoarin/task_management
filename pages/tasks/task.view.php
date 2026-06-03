<?php
session_start();

require_once "../../includes/conn.php";
include_once "../../includes/utils/user.utils.php";

if (!isset($_GET['id'])) {
    die("Task ID not found.");
}

$task_id = mysqli_real_escape_string($conn, $_GET['id']);

$query = mysqli_query($conn, "
    SELECT tasks_tbl.*
    FROM tasks_tbl
    WHERE task_id = '$task_id'
");

$task = mysqli_fetch_assoc($query);

if (!$task) {
    die("Task not found.");
}

/*
| GET USER ROLE
| users_tbl.role stores role_id: 1 = admin, 2 = member
*/
$session_user_id = $_SESSION['user_id'];

$role_query = mysqli_query($conn, "
    SELECT role
    FROM users_tbl
    WHERE user_id = '$session_user_id'
");

$role_data = mysqli_fetch_assoc($role_query);

$role_id = $role_data['role'] ?? null; // Returns 1 (admin) or 2 (member)

/*
| STATUS
*/
switch ($task['task_status']) {
    case 1:
        $statusText = "Pending";
        $statusClass = "pending";
        break;
    case 2:
        $statusText = "In Progress";
        $statusClass = "ongoing";
        break;
    case 3:
        $statusText = "Completed";
        $statusClass = "done";
        break;
    case 4:
        $statusText = "Incomplete";
        $statusClass = "urgent";
        break;
    default:
        $statusText = "Unknown";
        $statusClass = "pending";
}

/*
| SUBMISSION CHECK VARIABLES
*/
$hasText = !empty($task['submission_text']);
$hasFile = !empty($task['task_submit']);
$hasSubmission = $hasText || $hasFile;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task View</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .wrapper {
            max-width: 1400px;
            margin: auto;
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .back-btn {
            text-decoration: none;
            color: #555;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            color: #4f46e5;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .title-area h1 {
            font-size: 38px;
            margin-bottom: 10px;
        }

        .title-area p {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.7;
        }

        .status-badge {
            padding: 14px 24px;
            border-radius: 14px;
            color: #fff;
            font-weight: bold;
            font-size: 15px;
            min-width: 180px;
            text-align: center;
        }

        .pending {
            background: #f59e0b;
        }

        .ongoing {
            background: #4f46e5;
        }

        .done {
            background: #10b981;
        }

        .urgent {
            background: #ef4444;
        }

        .tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .tag {
            background: #eef2ff;
            color: #4f46e5;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        @media(max-width:992px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .card-title i {
            color: #4f46e5;
            font-size: 22px;
        }

        .description {
            line-height: 1.9;
            color: #4b5563;
            font-size: 15px;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .info-item:last-child {
            border: none;
            padding-bottom: 0;
        }

        .info-label {
            color: #6b7280;
            font-size: 14px;
        }

        .info-value {
            font-weight: 600;
            text-align: right;
        }

        .no-image {
            background: #f9fafb;
            border: 2px dashed #ddd;
            border-radius: 16px;
            padding: 50px;
            text-align: center;
            color: #9ca3af;
        }

        .no-image i {
            font-size: 55px;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            color: white !important;
            font-size: 14px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-primary {
            background: #4f46e5 !important;
        }

        .btn-success {
            background: #10b981 !important;
        }

        .btn-danger {
            background: #ef4444 !important;
        }

        textarea.form-control {
            border-radius: 10px;
            padding: 15px;
        }

        input.form-control {
            border-radius: 10px;
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <!-- TOPBAR -->
        <div class="topbar">
            <a href="../dashboard/dashboard.php" class="back-btn">
                <i class="las la-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- HEADER -->
        <div class="header">
            <div class="title-area">
                <h1><?php echo htmlspecialchars($task['task_name']); ?></h1>
                <p>Detailed task overview and attachment preview for assigned members.</p>
            </div>
            <div class="status-badge <?php echo $statusClass; ?>">
                <?php echo $statusText; ?>
            </div>
        </div>

        <!-- TAGS -->
        <div class="tags">
            <div class="tag">Task #<?php echo $task['task_id']; ?></div>
            <div class="tag">Assigned Task</div>
            <div class="tag">Project Management</div>
        </div>

        <!-- GRID -->
        <div class="content-grid">

            <!-- LEFT COLUMN -->
            <div>
                <!-- DESCRIPTION -->
                <div class="card">
                    <div class="card-title">
                        <i class="las la-file-alt"></i> Description
                    </div>
                    <div class="description">
                        <?php echo nl2br(htmlspecialchars($task['task_description'])); ?>
                    </div>
                </div>

                <!-- ATTACHMENTS -->
                <div class="card">
                    <div class="card-title">
                        <i class="las la-paperclip"></i> Attachments
                    </div>
                    <?php if (!empty($task['task_image'])) { ?>
                        <a href="../../uploads/attachments/<?php echo $task['task_image']; ?>" target="_blank"
                            class="btn btn-success">
                            <i class="las la-eye"></i> View Attachment
                        </a>
                    <?php } else { ?>
                        <div class="no-image">
                            <i class="las la-image"></i>
                            <p>No attachment uploaded.</p>
                        </div>
                    <?php } ?>
                </div>

                <!-- TASK SUBMISSION -->
                <div class="card">
                    <div class="card-title">
                        <i class="las la-upload"></i> Task Submission
                    </div>

                    <!-- ================= MEMBER ================= -->
                    <?php if ($role_id == 2) { ?>

                        <?php if (empty($task['submission_text']) && empty($task['task_submit'])) { ?>

                            <!-- SUBMIT FORM -->
                            <form action="ctrlData/ctrl.add.submission.php?id=<?php echo $task_id; ?>" method="POST"
                                enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label class="form-label"><strong>Submission Text</strong></label>
                                    <textarea name="submission_text" class="form-control" rows="5"
                                        placeholder="Write your submission here..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>Attachment (optional)</strong></label>
                                    <input type="file" name="submission_attachment" class="form-control">
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">
                                    Submit Task
                                </button>

                            </form>

                        <?php } else { ?>

                            <!-- VIEW SUBMISSION -->
                            <?php if (!empty($task['submission_text'])) { ?>
                                <div class="mb-3">
                                    <strong>Submission Text:</strong>
                                    <div class="p-3 bg-light rounded">
                                        <?php echo nl2br(htmlspecialchars($task['submission_text'])); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (!empty($task['task_submit'])) { ?>

                                <div class="mt-3">

                                    <strong>Attachment Actions:</strong>

                                    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">

                                        <!-- VIEW BUTTON -->
                                        <a href="../../uploads/submissions/<?php echo $task['task_submit']; ?>" target="_blank"
                                            class="btn btn-success">

                                            <i class="las la-eye"></i>

                                            View Attachment

                                        </a>

                                        <!-- DELETE BUTTON -->
                                        <a href="ctrlData/ctrl.delete.submission.php?id=<?php echo $task_id; ?>"
                                            class="btn btn-danger" onclick="return confirm('Delete submission?')">

                                            <i class="las la-trash"></i>

                                            Delete Submission

                                        </a>

                                    </div>

                                </div>

                            <?php } ?>

                        <?php } ?>

                    <?php } ?>

                    <!-- ================= ADMIN ================= -->
                    <?php if ($role_id == 1) { ?>

                        <?php if (!empty($task['submission_text']) || !empty($task['task_submit'])) { ?>

                            <?php if (!empty($task['submission_text'])) { ?>
                                <div class="mb-3">
                                    <strong>Submission Text:</strong>
                                    <div class="p-3 bg-light rounded">
                                        <?php echo nl2br(htmlspecialchars($task['submission_text'])); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (!empty($task['task_submit'])) { ?>
                                <a href="../../uploads/submissions/<?php echo $task['task_submit']; ?>" target="_blank"
                                    class="btn btn-success">
                                    View Attachment
                                </a>
                            <?php } ?>

                            <div class="mt-2">
                                <strong>Submitted By:</strong>
                                <?php echo htmlspecialchars($task['submitted_by'] ?? 'Unknown'); ?>
                            </div>

                        <?php } else { ?>

                            <div class="no-image">
                                No submission yet
                            </div>

                        <?php } ?>

                    <?php } ?>

                </div>
                <!-- END TASK SUBMISSION -->

            </div>
            <!-- END LEFT COLUMN -->

            <!-- RIGHT COLUMN -->
            <div>
                <!-- TASK INFO -->
                <div class="card">
                    <div class="card-title">
                        <i class="las la-info-circle"></i> Task Information
                    </div>
                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-label">Assigned Member</div>
                            <div class="info-value">
                                <div class="d-flex align-items-center">
                                    <?php
                                    $select_members = mysqli_query($conn, "
                                        SELECT * FROM task_members_tbl
                                        LEFT JOIN users_tbl ON users_tbl.user_id = task_members_tbl.user_id
                                        WHERE task_id = '$task_id'
                                    ");
                                    $members_num = mysqli_num_rows($select_members);

                                    if ($members_num != 0) {
                                        while ($row = mysqli_fetch_array($select_members)) {
                                            ?>
                                            <div class="text-center mx-1">
                                                <img class="rounded-circle"
                                                    src="<?php echo get_user_profile_image($conn, $row['user_id']); ?>"
                                                    alt="<?php echo $row['full_name']; ?>"
                                                    title="<?php echo $row['full_name']; ?>" style="width:35px; height:35px;">
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo 'No Assignees';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Task ID</div>
                            <div class="info-value">#<?php echo $task['task_id']; ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value"><?php echo $statusText; ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Attachment</div>
                            <div class="info-value">
                                <?php echo !empty($task['task_image']) ? 'Available' : 'None'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END RIGHT COLUMN -->

        </div>
        <!-- END GRID -->

    </div>
    <!-- END WRAPPER -->

</body>

</html>