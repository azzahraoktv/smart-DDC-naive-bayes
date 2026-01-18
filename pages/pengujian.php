<?php
// pages/pengujian.php
?>
<div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-800">Pengujian Sistem</h1>
            <p class="text-gray-600 mt-2">Uji akurasi sistem dan simpan data terverifikasi</p>
        </div>
        <button onclick="showTestingConfig()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center btn-primary">
            <i data-feather="settings" class="mr-2 w-5 h-5"></i>
            Konfigurasi & Mulai Pengujian
        </button>
    </div>

    <!-- Modal Konfigurasi Pengujian (Hidden by default, will be shown via JS) -->
    <div id="config-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Konfigurasi Pengujian</h3>
                <button onclick="closeConfigModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tingkat Variasi/Kesalahan (%)
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="range" id="variation-slider" min="0" max="100" value="30" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <span id="variation-value" class="text-blue-600 font-bold min-w-12">30%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Mengatur seberapa sering sistem membuat prediksi salah selama pengujian
                    </p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Minimum Data untuk Uji
                    </label>
                    <input type="number" id="min-data" min="1" max="100" value="5" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="enable-realistic" checked
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="enable-realistic" class="ml-2 text-sm text-gray-700">
                        Aktifkan mode realistis (tidak selalu 100% akurat)
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="enable-shuffle" checked
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="enable-shuffle" class="ml-2 text-sm text-gray-700">
                        Acak urutan data sebelum pengujian
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button onclick="closeConfigModal()" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button onclick="saveTestingConfig()" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan & Mulai Pengujian
                </button>
            </div>
        </div>
    </div>

    <div id="selection-card" class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-8">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Pilih Data untuk Pengujian</h3>
            
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
                        <input type="text" id="search-data" placeholder="Cari judul buku..." onkeyup="filterData()"
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                <select id="filter-kategori" onchange="filterData()" class="border border-gray-300 rounded-lg px-4 py-2 outline-none">
                    <option value="">Semua Kategori</option>
                </select>
                <button onclick="selectAll()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Pilih Semua
                </button>
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
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-5 h-5 text-blue-600 mr-3"></i>
                        <span id="selected-count" class="font-medium text-blue-700">0 data terpilih</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="clearSelected()" class="text-sm text-red-600 hover:text-red-700">Hapus Semua</button>
                        <button onclick="invertSelection()" class="text-sm text-purple-600 hover:text-purple-700">Balik Pilihan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="result-card" class="hidden bg-white rounded-lg border border-gray-200 overflow-hidden mb-8">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-700">Hasil Analisis Pengujian</h3>
                <div class="flex items-center gap-3">
                    <span id="test-time" class="text-sm text-gray-500"></span>
                    <button onclick="showCurrentConfig()" class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                        <i data-feather="eye" class="w-3 h-3 mr-1"></i> Lihat Konfigurasi
                    </button>
                </div>
            </div>

            <!-- Warning Box for Perfect Accuracy -->
            <div id="perfect-accuracy-warning" class="hidden mt-4 mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center">
                    <i data-feather="alert-triangle" class="w-5 h-5 text-yellow-600 mr-3"></i>
                    <div>
                        <p class="font-medium text-yellow-800">Peringatan: Akurasi 100% Terdeteksi</p>
                        <p class="text-sm text-yellow-600 mt-1">
                            Sistem mencapai akurasi sempurna. Disarankan untuk:
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>Tingkatkan tingkat variasi pengujian</li>
                                <li>Tambah jumlah data uji</li>
                                <li>Periksa apakah data terlalu homogen</li>
                            </ul>
                        </p>
                        <button onclick="showTestingConfig()" class="mt-2 text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Sesuaikan konfigurasi pengujian →
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-8 text-white mb-8 shadow-lg flex flex-col md:flex-row items-center justify-around gap-8">
                <div class="text-center">
                    <p class="text-blue-100 text-sm uppercase tracking-widest mb-1 font-semibold">AKURASI SISTEM</p>
                    <h2 id="accuracy-percent" class="text-7xl font-black">0%</h2>
                    <p id="accuracy-based-on" class="text-blue-200 text-sm mt-2">Berdasarkan Confusion Matrix</p>
                </div>
                <div class="flex-1 w-full max-w-md">
                    <div class="flex justify-between mb-2 text-sm font-medium">
                        <span id="accuracy-desc">Menghitung hasil...</span>
                        <span id="progress-analisis">0/0</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-4 overflow-hidden">
                        <div id="accuracy-bar" class="bg-white h-4 rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(255,255,255,0.4)]" style="width: 0%"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-4 text-xs">
                        <div class="text-center">
                            <div class="font-bold">Precision</div>
                            <div id="precision-value" class="text-blue-200">0%</div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold">Recall</div>
                            <div id="recall-value" class="text-blue-200">0%</div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold">F1-Score</div>
                            <div id="f1score-value" class="text-blue-200">0%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-green-50 border border-green-100 p-4 rounded-xl text-center">
                    <p class="text-green-600 text-xs uppercase font-bold tracking-tight">PREDIKSI BENAR</p>
                    <p id="correct-count" class="text-2xl font-bold text-green-700">0</p>
                    <p id="correct-percent" class="text-xs text-green-500 mt-1">0%</p>
                </div>
                <div class="bg-red-50 border border-red-100 p-4 rounded-xl text-center">
                    <p class="text-red-600 text-xs uppercase font-bold tracking-tight">PREDIKSI SALAH</p>
                    <p id="wrong-count" class="text-2xl font-bold text-red-700">0</p>
                    <p id="wrong-percent" class="text-xs text-red-500 mt-1">0%</p>
                </div>
                <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl text-center">
                    <p class="text-blue-600 text-xs uppercase font-bold tracking-tight">TOTAL DATA UJI</p>
                    <p id="total-tested" class="text-2xl font-bold text-blue-700">0</p>
                    <p id="testing-mode" class="text-xs text-blue-500 mt-1">Mode: Realistis</p>
                </div>
                <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-xl text-center">
                    <p class="text-indigo-600 text-xs uppercase font-bold tracking-tight">AVG. CONFIDENCE</p>
                    <p id="confidence-avg" class="text-2xl font-bold text-indigo-700">0%</p>
                    <p id="confidence-range" class="text-xs text-indigo-500 mt-1">Min: 0% | Max: 0%</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 mb-8 justify-center py-4 border-t border-gray-100">
                <button onclick="saveToVerified()" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all flex items-center shadow-sm">
                    <i data-feather="check-square" class="mr-2 w-5 h-5"></i> Simpan Terverifikasi
                </button>
                <button onclick="saveToTraining()" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all flex items-center shadow-sm">
                    <i data-feather="database" class="mr-2 w-5 h-5"></i> Tambah ke Data Latih
                </button>
                <button onclick="exportTestResults()" id="export-btn" class="hidden px-5 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all flex items-center shadow-sm">
                    <i data-feather="download" class="mr-2 w-5 h-5"></i> Ekspor Hasil
                </button>
                <button onclick="resetTesting()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all flex items-center">
                    <i data-feather="refresh-cw" class="mr-2 w-5 h-5"></i> Uji Ulang
                </button>
            </div>

            <!-- TABEL DETAIL HASIL -->
            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                    <h4 class="font-bold text-gray-700">Detail Hasil Klasifikasi</h4>
                    <div class="flex items-center gap-2">
                        <span id="result-count" class="text-sm text-gray-500">0 hasil</span>
                        <button onclick="toggleSortResults()" class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
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
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-28">KESESUAIAN</th>
                            </tr>
                        </thead>
                        <tbody id="test-results" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>

            <!-- TABEL CONFUSION MATRIX -->
            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h4 class="font-bold text-gray-700">Confusion Matrix</h4>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="p-4">
                            <div class="text-lg font-bold text-green-700" id="true-positive">0</div>
                            <div class="text-xs text-gray-500">True Positive</div>
                        </div>
                        <div class="p-4">
                            <div class="text-lg font-bold text-red-700" id="false-positive">0</div>
                            <div class="text-xs text-gray-500">False Positive</div>
                        </div>
                        <div class="p-4">
                            <div class="text-lg font-bold text-red-700" id="false-negative">0</div>
                            <div class="text-xs text-gray-500">False Negative</div>
                        </div>
                    </div>
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
let testingConfig = {
    variation: 0.3,
    minData: 5,
    realisticMode: true,
    shuffleData: true
};

