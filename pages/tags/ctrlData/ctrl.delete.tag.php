<?php
require_once '../../../includes/conn.php';

if (!isset($_GET['tag_id'])) {
    header("Location: ../list.tag.php");
    exit();
}

$tag_id = $_GET['tag_id'];
mysqli_query($conn, "DELETE FROM tags_tbl WHERE tag_id = '$tag_id'");

header("Location: ../list.tag.php");
exit();