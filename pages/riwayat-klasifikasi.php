<?php
// Ambil data dari session atau inisialisasi array kosong
$riwayat_data = isset($_SESSION['riwayat_klasifikasi']) ? $_SESSION['riwayat_klasifikasi'] : [];
?>

<div id="page-riwayat-klasifikasi" class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Klasifikasi</h1>
        <p class="text-gray-600 text-base">Daftar riwayat judul buku yang telah diklasifikasikan.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                        <i data-feather="file-text" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Riwayat</p>
                        <p class="text-2xl font-bold text-gray-800" id="total-klasifikasi">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                        <i data-feather="book" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Kategori</p>
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
            <div class="flex flex-col md:flex-row md:items-center gap-4 flex-1">
                <div class="relative flex-1 md:max-w-md">
                    <i data-feather="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    <input type="text" id="search-riwayat" placeholder="Cari judul buku..." onkeyup="filterRiwayat()"
                           class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm w-full focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                
                <select id="filter-kategori" onchange="filterRiwayat()" class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none bg-white">
                    <option value="">Semua Kategori</option>
                </select>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <button onclick="exportRiwayat()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition flex items-center">
                    <i data-feather="download" class="mr-2 w-4 h-4"></i> Export Excel
                </button>
                <button onclick="hapusSemuaRiwayat()" class="bg-red-50 text-red-600 hover:bg-red-100 px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center border border-red-100">
                    <i data-feather="trash-2" class="mr-2 w-4 h-4"></i> Hapus Semua
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div id="loading-table" class="p-8 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="mt-2 text-gray-500 text-sm">Memuat data riwayat...</p>
        </div>
        
        <div id="empty-state" class="p-12 text-center hidden">
            <div class="bg-gray-50 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <i data-feather="clock" class="w-8 h-8 text-gray-400"></i>
            </div>
            <h3 class="text-gray-600 font-semibold text-lg">Belum ada riwayat</h3>
            <p class="text-gray-500 text-sm mb-4">Lakukan klasifikasi judul buku terlebih dahulu.</p>
        </div>
        
        <div class="overflow-x-auto hidden" id="table-container">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-4 text-center w-10 bg-gray-50">
                            <input type="checkbox" id="check-all" onclick="toggleAllCheckboxes(this)" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase w-16 text-center">No</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase w-48">Waktu</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Judul Buku</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase text-center w-32">Kode DDC</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-riwayat" class="divide-y divide-gray-100 text-sm"></tbody>
            </table>
        </div>
    </div>
</div>

<div id="detail-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-lg w-full mx-4 shadow-xl transform transition-all">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-800">Detail Hasil Klasifikasi</h3>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div id="detail-content" class="mt-2"></div>
        <div class="mt-6 text-right">
            <button onclick="closeDetailModal()" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium">Tutup</button>
        </div>
    </div>
</div>

<script>
// Variabel global
let riwayatData = [];
let filteredData = [];

document.addEventListener("DOMContentLoaded", function() {
    initData();
    loadRiwayat();
});

function initData() {
    const savedRiwayat = localStorage.getItem('riwayatKlasifikasi');
    const dataBaruDariPHP = <?php echo json_encode($riwayat_data); ?>;
    
    let existingRiwayat = savedRiwayat ? JSON.parse(savedRiwayat) : [];

    if (Array.isArray(dataBaruDariPHP) && dataBaruDariPHP.length > 0) {
        dataBaruDariPHP.forEach(newItem => {
            // Generate ID untuk keperluan delete
            if(!newItem.id) newItem.id = Date.now() + Math.random().toString(36).substr(2, 9);
            
            const isDuplicate = existingRiwayat.some(oldItem => 
                (oldItem.id && oldItem.id === newItem.id) || 
                (oldItem.judul === newItem.judul && oldItem.waktu === newItem.waktu)
            );
            
            if (!isDuplicate) {
                existingRiwayat.push(newItem);
            }
        });
        localStorage.setItem('riwayatKlasifikasi', JSON.stringify(existingRiwayat));
    }
    riwayatData = existingRiwayat;
}

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
            updateStatistics();
        } else {
            container.classList.remove('hidden');
            renderTable();
            updateStatistics();
            updateFilterOptions();
        }
        feather.replace();
    }, 300);
}

