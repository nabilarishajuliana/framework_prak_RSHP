<?php


// Mulai sesi untuk menghapus sesi pengguna
session_start();

// Hapus semua sesi
session_unset();

// Hapus sesi
session_destroy();

// Redirect ke halaman login
header("Location: /RSH/pageCover/login.php");
exit();
?>