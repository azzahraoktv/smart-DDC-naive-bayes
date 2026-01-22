<?php
// FILE: php_backend/koneksi.php

// 1. Konfigurasi Error Reporting (Agar respon JSON bersih)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Jangan tampilkan error PHP di layar (merusak JSON)
ini_set('log_errors', 1);     // Catat error di file log server (apache/logs)

// 2. Konfigurasi Database (Sesuai XAMPP Anda)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "smart_ddc";
$port = 3307; // Port khusus MySQL Anda

// Variable global koneksi
$conn = null;
$connection_error = null;

try {
    // 3. Buat Koneksi MySQLi
    // Menggunakan @ untuk menekan warning PHP native, kita tangkap dengan Exception
    $conn = @new mysqli($host, $user, $pass, $db, $port);

    // Cek apakah koneksi properti error terisi
    if ($conn->connect_error) {
        throw new Exception("Gagal terhubung ke database: " . $conn->connect_error);
    }

    // 4. Test Ping (Memastikan server merespon)
    if (!$conn->ping()) {
        throw new Exception("Database tidak merespon (Ping failed).");
    }

    // Set Charset ke UTF-8 (Penting untuk simbol/emoji)
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    // 5. PENANGANAN ERROR (CRITICAL)
    $connection_error = $e->getMessage();
    error_log("❌ DB Connection Error: " . $connection_error);

    // Kirim respon JSON error dan HENTIKAN eksekusi script (EXIT)
    // Ini mencegah error "Call to member function query() on null" di file lain
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => "Koneksi Database Bermasalah: " . $connection_error
    ]);
    exit; // Wajib exit agar script lain tidak lanjut jalan tanpa database
}

// =================================================================
// HELPER FUNCTIONS (Opsional, untuk mempermudah coding di masa depan)
// =================================================================

// Cek status koneksi manual
function isDbConnected() {
    global $conn;
    return ($conn instanceof mysqli) && $conn->ping();
}

// Helper kirim JSON standar
if (!function_exists('jsonResponse')) {
    function jsonResponse($status, $message, $data = null) {
        header('Content-Type: application/json');
        $response = [
            "status" => $status,
            "message" => $message,
            "timestamp" => date('Y-m-d H:i:s')
        ];
        if ($data !== null) $response["data"] = $data;
        echo json_encode($response);
        exit;
    }
}

// Helper ambil satu baris data (Prepared Statement)
if (!function_exists('fetchOne')) {
    function fetchOne($sql, $params = []) {
        global $conn;
        if (!isDbConnected()) return null;

        try {
            $stmt = $conn->prepare($sql);
            if (!$stmt) return null;

            if (!empty($params)) {
                $types = "";
                foreach ($params as $p) {
                    if (is_int($p)) $types .= "i";
                    elseif (is_float($p)) $types .= "d";
                    else $types .= "s";
                }
                $stmt->bind_param($types, ...$params);
            }

            if (!$stmt->execute()) return null;

            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
            return $data;
        } catch (Exception $e) {
            error_log("fetchOne Error: " . $e->getMessage());
            return null;
        }
    }
}
?>