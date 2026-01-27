<?php
// FILE: auth_check.php
// Simpan di: C:\xampp\htdocs\smart-ddc\auth_check.php

session_start();

// 1. KONFIGURASI DURASI SESI (Dalam Detik)
// 1800 detik = 30 Menit.
$timeout_duration = 1800; 

// 2. CEK APAKAH SUDAH LOGIN?
// Jika variabel session 'isLoggedIn' tidak ada atau false, tendang ke login
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header("Location: login.php");
    exit;
}

// 3. CEK APAKAH SUDAH KELAMAAN DIAM (TIMEOUT)?
if (isset($_SESSION['last_activity'])) {
    // Hitung selisih waktu sekarang dengan waktu terakhir aktif
    $duration = time() - $_SESSION['last_activity'];
    
    // Jika selisih waktu melebihi batas durasi
    if ($duration > $timeout_duration) {
        // Hapus semua session
        session_unset();
        session_destroy();
        
        // Redirect ke login dengan pesan timeout
        header("Location: login.php?pesan=timeout");
        exit;
    }
}

// 4. UPDATE WAKTU AKTIVITAS TERAKHIR
// Agar sesi diperpanjang jika user terus aktif (klik menu, dll)
$_SESSION['last_activity'] = time();

// 5. ANTI-CACHE HEADER (PENTING!)
// Mencegah tombol "Back" browser membuka halaman ini setelah logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>