<?php
require_once "../../../includes/conn.php";
include_once "../../../includes/session.start.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login/login.php");
    exit();
}

$mail_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$box = ($_GET['box'] ?? 'inbox') === 'sent' ? 'sent' : 'inbox';
$user_id = (int) $_SESSION['user_id'];

if ($mail_id > 0) {
    mysqli_query($conn, "
        DELETE FROM mails_tbl
        WHERE mail_id = '$mail_id'
        AND (sender_id = '$user_id' OR receiver_id = '$user_id')
    ");
}

$_SESSION['success'] = "Mail deleted successfully.";
header("Location: ../" . ($box == 'sent' ? 'sent.php' : 'inbox.php'));
exit();
?>
