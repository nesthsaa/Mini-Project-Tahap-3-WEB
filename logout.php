<?php
// Inisialisasi session
session_start();

session_destroy();

// Redirect ke halaman login
header("location: login.php");
exit;
?>
