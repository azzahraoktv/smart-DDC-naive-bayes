<?php
// FILE: php_backend/logout.php

session_start();

// 1. Kosongkan semua variabel session
$_SESSION = array();

// 2. Hapus cookie session dari browser (PENTING UNTUK KEAMANAN)
// Ini memastikan ID session lama tidak bisa digunakan lagi
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Hancurkan data session di server
session_destroy();

// 4. Redirect kembali ke halaman login (keluar dari folder php_backend)
header("Location: ../login.php?logout=1");
exit;
?>