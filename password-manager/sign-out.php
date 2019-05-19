<?php
session_start();
session_destroy();
unset($_SESSION["pwmuser"]);
header('Location: login.php');
exit;
?>