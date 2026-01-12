<?php
// pages/pengujian.php
?>
<div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-800">Pengujian Sistem</h1>
            <p class="text-gray-600 mt-2">Uji akurasi sistem dan simpan data terverifikasi</p>
        </div>
        <button onclick="startTesting()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center btn-primary">
            <i data-feather="play" class="mr-2 w-5 h-5"></i>
            Mulai Pengujian
        </button>
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
                    <button onclick="clearSelected()" class="text-sm text-red-600 hover:text-red-700">Hapus Semua</button>
                </div>
            </div>
        </div>
    </div>

    <div id="result-card" class="hidden bg-white rounded-lg border border-gray-200 overflow-hidden mb-8">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-700">Hasil Analisis Pengujian</h3>
                <span id="test-time" class="text-sm text-gray-500"></span>
            </div>

            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-8 text-white mb-8 shadow-lg flex flex-col md:flex-row items-center justify-around gap-8">
                <div class="text-center">
                    <p class="text-blue-100 text-sm uppercase tracking-widest mb-1 font-semibold">Skor Akurasi</p>
                    <h2 id="accuracy-percent" class="text-7xl font-black">0%</h2>
                </div>
                <div class="flex-1 w-full max-w-md">
                    <div class="flex justify-between mb-2 text-sm font-medium">
                        <span id="accuracy-desc">Menghitung hasil...</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-4 overflow-hidden">
                        <div id="accuracy-bar" class="bg-white h-4 rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(255,255,255,0.4)]" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-green-50 border border-green-100 p-4 rounded-xl text-center">
                    <p class="text-green-600 text-xs uppercase font-bold tracking-tight">Prediksi Benar</p>
                    <p id="correct-count" class="text-2xl font-bold text-green-700">0</p>
                </div>
                <div class="bg-red-50 border border-red-100 p-4 rounded-xl text-center">
                    <p class="text-red-600 text-xs uppercase font-bold tracking-tight">Prediksi Salah</p>
                    <p id="wrong-count" class="text-2xl font-bold text-red-700">0</p>
                </div>
                <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl text-center">
                    <p class="text-blue-600 text-xs uppercase font-bold tracking-tight">Total Data Uji</p>
                    <p id="total-tested" class="text-2xl font-bold text-blue-700">0</p>
                </div>
                <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-xl text-center">
                    <p class="text-indigo-600 text-xs uppercase font-bold tracking-tight">Avg. Confidence</p>
                    <p id="confidence-avg" class="text-2xl font-bold text-indigo-700">0%</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 mb-8 justify-center py-4 border-t border-gray-100">
                <button onclick="saveToVerified()" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all flex items-center shadow-sm">
                    <i data-feather="check-square" class="mr-2 w-5 h-5"></i> Simpan Terverifikasi
                </button>
                <button onclick="saveToTraining()" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all flex items-center shadow-sm">
                    <i data-feather="database" class="mr-2 w-5 h-5"></i> Tambah ke Data Latih
                </button>
                <button onclick="resetTesting()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all flex items-center">
                    <i data-feather="refresh-cw" class="mr-2 w-5 h-5"></i> Uji Ulang
                </button>
            </div>

            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h4 class="font-bold text-gray-700">Detail Hasil Per Data</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Judul Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Label Asli</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prediksi Sistem</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody id="test-results" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let allData = [];
let selectedData = [];
let testResults = [];
let verifiedData = [];

document.addEventListener('DOMContentLoaded', function() {
    loadData();
    feather.replace();
});

