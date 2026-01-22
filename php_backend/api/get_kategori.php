<?php
// FILE: php_backend/api/get_kategori.php

header('Content-Type: application/json');

// Mengambil file koneksi dari folder parent (php_backend/)
if (file_exists('../koneksi.php')) {
    include '../koneksi.php';
} else {
    echo json_encode(["status" => "error", "message" => "File koneksi.php tidak ditemukan di ../koneksi.php"]);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'read';

// ======================================================================
// 1. BACA DATA (READ)
// ======================================================================
if ($action == 'read') {
    // Mengambil data urut berdasarkan Kode DDC
    $sql = "SELECT * FROM kategori_ddc ORDER BY kode_ddc ASC";
    $result = $conn->query($sql);
    
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'kode' => $row['kode_ddc'],
                'nama' => $row['nama_kategori']
                // Kolom deskripsi dihapus karena tidak ada di DB
            ];
        }
    }
    echo json_encode($data);
}

// ======================================================================
// 2. TAMBAH DATA (CREATE)
// ======================================================================
elseif ($action == 'create') {
    $kode = $_POST['kode'] ?? '';
    $nama = $_POST['nama'] ?? '';
    
    if (empty($kode) || empty($nama)) {
        echo json_encode(["status" => "error", "message" => "Kode dan Nama wajib diisi"]);
        exit;
    }

    // Cek Duplikat
    $stmt = $conn->prepare("SELECT kode_ddc FROM kategori_ddc WHERE kode_ddc = ?");
    $stmt->bind_param("s", $kode);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows > 0){
        echo json_encode(["status" => "error", "message" => "Kode DDC $kode sudah ada!"]);
        exit;
    }
    $stmt->close();
    
    // Insert Data (Tanpa deskripsi)
    $stmt = $conn->prepare("INSERT INTO kategori_ddc (kode_ddc, nama_kategori) VALUES (?, ?)");
    $stmt->bind_param("ss", $kode, $nama);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    $stmt->close();
}

// ======================================================================
// 3. EDIT DATA (UPDATE)
// ======================================================================
elseif ($action == 'update') {
    $kodeLama = $_POST['kode_lama'] ?? '';
    $kodeBaru = $_POST['kode'] ?? '';
    $nama = $_POST['nama'] ?? '';
    
    $stmt = $conn->prepare("UPDATE kategori_ddc SET kode_ddc=?, nama_kategori=? WHERE kode_ddc=?");
    $stmt->bind_param("sss", $kodeBaru, $nama, $kodeLama);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    $stmt->close();
}

// ======================================================================
// 4. HAPUS DATA (DELETE)
// ======================================================================
elseif ($action == 'delete') {
    $kode = $_POST['kode'] ?? '';
    
    $stmt = $conn->prepare("DELETE FROM kategori_ddc WHERE kode_ddc=?");
    $stmt->bind_param("s", $kode);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    $stmt->close();
}

// ======================================================================
// 5. IMPORT EXCEL (JSON Payload dari SheetJS)
// ======================================================================
elseif ($action == 'import_excel') {
    $inputJSON = file_get_contents('php://input');
    $dataImport = json_decode($inputJSON, true);
    
    if (is_array($dataImport) && count($dataImport) > 0) {
        $sukses = 0;
        
        // Prepare statement (Tanpa deskripsi)
        // ON DUPLICATE KEY UPDATE: Jika kode sudah ada, update namanya
        $stmt = $conn->prepare("INSERT INTO kategori_ddc (kode_ddc, nama_kategori) VALUES (?, ?) ON DUPLICATE KEY UPDATE nama_kategori = VALUES(nama_kategori)");

        foreach ($dataImport as $row) {
            // Mapping kolom fleksibel
            $kode = $row['Kode DDC'] ?? $row['Kode'] ?? $row['kode'] ?? '';
            $nama = $row['Nama Kategori'] ?? $row['Nama'] ?? $row['nama'] ?? '';
            
            if(!empty($kode) && !empty($nama)){
                $stmt->bind_param("ss", $kode, $nama);
                if($stmt->execute()) {
                    $sukses++;
                }
            }
        }
        $stmt->close();
        echo json_encode(["status" => "success", "message" => "Berhasil import $sukses data."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Data Excel kosong atau format salah."]);
    }
}

// Tutup koneksi global
if (isset($conn)) {
    $conn->close();
}
?>