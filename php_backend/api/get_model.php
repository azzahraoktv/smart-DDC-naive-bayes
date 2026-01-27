<?php
header('Content-Type: application/json');
require_once '../koneksi.php'; 

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. CEK STATUS MODEL (Apakah ada cache?)
if ($action == 'check_model') {
    $sql = "SELECT id, tgl_training, total_dokumen FROM model_naive_bayes ORDER BY id DESC LIMIT 1";
    $result = fetchAll($sql); // Asumsi pakai helper fetchAll dari koneksi.php
    
    if (!empty($result)) {
        echo json_encode(['status' => 'found', 'data' => $result[0]]);
    } else {
        echo json_encode(['status' => 'empty']);
    }
}

// 2. AMBIL MODEL LENGKAP (Load Otak AI)
elseif ($action == 'get_model') {
    $sql = "SELECT model_data FROM model_naive_bayes ORDER BY id DESC LIMIT 1";
    $result = fetchAll($sql);
    
    if (!empty($result)) {
        // Kirim data JSON mentah
        echo json_encode(['status' => 'success', 'data' => $result[0]['model_data']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Model tidak ditemukan']);
    }
}

// 3. SIMPAN MODEL BARU (Save Otak AI)
elseif ($action == 'save_model') {
    $total_doc = $_POST['total_dokumen'];
    $total_cat = $_POST['total_kategori'];
    $model_data = $_POST['model_data']; // String JSON besar

    // Reset tabel lama (Opsional, agar tidak menumpuk sampah)
    execute("TRUNCATE TABLE model_naive_bayes");

    // Simpan model baru
    $sql = "INSERT INTO model_naive_bayes (tgl_training, total_dokumen, total_kategori, model_data) VALUES (NOW(), ?, ?, ?)";
    $res = execute($sql, [$total_doc, $total_cat, $model_data]);

    if ($res) {
        echo json_encode(['status' => 'success', 'message' => 'Model berhasil dicache']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan model']);
    }
}
?>