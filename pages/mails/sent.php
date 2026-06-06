<?php require_once "../../includes/conn.php"; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>

<?php
$current_user_id = (int) $_SESSION['user_id'];
$mails = mysqli_query($conn, "
    SELECT mails_tbl.*, users_tbl.full_name AS receiver_name, tasks_tbl.task_name
    FROM mails_tbl
    INNER JOIN users_tbl ON users_tbl.user_id = mails_tbl.receiver_id
    INNER JOIN tasks_tbl ON tasks_tbl.task_id = mails_tbl.task_id
    WHERE mails_tbl.sender_id = '$current_user_id'
    ORDER BY mails_tbl.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task Management | Sent Mail</title>
    <?php include_once "../../includes/components/links.php"; ?>
    <style>
        :root { --primary:#5b4dff; --secondary:#3f8cff; --muted:#64748b; }
        body { background:#f5f7ff; }
        .page-header { background:linear-gradient(135deg,var(--primary),var(--secondary)); border-radius:18px; padding:20px 25px; color:#fff; display:flex; align-items:center; gap:15px; box-shadow:0 10px 25px rgba(91,77,255,.20); margin-top:20px; }
        .header-icon { width:60px; height:60px; border-radius:16px; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:24px; }
        .header-title { font-size:1.5rem; font-weight:700; color:#fff; margin:0; }
        .header-subtitle { margin:0; font-size:.85rem; opacity:.9; }
        .mail-card { background:#fff; border-radius:18px; padding:18px; margin-top:15px; box-shadow:0 10px 30px rgba(0,0,0,.06); }
        .mail-tabs { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; }
        .mail-tab { display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:12px; text-decoration:none; font-weight:700; color:#475569; background:#f1f5ff; }
        .mail-tab.active { color:#fff; background:linear-gradient(135deg,var(--primary),var(--secondary)); }
        .table { border-collapse:separate; border-spacing:0 12px; }
        .table thead th { font-size:12px; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; border:none!important; padding:10px; }
        .table tbody tr { background:#fff; box-shadow:0 6px 18px rgba(0,0,0,.05); border-radius:14px; transition:.2s ease; }
        .table tbody tr:hover { transform:translateY(-2px); box-shadow:0 12px 25px rgba(0,0,0,.08); }
        .table td { border:none!important; vertical-align:middle; padding:14px; }
        .mail-title { font-weight:800; color:#1f2937; }
        .message-cell { width: auto; max-width: 280px; white-space: nowrap; }
        .status-cell { width: 92px; white-space: nowrap; }
        .date-cell { width: 150px; white-space: nowrap; }
        .action-cell { width: 90px; white-space: nowrap; }
        .mail-preview { display:inline-block; max-width:280px; font-size:13px; color:var(--muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; vertical-align:middle; }
        .status-btn { padding:5px 12px; border-radius:999px; font-size:12px; font-weight:700; }
        .unread { background:#e2e8f0; color:#475569; }
        .read { background:rgba(91,77,255,.12); color:var(--primary); }
        .action { display:flex; align-items:center; gap:10px; }
        .action-btn { width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:10px; transition:.2s ease; text-decoration:none; border:none; }
        .view { background:#ecfdf5; color:#10b981; }
        .delete { background:#fef2f2; color:#ef4444; }
        .empty-state { text-align:center; color:var(--muted); padding:42px 15px; }
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
                    <div class="header-icon"><i class="lni lni-direction-alt"></i></div>
                    <div>
                        <h2 class="header-title">Sent Mail</h2>
                        <p class="header-subtitle">Messages you have sent for assigned tasks</p>
                    </div>
                </div>

                <div class="mail-card">
                    <div class="mail-tabs">
                        <a class="mail-tab" href="inbox.php"><i class="lni lni-inbox"></i> Inbox</a>
                        <a class="mail-tab active" href="sent.php"><i class="lni lni-direction-alt"></i> Sent</a>
                        <a class="mail-tab" href="compose.mail.php"><i class="lni lni-pencil"></i> Compose</a>
                    </div>

                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['success']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php } ?>

                    <div class="table-responsive">
                        <table class="table" data-toggle="table" data-search="true">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>To</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($mails) == 0) { ?>
                                    <tr><td colspan="6"><div class="empty-state">No sent mail yet.</div></td></tr>
                                <?php } ?>
                                <?php while ($mail = mysqli_fetch_array($mails)) { ?>
                                    <tr>
                                        <td><div class="mail-title"><?php echo htmlspecialchars($mail['task_name']); ?></div></td>
                                        <td><?php echo htmlspecialchars($mail['receiver_name']); ?></td>
                                        <td class="message-cell"><div class="mail-preview"><?php echo htmlspecialchars($mail['message']); ?></div></td>
                                        <td class="status-cell">
                                            <span class="status-btn <?php echo $mail['is_read'] ? 'read' : 'unread'; ?>">
                                                <?php echo $mail['is_read'] ? 'Read' : 'Unread'; ?>
                                            </span>
                                        </td>
                                        <td class="date-cell"><?php echo date('M d, Y h:i A', strtotime($mail['created_at'])); ?></td>
                                        <td class="action-cell">
                                            <div class="action">
                                                <a class="action-btn view" href="view.mail.php?id=<?php echo $mail['mail_id']; ?>&box=sent"><i class="lni lni-eye"></i></a>
                                                <a class="action-btn delete" href="ctrlData/ctrl.delete.mail.php?id=<?php echo $mail['mail_id']; ?>&box=sent" onclick="return confirm('Delete this mail?')"><i class="lni lni-trash-can"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>

</html>
