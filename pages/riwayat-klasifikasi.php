<div id="page-riwayat-klasifikasi" class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Klasifikasi</h1>
        <p class="text-gray-600 text-base">Daftar riwayat judul buku yang tersimpan di database.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
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
        <div class="flex flex-col xl:flex-row justify-between gap-4">
            
            <div class="flex flex-col md:flex-row gap-3 flex-1">
                <div class="relative flex-1">
                    <i data-feather="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="text" id="search-riwayat" placeholder="Cari judul buku..." oninput="resetPageAndRender()"
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-full focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                
                <div class="w-full md:w-48">
                    <select id="filter-kategori" onchange="resetPageAndRender()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">Semua Kategori</option>
                    </select>
                </div>

                <div class="w-full md:w-40">
                    <select id="rowsPerPage" onchange="resetPageAndRender()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-blue-500 transition">
                        <option value="10">Tampil 10</option>
                        <option value="25">Tampil 25</option>
                        <option value="50">Tampil 50</option>
                        <option value="100">Tampil 100</option>
                        <option value="-1">Semua Data</option>
                    </select>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2 justify-end">
                <button onclick="exportRiwayat()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition flex items-center transform hover:-translate-y-0.5">
                    <i data-feather="download" class="mr-2 w-4 h-4"></i> Excel
                </button>
                <button onclick="hapusSemuaRiwayat()" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center border border-red-100 transform hover:-translate-y-0.5">
                    <i data-feather="trash-2" class="mr-2 w-4 h-4"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden min-h-[400px] flex flex-col">
        <div id="loading-table" class="hidden absolute inset-0 bg-white/80 z-10 flex flex-col items-center justify-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-100 border-t-blue-600"></div>
            <p class="mt-3 text-gray-500 text-sm font-medium">Mengambil data...</p>
        </div>
        
        <div id="empty-state" class="hidden flex flex-col items-center justify-center py-20 text-center flex-1">
            <div class="bg-gray-50 rounded-full p-6 mb-4">
                <i data-feather="database" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h3 class="text-gray-800 font-semibold text-lg mb-1">Data Tidak Ditemukan</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">Coba ubah kata kunci pencarian atau filter kategori.</p>
        </div>
        
        <div class="overflow-x-auto flex-1" id="table-container">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4 w-40 cursor-pointer hover:text-blue-600" onclick="changeSort('waktu')">
                            Waktu <i data-feather="chevron-down" class="inline w-3 h-3 ml-1"></i>
                        </th>
                        <th class="px-6 py-4 cursor-pointer hover:text-blue-600" onclick="changeSort('judul')">
                            Judul Buku <i data-feather="chevron-down" class="inline w-3 h-3 ml-1"></i>
                        </th>
                        <th class="px-6 py-4 w-48">Kategori Hasil</th>
                        <th class="px-6 py-4 w-32 text-center cursor-pointer hover:text-blue-600" onclick="changeSort('conf')">
                            Conf. <i data-feather="chevron-down" class="inline w-3 h-3 ml-1"></i>
                        </th>
                        <th class="px-6 py-4 w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-riwayat" class="divide-y divide-gray-100 text-sm bg-white">
                    </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4 text-sm">
            <div class="text-gray-600">
                Menampilkan <span id="startEntry" class="font-bold text-gray-900">0</span> - <span id="endEntry" class="font-bold text-gray-900">0</span> dari <span id="totalEntries" class="font-bold text-gray-900">0</span> data
            </div>
            
            <div class="flex items-center gap-2">
                <button onclick="prevPage()" id="btnPrev" class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-feather="chevron-left" class="w-4 h-4"></i>
                </button>
                <div id="paginationNumbers" class="flex gap-1 overflow-x-auto max-w-[200px] md:max-w-none">
                    </div>
                <button onclick="nextPage()" id="btnNext" class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-feather="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ==========================================
// CONFIG & STATE
// ==========================================
const API_HISTORY = 'php_backend/api/get_riwayat.php'; 

let riwayatData = [];     // Semua data mentah dari DB
let filteredData = [];    // Data setelah difilter Search/Kategori
let currentSort = 'waktu'; // Default sorting

// Pagination State
let currentPage = 1;
let rowsPerPage = 10;

// Init
document.addEventListener("DOMContentLoaded", function() {
    if(typeof feather !== 'undefined') feather.replace();
    loadRiwayatFromDB();
});

