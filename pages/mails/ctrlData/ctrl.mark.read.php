<?php
require_once "../../../includes/conn.php";
include_once "../../../includes/session.start.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login/login.php");
    exit();
}

$mail_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$user_id = (int) $_SESSION['user_id'];

if ($mail_id > 0) {
    mysqli_query($conn, "
        UPDATE mails_tbl
        SET is_read = 1,
            read_at = NOW()
        WHERE mail_id = '$mail_id'
        AND receiver_id = '$user_id'
    ");
}

header("Location: ../inbox.php");
exit();
?>
