<?php require_once "../../includes/conn.php"; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/admin.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>
<?php include_once "../../includes/utils/file.utils.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Edit Task</title>

    <style>
        :root {
            --primary: #5b4dff;
            --secondary: #3f8cff;
            --muted: #64748b;
            --border: #e5e7eb;
        }

        body {
            background: #f5f7ff;
        }

        /* ================= HEADER ================= */
        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 18px;
            padding: 20px 25px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(91, 77, 255, .20);
            margin-top: 20px;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }

        .header-subtitle {
            margin: 0;
            font-size: .85rem;
            opacity: .9;
        }

        /* ================= CARD ================= */
        .glass-card {
            background: #fff;
            border-radius: 18px;
            padding: 25px;
            margin-top: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        /* SECTION HEADER */
        .section-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .section-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #eef2ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-head h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1rem;
            color: #111827;
        }

        .section-head p {
            margin: 0;
            font-size: .8rem;
            color: var(--muted);
        }

        /* INPUTS */
        .form-label {
            font-size: .85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .input-custom,
        textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 12px 12px 42px;
            font-size: .9rem;
            transition: .3s;
            background: #fff;
        }

        textarea {
            min-height: 120px;
            padding-left: 42px;
        }

        .input-custom:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(91, 77, 255, .12);
        }

        /* FILE INPUT */
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px dashed var(--border);
            border-radius: 12px;
            background: #fafaff;
        }

        /* DROPDOWN ASSIGNEES */
        .dropdown-menu {
            border-radius: 12px;
            padding: 10px;
        }

        /* BUTTON */
        .btn-add {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-weight: 700;
            margin-top: 10px;
            transition: .3s;
        }

        .btn-add:hover {
            transform: translateY(-2px);
        }

        .small-note {
            font-size: 12px;
            color: var(--muted);
        }
    </style>

    <?php include_once "../../includes/components/links.php"; ?>
</head>

