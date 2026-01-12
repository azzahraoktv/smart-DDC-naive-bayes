<?php
// api/get_data_training.php
require_once 'koneksi.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'list') {
    // GET semua data training
    $data = fetchAll("
        SELECT dt.id, dt.judul_buku, dt.deskripsi, dt.created_at,
               kd.kode_ddc, kd.nama_kategori
        FROM data_training dt
        JOIN kategori_ddc kd ON dt.kategori_id = kd.id
        ORDER BY dt.id DESC
        LIMIT 1000
    ");
    
    jsonResponse("success", "Data training", $data);
}

elseif ($action === 'add' && isset($_GET['judul'], $_GET['deskripsi'], $_GET['kategori_id'])) {
    // GET add data training
    $result = execute(
        "INSERT INTO data_training (judul_buku, deskripsi, kategori_id) VALUES (?, ?, ?)",
        [$_GET['judul'], $_GET['deskripsi'], $_GET['kategori_id']]
    );
    
    jsonResponse("success", "Data training ditambahkan", [
        "id" => $result['insert_id'],
        "judul" => $_GET['judul']
    ]);
}

elseif ($action === 'delete' && isset($_GET['id'])) {
    // GET delete data training
    execute("DELETE FROM data_training WHERE id = ?", [$_GET['id']]);
    jsonResponse("success", "Data training dihapus");
}

elseif ($action === 'count') {
    // GET count data
    $count = fetchOne("SELECT COUNT(*) as total FROM data_training");
    jsonResponse("success", "Jumlah data training", $count);
}

else {
    jsonResponse("error", "Action tidak valid: list|add|delete|count");
}
?>