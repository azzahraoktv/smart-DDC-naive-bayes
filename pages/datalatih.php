<div id="page-datalatih" class="w-full px-4 py-6 font-sans">
    
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">Manajemen Data Training</h1>
        <p class="text-gray-600 text-base">Database pengetahuan untuk algoritma Naive Bayes.</p>
    </div>
    
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center transition-all hover:shadow-md h-full">
            <div class="p-4 rounded-lg bg-blue-50 text-blue-700 mr-5">
                <i data-feather="book" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-base text-gray-500 font-medium">Total Data</p>
                <p class="text-3xl font-extrabold text-gray-800" id="totalData">0</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center transition-all hover:shadow-md h-full">
            <div class="p-4 rounded-lg bg-green-50 text-green-700 mr-5">
                <i data-feather="grid" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-base text-gray-500 font-medium">Jumlah Kategori</p>
                <p class="text-3xl font-extrabold text-gray-800" id="totalCategories">0</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center transition-all hover:shadow-md h-full">
            <div class="p-4 rounded-lg bg-purple-50 text-purple-700 mr-5">
                <i data-feather="clock" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-base text-gray-500 font-medium">Terakhir Update</p>
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
                
                <div class="w-full lg:w-48">
                    <select id="filterCategory" onchange="resetPaginationAndRender()" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base bg-white focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm cursor-pointer truncate">
                        <option value="">Semua Kategori</option>
                    </select>
                </div>

                <div class="w-full lg:w-40">
                    <select id="sortBy" onchange="resetPaginationAndRender()" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base bg-white focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm cursor-pointer">
                        <option value="newest">Urut: Terbaru</option>
                        <option value="oldest">Urut: Terlama</option>
                        <option value="title_asc">Urut: Judul (A-Z)</option>
                        <option value="ddc_asc">Urut: Kode (0-9)</option>
                    </select>
                </div>

                <div class="w-full lg:w-32">
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
                <button onclick="importDataTraining()" class="flex-1 md:flex-none bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg text-base font-bold shadow-md transition flex items-center justify-center gap-2" title="Import Excel">
                    <i data-feather="upload" class="w-5 h-5"></i> <span class="hidden xl:inline">Import</span>
                </button>
                <button onclick="exportDataTraining()" class="flex-1 md:flex-none bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-lg text-base font-bold shadow-md transition flex items-center justify-center gap-2" title="Export Excel">
                    <i data-feather="download" class="w-5 h-5"></i> <span class="hidden xl:inline">Export</span>
                </button>
                <button onclick="openModalDataTraining()" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-base font-bold shadow-md transition flex items-center justify-center gap-2">
                    <i data-feather="plus" class="w-5 h-5 mr-1"></i> Tambah
                </button>
                <button id="btnDeleteSelectedTraining" onclick="hapusDataTerpilihTraining()" class="hidden bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 px-5 py-3 rounded-lg text-base font-bold transition items-center justify-center gap-2" title="Hapus Terpilih">
                    <i data-feather="trash-2" class="w-5 h-5"></i>
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
                            <input type="checkbox" id="selectAllTraining" onclick="toggleSelectAllTraining(this)" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer">
                        </th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider w-16 text-center">No</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider w-40">Kode DDC</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider w-64">Kategori</th>
                        <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-datalatih" class="divide-y divide-gray-100 text-base">
                    </tbody>
            </table>
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

<div id="modal-data-training" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 animate-fade-in max-h-[90vh] overflow-y-auto">
        <div class="p-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800" id="modal-data-training-title">Tambah Data</h3>
                <button onclick="tutupModalDataTraining()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition">
                    <i data-feather="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <input type="hidden" id="inputIdData">

            <div class="space-y-6">
                <div>
                    <label class="block text-base font-bold text-gray-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="inputJudulBuku" class="w-full px-5 py-3 border border-gray-300 rounded-lg text-base focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm" placeholder="Masukkan judul buku lengkap...">
                </div>
                <div>
                    <label class="block text-base font-bold text-gray-700 mb-2">Deskripsi (Sinopsis)</label>
                    <textarea id="inputDeskripsiBuku" rows="4" class="w-full px-5 py-3 border border-gray-300 rounded-lg text-base focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm" placeholder="Opsional: Masukkan deskripsi singkat..."></textarea>
                </div>
                <div>
                    <label class="block text-base font-bold text-gray-700 mb-2">Kategori DDC <span class="text-red-500">*</span></label>
                    <select id="selectKategoriDDC" class="w-full px-5 py-3 border border-gray-300 rounded-lg text-base focus:ring-2 focus:ring-blue-500 outline-none transition bg-white cursor-pointer shadow-sm">
                        <option value="">-- Pilih Kategori --</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-10 flex justify-end gap-3">
                <button onclick="tutupModalDataTraining()" class="px-6 py-3 text-base font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
                <button onclick="simpanDataTraining()" class="px-6 py-3 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition flex items-center shadow-lg transform hover:-translate-y-0.5">
                    <i data-feather="save" class="w-5 h-5 mr-2"></i> Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<script>
