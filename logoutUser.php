<?php
session_start();
$_SESSION = null;
session_destroy();
header("location: login.php");
exit;
?>