<?php
// Ambil data dari session atau inisialisasi array kosong
$riwayat_data = isset($_SESSION['riwayat_klasifikasi']) ? $_SESSION['riwayat_klasifikasi'] : [];
$data_training = isset($_SESSION['data_training']) ? $_SESSION['data_training'] : [];
?>

<div id="page-riwayat-klasifikasi" class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Klasifikasi</h1>
        <p class="text-gray-600">Riwayat klasifikasi judul buku yang telah dilakukan</p>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                        <i data-feather="file-text" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="text-2xl font-bold text-gray-800" id="total-klasifikasi">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                        <i data-feather="check-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tersimpan</p>
                        <p class="text-2xl font-bold text-gray-800" id="total-tersimpan">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                        <i data-feather="book" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <p class="text-2xl font-bold text-gray-800" id="total-kategori">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600 mr-4">
                        <i data-feather="calendar" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800" id="total-hari-ini">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="relative">
                    <i data-feather="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="text" id="search-riwayat" placeholder="Cari judul..." onkeyup="filterRiwayat()"
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-full md:w-64 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                
                <select id="filter-kategori" onchange="filterRiwayat()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm outline-none">
                    <option value="">Semua Kategori</option>
                </select>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <button onclick="simpanTerpilih()" id="btn-simpan-terpilih" class="hidden bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center border border-indigo-200">
                    <i data-feather="save" class="mr-2 w-4 h-4"></i> Simpan Terpilih (<span id="count-terpilih">0</span>)
                </button>
                <!-- PERUBAHAN DI SINI: tombol mengarah ke menu pengujian -->
                <button onclick="keMenuPengujian()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition flex items-center">
                    <i data-feather="copy" class="mr-2 w-4 h-4"></i> Simpan Semua
                </button>
                <button onclick="exportRiwayat()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition flex items-center">
                    <i data-feather="download" class="mr-2 w-4 h-4"></i> Export Excel
                </button>
                <button onclick="hapusSemuaRiwayat()" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center border border-red-100">
                    <i data-feather="trash-2" class="mr-2 w-4 h-4"></i> Hapus Semua
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div id="loading-table" class="p-8 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="mt-2 text-gray-500 text-sm">Memuat data...</p>
        </div>
        
        <div id="empty-state" class="p-12 text-center hidden">
            <i data-feather="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
            <h3 class="text-gray-500 font-medium">Belum ada data klasifikasi</h3>
            <p class="text-gray-400 text-sm mb-4">Silakan lakukan klasifikasi terlebih dahulu.</p>
        </div>
        
        <div class="overflow-x-auto hidden" id="table-container">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-4 text-center w-10">
                            <input type="checkbox" id="check-all" onclick="toggleAllCheckboxes(this)" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase w-12 text-center">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Waktu</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Judul Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Kode DDC</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-riwayat" class="divide-y divide-gray-100 text-sm"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Variabel global
let riwayatData = [];
let trainingData = [];
let filteredData = [];

// Fungsi untuk navigasi ke menu pengujian - TAMBAHAN BARU
function keMenuPengujian() {
    // Redirect ke halaman pengujian atau tampilkan halaman pengujian
    // Sesuaikan dengan struktur aplikasi Anda
    window.location.href = 'index.php?page=pengujian';
    // Atau jika menggunakan SPA:
    // showPage('page-pengujian');
}

document.addEventListener("DOMContentLoaded", function() {
    initData();
    loadRiwayat();
});

function initData() {
    // 1. Ambil data lama dari localStorage
    const savedRiwayat = localStorage.getItem('riwayatKlasifikasi');
    const savedTraining = localStorage.getItem('dataTraining');
    
    // 2. Ambil data baru yang baru saja diklasifikasikan (dari PHP)
    const dataBaruDariPHP = <?php echo json_encode($riwayat_data); ?>;
    
    // 3. Inisialisasi riwayatData
    let existingRiwayat = savedRiwayat ? JSON.parse(savedRiwayat) : [];

    // 4. LOGIKA PENTING: Gabungkan data baru ke data lama jika belum ada (berdasarkan ID atau Judul)
    if (Array.isArray(dataBaruDariPHP)) {
        dataBaruDariPHP.forEach(newItem => {
            // Cek apakah item ini sudah ada di riwayat lokal agar tidak duplikat
            const isDuplicate = existingRiwayat.some(oldItem => oldItem.id === newItem.id);
            if (!isDuplicate) {
                existingRiwayat.push(newItem);
            }
        });
    }

    // 5. Simpan kembali ke variabel global dan localStorage
    riwayatData = existingRiwayat;
    trainingData = savedTraining ? JSON.parse(savedTraining) : <?php echo json_encode($data_training); ?>;
    
    localStorage.setItem('riwayatKlasifikasi', JSON.stringify(riwayatData));
    if (!savedTraining) localStorage.setItem('dataTraining', JSON.stringify(trainingData));
}