const API_URL = 'php_backend/api/get_data_training.php';
let globalDataTraining = [];
let globalKategori = [];
let currentPage = 1;
let rowsPerPage = 10;

async function loadDataToTable() {
    try {
        const resKat = await fetch(`${API_URL}?action=get_categories`);
        const jsonKat = await resKat.json();
        if(jsonKat.status === 'success') {
            globalKategori = jsonKat.data;
            populateFilterAndModal();
        }
        const res = await fetch(`${API_URL}?action=list`);
        const json = await res.json();
        if (json.status === 'success') {
            globalDataTraining = json.data;
            renderTable(); 
            updateStatistics();
        } 
    } catch (error) { console.error("Error:", error); }
}

function getFilteredAndSortedData() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const filterCategory = document.getElementById('filterCategory').value;
    const sortBy = document.getElementById('sortBy').value;

    let filtered = globalDataTraining.filter(item => {
        const matchSearch = (item.judul_buku && item.judul_buku.toLowerCase().includes(searchTerm)) || 
                            (item.deskripsi && item.deskripsi.toLowerCase().includes(searchTerm));
        const matchCategory = !filterCategory || item.kode_ddc === filterCategory;
        return matchSearch && matchCategory;
    });

    filtered.sort((a, b) => {
        const dateA = new Date(a.created_at || 0), dateB = new Date(b.created_at || 0);
        const titleA = (a.judul_buku || "").toLowerCase(), titleB = (b.judul_buku || "").toLowerCase();
        const codeA = a.kode_ddc || "", codeB = b.kode_ddc || "";

        switch (sortBy) {
            case 'newest': return dateB - dateA;
            case 'oldest': return dateA - dateB;
            case 'title_asc': return titleA.localeCompare(titleB);
            case 'ddc_asc': return codeA.localeCompare(codeB, undefined, {numeric: true});
            default: return dateB - dateA;
        }
    });
    return filtered;
}

