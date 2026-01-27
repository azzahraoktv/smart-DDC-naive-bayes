<?php
// File: php_backend/api/get_pengujian.php

// 1. HEADER & ERROR HANDLING
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

// Matikan error HTML
ini_set('display_errors', 0);
error_reporting(0);

// 2. CARI KONEKSI.PHP DENGAN CARA PALING KUAT (ABSOLUT)
// Ini akan mencari: C:/xampp/htdocs/smart-ddc/php_backend/koneksi.php
$root = $_SERVER['DOCUMENT_ROOT'];
// Sesuaikan nama folder project jika berbeda, misal: /SMART-DDC atau /smart-ddc
// Script ini otomatis mencari folder php_backend dimanapun ia berada di bawah root
$path_koneksi = __DIR__ . '/../koneksi.php';

// Jika folder project namanya beda (misal huruf besar/kecil), kita coba deteksi relatif:
if (!file_exists($path_koneksi)) {
    $path_koneksi = dirname(__DIR__) . '/koneksi.php';
}

if (!file_exists($path_koneksi)) {
    http_response_code(500);
    echo json_encode([
        "status" => "error", 
        "message" => "CRITICAL: File koneksi.php tidak ditemukan.",
        "dicari_di" => $path_koneksi
    ]);
    exit;
}

require_once $path_koneksi;

// Normalisasi Variabel Koneksi
if (!isset($conn) && isset($koneksi)) {
    $conn = $koneksi;
}

if (!$conn) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Koneksi Database Gagal (Variabel null)."]);
    exit;
}

// 3. LOGIKA API
$action = isset($_GET['action']) ? $_GET['action'] : '';

try {
    switch ($action) {
        case 'get_riwayat_data':
            $sql = "SELECT id, judul_buku, kode_ddc, kategori FROM riwayat_klasifikasi ORDER BY id DESC LIMIT 100";
            $result = $conn->query($sql);
            $data = [];
            if ($result) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode($data);
            break;

        case 'get_training_data':
            $sql = "SELECT judul_buku AS judul, kode_ddc AS kode, kategori FROM data_training";
            $result = $conn->query($sql);
            $data = [];
            if ($result) {
                while($row = $result->fetch_assoc()) {
                    $row['kategori_full'] = $row['kode'] . '|' . $row['kategori'];
                    $data[] = $row;
                }
            }
            echo json_encode($data);
            break;

        case 'simpan_hasil':
            $input = json_decode(file_get_contents('php://input'), true);
            if ($input) {
                $stmt = $conn->prepare("INSERT INTO hasil_pengujian (judul_buku, kode_ddc_asli, kode_ddc_prediksi, status_kesesuaian, confidence, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $inserted = 0;
                foreach ($input as $row) {
                    $status = ($row['correct']) ? 'Benar' : 'Salah';
                    $stmt->bind_param("ssssd", $row['judul'], $row['kode'], $row['predCode'], $status, $row['bestProbability']);
                    if ($stmt->execute()) $inserted++;
                }
                echo json_encode(["status" => "success", "inserted" => $inserted]);
            } else {
                echo json_encode(["status" => "error", "message" => "Data input tidak valid"]);
            }
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Action tidak valid: " . $action]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Server Error: " . $e->getMessage()]);
}
?>