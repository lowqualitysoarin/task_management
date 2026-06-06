<?php require_once "../../includes/conn.php"; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>

<?php
$current_user_id = (int) $_SESSION['user_id'];
$mail_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$box = ($_GET['box'] ?? 'inbox') === 'sent' ? 'sent' : 'inbox';

$mail_query = mysqli_query($conn, "
    SELECT mails_tbl.*,
           sender.full_name AS sender_name,
           receiver.full_name AS receiver_name,
           tasks_tbl.task_name,
           tasks_tbl.task_description
    FROM mails_tbl
    INNER JOIN users_tbl sender ON sender.user_id = mails_tbl.sender_id
    INNER JOIN users_tbl receiver ON receiver.user_id = mails_tbl.receiver_id
    INNER JOIN tasks_tbl ON tasks_tbl.task_id = mails_tbl.task_id
    WHERE mails_tbl.mail_id = '$mail_id'
    AND (mails_tbl.sender_id = '$current_user_id' OR mails_tbl.receiver_id = '$current_user_id')
");

$mail = mysqli_fetch_assoc($mail_query);
if (!$mail) {
    die("Mail not found.");
}

if ((int) $mail['receiver_id'] === $current_user_id && (int) $mail['is_read'] === 0) {
    mysqli_query($conn, "
        UPDATE mails_tbl
        SET is_read = 1,
            read_at = NOW()
        WHERE mail_id = '$mail_id'
        AND receiver_id = '$current_user_id'
    ");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task Management | View Mail</title>
    <?php include_once "../../includes/components/links.php"; ?>
    <style>
        :root { --primary:#5b4dff; --secondary:#3f8cff; --muted:#64748b; --border:#e5e7eb; }
        body { background:#f5f7ff; }
        .page-header { background:linear-gradient(135deg,var(--primary),var(--secondary)); border-radius:18px; padding:20px 25px; color:#fff; display:flex; align-items:center; gap:15px; box-shadow:0 10px 25px rgba(91,77,255,.20); margin-top:20px; }
        .header-icon { width:60px; height:60px; border-radius:16px; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:24px; }
        .header-title { font-size:1.5rem; font-weight:700; color:#fff; margin:0; }
        .header-subtitle { margin:0; font-size:.85rem; opacity:.9; }
        .mail-card { background:#fff; border-radius:18px; padding:25px; margin-top:15px; box-shadow:0 10px 30px rgba(0,0,0,.06); }
        .mail-tabs { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; }
        .mail-tab { display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:12px; text-decoration:none; font-weight:700; color:#475569; background:#f1f5ff; }
        .mail-tab.active { color:#fff; background:linear-gradient(135deg,var(--primary),var(--secondary)); }
        .meta-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; margin-bottom:20px; }
        .meta-item { border:1px solid var(--border); border-radius:14px; padding:14px; background:#fbfcff; }
        .meta-label { color:var(--muted); font-size:12px; text-transform:uppercase; font-weight:800; letter-spacing:.4px; margin-bottom:5px; }
        .meta-value { color:#0f172a; font-weight:800; }
        .message-box { border:1px solid var(--border); border-radius:16px; padding:20px; color:#334155; line-height:1.8; background:#fff; min-height:180px; }
        .btn-back { display:inline-flex; align-items:center; gap:8px; margin-top:18px; padding:10px 14px; border-radius:12px; background:#f1f5ff; color:#475569; font-weight:800; text-decoration:none; }
        @media(max-width:768px) { .meta-grid { grid-template-columns:1fr; } }
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
                        <h2 class="header-title"><?php echo htmlspecialchars($mail['task_name']); ?></h2>
                        <p class="header-subtitle">Task mail details</p>
                    </div>
                </div>

                <div class="mail-card">
                    <div class="mail-tabs">
                        <a class="mail-tab <?php echo $box == 'inbox' ? 'active' : ''; ?>" href="inbox.php"><i class="lni lni-inbox"></i> Inbox</a>
                        <a class="mail-tab <?php echo $box == 'sent' ? 'active' : ''; ?>" href="sent.php"><i class="lni lni-direction-alt"></i> Sent</a>
                        <a class="mail-tab" href="compose.mail.php?task_id=<?php echo $mail['task_id']; ?>"><i class="lni lni-pencil"></i> Compose</a>
                    </div>

                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">From</div>
                            <div class="meta-value"><?php echo htmlspecialchars($mail['sender_name']); ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">To</div>
                            <div class="meta-value"><?php echo htmlspecialchars($mail['receiver_name']); ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Task</div>
                            <div class="meta-value"><?php echo htmlspecialchars($mail['task_name']); ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Date Sent</div>
                            <div class="meta-value"><?php echo date('M d, Y h:i A', strtotime($mail['created_at'])); ?></div>
                        </div>
                    </div>

                    <div class="message-box">
                        <?php echo nl2br(htmlspecialchars($mail['message'])); ?>
                    </div>

                    <a class="btn-back" href="<?php echo $box == 'sent' ? 'sent.php' : 'inbox.php'; ?>">
                        <i class="lni lni-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </section>
        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>

</html>
