<?php
// pages/pengujian.php
?>
<div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-800">Pengujian Sistem Klasifikasi DDC</h1>
            <p class="text-gray-600 mt-2">Uji akurasi sistem klasifikasi berbasis Naive Bayes dengan data riwayat</p>
        </div>
        <div class="flex gap-3">
            <button onclick="startTesting()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                <i data-feather="play" class="mr-2 w-5 h-5"></i>
                Mulai Pengujian
            </button>
        </div>
    </div>

    <!-- Modal Info Pengujian (SIMPAN - JANGAN DIHAPUS) -->
    <div id="info-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Informasi Pengujian</h3>
                <button onclick="closeInfoModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="space-y-3 mb-6">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i data-feather="info" class="w-4 h-4 text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium text-blue-800">Metodologi Pengujian</span>
                    </div>
                    <p class="text-xs text-blue-600 mt-1 ml-6">
                        Sistem akan mengklasifikasi ulang data dengan algoritma Naive Bayes dan membandingkan hasilnya dengan label asli dari database.
                    </p>
                </div>
                
                <div class="p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-4 h-4 text-green-600 mr-2"></i>
                        <span class="text-sm font-medium text-green-800">Validitas Ilmiah</span>
                    </div>
                    <p class="text-xs text-green-600 mt-1 ml-6">
                        Hasil pengujian bersifat objektif dan dapat dipertanggungjawabkan untuk penelitian skripsi.
                    </p>
                </div>
            </div>
            
            <div class="text-sm text-gray-600 mb-4">
                <p class="font-medium mb-2">📊 Metrik yang akan dihitung:</p>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    <li><span class="font-medium">Akurasi</span>: Jumlah prediksi benar / Total data</li>
                    <li><span class="font-medium">Precision</span>: TP / (TP + FP)</li>
                    <li><span class="font-medium">Recall</span>: TP / (TP + FN)</li>
                    <li><span class="font-medium">F1-Score</span>: 2 × (Precision × Recall) / (Precision + Recall)</li>
                </ul>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button onclick="closeInfoModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Batal</button>
                <button onclick="startTestingFromModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Mulai Pengujian Objektif</button>
            </div>
        </div>
    </div>

    <div id="selection-card" class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-8">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Pilih Data untuk Pengujian</h3>
            
            <!-- Warning jika model belum terlatih (SIMPAN - JANGAN DIHAPUS) -->
            <div id="model-warning" class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
                <div class="flex items-start">
                    <i data-feather="alert-triangle" class="w-5 h-5 text-yellow-600 mr-3 mt-0.5"></i>
                    <div>
                        <p class="font-medium text-yellow-800 mb-1">Model Naive Bayes Belum Terlatih!</p>
                        <p class="text-sm text-yellow-600">
                            Sistem membutuhkan data training untuk melakukan klasifikasi.
                            <a href="data_training.php" class="font-medium underline ml-1">Tambahkan data training</a> terlebih dahulu.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-start">
                    <i data-feather="info" class="w-5 h-5 text-blue-600 mr-3 mt-0.5"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">Pilih data dari riwayat klasifikasi untuk diuji</p>
                        <p class="text-xs">Data yang sudah terverifikasi tidak akan muncul di sini</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="flex-1">
                    <div class="relative">
                        <i data-feather="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="text" id="search-data" placeholder="Cari judul buku..." onkeyup="filterData()" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <select id="filter-kategori" onchange="filterData()" class="border border-gray-300 rounded-lg px-4 py-2 outline-none">
                    <option value="">Semua Kategori</option>
                </select>
                <div class="flex gap-2">
                    <button onclick="selectAll()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Pilih Semua
                    </button>
                    <button onclick="clearSelected()" class="px-4 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition-colors duration-200">
                        Hapus Pilihan
                    </button>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left w-12"><input type="checkbox" id="select-all" onclick="toggleAll()"></th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode DDC</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody id="available-data" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
            <div id="selected-info" class="mt-4 hidden">
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-5 h-5 text-blue-600 mr-3"></i>
                        <div>
                            <span id="selected-count" class="font-medium text-blue-700 text-lg">0 data terpilih</span>
                            <p class="text-sm text-blue-600 mt-1">Klik "Mulai Pengujian" untuk proses pengujian objektif</p>
                        </div>
                    </div>
                    <button onclick="showTestingInfo()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        <i data-feather="play" class="w-4 h-4 mr-2"></i> Mulai Pengujian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="result-card" class="hidden bg-white rounded-lg border border-gray-200 overflow-hidden mb-8">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-700">Hasil Pengujian Sistem Klasifikasi</h3>
                    <p class="text-sm text-gray-500 mt-1">Berbasis Algoritma Naive Bayes</p>
                </div>
                <div class="flex items-center gap-3">
                    <span id="test-time" class="text-sm text-gray-500"></span>
                    <button onclick="exportTestResults()" class="text-xs text-blue-600 hover:text-blue-800 flex items-center border border-blue-200 px-3 py-1 rounded-lg">
                        <i data-feather="download" class="w-3 h-3 mr-1"></i> Ekspor Data
                    </button>
                </div>
            </div>

            <!-- Loading State (SIMPAN - JANGAN DIHAPUS) -->
            <div id="loading-section" class="mb-8 hidden">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                    <p class="text-blue-700 font-medium">Sedang memproses pengujian...</p>
                    <p id="progress-text" class="text-sm text-blue-600 mt-1">0/0 data diproses</p>
                </div>
            </div>

            <!-- Hasil Akurasi Utama -->
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-8 text-white mb-8 shadow-lg">
                <div class="text-center mb-6">
                    <p class="text-blue-100 text-sm uppercase tracking-widest mb-2 font-semibold">AKURASI SISTEM KESELURUHAN</p>
                    <h2 id="accuracy-percent" class="text-7xl font-black mb-2">0%</h2>
                    <p class="text-blue-200">Berdasarkan Confusion Matrix</p>
                </div>
                
                <div class="flex-1 w-full max-w-3xl mx-auto">
                    <div class="flex justify-between mb-2 text-sm font-medium">
                        <span id="accuracy-desc">Menghitung hasil...</span>
                        <span id="progress-count" class="text-blue-200">0/0 data</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-4 overflow-hidden mb-6">
                        <div id="accuracy-bar" class="bg-white h-4 rounded-full transition-all duration-1000" style="width: 0%"></div>
                    </div>
                    
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div>
                            <p class="text-blue-100 text-xs uppercase mb-1">Precision</p>
                            <p id="precision-value" class="text-xl font-bold">0%</p>
                        </div>
                        <div>
                            <p class="text-blue-100 text-xs uppercase mb-1">Recall</p>
                            <p id="recall-value" class="text-xl font-bold">0%</p>
                        </div>
                        <div>
                            <p class="text-blue-100 text-xs uppercase mb-1">F1-Score</p>
                            <p id="f1score-value" class="text-xl font-bold">0%</p>
                        </div>
                        <div>
                            <p class="text-blue-100 text-xs uppercase mb-1">Data Uji</p>
                            <p id="total-tested" class="text-xl font-bold">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confusion Matrix dan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h4 class="font-bold text-gray-700 mb-4">📊 Confusion Matrix</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-green-50 border border-green-200 p-4 rounded-lg text-center">
                            <p class="text-green-700 text-sm font-medium mb-1">True Positive (TP)</p>
                            <p id="true-positive" class="text-2xl font-bold text-green-700">0</p>
                            <p class="text-xs text-green-600 mt-1">Prediksi Benar Positif</p>
                        </div>
                        <div class="bg-red-50 border border-red-200 p-4 rounded-lg text-center">
                            <p class="text-red-700 text-sm font-medium mb-1">False Positive (FP)</p>
                            <p id="false-positive" class="text-2xl font-bold text-red-700">0</p>
                            <p class="text-xs text-red-600 mt-1">Prediksi Salah Positif</p>
                        </div>
                        <div class="bg-red-50 border border-red-200 p-4 rounded-lg text-center">
                            <p class="text-red-700 text-sm font-medium mb-1">False Negative (FN)</p>
                            <p id="false-negative" class="text-2xl font-bold text-red-700">0</p>
                            <p class="text-xs text-red-600 mt-1">Prediksi Salah Negatif</p>
                        </div>
                        <div class="bg-green-50 border border-green-200 p-4 rounded-lg text-center">
                            <p class="text-green-700 text-sm font-medium mb-1">True Negative (TN)</p>
                            <p id="true-negative" class="text-2xl font-bold text-green-700">0</p>
                            <p class="text-xs text-green-600 mt-1">Prediksi Benar Negatif</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h4 class="font-bold text-gray-700 mb-4">📈 Statistik Pengujian</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Prediksi Benar:</span>
                            <span id="correct-count" class="text-xl font-bold text-green-700">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Prediksi Salah:</span>
                            <span id="wrong-count" class="text-xl font-bold text-red-700">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Waktu Proses:</span>
                            <span id="processing-time" class="text-xl font-bold text-blue-700">0s</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Model Status:</span>
                            <span id="model-status" class="text-sm font-medium text-gray-700">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL SIMPAN TERVERIFIKASI DAN KELENGKAPANNYA (PERBAIKAN DI SINI) -->
            <div class="flex flex-wrap gap-3 mb-8 justify-center py-4 border-t border-gray-100">
                <button onclick="saveToVerified()" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all flex items-center shadow-sm">
                    <i data-feather="check-square" class="mr-2 w-5 h-5"></i> Simpan Data Valid
                </button>
                <button onclick="saveToTraining()" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all flex items-center shadow-sm">
                    <i data-feather="database" class="mr-2 w-5 h-5"></i> Tambah ke Data Training
                </button>
                <button onclick="resetTesting()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all flex items-center">
                    <i data-feather="refresh-cw" class="mr-2 w-5 h-5"></i> Uji Data Lain
                </button>
            </div>

            <!-- TABEL DETAIL HASIL (DIPERBAIKI SESUAI CONTOH) -->
            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                    <h4 class="font-bold text-gray-700">Detail Hasil Klasifikasi per Judul</h4>
                    <div class="flex items-center gap-2">
                        <span id="result-count" class="text-sm text-gray-500">0 hasil</span>
                        <button onclick="toggleSortResults()" class="text-xs text-blue-600 hover:text-blue-800 flex items-center bg-blue-50 px-3 py-1 rounded">
                            <i data-feather="filter" class="w-3 h-3 mr-1"></i> Urutkan
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-12">NO</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">JUDUL BUKU</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">PREDIKSI SISTEM</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-32">CONFIDENCE</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-32">AKURASI</th>
                            </tr>
                        </thead>
                        <tbody id="test-results" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>

            <!-- REKOMENDASI PERBAIKAN (SIMPAN - JANGAN DIHAPUS) -->
            <div id="analysis-section" class="mt-6 p-6 bg-gradient-to-r from-gray-50 to-blue-50 border border-gray-200 rounded-xl hidden">
                <h4 class="font-bold text-gray-800 text-lg mb-4">📋 Analisis Hasil & Rekomendasi untuk Skripsi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">🔍 Analisis Kesalahan:</p>
                        <p id="error-analysis" class="text-sm text-gray-600">Menganalisis pola kesalahan...</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">💡 Rekomendasi Perbaikan Model:</p>
                        <p id="recommendations" class="text-sm text-gray-600">Menyiapkan rekomendasi...</p>
                    </div>
                </div>
                <div class="mt-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                    <p class="text-xs text-yellow-800 font-medium">
                        <i data-feather="book-open" class="w-3 h-3 inline mr-1"></i>
                        Catatan ini dapat digunakan sebagai bahan pembahasan dalam Bab 4 Skripsi Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ==================== VARIABEL GLOBAL ====================
