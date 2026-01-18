<?php
// api/simpan_pengujian.php
header('Content-Type: application/json');
require_once '../config/database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Gunakan POST';
    echo json_encode($response);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['hasil_pengujian'])) {
    $response['message'] = 'Data kosong';
    echo json_encode($response);
    exit;
}

try {
    $db = new Database();
    
    foreach ($data['hasil_pengujian'] as $item) {
        $query = "INSERT INTO hasil_pengujian 
                 (judul_buku, kategori_hasil, confidence) 
                 VALUES (:judul, :kategori, :conf)";
        
        $db->query($query);
        $db->bind(':judul', $item['judul_buku'] ?? '');
        $db->bind(':kategori', $item['kategori_hasil'] ?? '');
        $db->bind(':conf', $item['confidence'] ?? 0);
        $db->execute();
    }
    
    $response['success'] = true;
    $response['message'] = 'Data tersimpan';
    $response['total'] = count($data['hasil_pengujian']);
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>