function renderTable() {
    const tbody = document.getElementById("tabel-datalatih");
    if (!tbody) return;

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
        tbody.innerHTML = `<tr><td colspan="6" class="p-12 text-center text-gray-500"><div class="flex flex-col items-center"><i data-feather="book-open" class="w-16 h-16 mb-4 text-gray-300"></i><p class="text-lg">Data tidak ditemukan</p></div></td></tr>`;
        if (typeof feather !== 'undefined') feather.replace();
        return;
    }

    let html = "";
    pageData.forEach((item, index) => {
        const realIndex = startIndex + index + 1; 
        const judulSafe = item.judul_buku ? item.judul_buku.replace(/'/g, "\\'") : "";
        const badgeColor = getCategoryColorForBadge(item.kode_ddc);

        html += `
            <tr class="hover:bg-blue-50/40 transition duration-200 border-b border-gray-100 last:border-0 fade-in">
                <td class="px-6 py-5 text-center">
                    <input type="checkbox" name="selectedTrainingItems" value="${item.id}" onclick="checkIfAnySelectedTraining()" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer">
                </td>
                <td class="px-6 py-5 text-gray-500 font-mono text-base text-center">${realIndex}</td>
                <td class="px-6 py-5">
                    <div class="font-bold text-gray-900 text-base leading-relaxed line-clamp-2" title="${judulSafe}">${judulSafe}</div>
                    <div class="text-sm text-gray-500 mt-1 flex items-center">
                        <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                        ${formatDate(item.created_at)}
                    </div>
                </td>
                <td class="px-6 py-5">
                    <span class="font-mono text-base font-bold text-blue-700 bg-blue-50 px-3 py-1.5 rounded border border-blue-100">${item.kode_ddc || '-'}</span>
                </td>
                <td class="px-6 py-5">
                    <span class="inline-flex items-center px-3 py-1 rounded text-sm font-bold border ${badgeColor}">
                        ${item.nama_kategori || 'Tanpa Kategori'}
                    </span>
                </td>
                <td class="px-6 py-5 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editDataTraining(${item.id})" class="p-2 text-blue-600 hover:bg-blue-50 hover:text-blue-800 rounded-lg transition" title="Edit">
                            <i data-feather="edit" class="w-5 h-5"></i>
                        </button>
                        <button onclick="hapusDataTraining(${item.id})" class="p-2 text-red-500 hover:bg-red-50 hover:text-red-700 rounded-lg transition" title="Hapus">
                            <i data-feather="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
    });

    tbody.innerHTML = html;
    if (typeof feather !== 'undefined') feather.replace();
    
    const selectAll = document.getElementById("selectAllTraining");
    if (selectAll) selectAll.checked = false;
    checkIfAnySelectedTraining();
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

function formatJudulBuku(str) { 
    if (!str) return "";
    return str.replace(/\w\S*/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
}

async function simpanDataTraining() {
    const id = document.getElementById('inputIdData').value;
    const judul = document.getElementById('inputJudulBuku').value.trim();
    const deskripsi = document.getElementById('inputDeskripsiBuku').value.trim();
    const kategoriId = document.getElementById('selectKategoriDDC').value;

    if (!judul || !kategoriId) { showNotification('error', 'Gagal', 'Judul dan Kategori wajib diisi.'); return; }

    const isDuplicate = globalDataTraining.some(item => {
        if (id && item.id == id) return false; 
        return item.judul_buku.toLowerCase().trim() === judul.toLowerCase() && item.deskripsi.trim() === deskripsi;
    });
    if (isDuplicate) { Swal.fire({ icon: 'error', title: 'Duplikat!', text: 'Data sudah ada.' }); return; }

    const action = id ? 'update' : 'add';
    const url = `${API_URL}?action=${action}&id=${id}&judul=${encodeURIComponent(judul)}&deskripsi=${encodeURIComponent(deskripsi)}&kategori_id=${kategoriId}`;

    try {
        const res = await fetch(url);
        const json = await res.json();
        if (json.status === 'success') {
            showNotification('success', 'Berhasil', json.message);
            tutupModalDataTraining();
            loadDataToTable(); 
        } else showNotification('error', 'Gagal', json.message);
    } catch (error) { showNotification('error', 'Error', 'Terjadi kesalahan sistem.'); }
}

function importDataTraining() { document.getElementById('fileInput')?.click(); importExcelDirectly(); } 
function importExcelDirectly() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.xlsx, .xls';
    input.onchange = (e) => {
        const file = e.target.files[0];
        if(!file) return;
        const reader = new FileReader();
        reader.onload = function(evt) {
            const data = new Uint8Array(evt.target.result);
            const workbook = XLSX.read(data, {type: 'array'});
            const jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
            processImportedData(jsonData);
        };
        reader.readAsArrayBuffer(file);
    };
    input.click();
}

async function processImportedData(dataArray) {
    let successCount = 0, failCount = 0;
    Swal.fire({ title: 'Memproses Import...', html: 'Mohon tunggu...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

    for (const item of dataArray) {
        const judulRaw = item['Judul Buku'] || item['judul'] || item['Judul'];
        const deskripsi = item['Deskripsi'] || item['deskripsi'] || "";
        const kodeDDC = item['Kode DDC'] || item['kode'] || item['Kode'];

        if (!judulRaw || !kodeDDC) { failCount++; continue; }
        const kat = globalKategori.find(k => k.kode_ddc == kodeDDC);
        if (!kat) { failCount++; continue; }

        const judul = formatJudulBuku(judulRaw.toString());
        const isDuplicate = globalDataTraining.some(existing => existing.judul_buku.toLowerCase() === judul.toLowerCase());
        if (isDuplicate) { failCount++; continue; }

        try {
            const url = `${API_URL}?action=add&judul=${encodeURIComponent(judul)}&deskripsi=${encodeURIComponent(deskripsi)}&kategori_id=${kat.id}`;
            await fetch(url);
            successCount++;
        } catch (e) { failCount++; }
    }
    Swal.close();
    Swal.fire({ icon: 'info', title: 'Selesai', html: `Berhasil: <b>${successCount}</b><br>Gagal/Skip: <b>${failCount}</b>` }).then(() => loadDataToTable());
}

function exportDataTraining() {
    if (globalDataTraining.length === 0) { showNotification('warning', 'Kosong', 'Tidak ada data.'); return; }
    const ws = XLSX.utils.json_to_sheet(globalDataTraining);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Data");
    XLSX.writeFile(wb, "Data_Training.xlsx");
}

function populateFilterAndModal() {
    const filterSelect = document.getElementById("filterCategory");
    const modalSelect = document.getElementById("selectKategoriDDC");
    filterSelect.innerHTML = '<option value="">Semua Kategori</option>';
    modalSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';
    globalKategori.forEach(k => {
        filterSelect.add(new Option(`${k.kode_ddc} - ${k.nama_kategori}`, k.kode_ddc));
        modalSelect.add(new Option(`${k.kode_ddc} - ${k.nama_kategori}`, k.id));
    });
}

function openModalDataTraining(id = null) {
    document.getElementById('modal-data-training').classList.remove('hidden');
    document.getElementById('modal-data-training-title').textContent = id ? 'Edit Data' : 'Tambah Data';
    if (id) {
        const data = globalDataTraining.find(i => i.id == id);
        if (data) {
            document.getElementById('inputIdData').value = data.id;
            document.getElementById('inputJudulBuku').value = data.judul_buku;
            document.getElementById('inputDeskripsiBuku').value = data.deskripsi;
            if(data.kategori_id) document.getElementById('selectKategoriDDC').value = data.kategori_id;
        }
    } else {
        document.getElementById('inputIdData').value = '';
        document.getElementById('inputJudulBuku').value = '';
        document.getElementById('inputDeskripsiBuku').value = '';
        document.getElementById('selectKategoriDDC').value = '';
    }
}
function tutupModalDataTraining() { document.getElementById('modal-data-training').classList.add('hidden'); }
function editDataTraining(id) { openModalDataTraining(id); }
function hapusDataTraining(id) {
    Swal.fire({ title: 'Hapus?', text: "Data akan dihapus permanen.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Hapus' })
    .then(async (result) => { if (result.isConfirmed) { await fetch(`${API_URL}?action=delete&id=${id}`); loadDataToTable(); showNotification('success', 'Terhapus', 'Data dihapus.'); } });
}
function hapusDataTerpilihTraining() {
    const cbs = document.querySelectorAll('input[name="selectedTrainingItems"]:checked');
    if (cbs.length === 0) return;
    Swal.fire({ title: 'Hapus Terpilih?', text: `Hapus ${cbs.length} data?`, icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya' })
    .then(async (res) => { if (res.isConfirmed) { for (const cb of cbs) await fetch(`${API_URL}?action=delete&id=${cb.value}`); loadDataToTable(); } });
}
function updateStatistics() {
    document.getElementById('totalData').textContent = globalDataTraining.length;
    document.getElementById('totalCategories').textContent = new Set(globalDataTraining.map(d => d.kode_ddc)).size;
    if(globalDataTraining.length) document.getElementById('lastUpdate').textContent = new Date(Math.max(...globalDataTraining.map(e => new Date(e.created_at)))).toLocaleDateString('id-ID');
}
function getCategoryColorForBadge(code) {
    if (!code) return "bg-gray-100 text-gray-600 border-gray-200";
    return code.startsWith('004') ? "bg-blue-50 text-blue-700 border-blue-200" : "bg-green-50 text-green-700 border-green-200";
}
function formatDate(iso) { try { return new Date(iso).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}); } catch(e){return '-';} }
function showNotification(icon, title, text) { Swal.fire({ icon, title, text, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }); }
function toggleSelectAllTraining(cb) { document.querySelectorAll('input[name="selectedTrainingItems"]').forEach(c => c.checked = cb.checked); checkIfAnySelectedTraining(); }
function checkIfAnySelectedTraining() { 
    const count = document.querySelectorAll('input[name="selectedTrainingItems"]:checked').length;
    const btn = document.getElementById('btnDeleteSelectedTraining');
    if(btn) { btn.style.display = count > 0 ? 'flex' : 'none'; btn.classList.toggle('hidden', count === 0); }
}
function debounce(func, wait) { let timeout; return function(...args) { clearTimeout(timeout); timeout = setTimeout(() => func.apply(this, args), wait); }; }

document.addEventListener("DOMContentLoaded", function() {
    loadDataToTable();
    document.getElementById('searchInput')?.addEventListener('input', debounce(() => { currentPage = 1; renderTable(); }, 300));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') tutupModalDataTraining(); });
});
</script>