let allData = [];
let selectedData = [];
let testResults = [];
let verifiedData = [];
let startTime = 0;
let naiveBayesModel = null;

// ==================== INISIALISASI ====================
document.addEventListener('DOMContentLoaded', function() {
    loadData();
    checkModelStatus();
    feather.replace();
});

// ==================== FUNGSI LOAD DATA (SIMPAN - JANGAN DIHAPUS) ====================
function loadData() {
    const savedRiwayat = localStorage.getItem('riwayatKlasifikasi');
    const riwayatData = savedRiwayat ? JSON.parse(savedRiwayat) : [];
    
    const savedVerified = localStorage.getItem('riwayatTerverifikasi');
    verifiedData = savedVerified ? JSON.parse(savedVerified) : [];
    
    allData = riwayatData.map(item => ({
        id: item.id || Date.now() + Math.random(),
        judul: item.judul || item.judulBuku || 'Judul tidak tersedia',
        kodeDDC: item.kodeDDC || item.kode || '',
        kategori: item.kategori || item.nama_kategori || 'Kategori tidak tersedia',
        tanggal: item.tanggal || item.waktu || new Date().toISOString(),
        confidence: item.confidence || 0, // Simpan confidence awal
        labelAsli: item.kategori || item.nama_kategori || 'Kategori tidak tersedia',
        confidenceAwal: item.confidence || 0 // Confidence awal dari hasil klasifikasi
    }));
    
    // Filter data yang belum terverifikasi
    allData = allData.filter(item => {
        const isVerified = verifiedData.some(verified => {
            const verifiedJudul = verified.judulBuku || verified.judul;
            const verifiedKode = verified.kodeDDC || verified.kode;
            return verifiedJudul === item.judul && verifiedKode === item.kodeDDC;
        });
        return !isVerified;
    });
    
    renderAvailableData();
    updateCategoryFilter();
}