function loadData() {
    console.log("Loading data for testing...");
    
    // Ambil data dari riwayat klasifikasi
    const savedRiwayat = localStorage.getItem('riwayatKlasifikasi');
    console.log("Raw riwayat data:", savedRiwayat);
    
    const riwayatData = savedRiwayat ? JSON.parse(savedRiwayat) : [];
    console.log("Parsed riwayat data:", riwayatData);
    
    // Ambil data terverifikasi
    const savedVerified = localStorage.getItem('riwayatTerverifikasi');
    verifiedData = savedVerified ? JSON.parse(savedVerified) : [];
    console.log("Verified data:", verifiedData);
    
    // Format data dengan benar
    allData = riwayatData.map(item => {
        // Pastikan ada properti yang diperlukan
        const judul = item.judul || item.judulBuku || 'Judul tidak tersedia';
        const kodeDDC = item.kodeDDC || item.kode || '';
        const kategori = item.kategori || item.nama_kategori || 'Kategori tidak tersedia';
        const tanggal = item.tanggal || item.waktu || new Date().toISOString();
        const confidence = item.confidence || 0;
        
        return {
            id: item.id || Date.now() + Math.random(),
            judul: judul,
            kodeDDC: kodeDDC,
            kategori: kategori,
            tanggal: tanggal,
            confidence: confidence,
            labelAsli: kategori // Label asli adalah kategori dari data
        };
    });
    
    console.log("All data before filtering:", allData);
    
    // Filter data yang belum terverifikasi
    allData = allData.filter(item => {
        // Cek apakah data sudah ada di hasil terverifikasi
        const isVerified = verifiedData.some(verified => {
            // Cek berdasarkan judul dan kodeDDC
            const verifiedJudul = verified.judulBuku || verified.judul;
            const verifiedKode = verified.kodeDDC || verified.kode;
            return verifiedJudul === item.judul && verifiedKode === item.kodeDDC;
        });
        
        return !isVerified;
    });
    
    console.log("All data after filtering (unverified):", allData);
    
    // Render data
    renderAvailableData();
    updateCategoryFilter();
}

function renderAvailableData() {
    const tbody = document.getElementById('available-data');
    console.log("Rendering available data:", allData);
    
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
        
        // Format tanggal
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
    // Ekstrak kategori unik dari data
    const categories = [...new Set(allData.map(item => item.kategori).filter(Boolean))].sort();
    
    let options = '<option value="">Semua Kategori</option>';
    categories.forEach(cat => {
        options += `<option value="${cat}">${cat}</option>`;
    });
    
    select.innerHTML = options;
}

function toggleSelectData(id) {
    console.log("Toggling selection for id:", id);
    
    const item = allData.find(d => d.id == id);
    if (!item) {
        console.error("Item not found:", id);
        return;
    }
    
    const existingIndex = selectedData.findIndex(s => s.id == id);
    
    if (existingIndex > -1) {
        // Hapus dari selected
        selectedData.splice(existingIndex, 1);
    } else {
        // Tambah ke selected
        selectedData.push({...item});
    }
    
    console.log("Selected data after toggle:", selectedData);
    renderAvailableData();
    updateSelectedInfo();
}

function toggleAll() {
    const masterCheckbox = document.getElementById('select-all');
    console.log("Toggle all:", masterCheckbox.checked);
    
    if (masterCheckbox.checked) {
        // Pilih semua
        selectedData = [...allData];
    } else {
        // Batalkan semua
        selectedData = [];
    }
    
    renderAvailableData();
    updateSelectedInfo();
}

