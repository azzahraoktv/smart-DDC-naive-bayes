<?php
// FILE: php_backend/api/get_data_training.php

// Header agar tidak kena blokir browser (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../koneksi.php'; // Pastikan path ini sesuai struktur folder Anda

$action = $_GET['action'] ?? 'list';

// --- 1. LIST DATA (GET) ---
if ($action === 'list') {
    $data = fetchAll("
        SELECT dt.id, dt.judul_buku, dt.deskripsi, dt.created_at, dt.kategori_id,
               kd.kode_ddc, kd.nama_kategori
        FROM data_training dt
        LEFT JOIN kategori_ddc kd ON dt.kategori_id = kd.id
        ORDER BY dt.id DESC
        LIMIT 1000
    ");
    jsonResponse("success", "Data loaded", $data);
}

// --- 2. ADD DATA (POST - WAJIB) ---
elseif ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $kategori_id = $_POST['kategori_id'] ?? '';

    if (empty($judul) || empty($kategori_id)) {
        jsonResponse("error", "Judul dan Kategori wajib diisi");
        exit;
    }

    $res = execute(
        "INSERT INTO data_training (judul_buku, deskripsi, kategori_id) VALUES (?, ?, ?)",
        [$judul, $deskripsi, $kategori_id]
    );
    
    if ($res) jsonResponse("success", "Berhasil disimpan", ["id" => $res['insert_id']]);
    else jsonResponse("error", "Gagal menyimpan ke database");
}

// --- 3. UPDATE DATA (POST - WAJIB) ---
elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $judul = $_POST['judul'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $kategori_id = $_POST['kategori_id'] ?? '';

    if (empty($id)) {
        jsonResponse("error", "ID tidak ditemukan");
        exit;
    }

    $res = execute(
        "UPDATE data_training SET judul_buku = ?, deskripsi = ?, kategori_id = ? WHERE id = ?",
        [$judul, $deskripsi, $kategori_id, $id]
    );
    
    if ($res) jsonResponse("success", "Berhasil diperbarui");
    else jsonResponse("error", "Gagal update data");
}

// --- 4. DELETE DATA (GET) ---
elseif ($action === 'delete' && isset($_GET['id'])) {
    $res = execute("DELETE FROM data_training WHERE id = ?", [$_GET['id']]);
    if ($res) jsonResponse("success", "Berhasil dihapus");
    else jsonResponse("error", "Gagal hapus data");
}

// --- 5. GET CATEGORIES (GET) ---
elseif ($action === 'get_categories') {
    $data = fetchAll("SELECT id, kode_ddc, nama_kategori FROM kategori_ddc ORDER BY kode_ddc ASC");
    jsonResponse("success", "List Kategori", $data);
}

// --- 6. IMPORT EXCEL BATCH (VERSI FIXED) ---
elseif ($action === 'import_excel' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil raw JSON data
    $json = file_get_contents('php://input');
    $dataImport = json_decode($json, true);

    if (!$dataImport || !is_array($dataImport)) {
        jsonResponse("error", "Format data JSON tidak valid atau kosong");
        exit;
    }

    $berhasil = 0;
    $gagal = 0;

    foreach ($dataImport as $row) {
        // Sanitasi input dasar
        $judul = trim($row['judul'] ?? '');
        $deskripsi = trim($row['deskripsi'] ?? '');
        $kategori_id = $row['kategori_id'] ?? '';

        // Validasi: Judul & Kategori ID wajib ada
        if (!empty($judul) && !empty($kategori_id)) {
            // Gunakan parameter binding (?) untuk keamanan
            $sql = "INSERT INTO data_training (judul_buku, deskripsi, kategori_id) VALUES (?, ?, ?)";
            $params = [$judul, $deskripsi, $kategori_id];
            
            // Panggil fungsi execute bawaan Anda
            $res = execute($sql, $params);

            if ($res) {
                $berhasil++;
            } else {
                $gagal++;
            }
        } else {
            $gagal++;
        }
    }

    jsonResponse("success", "Proses Import Selesai", [
        "imported" => $berhasil,
        "failed" => $gagal
    ]);
}

else {
    jsonResponse("error", "Action tidak valid");
}
?>