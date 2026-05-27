<?php 

session_start();

session_unset();
session_destroy();

session_start();
$_SESSION['success_logout'] = true;

header('location: ../login.php');

?><?php

include '../../../includes/session.start.php';

session_unset();
session_destroy();

header('Location: ../login.php');
exit();

?>