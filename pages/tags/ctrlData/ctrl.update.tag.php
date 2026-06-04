<?php
require_once '../../../includes/conn.php';

$tag_id = $_GET['tag_id'];

if (!isset($_POST['submit'])) {
    header("Location: ../edit.tag.php?tag_id=" . $tag_id);
    exit();
}

$tag = $_POST['tagname'];
mysqli_query($conn, "UPDATE tags_tbl SET tag = '$tag' WHERE tag_id = '$tag_id'");

header("Location: ../list.tag.php");
exit();