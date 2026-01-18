<?php
session_start();
session_unset();
session_destroy();

// Hapus cookie ini
setcookie('user_id', '', time() - 3600, "/");

header("Location: login.php");
exit();
?>