// 1. LOAD DATA DARI SERVER
async function loadRiwayatFromDB() {
    const loading = document.getElementById("loading-table");
    const container = document.getElementById("table-container");
    
    loading.classList.remove('hidden');
    container.classList.add('opacity-50');
    
    try {
        const response = await fetch(API_HISTORY + '?action=list');
        const res = await response.json();
        
        if(res.status === 'success') {
            riwayatData = res.data.map(item => ({
                id: item.id,
                judul: item.judul_buku,
                kategori: item.kategori_hasil,
                confidence: parseFloat(item.confidence || 0),
                waktu: item.waktu
            }));
            
            // Urutkan default (Terbaru)
            riwayatData.sort((a, b) => new Date(b.waktu) - new Date(a.waktu));
            
            // Isi dropdown filter
            populateFilterOptions();
            
            // Tampilkan
            resetPageAndRender();
            updateStatistics();
        } else {
            riwayatData = [];
            resetPageAndRender();
        }
    } catch (error) {
        console.error("Gagal koneksi:", error);
        riwayatData = [];
        resetPageAndRender();
    } finally {
        loading.classList.add('hidden');
        container.classList.remove('opacity-50');
    }
}

// 2. LOGIKA FILTER & SORTING
function applyFilterAndSort() {
    const search = document.getElementById('search-riwayat').value.toLowerCase();
    const catFilter = document.getElementById('filter-kategori').value;
    
    // Filter
    filteredData = riwayatData.filter(item => {
        const judul = (item.judul || "").toLowerCase();
        const kat = (item.kategori || "");
        return judul.includes(search) && (catFilter === "" || kat === catFilter);
    });

    // Sorting
    filteredData.sort((a, b) => {
        if (currentSort === 'waktu') return new Date(b.waktu) - new Date(a.waktu);
        if (currentSort === 'judul') return a.judul.localeCompare(b.judul);
        if (currentSort === 'conf') return b.confidence - a.confidence;
        return 0;
    });
}

