<?php
require_once '../../../includes/conn.php';

if (!isset($_POST['submit'])) {
    header("Location: ../add.tag.php");
    exit();
}

$tag = $_POST['tagname'];
mysqli_query($conn, "INSERT INTO tags_tbl (tag) VALUES ('$tag')");

header("Location: ../list.tag.php");
exit();