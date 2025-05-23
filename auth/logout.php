<?php
require_once '../includes/auth.php';
logout();
header("Location: ../auth/login.php");
exit();
?>