// 3. RENDER TABEL (DENGAN PAGINATION)
function renderTable() {
    const tbody = document.getElementById("tabel-riwayat");
    tbody.innerHTML = '';

    applyFilterAndSort(); // Update filteredData

    const totalItems = filteredData.length;
    
    // Update Stats Footer
    document.getElementById("totalEntries").textContent = totalItems;

    if (totalItems === 0) {
        document.getElementById("empty-state").classList.remove("hidden");
        document.getElementById("table-container").classList.add("hidden");
        updatePaginationUI(0, 0, 0);
        return;
    } else {
        document.getElementById("empty-state").classList.add("hidden");
        document.getElementById("table-container").classList.remove("hidden");
    }

    // Pagination Logic
    rowsPerPage = parseInt(document.getElementById("rowsPerPage").value);
    const totalPages = rowsPerPage === -1 ? 1 : Math.ceil(totalItems / rowsPerPage);
    
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const startIndex = (currentPage - 1) * (rowsPerPage === -1 ? totalItems : rowsPerPage);
    const endIndex = rowsPerPage === -1 ? totalItems : Math.min(startIndex + rowsPerPage, totalItems);
    
    // Update Info "Menampilkan X-Y"
    document.getElementById("startEntry").textContent = startIndex + 1;
    document.getElementById("endEntry").textContent = endIndex;
    
    // Update Tombol Pagination
    updatePaginationUI(totalPages);

    // Slice Data (Potong data sesuai halaman)
    const pageData = filteredData.slice(startIndex, endIndex);

    // Render Rows
    pageData.forEach((item, index) => {
        // Index global untuk nomor urut
        const realNo = startIndex + index + 1;
        
        // Format Waktu
        let displayWaktu = item.waktu;
        try {
            const d = new Date(item.waktu);
            displayWaktu = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }) + 
                          ' <span class="text-gray-300">|</span> ' + 
                          d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        } catch(e) {}

        // Format Badge
        let conf = item.confidence <= 1 ? item.confidence * 100 : item.confidence;
        let badgeColor = 'bg-gray-100 text-gray-600';
        if (conf >= 80) badgeColor = 'bg-green-50 text-green-700 border-green-200 border';
        else if (conf >= 60) badgeColor = 'bg-blue-50 text-blue-700 border-blue-200 border';
        else badgeColor = 'bg-yellow-50 text-yellow-700 border-yellow-200 border';

        // Format Kategori
        let kodeDDC = '-', namaKat = item.kategori;
        if(item.kategori && item.kategori.includes('-')) {
             const parts = item.kategori.split('-');
             kodeDDC = parts[0].trim();
        }

        const tr = document.createElement('tr');
        tr.className = "hover:bg-blue-50/30 transition duration-150 border-b border-gray-50 last:border-0 fade-in";
        tr.innerHTML = `
            <td class="px-6 py-4 text-center text-gray-400 font-mono text-xs">${realNo}</td>
            <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">${displayWaktu}</td>
            <td class="px-6 py-4">
                <div class="font-medium text-gray-800 text-sm leading-snug line-clamp-2" title="${item.judul}">${item.judul}</div>
            </td>
            <td class="px-6 py-4">
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded w-fit mb-1">${kodeDDC}</span>
                    <span class="text-xs text-gray-500 truncate max-w-[180px]">${namaKat}</span>
                </div>
            </td>
            <td class="px-6 py-4 text-center">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold ${badgeColor}">
                    ${conf.toFixed(1)}%
                </span>
            </td>
            <td class="px-6 py-4 text-center">
                <button onclick="hapusSatuRiwayat(${item.id})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                    <i data-feather="trash" class="w-4 h-4"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
    
    if(typeof feather !== 'undefined') feather.replace();
}

// 4. KONTROL PAGINATION UI
function updatePaginationUI(totalPages) {
    const btnPrev = document.getElementById("btnPrev");
    const btnNext = document.getElementById("btnNext");
    const container = document.getElementById("paginationNumbers");
    
    btnPrev.disabled = currentPage === 1;
    btnNext.disabled = currentPage === totalPages || totalPages === 0;
    
    // Generate Numbers (Simple: Current, Prev, Next)
    let html = '';
    
    // Logic simple: Max 5 pages visible
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    if(endPage - startPage < 4) startPage = Math.max(1, endPage - 4);

    for(let i = startPage; i <= endPage; i++) {
        const active = i === currentPage ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-50 border-gray-300';
        html += `<button onclick="goToPage(${i})" class="w-8 h-8 flex items-center justify-center rounded border text-xs font-medium transition ${active}">${i}</button>`;
    }
    container.innerHTML = html;
}

// Navigasi
function prevPage() { if(currentPage > 1) { currentPage--; renderTable(); } }
function nextPage() { currentPage++; renderTable(); }
function goToPage(p) { currentPage = p; renderTable(); }
function resetPageAndRender() { currentPage = 1; renderTable(); }
function changeSort(key) { currentSort = key; resetPageAndRender(); }

// 5. UTILS LAINNYA (Export, Delete, Stats)
function updateStatistics() {
    const total = riwayatData.length;
    const uniqueCats = new Set(riwayatData.map(d => d.kategori)).size;
    const today = new Date().toISOString().slice(0, 10);
    const todayCount = riwayatData.filter(d => (d.waktu || "").startsWith(today)).length;

    document.getElementById('total-klasifikasi').textContent = total;
    document.getElementById('total-kategori').textContent = uniqueCats;
    document.getElementById('total-hari-ini').textContent = todayCount;
}

function populateFilterOptions() {
    const select = document.getElementById('filter-kategori');
    const categories = [...new Set(riwayatData.map(d => d.kategori))].filter(Boolean).sort();
    select.innerHTML = '<option value="">Semua Kategori</option>';
    categories.forEach(cat => {
        const option = document.createElement('option');
        option.value = cat;
        option.textContent = cat;
        select.appendChild(option);
    });
}

function exportRiwayat() {
    if (filteredData.length === 0) return alert("Tidak ada data untuk diexport.");
    let csv = "No,Waktu,Judul Buku,Kategori,Confidence\n";
    filteredData.forEach((row, index) => {
        let cleanJudul = (row.judul || "").replace(/"/g, '""');
        csv += `${index+1},"${row.waktu}","${cleanJudul}","${row.kategori}","${row.confidence}"\n`;
    });
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "Riwayat_Klasifikasi_" + new Date().toISOString().slice(0,10) + ".csv";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

async function hapusSatuRiwayat(id) {
    if(!confirm("Yakin hapus?")) return;
    try {
        const res = await fetch(`${API_HISTORY}?action=delete&id=${id}`);
        const json = await res.json();
        if(json.status === 'success') {
            riwayatData = riwayatData.filter(d => d.id != id);
            resetPageAndRender();
            updateStatistics();
        } else alert("Gagal: " + json.message);
    } catch(e) { alert("Error sistem."); }
}

async function hapusSemuaRiwayat() {
    if(riwayatData.length === 0) return;
    if(!confirm("RESET SEMUA DATA?")) return;
    try {
        const res = await fetch(`${API_HISTORY}?action=hapus_semua`);
        const json = await res.json();
        if(json.status === 'success') {
            riwayatData = [];
            resetPageAndRender();
            updateStatistics();
        } else alert("Gagal reset: " + json.message);
    } catch(e) { alert("Error sistem."); }
}
</script>