<?php
// pages/hasil-terverifikasi.php
?>
<div id="page-hasil-terverifikasi" class="w-full px-4 py-6 font-sans">
    
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">Hasil Terverifikasi</h1>
        <p class="text-gray-600 text-base">Data riwayat klasifikasi yang telah divalidasi dan disahkan.</p>
    </div>

    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover flex items-center transition-all hover:shadow-md h-full">
            <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                <i data-feather="check-circle" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Data Valid</p>
                <p class="text-3xl font-extrabold text-gray-800" id="totalData">0</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover flex items-center transition-all hover:shadow-md h-full">
            <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                <i data-feather="bar-chart-2" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Rata-rata Confidence</p>
                <p class="text-3xl font-extrabold text-gray-800" id="avgConfidence">0%</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover flex items-center transition-all hover:shadow-md h-full">
            <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                <i data-feather="clock" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Terakhir Verifikasi</p>
                <p class="text-xl font-bold text-gray-800" id="lastUpdate">-</p>
            </div>
        </div>
    </div>

    <div class="mb-4 bg-white p-6 rounded-xl shadow-sm border border-gray-200 w-full">
        <div class="flex flex-col xl:flex-row gap-4 justify-between items-center w-full">
            
            <div class="flex flex-col lg:flex-row gap-3 w-full xl:w-auto flex-1">
                <div class="relative w-full lg:flex-1">
                    <i data-feather="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    <input type="text" id="searchInput" placeholder="Cari judul buku..." 
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition shadow-sm">
                </div>
                
                <div class="w-full lg:w-56">
                    <select id="filterCategory" onchange="resetPaginationAndRender()" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base bg-white focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm cursor-pointer">
                        <option value="">Semua Kategori</option>
                    </select>
                </div>

                <div class="w-full lg:w-48">
                    <select id="sortBy" onchange="resetPaginationAndRender()" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base bg-white focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm cursor-pointer">
                        <option value="newest">Urut: Terbaru</option>
                        <option value="oldest">Urut: Terlama</option>
                        <option value="conf_high">Confidence: Tinggi</option>
                        <option value="conf_low">Confidence: Rendah</option>
                    </select>
                </div>

                <div class="w-full lg:w-36">
                    <select id="rowsPerPage" onchange="resetPaginationAndRender()" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base bg-white focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm cursor-pointer">
                        <option value="10">10 Data</option>
                        <option value="25">25 Data</option>
                        <option value="50">50 Data</option>
                        <option value="100">100 Data</option>
                        <option value="-1">Semua</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2 w-full md:w-auto justify-end">
                <button onclick="exportExcel()" class="flex-1 md:flex-none bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg text-base font-bold shadow-md transition flex items-center justify-center gap-2">
                    <i data-feather="download" class="w-5 h-5"></i> <span class="hidden xl:inline">Export</span>
                </button>
                
                <button id="btnDeleteSelected" onclick="hapusDataTerpilih()" class="hidden bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 px-5 py-3 rounded-lg text-base font-bold transition items-center justify-center gap-2">
                    <i data-feather="trash-2" class="w-5 h-5"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden min-h-[400px] flex flex-col w-full">
        <div class="overflow-x-auto flex-1 w-full">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-5 text-center w-12">
                            <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer">
                        </th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider w-16 text-center">No</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider min-w-[250px]">Judul Buku</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider w-32">Kode DDC</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider w-64">Kategori</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider text-center w-32">
                            Confidence
                        </th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider text-center w-32">Status</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-verified" class="divide-y divide-gray-100 text-base">
                    </tbody>
            </table>
        </div>
        
        <div id="loading-state" class="hidden flex flex-col items-center justify-center py-20">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mb-4"></div>
            <p class="text-gray-500 font-medium">Memuat data...</p>
        </div>

        <div id="empty-state" class="hidden flex flex-col items-center justify-center py-20 text-center">
            <div class="bg-gray-50 rounded-full p-6 mb-4">
                <i data-feather="check-square" class="w-12 h-12 text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700">Tidak ada data</h3>
            <p class="text-gray-500 mt-2">Belum ada hasil verifikasi atau pencarian tidak ditemukan.</p>
        </div>
        
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4 text-base w-full">
            <div class="text-gray-600">
                Menampilkan <span id="startEntry" class="font-bold text-gray-900">0</span> - <span id="endEntry" class="font-bold text-gray-900">0</span> dari <span id="totalEntries" class="font-bold text-gray-900">0</span> data
            </div>
            <div class="flex items-center gap-2">
                <button onclick="prevPage()" id="btnPrev" class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition shadow-sm">
                    <i data-feather="chevron-left" class="w-5 h-5"></i>
                </button>
                <div id="paginationNumbers" class="flex gap-2 overflow-x-auto max-w-[250px]">
                    </div>
                <button onclick="nextPage()" id="btnNext" class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition shadow-sm">
                    <i data-feather="chevron-right" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
