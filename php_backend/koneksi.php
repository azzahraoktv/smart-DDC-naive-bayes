<?php
// FILE: php_backend/koneksi.php

error_reporting(E_ALL);
ini_set('display_errors', 0); 
ini_set('log_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "smart_ddc";
$port = 3307; // Sesuai screenshot kamu

$conn = null;

try {
    $conn = @new mysqli($host, $user, $pass, $db, $port);

    if ($conn->connect_error) {
        throw new Exception("Koneksi Gagal: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}

// --- HELPER FUNCTIONS (WAJIB ADA UNTUK API) ---

if (!function_exists('jsonResponse')) {
    function jsonResponse($status, $message, $data = null) {
        header('Content-Type: application/json');
        echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
        exit;
    }
}

// Helper: Ambil BANYAK baris (List Data)
if (!function_exists('fetchAll')) {
    function fetchAll($sql, $params = []) {
        global $conn;
        try {
            $stmt = $conn->prepare($sql);
            if (!$stmt) throw new Exception($conn->error);
            if (!empty($params)) {
                $types = str_repeat("s", count($params)); // Asumsi string semua aman
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("fetchAll Error: " . $e->getMessage());
            return [];
        }
    }
}

// Helper: Eksekusi Query (Insert/Update/Delete)
if (!function_exists('execute')) {
    function execute($sql, $params = []) {
        global $conn;
        try {
            $stmt = $conn->prepare($sql);
            if (!$stmt) throw new Exception($conn->error);
            if (!empty($params)) {
                $types = str_repeat("s", count($params));
                $stmt->bind_param($types, ...$params);
            }
            if (!$stmt->execute()) throw new Exception($stmt->error);
            return ['insert_id' => $stmt->insert_id, 'affected_rows' => $stmt->affected_rows];
        } catch (Exception $e) {
            error_log("execute Error: " . $e->getMessage());
            return false;
        }
    }
}

// Helper: Ambil SATU baris
if (!function_exists('fetchOne')) {
    function fetchOne($sql, $params = []) {
        global $conn;
        try {
            $stmt = $conn->prepare($sql);
            if (!$stmt) return null;
            if (!empty($params)) {
                $types = str_repeat("s", count($params));
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            return null;
        }
    }
}
?>