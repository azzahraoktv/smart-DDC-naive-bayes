<?php
// FILE: php_backend/cek_login.php
session_start();

// 1. INCLUDE KONEKSI
// Ini otomatis memuat: variabel $conn, fungsi fetchOne(), dan jsonResponse()
require_once __DIR__ . '/koneksi.php';

// 2. AMBIL INPUT
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input kosong
if (empty($username) || empty($password)) {
    jsonResponse("error", "Username dan Password harus diisi!");
}

// 3. QUERY DATABASE (PAKAI HELPER BARU)
// Gunakan fetchOne() agar otomatis aman dari SQL Injection (Prepared Statement)
// Tidak perlu lagi pakai real_escape_string manual
$user = fetchOne("SELECT * FROM users WHERE username = ? LIMIT 1", [$username]);

if ($user) {
    // 4. CEK PASSWORD
    // Catatan: Jika nanti Anda pakai hash, ganti jadi: if (password_verify($password, $user['password']))
    if ($password === $user['password']) {
        
        // SET SESSION
        $_SESSION['isLoggedIn']   = true;
        $_SESSION['id_user']      = $user['id_user'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['role']         = $user['role'];
        
        // FITUR AUTO LOGOUT (PENTING)
        $_SESSION['last_activity'] = time(); 
        
        // Response Sukses
        jsonResponse("success", "Login Berhasil", [
            "nama" => $user['nama_lengkap'],
            "role" => $user['role']
        ]);
        
    } else {
        jsonResponse("error", "Password salah!");
    }
} else {
    jsonResponse("error", "Username tidak ditemukan!");
}
?>