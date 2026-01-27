<?php
// FILE: php_backend/api/simpan_riwayat.php

require_once '../koneksi.php';

// Pastikan method adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse("error", "Method not allowed");
}

// Ambil data dari input POST
$judul      = isset($_POST['judul_buku']) ? $_POST['judul_buku'] : '';
$kategori   = isset($_POST['kategori_hasil']) ? $_POST['kategori_hasil'] : '';
$confidence = isset($_POST['confidence']) ? $_POST['confidence'] : 0;

// Validasi sederhana
if (empty($judul) || empty($kategori)) {
    jsonResponse("error", "Data judul atau kategori tidak lengkap");
}

// Query Insert (waktu otomatis diisi NOW() oleh MySQL)
$sql = "INSERT INTO riwayat_klasifikasi (judul_buku, kategori_hasil, confidence, waktu) VALUES (?, ?, ?, NOW())";
$params = [$judul, $kategori, $confidence];

// Eksekusi pakai helper 'execute' dari koneksi.php
$result = execute($sql, $params);

if ($result) {
    jsonResponse("success", "Riwayat berhasil disimpan", ["id" => $result['insert_id']]);
} else {
    jsonResponse("error", "Gagal menyimpan ke database");
}
?>