// ===============================
// KONFIGURASI API & STATE
// ===============================
const API_URL = 'php_backend/api/get_pengujian.php';

let verifiedData = [];
let currentPage = 1;
let rowsPerPage = 10;

// 1. INITIALIZATION
document.addEventListener('DOMContentLoaded', () => {
    if(typeof feather !== 'undefined') feather.replace();
    loadVerifiedData();
    let timeout = null;
    document.getElementById('searchInput').addEventListener('input', () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => { currentPage = 1; renderTable(); }, 300);
    });
});

// 2. LOAD DATA DARI SERVER
async function loadVerifiedData() {
    const tbody = document.getElementById('tabel-verified');
    const loading = document.getElementById('loading-state');
    const empty = document.getElementById('empty-state');

    tbody.innerHTML = '';
    loading.classList.remove('hidden');
    empty.classList.add('hidden');
    
    try {
        const response = await fetch(`${API_URL}?action=get_verified`);
        const json = await response.json();
        
        if (json.status === 'success') {
            verifiedData = json.data;
            populateFilterCategory();
            updateStatistics();
            renderTable();
        } else {
            verifiedData = [];
            renderTable();
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        verifiedData = [];
        renderTable();
    } finally {
        loading.classList.add('hidden');
    }
}

// 3. LOGIKA FILTER & SORTING
function getFilteredAndSortedData() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const filterCategory = document.getElementById('filterCategory').value;
    const sortBy = document.getElementById('sortBy').value;

    let filtered = verifiedData.filter(item => {
        const title = (item.judul_buku || item.judul || "").toLowerCase();
        const category = (item.kategori || "");
        
        const matchSearch = title.includes(searchTerm);
        const matchCategory = !filterCategory || category === filterCategory;
        return matchSearch && matchCategory;
    });

    filtered.sort((a, b) => {
        const dateA = new Date(a.created_at || a.tanggal || 0);
        const dateB = new Date(b.created_at || b.tanggal || 0);
        const confA = parseFloat(a.confidence || 0);
        const confB = parseFloat(b.confidence || 0);

        switch (sortBy) {
            case 'newest': return dateB - dateA;
            case 'oldest': return dateA - dateB;
            case 'conf_high': return confB - confA;
            case 'conf_low': return confA - confB;
            default: return dateB - dateA;
        }
    });

    return filtered;
}