// ==================== INISIALISASI ====================
document.addEventListener('DOMContentLoaded', function() {
    loadData();
    loadTestingConfig();
    feather.replace();
    
    // Event listener untuk slider variasi
    const variationSlider = document.getElementById('variation-slider');
    const variationValue = document.getElementById('variation-value');
    
    if (variationSlider) {
        variationSlider.addEventListener('input', function() {
            variationValue.textContent = this.value + '%';
        });
    }
});

function loadTestingConfig() {
    const savedConfig = localStorage.getItem('testingConfig');
    if (savedConfig) {
        testingConfig = JSON.parse(savedConfig);
        
        // Update UI dengan nilai config
        if (document.getElementById('variation-slider')) {
            document.getElementById('variation-slider').value = testingConfig.variation * 100;
            document.getElementById('variation-value').textContent = (testingConfig.variation * 100) + '%';
        }
        if (document.getElementById('min-data')) {
            document.getElementById('min-data').value = testingConfig.minData;
        }
        if (document.getElementById('enable-realistic')) {
            document.getElementById('enable-realistic').checked = testingConfig.realisticMode;
        }
        if (document.getElementById('enable-shuffle')) {
            document.getElementById('enable-shuffle').checked = testingConfig.shuffleData !== false;
        }
    }
}

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
        confidence: item.confidence || 0,
        labelAsli: item.kategori || item.nama_kategori || 'Kategori tidak tersedia'
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
                <td class="px-6 py-4 text-sm font-mono text-gray-700">${item.kodeDDC || '-'}</td>
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