<body>
    <?php #include_once "../../includes/components/preloader.php"; ?>

    <?php include_once "../../includes/elements/sidebar.php"; ?>
    <?php
    if (!isset($_GET['task_id'])) {
        header("location: ../list.task.php");
        exit();
    }

    $task_id = $_GET['task_id'];

    $select_task = mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_id = '$task_id'");
    $task = mysqli_fetch_array($select_task);

    $task_members = [];
    $select_task_members = mysqli_query($conn, "SELECT user_id FROM task_members_tbl WHERE task_id = '$task_id'");
    while ($row = mysqli_fetch_array($select_task_members)) {
        $task_members[] = (int) $row['user_id'];
    }

    $task_tags = [];
    $select_task_tags = mysqli_query($conn, "SELECT tag_id FROM task_tags_tbl WHERE task_id = '$task_id'");
    while ($row = mysqli_fetch_array($select_task_tags)) {
        $task_tags[] = (int) $row['tag_id'];
    }
    ?>

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <?php include_once "../../includes/elements/navbar.php"; ?>

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                <!-- HEADER -->
                <div class="page-header">
                    <div class="header-icon">
                        <i class="lni lni-clipboard"></i>
                    </div>
                    <div>
                        <h2 class="header-title">Update Task</h2>
                        <p class="header-subtitle">Make changes to a existing task</p>
                    </div>
                </div>

                <!-- FORM CARD -->
                <form action="ctrlData/ctrl.update.task.php?task_id=<?php echo $task_id; ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="glass-card">
                        <!-- TASK INFO -->
                        <div class="section-head">
                            <div class="section-icon"><i class="lni lni-clipboard"></i></div>
                            <div>
                                <h5>Task Information</h5>
                                <p>Enter task details</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Task Name</label>
                                <div class="input-group-custom">
                                    <i class="lni lni-pencil"></i>
                                    <input type="text" name="taskname" class="input-custom"
                                        value="<?php echo $task['task_name']; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Task Description</label>
                                <div class="input-group-custom">
                                    <i class="lni lni-text-format"></i>
                                    <textarea name="taskdescription"
                                        placeholder="Write task details..."><?php echo $task['task_description']; ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Task Status</label>
                                <div class="input-group-custom row">
                                    <?php
                                    $task_statuses = mysqli_query($conn, "SELECT * FROM task_status_tbl");
                                    while ($task_status = mysqli_fetch_array($task_statuses)) {
                                        ?>
                                        <div class="col">
                                            <div class="form-check radio-style mb-20">
                                                <input class="form-check-input" type="radio"
                                                    value="<?php echo $task_status['status_id'] ?>"
                                                    id="statusradio-<?php echo $task_status['status_id'] ?>"
                                                    name="taskstatus" required <?php if ($task['task_status'] == $task_status['status_id'])
                                                        echo "checked"; ?>>
                                                <label class="form-check-label"
                                                    for="statusradio-<?php echo $task_status['status_id'] ?>">
                                                    <?php echo $task_status['status'] ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- ASSIGN -->
                        <div class="section-head mt-3">
                            <div class="section-icon"><i class="lni lni-users"></i></div>
                            <div>
                                <h5>Assign Members</h5>
                                <p>Select team members for this task</p>
                            </div>
                        </div>

                        <hr>

                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary w-100" type="button" data-bs-toggle="dropdown">
                                Select Assignees
                            </button>

                            <ul class="dropdown-menu w-100" style="max-height:220px; overflow:auto;">
                                <?php
                                $select_users = mysqli_query(
                                    $conn,
                                    "SELECT * FROM users_tbl 
                 LEFT JOIN roles_tbl ON roles_tbl.role_id = users_tbl.role"
                                );

                                while ($user = mysqli_fetch_array($select_users)) {
                                    if ($user['role'] != "Admin") {
                                        $checkbox_id = "assignee" . $user['user_id'];
                                        ?>
                                        <li>
                                            <div class="form-check m-2">
                                                <input class="form-check-input" type="checkbox" id="<?= $checkbox_id; ?>"
                                                    value="<?= $user['user_id']; ?>" name="assignees[]" <?php
                                                      if (in_array($user['user_id'], $task_members))
                                                          echo 'checked'; ?>>
                                                <label class="form-check-label" for="<?= $checkbox_id; ?>">
                                                    <?= $user['full_name']; ?>
                                                </label>
                                            </div>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        </div>

                        <br>

                        <div class="section-head mt-3">
                            <div class="section-icon"><i class="lni lni-tag"></i></div>
                            <div>
                                <h5>Add Tags</h5>
                                <p>Add tags to categorize your task</p>
                            </div>
                        </div>

                        <hr>

                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary w-100" type="button" data-bs-toggle="dropdown">
                                Select Tags
                            </button>

                            <ul class="dropdown-menu w-100" style="max-height:220px; overflow:auto;">
                                <?php
                                $tags = mysqli_query($conn, "SELECT * FROM tags_tbl");
                                while ($tag = mysqli_fetch_array($tags)) {
                                    $checkbox_id = "tag" . $tag['tag_id'];
                                    ?>
                                    <li>
                                        <div class="form-check m-2">
                                            <input class="form-check-input" type="checkbox" id="<?= $checkbox_id; ?>"
                                                value="<?= $tag['tag_id']; ?>" name="tags[]" <?php if (in_array($tag['tag_id'], $task_tags))
                                                      echo 'checked'; ?>>
                                            <label class="form-check-label" for="<?= $checkbox_id; ?>">
                                                <?= $tag['tag']; ?>
                                            </label>
                                        </div>
                                    </li>
                                    <?php
                                } ?>
                            </ul>
                        </div>

                        <button type="submit" name="submit" class="btn-add">
                            <i class="lni lni-radio-button"></i> Update Task
                        </button>
                    </div>
                </form>

                <form action="ctrlData/ctrl.update.task.php?task_id=<?php echo $task_id; ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="glass-card">
                        <!-- TASK INFO -->
                        <div class="section-head">
                            <div class="section-icon"><i class="lni lni-clipboard"></i></div>
                            <div>
                                <h5>Task Attachment</h5>
                                <p>Change task attachment</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <?php if (!empty($task['task_attachment'])) { ?>
                                    <div class="mb-3">
                                        <?php preview_file($task['task_attachment'], '/task_management/uploads/attachments/'); ?>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <a href="delete_attachment.php?id=<?php echo $task['task_id']; ?>"
                                                    class="btn btn-danger col-md-12" onclick="return confirm('Delete attachment?')">
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <label class="form-label">Attachment</label>
                                    <input type="file" name="attachment"
                                        accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx">
                                    <div class="small-note">Allowed: JPG, PNG, PDF, DOC, XLS</div>
                                <?php } ?>

                                <button type="submit" name="submitattachment" class="btn-add">
                                    <i class="lni lni-add-files  "></i> Update Attachment
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Row -->
            </div>
            <!-- end container -->
        </section>
        <!-- ========== section end ========== -->

        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>
    <!-- ======== main-wrapper end =========== -->

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>