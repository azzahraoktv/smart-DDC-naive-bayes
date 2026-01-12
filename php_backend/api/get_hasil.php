<?php
// api/get_hasil.php
require_once 'koneksi.php';

$limit = $_GET['limit'] ?? 50;
$limit = min($limit, 1000); // Max 1000 data

$data = fetchAll("
    SELECT rk.id, rk.judul_buku, rk.confidence, rk.waktu,
           kd.kode_ddc, kd.nama_kategori
    FROM riwayat_klasifikasi rk
    JOIN kategori_ddc kd ON rk.kategori_hasil = kd.id
    ORDER BY rk.waktu DESC
    LIMIT ?
", [$limit]);

jsonResponse("success", "Riwayat klasifikasi", [
    "total" => count($data),
    "limit" => $limit,
    "data" => $data
]);
?>