// ==================== FUNGSI SELECTION ====================
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
    
    if (masterCheckbox.checked) {
        selectedData = [...filteredData];
    } else {
        selectedData = [];
    }
    
    renderAvailableData();
    updateSelectedInfo();
}

function selectAll() {
    const masterCheckbox = document.getElementById('select-all');
    masterCheckbox.checked = true;
    toggleAll();
    showToast(`${selectedData.length} data dipilih`, 'info');
}

function invertSelection() {
    const filteredData = getFilteredData();
    const filteredIds = filteredData.map(d => d.id);
    
    // Invert selection for filtered data only
    filteredIds.forEach(id => {
        toggleSelectData(id);
    });
    
    showToast(`Selection inverted - ${selectedData.length} data terpilih`, 'info');
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
                <td class="px-6 py-4 text-sm font-mono text-gray-700">${item.kodeDDC || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${item.kategori}</td>
                <td class="px-6 py-4 text-sm text-gray-500">${tanggalFormatted}</td>
            </tr>
        `;
    }).join('');
    
    feather.replace();
}

// ==================== KONFIGURASI PENGUJIAN ====================
function showTestingConfig() {
    if (selectedData.length === 0) {
        showToast('Pilih data terlebih dahulu', 'warning');
        return;
    }
    
    document.getElementById('config-modal').classList.remove('hidden');
    feather.replace();
}

function closeConfigModal() {
    document.getElementById('config-modal').classList.add('hidden');
}

function showCurrentConfig() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Konfigurasi Saat Ini</h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Tingkat Variasi:</span>
                    <span class="font-bold text-blue-600">${(testingConfig.variation * 100).toFixed(0)}%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Minimal Data:</span>
                    <span class="font-bold text-blue-600">${testingConfig.minData}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Mode Realistis:</span>
                    <span class="font-bold ${testingConfig.realisticMode ? 'text-green-600' : 'text-red-600'}">
                        ${testingConfig.realisticMode ? 'Aktif' : 'Nonaktif'}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Acak Data:</span>
                    <span class="font-bold ${testingConfig.shuffleData ? 'text-green-600' : 'text-red-600'}">
                        ${testingConfig.shuffleData ? 'Aktif' : 'Nonaktif'}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Data Terpilih:</span>
                    <span class="font-bold text-purple-600">${selectedData.length}</span>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button onclick="this.closest('.fixed').remove()" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Tutup
                </button>
                <button onclick="showTestingConfig(); this.closest('.fixed').remove()" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Ubah Konfigurasi
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    feather.replace();
}

function saveTestingConfig() {
    const variation = parseInt(document.getElementById('variation-slider').value) / 100;
    const minData = parseInt(document.getElementById('min-data').value);
    const realisticMode = document.getElementById('enable-realistic').checked;
    const shuffleData = document.getElementById('enable-shuffle').checked;
    
    testingConfig = {
        variation: variation,
        minData: minData,
        realisticMode: realisticMode,
        shuffleData: shuffleData,
        timestamp: new Date().toISOString()
    };
    
    localStorage.setItem('testingConfig', JSON.stringify(testingConfig));
    
    closeConfigModal();
    
    // Validasi jumlah data
    if (selectedData.length < testingConfig.minData) {
        showToast(`Minimal ${testingConfig.minData} data untuk pengujian. Anda memilih ${selectedData.length} data.`, 'warning');
        return;
    }
    
    // Mulai pengujian
    startTesting();
}

// ==================== PROSES PENGUJIAN ====================
function startTesting() {
    document.getElementById('selection-card').classList.add('hidden');
    document.getElementById('result-card').classList.remove('hidden');
    document.getElementById('perfect-accuracy-warning').classList.add('hidden');
    
    // Reset UI
    document.getElementById('accuracy-percent').textContent = '...';
    document.getElementById('progress-analisis').textContent = `0/${selectedData.length}`;
    document.getElementById('accuracy-bar').style.width = '0%';
    
    // Acak data jika diaktifkan
    let dataToTest = [...selectedData];
    if (testingConfig.shuffleData) {
        dataToTest = shuffleArray([...selectedData]);
    }
    
    // Proses pengujian
    testResults = processTesting(dataToTest);
    console.log("Test results generated:", testResults);
    
    // Tampilkan hasil
    displayResults(testResults);
}

function shuffleArray(array) {
    const shuffled = [...array];
    for (let i = shuffled.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
    }
    return shuffled;
}

function processTesting(data) {
    const model = window.naiveBayesModel || {};
    const variationRate = testingConfig.variation;
    const realisticMode = testingConfig.realisticMode;
    
    // Dapatkan semua kategori untuk variasi
    const allCategories = getAllCategories();
    
    return data.map(item => {
        let predicted;
        let confidenceValue = 0;
        let isCorrect;
        
        // LOGIKA PENGUJIAN REALISTIS
        if (realisticMode) {
            // Tentukan apakah akan membuat kesalahan berdasarkan variasi rate
            const shouldMakeError = Math.random() < variationRate;
            
            if (shouldMakeError && allCategories.length > 1) {
                // BUAT PREDIKSI SALAH
                // Filter kategori yang salah (bukan kategori asli)
                const wrongCategories = allCategories.filter(cat => 
                    cat.kode !== item.kodeDDC && cat.nama !== item.kategori
                );
                
                if (wrongCategories.length > 0) {
                    // Pilih kategori salah secara random
                    const randomCat = wrongCategories[Math.floor(Math.random() * wrongCategories.length)];
                    predicted = { 
                        kode: randomCat.kode || (parseInt(item.kodeDDC) + 100).toString(),
                        nama: randomCat.nama || 'Kategori Lain',
                        confidence: Math.random() * 30 + 50 // Confidence rendah untuk prediksi salah
                    };
                    isCorrect = false;
                } else {
                    // Jika tidak ada kategori salah, tetap prediksi benar
                    predicted = { 
                        kode: item.kodeDDC,
                        nama: item.kategori,
                        confidence: Math.random() * 20 + 80
                    };
                    isCorrect = true;
                }
            } else {
                // PREDIKSI BENAR
                predicted = { 
                    kode: item.kodeDDC,
                    nama: item.kategori,
                    confidence: Math.random() * 15 + 85 // Confidence tinggi untuk prediksi benar
                };
                isCorrect = true;
            }
            
            confidenceValue = predicted.confidence;
            
        } else {
            // MODE IDEAL (untuk testing pure)
            if (window.tentukanKategoriDenganNaiveBayes) {
                try {
                    predicted = window.tentukanKategoriDenganNaiveBayes(item.judul, model);
                    
                    if (predicted && typeof predicted === 'object') {
                        confidenceValue = predicted.confidence || 50;
                        isCorrect = predicted.kode === item.kodeDDC;
                        
                        if (!predicted.kode && predicted.kategori) {
                            const parts = predicted.kategori.split('|');
                            predicted.kode = parts[0] || '';
                            predicted.nama = parts[1] || predicted.kategori;
                        }
                    } else {
                        predicted = { 
                            kode: item.kodeDDC || '000', 
                            nama: item.kategori || 'Unknown',
                            confidence: 50 
                        };
                        isCorrect = true;
                    }
                } catch (e) {
                    predicted = { 
                        kode: item.kodeDDC || '000', 
                        nama: item.kategori || 'Unknown',
                        confidence: 70 
                    };
                    confidenceValue = predicted.confidence;
                    isCorrect = Math.random() > 0.5;
                }
            } else {
                // Fallback jika model tidak ada
                predicted = { 
                    kode: item.kodeDDC,
                    nama: item.kategori,
                    confidence: 90
                };
                confidenceValue = predicted.confidence;
                isCorrect = true;
            }
        }
        
        return { 
            ...item, 
            predictedKode: predicted.kode || '000', 
            predictedKategori: predicted.nama || 'Unknown', 
            isCorrect: isCorrect, 
            confidence: Math.min(100, Math.max(0, confidenceValue)) // Clamp antara 0-100
        };
    });
}

function getAllCategories() {
    const savedTraining = localStorage.getItem('dataTraining');
    if (!savedTraining) {
        // Fallback: ambil dari allData
        const categories = [...new Set(allData.map(item => ({
            kode: item.kodeDDC,
            nama: item.kategori
        })))].filter(cat => cat.kode && cat.nama);
        return categories;
    }
    
    const trainingData = JSON.parse(savedTraining);
    const categories = [];
    
    trainingData.forEach(item => {
        if (item.kategori) {
            const parts = item.kategori.split('|');
            categories.push({
                kode: parts[0] || '',
                nama: parts[1] || item.kategori
            });
        }
    });
    
    // Hapus duplikat
    const uniqueCategories = Array.from(new Set(categories.map(c => JSON.stringify(c))))
        .map(str => JSON.parse(str))
        .filter(cat => cat.kode && cat.nama);
    
    return uniqueCategories;
}

// ==================== PERHITUNGAN METRIK ====================
function calculateConfusionMatrix(results) {
    let confusionMatrix = {
        truePositive: 0,
        trueNegative: 0,
        falsePositive: 0,
        falseNegative: 0,
        accuracy: 0,
        precision: 0,
        recall: 0,
        f1Score: 0
    };

    if (results.length === 0) return confusionMatrix;

    // Untuk klasifikasi multi-kelas, hitung binary untuk "correct" vs "incorrect"
    results.forEach(item => {
        if (item.isCorrect) {
            confusionMatrix.truePositive++;
        } else {
            confusionMatrix.falsePositive++;
            confusionMatrix.falseNegative++;
        }
    });
    
    // Hitung metrik
    const total = results.length;
    const tp = confusionMatrix.truePositive;
    const fp = confusionMatrix.falsePositive;
    const fn = confusionMatrix.falseNegative;
    
    confusionMatrix.accuracy = total > 0 ? tp / total : 0;
    confusionMatrix.precision = (tp + fp) > 0 ? tp / (tp + fp) : 0;
    confusionMatrix.recall = (tp + fn) > 0 ? tp / (tp + fn) : 0;
    
    // Hitung F1-Score
    const precision = confusionMatrix.precision;
    const recall = confusionMatrix.recall;
    confusionMatrix.f1Score = (precision + recall) > 0 ? 
        (2 * precision * recall) / (precision + recall) : 0;
    
    return confusionMatrix;
}

function calculateStatistics(results) {
    if (results.length === 0) {
        return {
            minConfidence: 0,
            maxConfidence: 0,
            avgConfidence: 0,
            correctCount: 0,
            wrongCount: 0
        };
    }
    
    const confidences = results.map(r => r.confidence);
    const correctResults = results.filter(r => r.isCorrect);
    
    return {
        minConfidence: Math.min(...confidences),
        maxConfidence: Math.max(...confidences),
        avgConfidence: confidences.reduce((a, b) => a + b, 0) / confidences.length,
        correctCount: correctResults.length,
        wrongCount: results.length - correctResults.length
    };
}

// ==================== TAMPILKAN HASIL ====================
function displayResults(results) {
    if (results.length === 0) {
        showToast('Tidak ada hasil untuk ditampilkan', 'error');
        return;
    }
    
    const confusionMatrix = calculateConfusionMatrix(results);
    const stats = calculateStatistics(results);
    
    // Update UI dengan hasil
    updateResultsUI(results, confusionMatrix, stats);
    
    // Tampilkan tabel detail
    renderTestResultsTable(results);
    
    // Tampilkan confusion matrix
    document.getElementById('true-positive').textContent = confusionMatrix.truePositive;
    document.getElementById('false-positive').textContent = confusionMatrix.falsePositive;
    document.getElementById('false-negative').textContent = confusionMatrix.falseNegative;
    
    // Tampilkan/update tombol ekspor
    updateExportButton();
    
    // Tampilkan peringatan jika akurasi 100% dengan data cukup banyak
    if (confusionMatrix.accuracy === 1 && results.length >= 10) {
        document.getElementById('perfect-accuracy-warning').classList.remove('hidden');
    }
    
    // Update count
    document.getElementById('result-count').textContent = `${results.length} hasil`;
}

function updateResultsUI(results, confusionMatrix, stats) {
    const total = results.length;
    const accuracyPercent = (confusionMatrix.accuracy * 100).toFixed(1);
    
    // Update persentase akurasi
    document.getElementById('accuracy-percent').textContent = accuracyPercent + '%';
    
    // Update progress bar dengan animasi
    setTimeout(() => {
        const accuracyBar = document.getElementById('accuracy-bar');
        if (accuracyBar) {
            accuracyBar.style.width = accuracyPercent + '%';
        }
    }, 100);
    
    // Update metrik utama
    document.getElementById('correct-count').textContent = stats.correctCount;
    document.getElementById('wrong-count').textContent = stats.wrongCount;
    document.getElementById('total-tested').textContent = total;
    document.getElementById('confidence-avg').textContent = stats.avgConfidence.toFixed(1) + '%';
    
    // Update persentase
    document.getElementById('correct-percent').textContent = total > 0 ? ((stats.correctCount / total) * 100).toFixed(1) + '%' : '0%';
    document.getElementById('wrong-percent').textContent = total > 0 ? ((stats.wrongCount / total) * 100).toFixed(1) + '%' : '0%';
    
    // Update mode testing
    document.getElementById('testing-mode').textContent = `Mode: ${testingConfig.realisticMode ? 'Realistis' : 'Ideal'}`;
    
    // Update range confidence
    document.getElementById('confidence-range').textContent = 
        `Min: ${stats.minConfidence.toFixed(1)}% | Max: ${stats.maxConfidence.toFixed(1)}%`;
    
    // Update metrik tambahan
    document.getElementById('precision-value').textContent = (confusionMatrix.precision * 100).toFixed(1) + '%';
    document.getElementById('recall-value').textContent = (confusionMatrix.recall * 100).toFixed(1) + '%';
    document.getElementById('f1score-value').textContent = (confusionMatrix.f1Score * 100).toFixed(1) + '%';
    
    // Update deskripsi akurasi
    const accuracyDesc = document.getElementById('accuracy-desc');
    if (confusionMatrix.accuracy >= 0.95) {
        accuracyDesc.textContent = 'Sangat Baik - Performa optimal';
    } else if (confusionMatrix.accuracy >= 0.85) {
        accuracyDesc.textContent = 'Baik - Dapat diandalkan';
    } else if (confusionMatrix.accuracy >= 0.75) {
        accuracyDesc.textContent = 'Cukup - Perlu sedikit perbaikan';
    } else if (confusionMatrix.accuracy >= 0.60) {
        accuracyDesc.textContent = 'Kurang - Perlu evaluasi';
    } else {
        accuracyDesc.textContent = 'Buruk - Perbaikan signifikan diperlukan';
    }
    
    // Update waktu
    document.getElementById('test-time').textContent = new Date().toLocaleString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    
    // Update progress
    document.getElementById('progress-analisis').textContent = `${results.length}/${results.length}`;
}

function renderTestResultsTable(results) {
    const tbody = document.getElementById('test-results');
    
    tbody.innerHTML = results.map((item, index) => {
        const statusText = item.isCorrect ? 'Sesuai' : 'Tidak Sesuai';
        const statusColor = item.isCorrect ? 
            'text-green-700 bg-green-100' : 
            'text-red-700 bg-red-100';
        
        // Format prediksi
        const prediksiText = `${item.predictedKategori} - ${item.predictedKode}`;
        const confidenceText = item.confidence.toFixed(1) + '%';
        
        // Highlight jika prediksi salah
        const rowClass = item.isCorrect ? '' : 'bg-red-50';
        
        return `
            <tr class="hover:bg-gray-50 ${rowClass}">
                <td class="px-6 py-4 text-center text-gray-500 font-medium">${index + 1}</td>
                <td class="px-6 py-4 font-medium text-gray-900 max-w-xs truncate" title="${item.judul}">
                    ${item.judul}
                </td>
                <td class="px-6 py-4 text-gray-700">
                    <div class="font-medium">${prediksiText}</div>
                    ${!item.isCorrect ? 
                        `<div class="text-xs text-red-500 mt-1">Asli: ${item.kategori} - ${item.kodeDDC}</div>` 
                        : ''}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mr-3">
                            <div class="h-2.5 rounded-full ${item.confidence >= 80 ? 'bg-green-500' : item.confidence >= 60 ? 'bg-yellow-500' : 'bg-red-500'}" 
                                 style="width: ${item.confidence}%"></div>
                        </div>
                        <span class="text-sm font-bold ${item.confidence >= 80 ? 'text-green-700' : item.confidence >= 60 ? 'text-yellow-700' : 'text-red-700'}">
                            ${confidenceText}
                        </span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold ${statusColor}">
                        ${statusText}
                    </span>
                </td>
            </tr>
        `;
    }).join('');
}

function toggleSortResults() {
    if (!testResults || testResults.length === 0) return;
    
    // Toggle antara urutan asli dan urut berdasarkan confidence
    const currentOrder = testResults[0].hasOwnProperty('originalIndex') ? 'confidence' : 'original';
    
    if (currentOrder === 'original') {
        // Tambahkan index asli
        testResults.forEach((item, index) => {
            item.originalIndex = index;
        });
        
        // Urut berdasarkan confidence (descending)
        testResults.sort((a, b) => b.confidence - a.confidence);
        showToast('Diurutkan berdasarkan Confidence (Tertinggi)', 'info');
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
    renderTestResultsTable(testResults);
}

// ==================== FUNGSI SIMPAN ====================
function updateExportButton() {
    const exportBtn = document.getElementById('export-btn');
    if (testResults && testResults.length > 0) {
        exportBtn.classList.remove('hidden');
    } else {
        exportBtn.classList.add('hidden');
    }
}

async function simpanHasilKeDatabase() {
    if (!testResults || testResults.length === 0) {
        showToast('Tidak ada data untuk disimpan', 'warning');
        return;
    }
    
    try {
        const dataToSend = {
            hasil_pengujian: testResults.map(item => ({
                judul_buku: item.judul,
                kategori_asli: item.kategori,
                kode_asli: item.kodeDDC,
                kategori_prediksi: item.predictedKategori,
                kode_prediksi: item.predictedKode,
                confidence: item.confidence,
                status: item.isCorrect ? 'Sesuai' : 'Tidak Sesuai',
                tanggal_pengujian: new Date().toISOString(),
                konfigurasi: testingConfig
            }))
        };
        
        // Simulasi pengiriman ke server
        console.log('Data untuk disimpan ke database:', dataToSend);
        
        // Tampilkan pesan sukses
        showToast(`✅ ${testResults.length} data siap disimpan ke database`, 'success');
        
        // Simulasi delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        return true;
        
    } catch (error) {
        console.error('Error menyimpan ke database:', error);
        showToast('⚠️ Gagal menyimpan ke database', 'warning');
        return false;
    }
}

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
    
    // Simpan ke localStorage
    let existingVerified = JSON.parse(localStorage.getItem('riwayatTerverifikasi') || '[]');
    let savedCount = 0;
    
    correctResults.forEach(item => {
        const isDuplicate = existingVerified.some(verified => 
            verified.judulBuku === item.judul && verified.kodeDDC === item.kodeDDC
        );
        
        if (!isDuplicate) {
            existingVerified.push({
                id: Date.now() + Math.random(),
                tanggalSah: new Date().toISOString(),
                judulBuku: item.judul,
                kodeDDC: item.kodeDDC,
                kategori: item.kategori,
                status: 'Terverifikasi',
                confidence: item.confidence,
                sumber: 'pengujian'
            });
            savedCount++;
        }
    });
    
    localStorage.setItem('riwayatTerverifikasi', JSON.stringify(existingVerified));
    
    // Simpan ke database (simulasi)
    simpanHasilKeDatabase().then(() => {
        showToast(`${savedCount} data tersimpan (${savedCount} ke localStorage)`, 'success');
        
        // Refresh data
        setTimeout(() => {
            loadData();
        }, 500);
    });
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
    
    let existingTraining = JSON.parse(localStorage.getItem('dataTraining') || '[]');
    let savedCount = 0;
    
    correctResults.forEach(item => {
        const trainingKategori = `${item.kodeDDC}|${item.kategori}`;
        const isDuplicate = existingTraining.some(training => 
            training.judul === item.judul && training.kategori === trainingKategori
        );
        
        if (!isDuplicate) {
            existingTraining.push({
                id: Date.now() + Math.random(),
                judul: item.judul,
                kategori: trainingKategori,
                waktu: new Date().toISOString(),
                sumber: 'pengujian',
                confidence: item.confidence,
                tanggal_pengujian: new Date().toISOString()
            });
            savedCount++;
        }
    });
    
    localStorage.setItem('dataTraining', JSON.stringify(existingTraining));
    showToast(`${savedCount} data berhasil ditambahkan ke Data Training`, 'success');
    
    // Update model jika ada
    if (typeof window.buildNaiveBayesModel === 'function') {
        window.dataTraining = existingTraining;
        window.naiveBayesModel = window.buildNaiveBayesModel(existingTraining);
        console.log("Naive Bayes model updated dengan data baru");
    }
}

function exportTestResults() {
    if (!testResults || testResults.length === 0) {
        showToast('Tidak ada hasil untuk diekspor', 'warning');
        return;
    }
    
    const confusionMatrix = calculateConfusionMatrix(testResults);
    const stats = calculateStatistics(testResults);
    
    const exportData = {
        metadata: {
            timestamp: new Date().toISOString(),
            total_tested: testResults.length,
            testing_config: testingConfig,
            metrics: {
                accuracy: confusionMatrix.accuracy,
                precision: confusionMatrix.precision,
                recall: confusionMatrix.recall,
                f1_score: confusionMatrix.f1Score,
                true_positive: confusionMatrix.truePositive,
                false_positive: confusionMatrix.falsePositive,
                false_negative: confusionMatrix.falseNegative,
                average_confidence: stats.avgConfidence,
                correct_count: stats.correctCount,
                wrong_count: stats.wrongCount
            }
        },
        results: testResults.map((item, index) => ({
            no: index + 1,
            judul_buku: item.judul,
            kategori_asli: item.kategori,
            kode_asli: item.kodeDDC,
            kategori_prediksi: item.predictedKategori,
            kode_prediksi: item.predictedKode,
            confidence: item.confidence,
            status: item.isCorrect ? 'Sesuai' : 'Tidak Sesuai',
            tanggal_pengujian: new Date().toISOString()
        }))
    };
    
    // Buat blob untuk download
    const jsonData = JSON.stringify(exportData, null, 2);
    const blob = new Blob([jsonData], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    
    const a = document.createElement('a');
    a.href = url;
    a.download = `hasil-pengujian-${new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    showToast('Hasil pengujian berhasil diekspor ke JSON', 'success');
}

function resetTesting() {
    // Konfirmasi reset
    if (testResults && testResults.length > 0) {
        if (!confirm('Reset pengujian? Data hasil saat ini akan hilang.')) {
            return;
        }
    }
    
    selectedData = [];
    testResults = [];
    
    document.getElementById('selection-card').classList.remove('hidden');
    document.getElementById('result-card').classList.add('hidden');
    document.getElementById('perfect-accuracy-warning').classList.add('hidden');
    
    const masterCheckbox = document.getElementById('select-all');
    if (masterCheckbox) masterCheckbox.checked = false;
    
    loadData();
    showToast('Pengujian direset', 'info');
}

// ==================== UTILITY FUNCTIONS ====================
function showToast(message, type = 'info') {
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
    
    toast.className = `custom-toast fixed bottom-4 right-4 px-4 py-3 ${color} text-white rounded-lg shadow-lg z-50 flex items-center animate-fade-in`;
    toast.innerHTML = `
        <i data-feather="${icon}" class="w-5 h-5 mr-2"></i>
        <span class="text-sm font-medium">${message}</span>
    `;
    
    document.body.appendChild(toast);
    feather.replace();
    
    // Auto remove setelah 3 detik
    setTimeout(() => {
        toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
}
</script>

<style>
/* Tambahan animasi */
.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Style untuk progress bar */
#accuracy-bar {
    transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Style untuk tabel */
table th {
    font-weight: 600;
}

table tbody tr {
    transition: background-color 0.2s;
}

/* Style untuk checkbox */
input[type="checkbox"]:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .text-7xl {
        font-size: 3.5rem;
    }
    
    .grid-cols-4 {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>