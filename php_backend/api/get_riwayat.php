<?php
// FILE: php_backend/api/get_riwayat.php

// Panggil koneksi (pastikan path ini benar sesuai struktur folder kamu)
// Jika api ada di dalam folder 'api', maka naik satu level ke 'koneksi.php'
require_once '../koneksi.php';

// Ambil parameter action dari URL (default: 'list')
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// ==========================================================
// 1. AMBIL DATA (LIST)
// ==========================================================
if ($action === 'list') {
    // Ambil data terbaru (Limit 100 agar ringan)
    $sql = "SELECT * FROM riwayat_klasifikasi ORDER BY waktu DESC LIMIT 100";
    
    // Pakai helper 'fetchAll' dari koneksi.php
    $data = fetchAll($sql);
    
    // Pakai helper 'jsonResponse'
    jsonResponse("success", "Data berhasil diambil", $data);
}

// ==========================================================
// 2. HAPUS SATU DATA
// ==========================================================
else if ($action === 'delete') {
    // Frontend mengirim ID lewat URL params (meski method POST)
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    
    if (empty($id)) {
        jsonResponse("error", "ID tidak valid");
    }

    $sql = "DELETE FROM riwayat_klasifikasi WHERE id = ?";
    
    // Pakai helper 'execute'
    $result = execute($sql, [$id]);

    if ($result && $result['affected_rows'] > 0) {
        jsonResponse("success", "Data berhasil dihapus");
    } else {
        jsonResponse("error", "Gagal menghapus atau data sudah tidak ada");
    }
}

// ==========================================================
// 3. HAPUS SEMUA DATA (RESET)
// ==========================================================
else if ($action === 'hapus_semua') {
    // TRUNCATE: Kosongkan tabel & reset ID
    $sql = "TRUNCATE TABLE riwayat_klasifikasi";
    
    // execute tanpa parameter
    $result = execute($sql);

    if ($result !== false) {
        jsonResponse("success", "Semua riwayat berhasil dikosongkan");
    } else {
        jsonResponse("error", "Gagal mengosongkan database");
    }
}

// Action tidak dikenali
else {
    jsonResponse("error", "Action tidak valid");
}
?>