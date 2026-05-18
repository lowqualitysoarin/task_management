<?php 

session_start();

session_unset();
session_destroy();

session_start();
$_SESSION['success_logout'] = true;

header('location: ../login.php');

?>