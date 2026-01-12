<?php
// api/get_kategori.php
require_once 'koneksi.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'list') {
    $data = fetchAll("SELECT * FROM kategori_ddc ORDER BY kode_ddc");
    jsonResponse("success", "Kategori DDC", $data);
}

elseif ($action === 'get' && isset($_GET['kode'])) {
    $data = fetchOne("SELECT * FROM kategori_ddc WHERE kode_ddc = ?", [$_GET['kode']]);
    jsonResponse("success", "Detail kategori", $data);
}

elseif ($action === 'search' && isset($_GET['q'])) {
    $data = fetchAll(
        "SELECT * FROM kategori_ddc WHERE nama_kategori LIKE ? OR kode_ddc LIKE ? ORDER BY kode_ddc",
        ["%" . $_GET['q'] . "%", "%" . $_GET['q'] . "%"]
    );
    jsonResponse("success", "Hasil pencarian", $data);
}

else {
    jsonResponse("error", "Action tidak valid: list|get|search");
}
?>