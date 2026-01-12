<?php
// api/get_klasifikasi.php
require_once 'koneksi.php';

// Ambil parameter dari URL GET
$judul = $_GET['judul'] ?? '';
$deskripsi = $_GET['deskripsi'] ?? '';

// Debug: lihat apa yang diterima
// echo "Judul: $judul, Deskripsi: $deskripsi";

if (empty($judul) || empty($deskripsi)) {
    jsonResponse("error", "Parameter kurang: ?judul=...&deskripsi=...");
}

try {
    // 1. Cek model
    $model = fetchOne("SELECT model_data FROM model_naive_bayes ORDER BY id DESC LIMIT 1");
    if (!$model) jsonResponse("error", "Model belum ditraining");
    
    $modelData = json_decode($model['model_data'], true);
    
    // 2. Preprocessing
    $text = strtolower($judul . ' ' . $deskripsi);
    $text = preg_replace('/[^\w\s]/u', ' ', $text);
    $words = array_unique(array_filter(preg_split('/\s+/', $text)));
    
    // 3. Naive Bayes
    $scores = [];
    foreach ($modelData['categories'] as $kode => $category) {
        $score = log($category['prior']);
        foreach ($words as $word) {
            $prob = $category['word_probabilities'][$word] ?? 
                   (1 / ($category['total_words'] + $modelData['vocabulary_size']));
            $score += log($prob);
        }
        $scores[$kode] = exp($score);
    }
    
    // 4. Hasil terbaik
    arsort($scores);
    $bestKode = array_key_first($scores);
    $totalScore = array_sum($scores);
    $confidence = round(($scores[$bestKode] / $totalScore) * 100, 2);
    
    // 5. Info kategori
    $kategori = fetchOne("SELECT id, nama_kategori FROM kategori_ddc WHERE kode_ddc = ?", [$bestKode]);
    if (!$kategori) jsonResponse("error", "Kategori tidak ditemukan");
    
    // 6. Simpan riwayat
    execute(
        "INSERT INTO riwayat_klasifikasi (judul_buku, kategori_hasil, confidence) VALUES (?, ?, ?)",
        [$judul, $kategori['id'], $confidence]
    );
    
    // 7. Response
    jsonResponse("success", "Klasifikasi berhasil", [
        "judul" => $judul,
        "kode_ddc" => $bestKode,
        "nama_kategori" => $kategori['nama_kategori'],
        "confidence" => $confidence . "%",
        "top_3" => array_slice($scores, 0, 3, true)
    ]);
    
} catch (Exception $e) {
    jsonResponse("error", $e->getMessage());
}
?>