<?php require_once "../../includes/conn.php"; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>
<?php include_once "../../includes/utils/db.utils.php"; ?>

<?php
$current_user_id = (int) $_SESSION['user_id'];
$role = $_SESSION['role'];
$selected_task_id = isset($_GET['task_id']) ? (int) $_GET['task_id'] : 0;

if ($role == 'Admin') {
    $tasks = mysqli_query($conn, "
        SELECT task_id, task_name
        FROM tasks_tbl
        ORDER BY task_name ASC
    ");
} else {
    $tasks = mysqli_query($conn, "
        SELECT tasks_tbl.task_id, tasks_tbl.task_name
        FROM tasks_tbl
        INNER JOIN task_members_tbl ON task_members_tbl.task_id = tasks_tbl.task_id
        WHERE task_members_tbl.user_id = '$current_user_id'
        ORDER BY tasks_tbl.task_name ASC
    ");
}

$can_use_selected_task = false;
if ($selected_task_id > 0) {
    $can_use_selected_task = can_view_task($conn, $selected_task_id, $current_user_id, $role);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task Management | Compose Mail</title>
    <?php include_once "../../includes/components/links.php"; ?>

    <style>
        :root {
            --primary: #5b4dff;
            --secondary: #3f8cff;
            --muted: #64748b;
            --border: #e5e7eb;
        }

        body { background: #f5f7ff; }

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

        .mail-card {
            background: #fff;
            border-radius: 18px;
            padding: 25px;
            margin-top: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        .mail-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .mail-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            color: #475569;
            background: #f1f5ff;
        }

        .mail-tab.active {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .form-label {
            font-size: .85rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: .9rem;
        }

        textarea.form-control { min-height: 180px; }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(91, 77, 255, .12);
        }

        .btn-send {
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-weight: 800;
            padding: 12px 18px;
        }

        .small-note {
            color: var(--muted);
            font-size: 13px;
            margin-top: 7px;
        }
    </style>
</head>

<body>
    <?php include_once "../../includes/components/preloader.php"; ?>
    <?php include_once "../../includes/elements/sidebar.php"; ?>

    <main class="main-wrapper">
        <?php include_once "../../includes/elements/navbar.php"; ?>

        <section class="section">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="header-icon"><i class="lni lni-envelope"></i></div>
                    <div>
                        <h2 class="header-title">Compose Mail</h2>
                        <p class="header-subtitle">Send task-based messages to assigned users</p>
                    </div>
                </div>

                <div class="mail-card">
                    <div class="mail-tabs">
                        <a class="mail-tab" href="inbox.php"><i class="lni lni-inbox"></i> Inbox</a>
                        <a class="mail-tab" href="sent.php"><i class="lni lni-direction-alt"></i> Sent</a>
                        <a class="mail-tab active" href="compose.mail.php"><i class="lni lni-pencil"></i> Compose</a>
                    </div>

                    <?php if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php } ?>

                    <form method="GET" class="mb-4">
                        <label class="form-label">Task</label>
                        <select name="task_id" class="form-select" onchange="this.form.submit()" required>
                            <option value="">Select task</option>
                            <?php while ($task = mysqli_fetch_array($tasks)) { ?>
                                <option value="<?php echo $task['task_id']; ?>" <?php echo $selected_task_id == $task['task_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($task['task_name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="small-note">The selected task becomes the mail topic.</div>
                    </form>

                    <form action="ctrlData/ctrl.send.mail.php" method="POST">
                        <input type="hidden" name="task_id" value="<?php echo $selected_task_id; ?>">

                        <div class="mb-3">
                            <label class="form-label">Send To</label>
                            <select name="receiver_id" class="form-select" <?php echo !$can_use_selected_task ? 'disabled' : ''; ?> required>
                                <option value="">Select assigned user</option>
                                <?php
                                if ($can_use_selected_task) {
                                    $receivers = mysqli_query($conn, "
                                        SELECT DISTINCT users_tbl.user_id, users_tbl.full_name, users_tbl.username, users_tbl.role
                                        FROM users_tbl
                                        LEFT JOIN task_members_tbl
                                            ON task_members_tbl.user_id = users_tbl.user_id
                                            AND task_members_tbl.task_id = '$selected_task_id'
                                        WHERE users_tbl.user_id != '$current_user_id'
                                        AND (
                                            task_members_tbl.task_id IS NOT NULL
                                            OR users_tbl.role = 1
                                        )
                                        ORDER BY users_tbl.role ASC, users_tbl.full_name ASC
                                    ");

                                    while ($receiver = mysqli_fetch_array($receivers)) {
                                        ?>
                                        <option value="<?php echo $receiver['user_id']; ?>">
                                            <?php echo htmlspecialchars($receiver['full_name']); ?> (@<?php echo htmlspecialchars($receiver['username']); ?>)
                                            <?php echo $receiver['role'] == 1 ? ' - Admin' : ''; ?>
                                        </option>
                                    <?php }
                                }
                                ?>
                            </select>
                            <div class="small-note">Admins and users assigned to the selected task are shown.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" placeholder="Write your message..." required></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn-send">
                            <i class="lni lni-telegram-original"></i> Send Mail
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>

    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>

</html>
