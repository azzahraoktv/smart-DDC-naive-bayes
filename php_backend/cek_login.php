<?php
// FILE: php_backend/cek_login.php - VERSI SUPER SIMPLE

session_start();

// 1. INCLUDE KONEKSI
require_once __DIR__ . '/koneksi.php';

// 2. CEK KONEKSI SEKARANG JUGA
$db_status = isDbConnected();
if (!$db_status['connected']) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => "Database offline! " . $db_status['error'],
        "debug_info" => "Periksa: MySQL XAMPP running? Port 3307?"
    ]);
    exit;
}

// 3. AMBIL INPUT
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($username) || empty($password)) {
    jsonResponse("error", "Username dan Password harus diisi!");
}

// 4. QUERY LANGSUNG TANPA PREPARED STATEMENT (untuk testing)
global $conn;

// Escape input
$username = $conn->real_escape_string(trim($username));

// 5. QUERY SEDERHANA
$sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
error_log("Login Query: " . $sql);

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Debug: tampilkan data user
    error_log("User found: " . print_r($user, true));
    
    if ($password === $user['password']) {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['id_user'] = $user['id_user'];
        
        // --- PENYESUAIAN DI SINI ---
        // Disinkronkan agar terpanggil di beranda.php yang mencari 'nama_lengkap'
        $_SESSION['nama_lengkap'] = $user['nama_lengkap']; 
        $_SESSION['role'] = $user['role']; 
        // ---------------------------
        
        jsonResponse("success", "Login Berhasil", [
            "nama" => $user['nama_lengkap']
        ]);
    } else {
        jsonResponse("error", "Password salah!");
    }
} else {
    // 6. DEBUG: CEK APA YANG ADA DI DATABASE
    error_log("Username '$username' not found. Checking all users...");
    
    $all_users = $conn->query("SELECT username FROM users");
    $usernames = [];
    while ($row = $all_users->fetch_assoc()) {
        $usernames[] = $row['username'];
    }
    
    jsonResponse("error", "Username '$username' tidak ditemukan! Users in DB: " . implode(', ', $usernames));
}
?>