function renderTable() {
    const tbody = document.getElementById("tabel-riwayat");
    const searchVal = document.getElementById('search-riwayat').value.toLowerCase();
    const katVal = document.getElementById('filter-kategori').value;

    const displayData = filteredData.filter(d => {
        const matchJudul = d.judul ? d.judul.toLowerCase().includes(searchVal) : false;
        const matchKat = katVal ? d.kategori === katVal : true;
        return matchJudul && matchKat;
    });

    if (displayData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-gray-500">Data tidak ditemukan sesuai filter.</td></tr>`;
        return;
    }

    tbody.innerHTML = displayData.map((d, i) => {
        let displayWaktu = '-';
        if (d.waktu) {
            const dateObj = new Date(d.waktu);
            if (!isNaN(dateObj)) {
                displayWaktu = dateObj.toLocaleString('id-ID', {
                    day: 'numeric', month: 'short', year: 'numeric', 
                    hour: '2-digit', minute: '2-digit'
                });
            }
        }

        return `
            <tr class="hover:bg-blue-50 transition border-b border-gray-100 last:border-0 group">
                <td class="px-4 py-4 text-center">
                    <input type="checkbox" class="row-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                </td>
                <td class="px-6 py-4 text-center text-gray-500 font-mono text-sm">${i + 1}</td>
                <td class="px-6 py-4 text-gray-600 text-sm whitespace-nowrap">
                    <div class="flex items-center">
                        <i data-feather="clock" class="w-3 h-3 mr-2 text-gray-400"></i>
                        ${displayWaktu}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800 text-base leading-snug cursor-pointer hover:text-blue-600" onclick="showDetail('${d.id}')">
                        ${d.judul}
                    </p>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="bg-blue-100 text-blue-700 font-bold px-3 py-1.5 rounded-lg text-sm border border-blue-200 inline-block min-w-[60px]">
                        ${d.kode}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm px-3 py-1.5 rounded-full bg-purple-50 text-purple-700 border border-purple-100 font-medium">
                        ${d.kategori}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <button onclick="hapusRiwayatItem('${d.id}')" class="text-gray-400 hover:text-red-600 bg-transparent hover:bg-red-50 p-2 rounded-full transition duration-200" title="Hapus Item Ini">
                        <i data-feather="trash-2" class="w-5 h-5"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
    
    feather.replace();
}

// Fitur Checkbox (Hanya visual select all)
function toggleAllCheckboxes(master) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = master.checked);
}

function hapusRiwayatItem(id) {
    // 1. Konfirmasi
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;
    
    // 2. Hapus data dari array (filter out)
    const initialLength = riwayatData.length;
    riwayatData = riwayatData.filter(d => String(d.id) !== String(id));
    
    // 3. Simpan ke LocalStorage
    localStorage.setItem('riwayatKlasifikasi', JSON.stringify(riwayatData));
    
    // 4. Reload Tabel
    loadRiwayat();
    
    // 5. Feedback User
    if(riwayatData.length < initialLength) {
        showToast('Data berhasil dihapus', 'success');
    } else {
        showToast('Gagal menghapus data', 'warning');
    }
}

function updateStatistics() {
    const total = riwayatData.length;
    const categories = [...new Set(riwayatData.map(d => d.kategori))].filter(Boolean).length;
    const today = new Date().toDateString();
    const todayCount = riwayatData.filter(d => {
        const dDate = new Date(d.waktu);
        return !isNaN(dDate) && dDate.toDateString() === today;
    }).length;

    document.getElementById('total-klasifikasi').textContent = total;
    document.getElementById('total-kategori').textContent = categories;
    document.getElementById('total-hari-ini').textContent = todayCount;
}

function filterRiwayat() { renderTable(); }

function updateFilterOptions() {
    const select = document.getElementById('filter-kategori');
    const currentVal = select.value;
    const categories = [...new Set(riwayatData.map(d => d.kategori))].filter(Boolean).sort();
    select.innerHTML = '<option value="">Semua Kategori</option>' + 
        categories.map(cat => `<option value="${cat}" ${cat === currentVal ? 'selected' : ''}>${cat}</option>`).join('');
}

function hapusSemuaRiwayat() {
    if (riwayatData.length === 0) return;
    if (!confirm('Hapus SELURUH riwayat? Data tidak bisa dikembalikan.')) return;
    riwayatData = [];
    localStorage.setItem('riwayatKlasifikasi', JSON.stringify([]));
    loadRiwayat();
    showToast('Seluruh riwayat berhasil dihapus', 'success');
}

function exportRiwayat() {
    if (riwayatData.length === 0) return showToast('Tidak ada data', 'warning');
    let csv = 'No,Waktu,Judul Buku,Kode DDC,Kategori\n';
    const dataToExport = [...riwayatData].sort((a, b) => new Date(b.waktu) - new Date(a.waktu));
    dataToExport.forEach((d, index) => { 
        const cleanJudul = d.judul ? d.judul.replace(/"/g, '""') : "";
        const waktu = d.waktu ? new Date(d.waktu).toLocaleString('id-ID') : '-';
        csv += `${index+1},"${waktu}","${cleanJudul}",${d.kode},"${d.kategori}"\n`; 
    });
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('href', url);
    a.setAttribute('download', `Riwayat_Klasifikasi_${Date.now()}.csv`);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    showToast('Berhasil download Excel', 'success');
}

function showDetail(id) {
    const data = riwayatData.find(d => String(d.id) === String(id));
    if (!data) return;
    const waktu = data.waktu ? new Date(data.waktu).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' }) : '-';
    document.getElementById('detail-content').innerHTML = `
        <div class="space-y-6">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Judul Buku</label>
                <p class="font-serif text-xl text-gray-800 mt-1 leading-relaxed">${data.judul}</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Kode DDC</label>
                    <div class="mt-1 flex items-center"><span class="text-2xl font-bold text-blue-600">${data.kode}</span></div>
                </div>
                 <div>
                    <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Kategori</label>
                    <p class="font-medium text-gray-800 mt-1 bg-purple-50 text-purple-700 inline-block px-3 py-1 rounded-lg border border-purple-100">${data.kategori}</p>
                </div>
            </div>
            <div class="border-t pt-4">
                <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Waktu Klasifikasi</label>
                <div class="flex items-center mt-1 text-gray-700"><i data-feather="calendar" class="w-4 h-4 mr-2"></i>${waktu}</div>
            </div>
        </div>
    `;
    document.getElementById('detail-modal').classList.remove('hidden');
    document.getElementById('detail-modal').classList.add('flex');
    feather.replace();
}

function closeDetailModal() { 
    document.getElementById('detail-modal').classList.add('hidden');
    document.getElementById('detail-modal').classList.remove('flex');
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const color = type === 'success' ? 'bg-emerald-600' : (type === 'warning' ? 'bg-yellow-600' : 'bg-red-600');
    toast.className = `fixed bottom-6 right-6 px-6 py-4 ${color} text-white rounded-xl shadow-2xl z-[100] transition-all flex items-center text-sm font-medium`;
    toast.innerHTML = `<i data-feather="${type === 'success' ? 'check-circle' : 'info'}" class="w-5 h-5 mr-3"></i> ${message}`;
    document.body.appendChild(toast);
    feather.replace();
    setTimeout(() => { toast.remove(); }, 3000);
}
</script>