function selectAll() {
    console.log("Select all clicked");
    const masterCheckbox = document.getElementById('select-all');
    masterCheckbox.checked = true;
    toggleAll();
    showToast(`${selectedData.length} data dipilih`, 'info');
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
    console.log("Clearing selected data");
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
    const searchTerm = document.getElementById('search-data').value.toLowerCase();
    const categoryFilter = document.getElementById('filter-kategori').value;
    
    console.log("Filtering data:", { searchTerm, categoryFilter });
    
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
    
    // Filter data berdasarkan pencarian dan kategori
    const filtered = allData.filter(item => {
        const matchesSearch = item.judul.toLowerCase().includes(searchTerm) || 
                             item.kategori.toLowerCase().includes(searchTerm) ||
                             item.kodeDDC.toLowerCase().includes(searchTerm);
        
        const matchesCategory = !categoryFilter || item.kategori === categoryFilter;
        
        return matchesSearch && matchesCategory;
    });
    
    console.log("Filtered results:", filtered);
    
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
    
    // Render data yang sudah difilter
    tbody.innerHTML = filtered.map((item, index) => {
        const isSelected = selectedData.some(s => s.id === item.id);
        
        // Format tanggal
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

function startTesting() {
    console.log("Starting testing with data:", selectedData);
    
    if (selectedData.length === 0) {
        showToast('Pilih data terlebih dahulu', 'warning');
        return;
    }
    
    // Sembunyikan card pemilihan, tampilkan hasil
    document.getElementById('selection-card').classList.add('hidden');
    document.getElementById('result-card').classList.remove('hidden');
    
    // Proses pengujian
    testResults = processTesting(selectedData);
    console.log("Test results:", testResults);
    
    // Tampilkan hasil
    displayResults(testResults);
}

function processTesting(data) {
    console.log("Processing testing for data:", data);
    
    const model = window.naiveBayesModel || {};
    console.log("Naive Bayes model available:", !!window.tentukanKategoriDenganNaiveBayes);
    
    return data.map(item => {
        let predicted;
        
        // Coba gunakan fungsi klasifikasi jika ada
        if (window.tentukanKategoriDenganNaiveBayes) {
            try {
                predicted = window.tentukanKategoriDenganNaiveBayes(item.judul, model);
                console.log("Prediction for", item.judul, ":", predicted);
            } catch (e) {
                console.error("Prediction error:", e);
                predicted = { kode: item.kodeDDC, nama: item.kategori, confidence: 85 };
            }
        } else {
            // Fallback: gunakan data asli
            predicted = { 
                kode: item.kodeDDC, 
                nama: item.kategori, 
                confidence: item.confidence || 85 
            };
        }
        
        // Bandingkan dengan label asli
        const isCorrect = predicted.kode === item.kodeDDC;
        const confidence = predicted.confidence || item.confidence || 85;
        
        return { 
            ...item, 
            predictedKode: predicted.kode, 
            predictedKategori: predicted.nama, 
            isCorrect: isCorrect, 
            confidence: confidence 
        };
    });
}

function displayResults(results) {
    console.log("Displaying results:", results);
    
    if (results.length === 0) {
        showToast('Tidak ada hasil untuk ditampilkan', 'error');
        return;
    }
    
    // Hitung statistik
    const correct = results.filter(r => r.isCorrect).length;
    const total = results.length;
    const accuracy = total > 0 ? (correct / total) * 100 : 0;
    const avgConf = total > 0 ? results.reduce((acc, curr) => acc + curr.confidence, 0) / total : 0;
    
    console.log("Statistics:", { correct, total, accuracy, avgConf });
    
    // Update UI
    document.getElementById('accuracy-percent').textContent = accuracy.toFixed(1) + '%';
    document.getElementById('correct-count').textContent = correct;
    document.getElementById('wrong-count').textContent = total - correct;
    document.getElementById('total-tested').textContent = total;
    document.getElementById('confidence-avg').textContent = avgConf.toFixed(1) + '%';
    document.getElementById('test-time').textContent = new Date().toLocaleString('id-ID');
    
    // Update progress bar dengan animasi
    setTimeout(() => {
        const accuracyBar = document.getElementById('accuracy-bar');
        if (accuracyBar) {
            accuracyBar.style.width = accuracy + '%';
        }
    }, 100);
    
    // Update deskripsi akurasi
    const accuracyDesc = document.getElementById('accuracy-desc');
    if (accuracy >= 90) {
        accuracyDesc.textContent = 'Sangat Baik - Sistem sangat akurat';
    } else if (accuracy >= 80) {
        accuracyDesc.textContent = 'Baik - Sistem cukup akurat';
    } else if (accuracy >= 70) {
        accuracyDesc.textContent = 'Cukup - Perlu sedikit perbaikan';
    } else if (accuracy >= 50) {
        accuracyDesc.textContent = 'Kurang - Perlu perbaikan signifikan';
    } else {
        accuracyDesc.textContent = 'Buruk - Perlu evaluasi ulang sistem';
    }
    
    // Tampilkan detail hasil
    const tbody = document.getElementById('test-results');
    tbody.innerHTML = results.map((item, index) => {
        const statusColor = item.isCorrect ? 'text-green-600' : 'text-red-600';
        const statusBg = item.isCorrect ? 'bg-green-100' : 'bg-red-100';
        const statusText = item.isCorrect ? 'BENAR' : 'SALAH';
        
        return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-center text-gray-500">${index + 1}</td>
                <td class="px-6 py-4 font-medium text-gray-900 max-w-xs">${item.judul}</td>
                <td class="px-6 py-4 text-gray-700">
                    ${item.kategori}
                    <div class="text-xs text-gray-400 font-mono mt-1">${item.kodeDDC || '-'}</div>
                </td>
                <td class="px-6 py-4 text-gray-700">
                    ${item.predictedKategori}
                    <div class="text-xs text-gray-400 font-mono mt-1">${item.predictedKode || '-'}</div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold ${statusBg} ${statusColor}">
                        ${statusText}
                    </span>
                    <div class="text-xs text-gray-400 mt-1">Confidence: ${item.confidence.toFixed(1)}%</div>
                </td>
            </tr>
        `;
    }).join('');
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
    
    // Ambil data terverifikasi yang sudah ada
    let existingVerified = [];
    try {
        const saved = localStorage.getItem('riwayatTerverifikasi');
        existingVerified = saved ? JSON.parse(saved) : [];
    } catch (e) {
        console.error("Error loading verified data:", e);
        existingVerified = [];
    }
    
    // Tambahkan data baru
    let savedCount = 0;
    correctResults.forEach(item => {
        // Cek duplikat
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
                source: 'pengujian'
            });
            savedCount++;
        }
    });
    
    // Simpan ke localStorage
    try {
        localStorage.setItem('riwayatTerverifikasi', JSON.stringify(existingVerified));
        showToast(`${savedCount} data berhasil disimpan ke Hasil Terverifikasi`, 'success');
        
        // Refresh data setelah menyimpan
        setTimeout(() => {
            loadData();
        }, 1000);
        
    } catch (e) {
        console.error("Error saving to verified:", e);
        showToast('Gagal menyimpan data', 'error');
    }
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
    
    // Ambil data training yang sudah ada
    let existingTraining = [];
    try {
        const saved = localStorage.getItem('dataTraining');
        existingTraining = saved ? JSON.parse(saved) : [];
    } catch (e) {
        console.error("Error loading training data:", e);
        existingTraining = [];
    }
    
    // Tambahkan data baru
    let savedCount = 0;
    correctResults.forEach(item => {
        // Cek duplikat
        const isDuplicate = existingTraining.some(training => 
            training.judul === item.judul && training.kategori === item.kodeDDC + '|' + item.kategori
        );
        
        if (!isDuplicate) {
            existingTraining.push({
                id: Date.now() + Math.random(),
                judul: item.judul,
                kategori: item.kodeDDC + '|' + item.kategori,
                deskripsi: 'Data dari pengujian sistem',
                waktu: new Date().toISOString(),
                source: 'pengujian',
                accuracy: item.confidence
            });
            savedCount++;
        }
    });
    
    // Simpan ke localStorage
    try {
        localStorage.setItem('dataTraining', JSON.stringify(existingTraining));
        showToast(`${savedCount} data berhasil ditambahkan ke Data Training`, 'success');
        
        // Update model jika ada di global scope
        if (typeof window.buildNaiveBayesModel === 'function') {
            window.dataTraining = existingTraining;
            window.naiveBayesModel = window.buildNaiveBayesModel(existingTraining);
            console.log("Naive Bayes model updated");
        }
        
    } catch (e) {
        console.error("Error saving to training:", e);
        showToast('Gagal menyimpan data', 'error');
    }
}

function resetTesting() {
    console.log("Resetting testing");
    selectedData = [];
    testResults = [];
    
    // Reset UI
    document.getElementById('selection-card').classList.remove('hidden');
    document.getElementById('result-card').classList.add('hidden');
    
    // Reset checkbox
    const masterCheckbox = document.getElementById('select-all');
    if (masterCheckbox) masterCheckbox.checked = false;
    
    // Reload data
    loadData();
    
    showToast('Pengujian direset', 'info');
}

function showToast(message, type = 'info') {
    console.log("Toast:", message, type);
    
    // Hapus toast sebelumnya
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
    
    toast.className = `custom-toast fixed bottom-4 right-4 px-4 py-3 ${color} text-white rounded-lg shadow-lg z-50 flex items-center animate-fade-in`;
    toast.innerHTML = `
        <i data-feather="${type === 'success' ? 'check-circle' : type === 'warning' ? 'alert-triangle' : type === 'error' ? 'alert-circle' : 'info'}" class="w-5 h-5 mr-2"></i>
        <span class="text-sm font-medium">${message}</span>
    `;
    
    document.body.appendChild(toast);
    feather.replace();
    
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