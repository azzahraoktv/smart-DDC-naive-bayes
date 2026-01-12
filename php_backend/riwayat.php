<?php
header("Content-Type: application/json");
// ASUMSI: koneksi.php berada di folder yang sama (php_backend/)
include 'koneksi.php'; 

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Jika koneksi gagal, hentikan eksekusi di sini (pesan error dari koneksi.php)
if (!$conn) {
    exit;
}

// 1. AMBIL DATA (GET) - Menggunakan JOIN ke tabel kategori
if ($action == 'get') {
    // Menggunakan prepared statement untuk menghindari error SQL
    $query = "SELECT 
                dc.id_klasifikasi AS id, 
                dc.waktu_klasifikasi AS waktu, 
                dc.judul AS judul_buku, 
                dc.prediksi_kode AS kode_ddc,
                dc.confidence,
                k.nama_kategori AS kategori
              FROM data_klasifikasi dc
              JOIN kategori k ON dc.prediksi_kode = k.kode_ddc
              ORDER BY dc.waktu_klasifikasi DESC";
    
    $result = mysqli_query($conn, $query);
    
    $data = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Perhatian: confidence harus diubah ke string saat dikirim ke frontend jika di DB DECIMAL
            $row['confidence'] = (string)$row['confidence']; 
            $data[] = $row;
        }
    }
    
    echo json_encode($data);
}

// 2. SIMPAN DATA (POST)
elseif ($action == 'save') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Siapkan data dari input JSON
    $judul = $input['judul'] ?? '';
    $kode = $input['kode'] ?? '';
    $confidence = isset($input['confidence']) ? floatval($input['confidence']) : 0.00;
    $waktu = date('Y-m-d H:i:s'); 

    // Menggunakan prepared statement untuk INSERT
    $query = $conn->prepare("INSERT INTO data_klasifikasi (waktu_klasifikasi, judul, prediksi_kode, confidence) VALUES (?, ?, ?, ?)");
    $query->bind_param("sssd", $waktu, $judul, $kode, $confidence);
    
    if ($query->execute()) {
        echo json_encode(["status" => "success", "message" => "Berhasil disimpan", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

// 3. HAPUS SATU DATA
elseif ($action == 'delete') {
    $id = intval($_GET['id']);
    
    $query = $conn->prepare("DELETE FROM data_klasifikasi WHERE id_klasifikasi = ?");
    $query->bind_param("i", $id);
    
    if ($query->execute()) {
        echo json_encode(["status" => "success", "message" => "Data berhasil dihapus"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

// 4. HAPUS SEMUA DATA
elseif ($action == 'clear') {
    $query = "TRUNCATE TABLE data_klasifikasi"; 
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Semua data berhasil dikosongkan"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}
?>