function renderAvailableData() {
    const tbody = document.getElementById('available-data');
    
    if (allData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <i data-feather="inbox" class="w-16 h-16 mb-4 text-gray-300"></i>
                        <p class="text-lg font-medium text-gray-600 mb-2">Tidak ada data untuk diuji</p>
                        <p class="text-sm text-gray-400">Semua data sudah terverifikasi atau belum ada riwayat klasifikasi</p>
                        <button onclick="window.location.href='klasifikasi.php'" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                            <i data-feather="plus" class="w-4 h-4 mr-2 inline"></i> Buat Klasifikasi Baru
                        </button>
                    </div>
                </td>
            </tr>
        `;
        feather.replace();
        return;
    }
    
    tbody.innerHTML = allData.map((item, index) => {
        const isSelected = selectedData.some(s => s.id === item.id);
        let tanggalFormatted = '-';
        try {
            const date = new Date(item.tanggal);
            tanggalFormatted = date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        } catch (e) {
            tanggalFormatted = item.tanggal;
        }
        
        return `
            <tr class="${isSelected ? 'bg-blue-50' : ''} hover:bg-gray-50">
                <td class="px-6 py-4">
                    <input type="checkbox" 
                           onchange="toggleSelectData('${item.id}')" 
                           ${isSelected ? 'checked' : ''} 
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="${item.judul}">
                    ${item.judul}
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">${item.kodeDDC || '-'}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">${item.kategori}</td>
                <td class="px-6 py-4 text-sm text-gray-500">${tanggalFormatted}</td>
            </tr>
        `;
    }).join('');
    
    feather.replace();
}

function updateCategoryFilter() {
    const select = document.getElementById('filter-kategori');
    const categories = [...new Set(allData.map(item => item.kategori).filter(Boolean))].sort();
    
    let options = '<option value="">Semua Kategori</option>';
    categories.forEach(cat => {
        options += `<option value="${cat}">${cat}</option>`;
    });
    
    select.innerHTML = options;
}

// ==================== FUNGSI SELECTION (SIMPAN - JANGAN DIHAPUS) ====================
function toggleSelectData(id) {
    const item = allData.find(d => d.id == id);
    if (!item) return;
    
    const existingIndex = selectedData.findIndex(s => s.id == id);
    
    if (existingIndex > -1) {
        selectedData.splice(existingIndex, 1);
    } else {
        selectedData.push({...item});
    }
    
    renderAvailableData();
    updateSelectedInfo();
}

function toggleAll() {
    const masterCheckbox = document.getElementById('select-all');
    const filteredData = getFilteredData();
    
    // Jika semua data terfilter sudah terpilih, hapus semua
    const allFilteredSelected = filteredData.every(item => 
        selectedData.some(s => s.id === item.id)
    );
    
    if (allFilteredSelected) {
        // Hapus hanya data yang ada di filtered dari selectedData
        const filteredIds = filteredData.map(d => d.id);
        selectedData = selectedData.filter(item => !filteredIds.includes(item.id));
        masterCheckbox.checked = false;
    } else {
        // Tambahkan semua data filtered yang belum terpilih
        filteredData.forEach(item => {
            if (!selectedData.some(s => s.id === item.id)) {
                selectedData.push({...item});
            }
        });
        masterCheckbox.checked = true;
    }
    
    renderAvailableData();
    updateSelectedInfo();
}

function selectAll() {
    const masterCheckbox = document.getElementById('select-all');
    masterCheckbox.checked = true;
    toggleAll();
    showToast(`${selectedData.length} data dipilih untuk pengujian`, 'info');
}

function getFilteredData() {
    const searchTerm = document.getElementById('search-data').value.toLowerCase();
    const categoryFilter = document.getElementById('filter-kategori').value;
    
    return allData.filter(item => {
        const matchesSearch = item.judul.toLowerCase().includes(searchTerm) || 
                             item.kategori.toLowerCase().includes(searchTerm) ||
                             (item.kodeDDC && item.kodeDDC.toLowerCase().includes(searchTerm));
        
        const matchesCategory = !categoryFilter || item.kategori === categoryFilter;
        
        return matchesSearch && matchesCategory;
    });
}

function updateSelectedInfo() {
    const infoDiv = document.getElementById('selected-info');
    const countSpan = document.getElementById('selected-count');
    
    if (selectedData.length > 0) {
        infoDiv.classList.remove('hidden');
        countSpan.textContent = `${selectedData.length} data terpilih`;
    } else {
        infoDiv.classList.add('hidden');
    }
}

function clearSelected() {
    if (selectedData.length === 0) {
        showToast('Tidak ada data terpilih', 'warning');
        return;
    }
    
    if (confirm(`Hapus ${selectedData.length} data terpilih?`)) {
        selectedData = [];
        const masterCheckbox = document.getElementById('select-all');
        if (masterCheckbox) masterCheckbox.checked = false;
        
        renderAvailableData();
        updateSelectedInfo();
        showToast('Data terpilih dihapus', 'success');
    }
}

function filterData() {
    const tbody = document.getElementById('available-data');
    
    if (allData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    Tidak ada data
                </td>
            </tr>
        `;
        return;
    }
    
    const filtered = getFilteredData();
    
    if (filtered.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <i data-feather="search" class="w-12 h-12 mb-3 text-gray-300"></i>
                        <p class="text-gray-600">Tidak ditemukan data yang cocok</p>
                        <p class="text-sm text-gray-400 mt-1">Coba kata kunci atau filter lain</p>
                    </div>
                </td>
            </tr>
        `;
        feather.replace();
        return;
    }
    
    tbody.innerHTML = filtered.map((item, index) => {
        const isSelected = selectedData.some(s => s.id === item.id);
        let tanggalFormatted = '-';
        try {
            const date = new Date(item.tanggal);
            tanggalFormatted = date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        } catch (e) {
            tanggalFormatted = item.tanggal;
        }
        
        return `
            <tr class="${isSelected ? 'bg-blue-50' : ''} hover:bg-gray-50">
                <td class="px-6 py-4">
                    <input type="checkbox" 
                           onchange="toggleSelectData('${item.id}')" 
                           ${isSelected ? 'checked' : ''} 
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="${item.judul}">
                    ${item.judul}
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">${item.kodeDDC || '-'}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">${item.kategori}</td>
                <td class="px-6 py-4 text-sm text-gray-500">${tanggalFormatted}</td>
            </tr>
        `;
    }).join('');
    
    feather.replace();
}

// ==================== MODAL INFORMASI (SIMPAN - JANGAN DIHAPUS) ====================
function showTestingInfo() {
    if (selectedData.length === 0) {
        showToast('Pilih minimal 1 data untuk pengujian', 'warning');
        return;
    }
    
    if (selectedData.length > 100) {
        if (!confirm(`Anda akan menguji ${selectedData.length} data. Proses ini mungkin memakan waktu. Lanjutkan?`)) {
            return;
        }
    }
    
    document.getElementById('info-modal').classList.remove('hidden');
    feather.replace();
}

function closeInfoModal() {
    document.getElementById('info-modal').classList.add('hidden');
}

function startTestingFromModal() {
    closeInfoModal();
    startTesting();
}

// ==================== FUNGSI PENGUJIAN ====================
function startTesting() {
    if (selectedData.length === 0) {
        showToast('Pilih minimal 1 data untuk pengujian', 'warning');
        return;
    }
    
    // Validasi model
    checkModelStatus();
    if (!naiveBayesModel || !naiveBayesModel.categoryDocCount || Object.keys(naiveBayesModel.categoryDocCount).length === 0) {
        showToast('Model Naive Bayes belum terlatih! Tambah data training terlebih dahulu.', 'error');
        return;
    }
    
    // Tampilkan loading
    document.getElementById('selection-card').classList.add('hidden');
    document.getElementById('result-card').classList.remove('hidden');
    document.getElementById('loading-section').classList.remove('hidden');
    document.getElementById('analysis-section').classList.add('hidden');
    
    // Reset UI
    document.getElementById('accuracy-percent').textContent = '...';
    document.getElementById('accuracy-bar').style.width = '0%';
    document.getElementById('progress-text').textContent = `Mengklasifikasi ${selectedData.length} data...`;
    
    startTime = Date.now();
    
    // Proses pengujian
    setTimeout(() => {
        processTesting();
    }, 500);
}

function processTesting() {
    if (!window.tentukanKategoriDenganNaiveBayes) {
        loadNaiveBayesFunctions();
    }
    
    if (typeof window.tentukanKategoriDenganNaiveBayes !== 'function') {
        document.getElementById('loading-section').classList.add('hidden');
        showToast('Fungsi klasifikasi Naive Bayes tidak ditemukan!', 'error');
        return;
    }
    
    testResults = [];
    let processedCount = 0;
    const totalCount = selectedData.length;
    
    // Proses satu per satu untuk progress yang lebih baik
    function processNext() {
        if (processedCount >= totalCount) {
            // Selesai semua
            document.getElementById('loading-section').classList.add('hidden');
            calculateAndDisplayResults();
            return;
        }
        
        const item = selectedData[processedCount];
        
        try {
            // Panggil fungsi klasifikasi
            const prediction = window.tentukanKategoriDenganNaiveBayes(item.judul, naiveBayesModel);
            
            // Parse hasil
            let predictedKode = prediction.kode || '000';
            let predictedKategori = prediction.nama || prediction.kategori || 'Unknown';
            
            if (predictedKategori.includes('|')) {
                const parts = predictedKategori.split('|');
                predictedKode = parts[0] || predictedKode;
                predictedKategori = parts[1] || predictedKategori;
            }
            
            // Hitung akurasi per judul (1 jika benar, 0 jika salah)
            const isCorrect = String(predictedKode) === String(item.kodeDDC);
            
            // Gunakan confidence awal dari hasil klasifikasi, bukan confidence dari pengujian
            const confidence = item.confidenceAwal || item.confidence || 0;
            
            testResults.push({
                ...item,
                predictedKode: predictedKode,
                predictedKategori: predictedKategori,
                isCorrect: isCorrect,
                confidence: confidence, // Gunakan confidence awal
                accuracy: isCorrect ? 1 : 0
            });
            
        } catch (error) {
            // Jika error, catat sebagai salah
            testResults.push({
                ...item,
                predictedKode: '000',
                predictedKategori: 'Error: ' + error.message.substring(0, 30),
                isCorrect: false,
                confidence: item.confidenceAwal || 0, // Tetap gunakan confidence awal
                accuracy: 0,
                error: error.message
            });
        }
        
        processedCount++;
        const progressPercent = (processedCount / totalCount) * 100;
        document.getElementById('progress-text').textContent = `Diproses: ${processedCount}/${totalCount} data`;
        document.getElementById('accuracy-bar').style.width = progressPercent + '%';
        
        // Lanjutkan ke data berikutnya
        setTimeout(processNext, 50);
    }
    
    // Mulai proses
    processNext();
}

function calculateAndDisplayResults() {
    if (testResults.length === 0) {
        showToast('Tidak ada hasil untuk ditampilkan', 'error');
        return;
    }
    
    // Hitung confusion matrix
    const confusionMatrix = calculateConfusionMatrix(testResults);
    
    // Hitung metrik berdasarkan confusion matrix
    const total = testResults.length;
    const tp = confusionMatrix.truePositive;
    const fp = confusionMatrix.falsePositive;
    const fn = confusionMatrix.falseNegative;
    const tn = confusionMatrix.trueNegative;
    
    // Hitung akurasi: (TP + TN) / Total
    const accuracy = total > 0 ? ((tp + tn) / total) * 100 : 0;
    
    // Hitung precision: TP / (TP + FP)
    const precision = (tp + fp) > 0 ? (tp / (tp + fp)) * 100 : 0;
    
    // Hitung recall: TP / (TP + FN)
    const recall = (tp + fn) > 0 ? (tp / (tp + fn)) * 100 : 0;
    
    // Hitung F1-Score: 2 * (precision * recall) / (precision + recall)
    const f1Score = (precision + recall) > 0 ? 
        (2 * precision * recall) / (precision + recall) : 0;
    
    // Hitung waktu proses
    const processingTime = ((Date.now() - startTime) / 1000).toFixed(2);
    
    // Update UI dengan hasil
    updateResultsUI(accuracy, precision, recall, f1Score, confusionMatrix, processingTime);
    
    // Render tabel hasil (DIPERBAIKI SESUAI CONTOH)
    renderTestResultsTable();
    
    // Tampilkan analisis
    showAnalysis(accuracy, confusionMatrix);
    
    // Update waktu pengujian
    document.getElementById('test-time').textContent = new Date().toLocaleString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    showToast(`Pengujian selesai! Akurasi: ${accuracy.toFixed(2)}%`, 'success');
}

function calculateConfusionMatrix(results) {
    let confusionMatrix = {
        truePositive: 0,  // Prediksi benar positif
        falsePositive: 0, // Prediksi salah positif
        falseNegative: 0, // Prediksi salah negatif
        trueNegative: 0   // Prediksi benar negatif
    };

    results.forEach(item => {
        if (item.isCorrect) {
            confusionMatrix.truePositive++;
        } else {
            confusionMatrix.falsePositive++;
            confusionMatrix.falseNegative++;
        }
    });
    
    // TN selalu 0 untuk kasus ini
    confusionMatrix.trueNegative = 0;
    
    return confusionMatrix;
}

function updateResultsUI(accuracy, precision, recall, f1Score, confusionMatrix, processingTime) {
    const total = testResults.length;
    const correctCount = confusionMatrix.truePositive;
    const wrongCount = confusionMatrix.falsePositive;
    
    // Update persentase akurasi
    document.getElementById('accuracy-percent').textContent = accuracy.toFixed(2) + '%';
    document.getElementById('precision-value').textContent = precision.toFixed(2) + '%';
    document.getElementById('recall-value').textContent = recall.toFixed(2) + '%';
    document.getElementById('f1score-value').textContent = f1Score.toFixed(2) + '%';
    
    // Update progress bar final
    setTimeout(() => {
        document.getElementById('accuracy-bar').style.width = accuracy + '%';
    }, 100);
    
    // Update confusion matrix
    document.getElementById('true-positive').textContent = confusionMatrix.truePositive;
    document.getElementById('false-positive').textContent = confusionMatrix.falsePositive;
    document.getElementById('false-negative').textContent = confusionMatrix.falseNegative;
    document.getElementById('true-negative').textContent = confusionMatrix.trueNegative;
    
    // Update statistik
    document.getElementById('correct-count').textContent = correctCount;
    document.getElementById('wrong-count').textContent = wrongCount;
    document.getElementById('total-tested').textContent = total;
    document.getElementById('processing-time').textContent = processingTime + 's';
    
    // Update progress count
    document.getElementById('progress-count').textContent = `${total} data diuji`;
    document.getElementById('result-count').textContent = `${total} hasil klasifikasi`;
    
    // Update model status
    const modelStatus = document.getElementById('model-status');
    if (naiveBayesModel && naiveBayesModel.totalDocs > 0) {
        modelStatus.textContent = `Terlatih (${naiveBayesModel.totalDocs} data training)`;
        modelStatus.className = 'text-sm font-medium text-green-600';
    } else {
        modelStatus.textContent = 'Belum terlatih';
        modelStatus.className = 'text-sm font-medium text-red-600';
    }
    
    // Update deskripsi akurasi
    const accuracyDesc = document.getElementById('accuracy-desc');
    if (accuracy >= 95) {
        accuracyDesc.textContent = 'Sangat Baik - Performa optimal untuk skripsi';
    } else if (accuracy >= 85) {
        accuracyDesc.textContent = 'Baik - Dapat dipertanggungjawabkan secara ilmiah';
    } else if (accuracy >= 75) {
        accuracyDesc.textContent = 'Cukup - Perlu perbaikan preprocessing data';
    } else if (accuracy >= 60) {
        accuracyDesc.textContent = 'Kurang - Evaluasi fitur dan model diperlukan';
    } else {
        accuracyDesc.textContent = 'Buruk - Perlu penelitian lebih lanjut';
    }
}

function renderTestResultsTable() {
    const tbody = document.getElementById('test-results');
    
    tbody.innerHTML = testResults.map((r, i) => {
        // Format confidence (gunakan confidence awal)
        const confidencePercent = r.confidence ? r.confidence.toFixed(1) + '%' : '0.0%';
        const confidenceColor = r.confidence >= 80 ? 'text-green-600' : 
                              r.confidence >= 60 ? 'text-yellow-600' : 'text-red-600';
        
        // Format akurasi per judul sesuai contoh (100.0% jika benar, 0.0% jika salah)
        const accuracyPercent = (r.accuracy * 100).toFixed(1) + '%';
        const accuracyColor = r.accuracy === 1 ? 'text-green-600 font-bold' : 'text-red-600 font-bold';
        
        // Format prediksi sesuai contoh: "Aplikasi Desain & Lain-lain (Office) (005.369) TP"
        const prediksiText = `${r.predictedKategori} (${r.predictedKode}) ${r.isCorrect ? 'TP' : 'FP/FN'}`;
        
        // Row style berdasarkan status
        const rowClass = r.isCorrect ? '' : 'bg-red-50';
        
        // Icon check (✓) atau cross (✗) di depan judul seperti contoh
        const statusIcon = r.isCorrect ? 
            '<span class="text-green-600 mr-2">✓</span>' : 
            '<span class="text-red-600 mr-2">✗</span>';
        
        // Potong judul jika terlalu panjang seperti contoh
        const judulText = r.judul.length > 50 ? r.judul.substring(0, 50) + '...' : r.judul;
        
        return `
            <tr class="hover:bg-gray-50 ${rowClass}">
                <td class="px-6 py-4 text-center text-gray-500 font-medium">${i+1}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        ${statusIcon}
                        <span class="font-medium max-w-xs truncate" title="${r.judul}">${judulText}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium ${r.isCorrect ? 'text-green-700' : 'text-red-700'}">${prediksiText}</div>
                </td>
                <td class="px-6 py-4">
                    <span class="${confidenceColor} font-medium">${confidencePercent}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="${accuracyColor} font-bold">${accuracyPercent}</span>
                </td>
            </tr>`;
    }).join('');
    
    feather.replace();
}

// ==================== FUNGSI SIMPAN TERVERIFIKASI (PERBAIKAN: HAPUS "LIHAT DATA VERIFIKASI") ====================
function saveToVerified() {
    if (!testResults || testResults.length === 0) {
        showToast('Belum ada hasil pengujian', 'warning');
        return;
    }
    
    const correctResults = testResults.filter(item => item.isCorrect);
    if (correctResults.length === 0) {
        showToast('Tidak ada data yang benar untuk diverifikasi', 'warning');
        return;
    }
    
    // Konfirmasi
    const confirmMessage = `Simpan ${correctResults.length} data yang terklasifikasi dengan benar ke data terverifikasi?\n\nData akan langsung tersimpan dan dapat diakses di menu "Hasil Terverifikasi".`;
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    // Simpan ke localStorage
    let existingVerified = JSON.parse(localStorage.getItem('riwayatTerverifikasi') || '[]');
    let savedCount = 0;
    let skippedCount = 0;
    
    correctResults.forEach(item => {
        // Cek duplikasi berdasarkan judul dan kode DDC
        const isDuplicate = existingVerified.some(verified => {
            const verifiedJudul = verified.judulBuku || verified.judul;
            const verifiedKode = verified.kodeDDC || verified.kode;
            return verifiedJudul === item.judul && verifiedKode === item.kodeDDC;
        });
        
        if (!isDuplicate) {
            existingVerified.push({
                id: 'verified_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                tanggalSah: new Date().toISOString(),
                judulBuku: item.judul,
                kodeDDC: item.kodeDDC,
                kategori: item.kategori,
                status: 'Terverifikasi (Hasil Pengujian)',
                confidence: item.confidence, // Simpan confidence awal
                sumber: 'pengujian_objectif',
                hasilPengujian: 'valid',
                metadata: {
                    accuracy: item.accuracy * 100,
                    test_timestamp: new Date().toISOString(),
                    predicted_kode: item.predictedKode,
                    predicted_kategori: item.predictedKategori,
                    confusion_type: item.isCorrect ? 'TP' : 'FP'
                }
            });
            savedCount++;
        } else {
            skippedCount++;
        }
    });
    
    localStorage.setItem('riwayatTerverifikasi', JSON.stringify(existingVerified));
    
    // Tampilkan pesan sukses tanpa tombol "Lihat Data Verifikasi"
    let message = `✅ ${savedCount} data valid berhasil disimpan ke Data Terverifikasi`;
    if (skippedCount > 0) {
        message += ` (${skippedCount} data duplikat dilewati)`;
    }
    
    showToast(message, 'success', 5000);
    
    // Refresh data untuk menghapus data yang sudah diverifikasi dari daftar
    setTimeout(() => {
        loadData();
    }, 500);
}

function saveToTraining() {
    if (!testResults || testResults.length === 0) {
        showToast('Belum ada hasil pengujian', 'warning');
        return;
    }
    
    const correctResults = testResults.filter(item => item.isCorrect);
    if (correctResults.length === 0) {
        showToast('Tidak ada data yang benar untuk disimpan ke Data Training', 'warning');
        return;
    }
    
    // Konfirmasi dengan detail
    const confirmMessage = `Tambahkan ${correctResults.length} data ke dataset training?\n\nData akan digunakan untuk meningkatkan akurasi model klasifikasi.`;
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    let existingTraining = JSON.parse(localStorage.getItem('dataTraining') || '[]');
    let savedCount = 0;
    let skippedCount = 0;
    
    correctResults.forEach(item => {
        const trainingKategori = `${item.kodeDDC}|${item.kategori}`;
        
        // Cek duplikasi berdasarkan judul dan kategori lengkap
        const isDuplicate = existingTraining.some(training => {
            const sameJudul = training.judul === item.judul;
            const sameKategori = training.kategori === trainingKategori;
            return sameJudul && sameKategori;
        });
        
        if (!isDuplicate) {
            existingTraining.push({
                id: 'train_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                judul: item.judul,
                kategori: trainingKategori,
                waktu: new Date().toISOString(),
                sumber: 'pengujian_valid',
                confidence: item.confidence,
                metadata: {
                    asli_kode: item.kodeDDC,
                    asli_kategori: item.kategori,
                    test_result: 'correct',
                    test_timestamp: new Date().toISOString(),
                    predicted_kode: item.predictedKode,
                    predicted_kategori: item.predictedKategori,
                    accuracy: item.accuracy * 100
                }
            });
            savedCount++;
        } else {
            skippedCount++;
        }
    });
    
    localStorage.setItem('dataTraining', JSON.stringify(existingTraining));
    
    let message = `📚 ${savedCount} data berhasil ditambahkan ke Data Training`;
    if (skippedCount > 0) {
        message += ` (${skippedCount} data duplikat dilewati)`;
    }
    
    showToast(message, 'success', 5000);
    
    // Update model
    if (typeof window.buildNaiveBayesModel === 'function') {
        try {
            window.dataTraining = existingTraining;
            window.naiveBayesModel = window.buildNaiveBayesModel(existingTraining);
            naiveBayesModel = window.naiveBayesModel;
            checkModelStatus(); // Update status model
            
            // Tampilkan informasi model baru
            const modelInfo = `Model diperbarui: ${naiveBayesModel.totalDocs} dokumen, ${Object.keys(naiveBayesModel.categoryDocCount || {}).length} kategori`;
            showToast(modelInfo, 'info', 3000);
        } catch (error) {
            console.error("❌ Error memperbarui model:", error);
            showToast('Gagal memperbarui model: ' + error.message, 'error');
        }
    } else {
        showToast('Fungsi buildNaiveBayesModel tidak ditemukan', 'warning');
    }
}

// ==================== FUNGSI EKSPOR (SIMPAN - JANGAN DIHAPUS) ====================
function exportTestResults() {
    if (!testResults || testResults.length === 0) {
        showToast('Tidak ada hasil untuk diekspor', 'warning');
        return;
    }
    
    const confusionMatrix = calculateConfusionMatrix(testResults);
    const total = testResults.length;
    const correctCount = confusionMatrix.truePositive;
    const wrongCount = confusionMatrix.falsePositive;
    const accuracy = total > 0 ? ((correctCount / total) * 100) : 0;
    
    const exportData = {
        metadata: {
            judul: "Hasil Pengujian Sistem Klasifikasi DDC - Skripsi",
            penulis: "Mahasiswa",
            institusi: "Universitas Anda",
            timestamp: new Date().toISOString(),
            total_data_uji: testResults.length,
            algoritma: "Naive Bayes",
            metode_pengujian: "Ground Truth Comparison",
            deskripsi: "Hasil pengujian objektif untuk Bab 4 Skripsi"
        },
        metrics: {
            accuracy: parseFloat(accuracy.toFixed(4)),
            precision: parseFloat((confusionMatrix.truePositive / (confusionMatrix.truePositive + confusionMatrix.falsePositive) * 100).toFixed(4)),
            recall: parseFloat((confusionMatrix.truePositive / (confusionMatrix.truePositive + confusionMatrix.falseNegative) * 100).toFixed(4)),
            f1_score: parseFloat((2 * (confusionMatrix.truePositive / (confusionMatrix.truePositive + confusionMatrix.falsePositive)) * (confusionMatrix.truePositive / (confusionMatrix.truePositive + confusionMatrix.falseNegative)) / ((confusionMatrix.truePositive / (confusionMatrix.truePositive + confusionMatrix.falsePositive)) + (confusionMatrix.truePositive / (confusionMatrix.truePositive + confusionMatrix.falseNegative))) * 100).toFixed(4)),
            true_positive: confusionMatrix.truePositive,
            false_positive: confusionMatrix.falsePositive,
            false_negative: confusionMatrix.falseNegative,
            true_negative: confusionMatrix.trueNegative,
            correct_predictions: correctCount,
            wrong_predictions: wrongCount
        },
        results: testResults.map((item, index) => ({
            no: index + 1,
            judul_buku: item.judul,
            ground_truth: {
                kode_ddc: item.kodeDDC,
                kategori: item.kategori
            },
            prediction: {
                kode_ddc: item.predictedKode,
                kategori: item.predictedKategori,
                confidence: item.confidence // Confidence awal
            },
            accuracy_per_item: item.accuracy * 100,
            status: item.isCorrect ? "BENAR" : "SALAH",
            confusion_type: item.isCorrect ? "TP" : "FP/FN",
            timestamp: new Date().toISOString()
        }))
    };
    
    // Buat blob untuk download
    const jsonData = JSON.stringify(exportData, null, 2);
    const blob = new Blob([jsonData], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    
    const a = document.createElement('a');
    a.href = url;
    const dateStr = new Date().toISOString().split('T')[0];
    a.download = `hasil-pengujian-ddc-skripsi-${dateStr}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    showToast('Data pengujian berhasil diekspor untuk keperluan skripsi', 'success');
}

// ==================== FUNGSI RESET (SIMPAN - JANGAN DIHAPUS) ====================
function resetTesting() {
    if (testResults && testResults.length > 0) {
        if (!confirm('Reset pengujian? Anda akan kembali ke pemilihan data.')) {
            return;
        }
    }
    
    selectedData = [];
    testResults = [];
    
    document.getElementById('selection-card').classList.remove('hidden');
    document.getElementById('result-card').classList.add('hidden');
    document.getElementById('analysis-section').classList.add('hidden');
    
    const masterCheckbox = document.getElementById('select-all');
    if (masterCheckbox) masterCheckbox.checked = false;
    
    loadData();
    showToast('Siap untuk pengujian baru', 'info');
}

// ==================== FUNGSI SORT (SIMPAN - JANGAN DIHAPUS) ====================
function toggleSortResults() {
    if (!testResults || testResults.length === 0) return;
    
    // Toggle antara urutan asli dan urut berdasarkan status (salah dulu)
    const currentOrder = testResults[0].hasOwnProperty('originalIndex') ? 'sorted' : 'original';
    
    if (currentOrder === 'original') {
        // Tambahkan index asli
        testResults.forEach((item, index) => {
            item.originalIndex = index;
        });
        
        // Urut berdasarkan status (salah dulu, lalu benar)
        testResults.sort((a, b) => {
            if (a.isCorrect === b.isCorrect) return 0;
            return a.isCorrect ? 1 : -1;
        });
        
        showToast('Diurutkan: Prediksi salah ditampilkan pertama', 'info');
    } else {
        // Kembali ke urutan asli
        testResults.sort((a, b) => a.originalIndex - b.originalIndex);
        
        // Hapus properti originalIndex
        testResults.forEach(item => {
            delete item.originalIndex;
        });
        
        showToast('Kembali ke urutan asli', 'info');
    }
    
    // Render ulang tabel
    renderTestResultsTable();
}

// ==================== FUNGSI NAIVE BAYES (SIMPAN - JANGAN DIHAPUS) ====================
function checkModelStatus() {
    // Cek jika fungsi Naive Bayes sudah dimuat
    if (typeof window.tentukanKategoriDenganNaiveBayes !== 'function') {
        loadNaiveBayesFunctions();
    }
    
    // Cek model
    if (window.naiveBayesModel) {
        naiveBayesModel = window.naiveBayesModel;
    } else {
        // Coba load dari data training
        const trainingData = JSON.parse(localStorage.getItem('dataTraining') || '[]');
        if (trainingData.length > 0 && typeof window.buildNaiveBayesModel === 'function') {
            naiveBayesModel = window.buildNaiveBayesModel(trainingData);
            window.naiveBayesModel = naiveBayesModel;
        }
    }
    
    // Update warning UI
    const warningDiv = document.getElementById('model-warning');
    if (naiveBayesModel && naiveBayesModel.totalDocs > 0) {
        warningDiv.classList.add('hidden');
    } else {
        warningDiv.classList.remove('hidden');
    }
}

function loadNaiveBayesFunctions() {
    // Jika fungsi belum ada, definisikan versi sederhana
    if (typeof window.buildNaiveBayesModel !== 'function') {
        window.buildNaiveBayesModel = function(trainingData) {
            console.log("Membangun model Naive Bayes...");
            
            const model = {
                vocabulary: new Set(),
                categoryWordCount: {},
                categoryDocCount: {},
                totalDocs: 0
            };
            
            if (!trainingData || trainingData.length === 0) {
                console.warn("Data training kosong, mengembalikan model default");
                return model;
            }
            
            trainingData.forEach(item => {
                if (!item.judul || !item.kategori) return;
                
                const words = preprocessText(item.judul);
                const category = item.kategori;
                
                words.forEach(word => model.vocabulary.add(word));
                
                if (!model.categoryWordCount[category]) {
                    model.categoryWordCount[category] = {};
                    model.categoryDocCount[category] = 0;
                }
                
                words.forEach(word => {
                    model.categoryWordCount[category][word] = 
                        (model.categoryWordCount[category][word] || 0) + 1;
                });
                
                model.categoryDocCount[category]++;
                model.totalDocs++;
            });
            
            console.log(`Model dibangun: ${model.totalDocs} dokumen, ${model.vocabulary.size} kata unik`);
            return model;
        };
    }
    
    if (typeof window.tentukanKategoriDenganNaiveBayes !== 'function') {
        window.tentukanKategoriDenganNaiveBayes = function(judul, model = naiveBayesModel) {
            if (!judul || typeof judul !== 'string') {
                return { kode: '000', nama: 'Unknown', confidence: 0 };
            }
            
            if (!model || !model.categoryDocCount || Object.keys(model.categoryDocCount).length === 0) {
                console.warn("Model Naive Bayes belum dilatih atau kosong");
                return { 
                    kode: '000', 
                    nama: 'Model Belum Terlatih', 
                    confidence: 0
                };
            }
            
            const words = preprocessText(judul);
            
            let bestCategory = null;
            let bestScore = -Infinity;
            const scores = {};
            
            Object.keys(model.categoryDocCount).forEach(category => {
                const prior = model.categoryDocCount[category] / model.totalDocs;
                let likelihood = 0;
                
                words.forEach(word => {
                    const wordCount = model.categoryWordCount[category][word] || 0;
                    const totalWordsInCategory = Object.values(model.categoryWordCount[category] || {}).reduce((a, b) => a + b, 0);
                    const probability = (wordCount + 1) / (totalWordsInCategory + model.vocabulary.size);
                    likelihood += Math.log(probability);
                });
                
                const posterior = Math.log(prior) + likelihood;
                scores[category] = posterior;
                
                if (posterior > bestScore) {
                    bestScore = posterior;
                    bestCategory = category;
                }
            });
            
            let totalScore = 0;
            Object.values(scores).forEach(score => {
                totalScore += Math.exp(score);
            });
            
            const confidence = totalScore > 0 ? 
                (Math.exp(scores[bestCategory]) / totalScore) * 100 : 50;
            
            let kode = '000';
            let nama = 'Unknown';
            
            if (bestCategory && bestCategory.includes('|')) {
                const parts = bestCategory.split('|');
                kode = parts[0] || '000';
                nama = parts[1] || bestCategory;
            } else if (bestCategory) {
                nama = bestCategory;
                const savedTraining = JSON.parse(localStorage.getItem('dataTraining') || '[]');
                const match = savedTraining.find(item => item.kategori === bestCategory);
                if (match && match.kategori.includes('|')) {
                    kode = match.kategori.split('|')[0];
                }
            }
            
            return {
                kode: kode,
                nama: nama,
                kategori: bestCategory || '',
                confidence: Math.min(100, Math.max(0, confidence))
            };
        };
    }
    
    // Fungsi helper
    function preprocessText(text) {
        if (!text) return [];
        return text.toLowerCase()
            .replace(/[^\w\s]/g, ' ')
            .split(/\s+/)
            .filter(word => word.length > 2)
            .filter(word => !isStopWord(word));
    }
    
    function isStopWord(word) {
        const stopWords = ['dan', 'dengan', 'di', 'ke', 'dari', 'untuk', 'pada', 'adalah', 'yang', 'dalam'];
        return stopWords.includes(word.toLowerCase());
    }
}

// ==================== FUNGSI ANALISIS (SIMPAN - JANGAN DIHAPUS) ====================
function showAnalysis(accuracy, confusionMatrix) {
    const analysisSection = document.getElementById('analysis-section');
    const errorAnalysis = document.getElementById('error-analysis');
    const recommendations = document.getElementById('recommendations');
    
    analysisSection.classList.remove('hidden');
    
    const tp = confusionMatrix.truePositive;
    const fp = confusionMatrix.falsePositive;
    const fn = confusionMatrix.falseNegative;
    const total = testResults.length;
    
    // Analisis kesalahan
    let analysisText = '';
    if (fp === 0 && fn === 0) {
        analysisText = '🎉 Semua prediksi benar! Algoritma Naive Bayes bekerja dengan sangat baik pada dataset ini.';
    } else {
        analysisText = `📊 Ditemukan ${fp} kesalahan prediksi (${((fp/total)*100).toFixed(1)}%). `;
        
        if (accuracy >= 90) {
            analysisText += 'Kesalahan minor terjadi pada kategori yang memiliki kemiripan tinggi.';
        } else if (accuracy >= 80) {
            analysisText += 'Perlu evaluasi preprocessing data untuk mengurangi kesalahan.';
        } else if (accuracy >= 70) {
            analysisText += 'Model membutuhkan lebih banyak data training pada kategori yang sering salah.';
        } else if (accuracy >= 60) {
            analysisText += 'Perlu evaluasi mendalam terhadap fitur dan parameter model.';
        } else {
            analysisText += 'Model membutuhkan perbaikan signifikan pada preprocessing dan data training.';
        }
    }
    
    // Rekomendasi untuk skripsi
    let recText = '';
    if (accuracy >= 90) {
        recText = '✅ Hasil sangat memuaskan. Dapat digunakan sebagai bukti efektivitas algoritma Naive Bayes untuk klasifikasi DDC.';
    } else if (accuracy >= 80) {
        recText = '✅ Hasil baik. Pertimbangkan untuk menambah data training dan optimasi parameter untuk meningkatkan akurasi.';
    } else if (accuracy >= 70) {
        recText = '⚠️ Hasil cukup. Analisis kesalahan spesifik untuk memahami kelemahan algoritma. Pertimbangkan feature engineering.';
    } else if (accuracy >= 60) {
        recText = '⚠️ Hasil kurang. Evaluasi ulang preprocessing teks, pemilihan fitur, atau pertimbangkan algoritma alternatif.';
    } else {
        recText = '🔴 Hasil rendah. Perlu penelitian mendalam untuk meningkatkan akurasi model sebelum digunakan untuk klasifikasi.';
    }
    
    errorAnalysis.textContent = analysisText;
    recommendations.textContent = recText;
}

// ==================== TOAST NOTIFICATION (SIMPAN - JANGAN DIHAPUS) ====================
function showToast(message, type = 'info', duration = 4000) {
    // Hapus toast yang ada
    const existingToasts = document.querySelectorAll('.custom-toast');
    existingToasts.forEach(toast => toast.remove());
    
    const toast = document.createElement('div');
    const colors = {
        'success': 'bg-green-600',
        'warning': 'bg-yellow-600',
        'info': 'bg-blue-600',
        'error': 'bg-red-600'
    };
    const color = colors[type] || colors.info;
    
    const icons = {
        'success': 'check-circle',
        'warning': 'alert-triangle',
        'error': 'alert-circle',
        'info': 'info'
    };
    const icon = icons[type] || 'info';
    
    toast.className = `custom-toast fixed bottom-4 right-4 px-4 py-3 ${color} text-white rounded-lg shadow-lg z-50 flex items-center animate-fade-in max-w-md`;
    toast.innerHTML = `
        <i data-feather="${icon}" class="w-5 h-5 mr-2 flex-shrink-0"></i>
        <span class="text-sm font-medium flex-1">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-3 text-white/80 hover:text-white">
            <i data-feather="x" class="w-4 h-4"></i>
        </button>
    `;
    
    document.body.appendChild(toast);
    feather.replace();
    
    // Auto remove setelah durasi tertentu
    setTimeout(() => {
        toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, duration);
}

// ==================== FUNGSI DEBUG (SIMPAN - JANGAN DIHAPUS) ====================
function debugTestResults() {
    console.log('=== DEBUG HASIL PENGUJIAN ===');
    console.log('Total data:', testResults.length);
    console.log('Hasil pengujian:', testResults);
    
    const confusionMatrix = calculateConfusionMatrix(testResults);
    console.log('Confusion Matrix:', confusionMatrix);
    
    // Cek fungsi klasifikasi
    if (typeof window.tentukanKategoriDenganNaiveBayes === 'function') {
        console.log('✅ Fungsi klasifikasi ditemukan');
    } else {
        console.error('❌ Fungsi klasifikasi TIDAK ditemukan!');
    }
    
    // Cek model
    console.log('Model Naive Bayes:', naiveBayesModel);
}

// Ekspos fungsi untuk debugging
window.debugTesting = debugTestResults;
window.getTestingData = () => ({ allData, selectedData, testResults });
window.reloadNaiveBayesModel = checkModelStatus;
</script>

<style>
/* Styles yang TIDAK DIHAPUS */
.animate-fade-in { 
    animation: fadeIn 0.5s ease-out; 
}
@keyframes fadeIn { 
    from { opacity: 0; transform: translateY(10px); } 
    to { opacity: 1; transform: translateY(0); } 
}

#accuracy-bar {
    transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
}

table th {
    font-weight: 600;
}

table tbody tr {
    transition: background-color 0.2s;
}

input[type="checkbox"]:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.custom-toast {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from { 
        opacity: 0; 
        transform: translateX(30px); 
    }
    to { 
        opacity: 1; 
        transform: translateX(0); 
    }
}

@media (max-width: 768px) {
    .text-7xl {
        font-size: 3.5rem;
    }
    
    .grid-cols-4 {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Style untuk status */
.status-correct {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.status-wrong {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

/* Style untuk card */
.card-hover {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Loading spinner */
@keyframes spin {
    to { transform: rotate(360deg); }
}
.animate-spin {
    animation: spin 1s linear infinite;
}
</style>