// Fungsi loadRiwayat
function loadRiwayat() {
    const loading = document.getElementById("loading-table");
    const empty = document.getElementById("empty-state");
    const container = document.getElementById("table-container");
    loading.classList.remove('hidden');
    container.classList.add('hidden');
    empty.classList.add('hidden');

    setTimeout(() => {
        filteredData = [...riwayatData].sort((a, b) => new Date(b.waktu) - new Date(a.waktu));
        loading.classList.add('hidden');
        if (filteredData.length === 0) {
            empty.classList.remove('hidden');
        } else {
            container.classList.remove('hidden');
            renderTable();
            updateStatistics();
            updateFilterOptions();
        }
        feather.replace();
    }, 300);
}

// UPDATE: renderTable ditambahkan checkbox
function renderTable() {
    const tbody = document.getElementById("tabel-riwayat");
    const searchVal = document.getElementById('search-riwayat').value.toLowerCase();
    const katVal = document.getElementById('filter-kategori').value;

    const displayData = filteredData.filter(d => {
        return d.judul.toLowerCase().includes(searchVal) && (!katVal || d.kategori === katVal);
    });

    tbody.innerHTML = displayData.map((d, i) => {
        const isSaved = trainingData.some(t => t.judul === d.judul && t.kategori === d.kode);
        const formatWaktu = d.waktu ? new Date(d.waktu).toLocaleString('id-ID', {
            day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
        }) : '-';

        return `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-4 text-center">
                    <input type="checkbox" value="${d.id}" onchange="updateBatchUI()" class="row-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" ${isSaved ? 'disabled' : ''}>
                </td>
                <td class="px-6 py-4 text-center text-gray-400 font-mono">${i + 1}</td>
                <td class="px-6 py-4 text-xs text-gray-500">${formatWaktu}</td>
                <td class="px-6 py-4 font-medium text-gray-800">
                    <a href="javascript:void(0)" onclick="showDetail('${d.id}')" class="hover:text-blue-600">${d.judul}</a>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="bg-blue-50 text-blue-700 font-bold px-2 py-1 rounded border border-blue-100">${d.kode}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full bg-purple-100 text-purple-700">${d.kategori}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2 justify-center items-center">
                        ${isSaved ? `
                            <span class="flex items-center text-emerald-600 font-bold text-xs bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100">
                                <i data-feather="check" class="w-3 h-3 mr-1"></i> Tersimpan
                            </span>
                        ` : `
                            <button onclick="simpanPerJudul('${d.id}')" class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-indigo-700 transition flex items-center">
                                <i data-feather="save" class="w-3 h-3 mr-1"></i> Simpan
                            </button>
                        `}
                        <button onclick="hapusRiwayatItem('${d.id}')" class="text-red-400 hover:text-red-600 p-1">
                            <i data-feather="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
    feather.replace();
    updateBatchUI();
}

// BARU: Fungsi untuk Toggle Semua Checkbox
function toggleAllCheckboxes(master) {
    const checkboxes = document.querySelectorAll('.row-checkbox:not(:disabled)');
    checkboxes.forEach(cb => cb.checked = master.checked);
    updateBatchUI();
}

// BARU: Fungsi Update UI Tombol Batch
function updateBatchUI() {
    const checked = document.querySelectorAll('.row-checkbox:checked').length;
    const btn = document.getElementById('btn-simpan-terpilih');
    const countSpan = document.getElementById('count-terpilih');
    
    if(checked > 0) {
        btn.classList.remove('hidden');
        countSpan.innerText = checked;
    } else {
        btn.classList.add('hidden');
    }
}

// BARU: Simpan Data Terpilih
function simpanTerpilih() {
    const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
    if(selectedIds.length === 0) return;

    let count = 0;
    selectedIds.forEach(id => {
        const item = riwayatData.find(d => d.id == id);
        if (item && !trainingData.some(t => t.judul === item.judul && t.kategori === item.kode)) {
            trainingData.push({
                id: Date.now() + Math.random(),
                judul: item.judul,
                kategori: item.kode,
                nama_kategori: item.kategori,
                waktu: new Date().toISOString()
            });
            count++;
        }
    });

    localStorage.setItem('dataTraining', JSON.stringify(trainingData));
    showToast(`${count} data berhasil disimpan ke training`, 'success');
    renderTable();
    updateStatistics();
    document.getElementById('check-all').checked = false;
}

// Fungsi pendukung lainnya
function simpanPerJudul(id) {
    const item = riwayatData.find(d => d.id == id);
    if (!item) return;
    trainingData.push({
        id: Date.now(),
        judul: item.judul,
        kategori: item.kode,
        nama_kategori: item.kategori,
        waktu: new Date().toISOString()
    });
    localStorage.setItem('dataTraining', JSON.stringify(trainingData));
    showToast('Berhasil disimpan ke data training', 'success');
    renderTable();
    updateStatistics();
}

function updateStatistics() {
    const total = riwayatData.length;
    const saved = riwayatData.filter(d => trainingData.some(t => t.judul === d.judul && t.kategori === d.kode)).length;
    const categories = [...new Set(riwayatData.map(d => d.kategori))].length;
    const today = new Date().toDateString();
    const todayCount = riwayatData.filter(d => new Date(d.waktu).toDateString() === today).length;
    document.getElementById('total-klasifikasi').textContent = total;
    document.getElementById('total-tersimpan').textContent = saved;
    document.getElementById('total-kategori').textContent = categories;
    document.getElementById('total-hari-ini').textContent = todayCount;
}

function filterRiwayat() { renderTable(); }
function updateFilterOptions() {
    const select = document.getElementById('filter-kategori');
    const categories = [...new Set(riwayatData.map(d => d.kategori))].sort();
    select.innerHTML = '<option value="">Semua Kategori</option>' + 
        categories.map(cat => `<option value="${cat}">${cat}</option>`).join('');
}
function hapusRiwayatItem(id) {
    if (!confirm('Hapus data ini dari riwayat?')) return;
    riwayatData = riwayatData.filter(d => d.id != id);
    localStorage.setItem('riwayatKlasifikasi', JSON.stringify(riwayatData));
    loadRiwayat();
}
function hapusSemuaRiwayat() {
    if (!confirm('Hapus seluruh riwayat klasifikasi?')) return;
    riwayatData = [];
    localStorage.setItem('riwayatKlasifikasi', JSON.stringify([]));
    loadRiwayat();
}
function exportRiwayat() {
    if (riwayatData.length === 0) return showToast('Tidak ada data', 'warning');
    let csv = 'Waktu,Judul,Kode,Kategori\n';
    riwayatData.forEach(d => { csv += `${d.waktu},"${d.judul}",${d.kode},${d.kategori}\n`; });
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('href', url);
    a.setAttribute('download', `riwayat-${Date.now()}.csv`);
    a.click();
    showToast('Berhasil mendownload laporan', 'success');
}
function showDetail(id) {
    const data = riwayatData.find(d => d.id == id);
    if (!data) return;
    document.getElementById('detail-content').innerHTML = `
        <div class="space-y-4">
            <div><label class="text-xs text-gray-400 uppercase">Judul Buku</label><p class="font-bold">${data.judul}</p></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="text-xs text-gray-400 uppercase">Kode DDC</label><p class="text-blue-600 font-bold">${data.kode}</p></div>
                <div><label class="text-xs text-gray-400 uppercase">Kategori</label><p class="font-medium">${data.kategori}</p></div>
            </div>
            <div><label class="text-xs text-gray-400 uppercase">Waktu Klasifikasi</label><p>${new Date(data.waktu).toLocaleString('id-ID')}</p></div>
        </div>
    `;
    document.getElementById('detail-modal').classList.remove('hidden');
    feather.replace();
}
function closeDetailModal() { document.getElementById('detail-modal').classList.add('hidden'); }
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const color = type === 'success' ? 'bg-emerald-600' : 'bg-red-600';
    toast.className = `fixed bottom-6 right-6 px-5 py-3 ${color} text-white rounded-xl shadow-2xl z-[100] transition-all flex items-center text-sm font-medium`;
    toast.innerHTML = `<i data-feather="info" class="w-4 h-4 mr-2"></i> ${message}`;
    document.body.appendChild(toast);
    feather.replace();
    setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 500); }, 3000);
}
</script>