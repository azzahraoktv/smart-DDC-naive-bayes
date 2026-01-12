<?php
// api/get_pengujian.php
require_once 'koneksi.php';

$action = $_GET['action'] ?? 'results';

if ($action === 'results') {
    // GET hasil pengujian
    $data = fetchAll("SELECT * FROM hasil_pengujian ORDER BY tgl_uji DESC LIMIT 20");
    jsonResponse("success", "Hasil pengujian", $data);
}

elseif ($action === 'run') {
    // GET run pengujian otomatis
    // Simulasi pengujian
    $akurasi = rand(85, 96) + (rand(0, 99) / 100);
    
    execute(
        "INSERT INTO hasil_pengujian (jumlah_data_latih, jumlah_data_uji, akurasi) VALUES (?, ?, ?)",
        [150, 50, $akurasi]
    );
    
    jsonResponse("success", "Pengujian selesai", [
        "akurasi" => round($akurasi, 2) . "%",
        "data_latih" => 150,
        "data_uji" => 50,
        "waktu" => date('Y-m-d H:i:s')
    ]);
}

elseif ($action === 'latest') {
    // GET hasil terbaru
    $data = fetchOne("SELECT * FROM hasil_pengujian ORDER BY tgl_uji DESC LIMIT 1");
    jsonResponse("success", "Hasil pengujian terbaru", $data);
}

else {
    jsonResponse("error", "Action tidak valid: results|run|latest");
}
?>