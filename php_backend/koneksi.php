<?php
// FILE: php_backend/koneksi.php

error_reporting(E_ALL);
ini_set('display_errors', 0); // UBAH KE 0 agar respon JSON bersih
ini_set('log_errors', 1);     // Tetap catat error di file log XAMPP

$host = "localhost"; 
$user = "root"; 
$pass = "";     
$db   = "smart_ddc";
$port = 3307;

// 2. BUAT VARIABLE GLOBAL untuk error tracking
$connection_error = null;
$conn = null;

try {
    // 3. KONEKSI dengan timeout pendek
    $conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        $connection_error = "Koneksi database gagal: " . $conn->connect_error;
        throw new Exception($connection_error);
    }
    
    // 4. TEST KONEKSI SEKARANG JUGA
    if (!$conn->ping()) {
        $connection_error = "Database tidak merespon (ping failed)";
        throw new Exception($connection_error);
    }
    
    $conn->set_charset("utf8mb4");
    
    // 5. LOG SUKSES
    error_log("✅ Database connected successfully to port $port");
    
} catch (Exception $e) {
    // 6. LOG ERROR DETAIL
    $connection_error = $e->getMessage();
    error_log("❌ Database connection failed: " . $connection_error);
    $conn = null;
}

// 7. FUNGSI UNTUK CEK KONEKSI
function isDbConnected() {
    global $conn, $connection_error;
    
    if (!$conn) {
        return [
            'connected' => false,
            'error' => $connection_error ?? "Tidak ada koneksi database"
        ];
    }
    
    // Test dengan ping
    if (!$conn->ping()) {
        return [
            'connected' => false,
            'error' => "Database connection lost"
        ];
    }
    
    return ['connected' => true, 'error' => null];
}

/**
 * Fungsi Response JSON - dengan info koneksi
 */
function jsonResponse($status, $message, $data = null) {
    // Jika error, tambahkan info koneksi
    if ($status === "error") {
        $db_status = isDbConnected();
        if (!$db_status['connected']) {
            $message .= " [DB Error: " . $db_status['error'] . "]";
        }
    }
    
    header('Content-Type: application/json');
    
    $response = [
        "status" => $status,
        "message" => $message,
        "timestamp" => date('Y-m-d H:i:s'),
        "debug" => [
            "db_connected" => isDbConnected()['connected']
        ]
    ];
    
    if ($data !== null) {
        $response["data"] = $data;
    }
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Fungsi Fetch One Row - dengan cek koneksi SEBELUM query
 */
function fetchOne($sql, $params = []) {
    global $conn;
    
    // CEK KONEKSI DULU
    $db_status = isDbConnected();
    if (!$db_status['connected']) {
        error_log("fetchOne failed: " . $db_status['error']);
        return null;
    }
    
    error_log("Executing query: " . $sql);
    
    try {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return null;
        }

        if (!empty($params)) {
            $types = "";
            foreach ($params as $param) {
                if (is_int($param)) $types .= "i";
                elseif (is_float($param)) $types .= "d";
                else $types .= "s";
            }
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return null;
        }
        
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        
        return $data ?: null;
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());
        return null;
    }
}
function closeConnection() {
    global $conn;
    if (isset($conn) && $conn) {
        $conn->close();
        $conn = null;
    }
}
?>