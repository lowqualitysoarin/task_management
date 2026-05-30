<?php
if ($_SESSION['role'] != "Admin") {
    header("Location: ../dashboard/dashboard.php");
    exit();
}