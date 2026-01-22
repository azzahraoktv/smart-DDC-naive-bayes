<?php
// FILE: php_backend/api/get_data_training.php
require_once '../koneksi.php'; // Pastikan path ini benar menunjuk ke file koneksi.php Anda

$action = $_GET['action'] ?? 'list';

// 1. LIST DATA (JOIN untuk dapat kode ddc & nama kategori)
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

// 2. ADD DATA
elseif ($action === 'add' && isset($_GET['judul'], $_GET['deskripsi'], $_GET['kategori_id'])) {
    $res = execute(
        "INSERT INTO data_training (judul_buku, deskripsi, kategori_id) VALUES (?, ?, ?)",
        [$_GET['judul'], $_GET['deskripsi'], $_GET['kategori_id']]
    );
    if ($res) jsonResponse("success", "Berhasil disimpan", ["id" => $res['insert_id']]);
    else jsonResponse("error", "Gagal menyimpan");
}

// 3. UPDATE DATA
elseif ($action === 'update' && isset($_GET['id'], $_GET['judul'], $_GET['deskripsi'], $_GET['kategori_id'])) {
    $res = execute(
        "UPDATE data_training SET judul_buku = ?, deskripsi = ?, kategori_id = ? WHERE id = ?",
        [$_GET['judul'], $_GET['deskripsi'], $_GET['kategori_id'], $_GET['id']]
    );
    if ($res) jsonResponse("success", "Berhasil diperbarui");
    else jsonResponse("error", "Gagal update");
}

// 4. DELETE DATA
elseif ($action === 'delete' && isset($_GET['id'])) {
    $res = execute("DELETE FROM data_training WHERE id = ?", [$_GET['id']]);
    if ($res) jsonResponse("success", "Berhasil dihapus");
    else jsonResponse("error", "Gagal hapus");
}

// 5. GET CATEGORIES (Untuk Dropdown)
elseif ($action === 'get_categories') {
    $data = fetchAll("SELECT id, kode_ddc, nama_kategori FROM kategori_ddc ORDER BY kode_ddc ASC");
    jsonResponse("success", "List Kategori", $data);
}

else {
    jsonResponse("error", "Action tidak valid");
}
?>