// 4. RENDER TABLE
function renderTable() {
    const tbody = document.getElementById('tabel-verified');
    const emptyState = document.getElementById('empty-state');
    
    const filteredData = getFilteredAndSortedData();
    const totalItems = filteredData.length;

    const totalPages = Math.ceil(totalItems / rowsPerPage);
    if(currentPage > totalPages) currentPage = totalPages || 1;
    if(currentPage < 1) currentPage = 1;

    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = rowsPerPage === -1 ? totalItems : Math.min(startIndex + rowsPerPage, totalItems);
    const pageData = rowsPerPage === -1 ? filteredData : filteredData.slice(startIndex, endIndex);

    document.getElementById("startEntry").textContent = totalItems === 0 ? 0 : startIndex + 1;
    document.getElementById("endEntry").textContent = endIndex;
    document.getElementById("totalEntries").textContent = totalItems;
    
    updatePaginationButtons(totalPages);

    if (totalItems === 0) {
        tbody.innerHTML = '';
        emptyState.classList.remove('hidden');
        if(typeof feather !== 'undefined') feather.replace();
        return;
    } else {
        emptyState.classList.add('hidden');
    }

    let html = '';
    pageData.forEach((item, index) => {
        const realIndex = startIndex + index + 1;
        const dateObj = new Date(item.created_at || item.tanggal || Date.now());
        const dateStr = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        
        let confidence = parseFloat(item.confidence || 0);
        if(confidence <= 1 && confidence > 0) confidence *= 100;

        let confClass = 'bg-gray-100 text-gray-600';
        if(confidence >= 90) confClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
        else if(confidence >= 70) confClass = 'bg-blue-100 text-blue-800 border-blue-200';
        else confClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';

        html += `
            <tr class="hover:bg-blue-50/40 transition duration-200 border-b border-gray-100 last:border-0 fade-in">
                <td class="px-6 py-5 text-center">
                    <input type="checkbox" name="selectedItems" value="${item.id}" onclick="checkIfAnySelected()" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer">
                </td>
                <td class="px-6 py-5 text-gray-500 font-mono text-base text-center">${realIndex}</td>
                <td class="px-6 py-5">
                    <div class="font-bold text-gray-900 text-base leading-relaxed">${item.judul_buku || item.judul}</div>
                    <div class="text-sm text-gray-500 mt-1 flex items-center">
                        <i data-feather="calendar" class="w-4 h-4 mr-2 text-gray-400"></i> ${dateStr}
                    </div>
                </td>
                <td class="px-6 py-5">
                    <span class="font-mono text-base font-bold text-blue-700 bg-blue-50 px-3 py-1.5 rounded border border-blue-100">${item.kode_ddc}</span>
                </td>
                <td class="px-6 py-5 text-gray-700 text-base">
                    ${item.kategori}
                </td>
                <td class="px-6 py-5 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded font-bold text-sm border ${confClass}">
                        ${confidence.toFixed(1)}%
                    </span>
                </td>
                <td class="px-6 py-5 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i data-feather="check-circle" class="w-4 h-4 mr-1.5"></i> Valid
                    </span>
                </td>
                <td class="px-6 py-5 text-center">
                    <button onclick="hapusData(${item.id})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                        <i data-feather="trash-2" class="w-5 h-5"></i>
                    </button>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    checkIfAnySelected();
    if(typeof feather !== 'undefined') feather.replace();
}

function updatePaginationButtons(totalPages) {
    const btnPrev = document.getElementById("btnPrev");
    const btnNext = document.getElementById("btnNext");
    const container = document.getElementById("paginationNumbers");
    
    btnPrev.disabled = currentPage === 1;
    btnNext.disabled = currentPage === totalPages || totalPages === 0;
    
    let html = '';
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    if(endPage - startPage < 4) startPage = Math.max(1, endPage - 4);
    
    for(let i = startPage; i <= endPage; i++) {
        const activeClass = i === currentPage 
            ? "bg-blue-600 text-white border-blue-600 shadow-md" 
            : "bg-white text-gray-700 border-gray-300 hover:bg-gray-50";
        html += `<button onclick="goToPage(${i})" class="w-10 h-10 flex items-center justify-center rounded-lg border text-sm font-bold transition ${activeClass}">${i}</button>`;
    }
    container.innerHTML = html;
}

function prevPage() { if(currentPage > 1) { currentPage--; renderTable(); } }
function nextPage() { currentPage++; renderTable(); }
function goToPage(page) { currentPage = page; renderTable(); }
function resetPaginationAndRender() {
    currentPage = 1;
    rowsPerPage = parseInt(document.getElementById("rowsPerPage").value);
    renderTable();
}

// 6. UTILITIES
function populateFilterCategory() {
    const select = document.getElementById('filterCategory');
    const categories = [...new Set(verifiedData.map(d => d.kategori))].filter(Boolean).sort();
    const currentVal = select.value;
    select.innerHTML = '<option value="">Semua Kategori</option>';
    
    categories.forEach(cat => {
        const option = document.createElement('option');
        option.value = cat;
        option.textContent = cat;
        if(cat === currentVal) option.selected = true;
        select.appendChild(option);
    });
}

function updateStatistics() {
    if(verifiedData.length === 0) {
        document.getElementById('totalData').textContent = 0;
        document.getElementById('avgConfidence').textContent = '0%';
        document.getElementById('lastUpdate').textContent = '-';
        return;
    }

    document.getElementById('totalData').textContent = verifiedData.length;

    const totalConf = verifiedData.reduce((acc, curr) => {
        let val = parseFloat(curr.confidence || 0);
        if(val <= 1) val *= 100;
        return acc + val;
    }, 0);
    const avg = (totalConf / verifiedData.length).toFixed(1);
    document.getElementById('avgConfidence').textContent = avg + '%';

    const dates = verifiedData.map(d => new Date(d.created_at || d.tanggal));
    const maxDate = new Date(Math.max.apply(null, dates));
    if(!isNaN(maxDate)) {
        document.getElementById('lastUpdate').textContent = maxDate.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        });
    }
}

// 7. ACTIONS
function toggleSelectAll(source) {
    const checkboxes = document.getElementsByName('selectedItems');
    for(let i = 0; i < checkboxes.length; i++) { checkboxes[i].checked = source.checked; }
    checkIfAnySelected();
}

function checkIfAnySelected() {
    const checkboxes = document.getElementsByName('selectedItems');
    const selectedCount = Array.from(checkboxes).filter(c => c.checked).length;
    const btn = document.getElementById('btnDeleteSelected');
    if (selectedCount > 0) { btn.classList.remove('hidden'); btn.classList.add('flex'); } 
    else { btn.classList.add('hidden'); btn.classList.remove('flex'); }
}

function hapusData(id) {
    Swal.fire({
        title: 'Hapus Data?', text: "Data akan dihapus permanen.", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Ya, Hapus'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await fetch(`${API_URL}?action=delete_verified&id=${id}`);
                const json = await res.json();
                if (json.status === 'success') { Swal.fire('Terhapus!', 'Data dihapus.', 'success'); loadVerifiedData(); }
                else Swal.fire('Gagal', json.message, 'error');
            } catch (e) { Swal.fire('Error', 'Gagal koneksi.', 'error'); }
        }
    });
}

function hapusDataTerpilih() {
    const checkboxes = document.querySelectorAll('input[name="selectedItems"]:checked');
    if (checkboxes.length === 0) return;
    Swal.fire({ title: 'Hapus Terpilih?', text: `Hapus ${checkboxes.length} data?`, icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya' })
    .then(async (result) => {
        if (result.isConfirmed) {
            for (const cb of checkboxes) { await fetch(`${API_URL}?action=delete_verified&id=${cb.value}`); }
            Swal.fire('Selesai!', 'Data terpilih dihapus.', 'success'); loadVerifiedData();
        }
    });
}

function exportExcel() {
    if (verifiedData.length === 0) return Swal.fire('Info', 'Tidak ada data.', 'info');
    const exportData = verifiedData.map((item, idx) => ({
        'No': idx + 1, 'Tanggal': new Date(item.created_at).toLocaleDateString('id-ID'),
        'Judul Buku': item.judul_buku, 'Kode DDC': item.kode_ddc, 'Kategori': item.kategori,
        'Confidence': (item.confidence > 1 ? item.confidence : item.confidence * 100) + '%', 'Status': 'Valid'
    }));
    const ws = XLSX.utils.json_to_sheet(exportData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Hasil Terverifikasi");
    XLSX.writeFile(wb, `Hasil_Validasi_DDC_${new Date().toISOString().slice(0,10)}.xlsx`);
}
</script>