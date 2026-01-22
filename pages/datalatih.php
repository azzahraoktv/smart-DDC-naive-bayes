<div id="page-datalatih">
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Manajemen Data Training</h1>
        <p class="text-gray-600">Database pengetahuan untuk algoritma Naive Bayes.</p>
        <p class="text-sm text-gray-500 mt-1" id="data-count">0 data training tersimpan</p>
    </div>
    
    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                    <i data-feather="book" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Data Training</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalData">0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                    <i data-feather="grid" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jumlah Kategori</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalCategories">0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                    <i data-feather="database" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Terakhir Diperbarui</p>
                    <p class="text-lg font-bold text-gray-800" id="lastUpdate">-</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6 flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Judul Buku</label>
            <input type="text" id="searchInput" placeholder="Ketik judul buku..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
        </div>
        <div class="min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
            <select id="sortBy" onchange="renderTable()"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
                <option value="newest">Terbaru (Terakhir Masuk)</option>
                <option value="oldest">Terlama (Awal Masuk)</option>
                <option value="title_asc">Judul (A-Z)</option>
                <option value="title_desc">Judul (Z-A)</option>
                <option value="ddc_asc">Kode DDC (0-9)</option>
                <option value="ddc_desc">Kode DDC (9-0)</option>
            </select>
        </div>
        <div class="min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori</label>
            <select id="filterCategory" onchange="renderTable()"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
                <option value="">Semua Kategori</option>
            </select>
        </div>
        <div class="self-end">
            <button onclick="resetFilterDataTraining()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <i data-feather="filter" class="w-4 h-4 mr-1"></i> Reset
            </button>
        </div>
    </div>
    
    <div class="mb-6 flex flex-wrap gap-2 md:gap-3">
        <button onclick="importDataTraining()" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition-all duration-300 card-hover">
            <i data-feather="upload" class="mr-2 w-4 h-4"></i> Impor Excel
        </button>
        <button onclick="exportDataTraining()" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition-all duration-300 card-hover">
            <i data-feather="download" class="mr-2 w-4 h-4"></i> Ekspor Excel
        </button>
        <button onclick="openModalDataTraining()" class="btn-primary text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm card-hover">
            <i data-feather="plus" class="mr-2 w-4 h-4"></i> Tambah Manual
        </button>
        <button id="btnDeleteSelectedTraining" onclick="hapusDataTerpilihTraining()" class="btn-danger px-4 py-2 rounded-lg text-sm font-bold shadow-sm flex items-center transition" style="display:none;">
            <i data-feather="trash-2" class="mr-2 w-4 h-4"></i> Hapus Terpilih
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden card-hover fade-in">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-4 text-center w-12">
                            <input type="checkbox" id="selectAllTraining" onclick="toggleSelectAllTraining(this)" class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase w-16">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Judul Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase w-32">Kode DDC</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-datalatih" class="divide-y divide-gray-200 text-sm">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-data-training" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 animate-fade-in max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800" id="modal-data-training-title">Tambah Data Training Baru</h3>
                <button onclick="tutupModalDataTraining()" class="text-gray-400 hover:text-gray-600">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <input type="hidden" id="inputIdData">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="inputJudulBuku" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: Belajar Pemrograman Web">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Buku <span class="text-red-500">*</span></label>
                    <textarea id="inputDeskripsiBuku" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Masukkan deskripsi atau sinopsis buku"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori DDC <span class="text-red-500">*</span></label>
                    <select id="selectKategoriDDC" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">-- Pilih Kategori --</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Data diambil dari database kategori.</p>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <button onclick="tutupModalDataTraining()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
                <button onclick="simpanDataTraining()" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition flex items-center">
                    <i data-feather="save" class="w-4 h-4 mr-2"></i> Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<script>
// ===============================
// KONFIGURASI API
// ===============================
const API_URL = 'php_backend/api/get_data_training.php';

// Global Variables
let globalDataTraining = [];
let globalKategori = [];

// Helper: Format Judul (Title Case)
function formatJudulBuku(str) {
    if (!str) return "";
    const kataKecil = ['di', 'ke', 'dari', 'dan', 'atau', 'yang', 'untuk', 'pada', 'dalam', 'dengan', 'oleh', 'atas', 'bagi', 'kepada', 'tentang', 'secara', 'melalui', 'terhadap', 'daripada', 'pun', 'per', 'demi', 'si', 'sang', 'bin', 'binti'];
    let words = str.toLowerCase().trim().split(/\s+/);
    return words.map((word, index) => {
        if (index === 0) return word.charAt(0).toUpperCase() + word.slice(1);
        if (kataKecil.includes(word)) return word;
        return word.charAt(0).toUpperCase() + word.slice(1);
    }).join(' ');
}

// 1. LOAD DATA UTAMA
async function loadDataToTable() {
    // A. Ambil Kategori (Dropdown)
    try {
        const resKat = await fetch(`${API_URL}?action=get_categories`);
        const jsonKat = await resKat.json();
        if(jsonKat.status === 'success') {
            globalKategori = jsonKat.data;
            populateFilterAndModal();
        }
    } catch (e) { console.error("Gagal load kategori:", e); }

    // B. Ambil Data Training
    try {
        const res = await fetch(`${API_URL}?action=list`);
        const json = await res.json();
        
        if (json.status === 'success') {
            globalDataTraining = json.data;
            renderTable(); 
            updateStatistics();
        } else {
            console.error("API Error:", json.message);
        }
    } catch (error) {
        console.error("Gagal koneksi ke server:", error);
        showNotification('error', 'Koneksi Gagal', 'Gagal memuat data dari server.');
    }
}

// 2. RENDER TABEL (FILTER & SORTING)
function renderTable() {
    const tbody = document.getElementById("tabel-datalatih");
    const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const filterCategory = document.getElementById('filterCategory')?.value || '';
    const sortBy = document.getElementById('sortBy')?.value || 'newest';

    if (!tbody) return;

    // Filter
    let filtered = globalDataTraining.filter(item => {
        const matchSearch = (item.judul_buku && item.judul_buku.toLowerCase().includes(searchTerm)) || 
                            (item.deskripsi && item.deskripsi.toLowerCase().includes(searchTerm));
        const matchCategory = !filterCategory || item.kode_ddc === filterCategory;
        return matchSearch && matchCategory;
    });

    // Sorting (Termasuk DDC)
    filtered.sort((a, b) => {
        const dateA = new Date(a.created_at || 0);
        const dateB = new Date(b.created_at || 0);
        const titleA = (a.judul_buku || "").toLowerCase();
        const titleB = (b.judul_buku || "").toLowerCase();
        const codeA = a.kode_ddc || "";
        const codeB = b.kode_ddc || "";

        switch (sortBy) {
            case 'newest': return dateB - dateA;
            case 'oldest': return dateA - dateB;
            case 'title_asc': return titleA.localeCompare(titleB);
            case 'title_desc': return titleB.localeCompare(titleA);
            case 'ddc_asc': return codeA.localeCompare(codeB, undefined, {numeric: true});
            case 'ddc_desc': return codeB.localeCompare(codeA, undefined, {numeric: true});
            default: return dateB - dateA;
        }
    });

    // Render HTML
    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-gray-400"><div class="flex flex-col items-center"><i data-feather="book-open" class="w-12 h-12 mb-3 text-gray-300"></i><p class="text-lg font-medium text-gray-500 mb-2">Data tidak ditemukan</p></div></td></tr>`;
        if (typeof feather !== 'undefined') feather.replace();
        return;
    }

    let html = "";
    filtered.forEach((item, index) => {
        const badgeColor = getCategoryColorForBadge(item.kode_ddc);
        const judulSafe = item.judul_buku ? item.judul_buku.replace(/'/g, "\\'") : "";

        html += `
            <tr class="hover:bg-gray-50 transition-colors fade-in">
                <td class="px-4 py-4 text-center">
                    <input type="checkbox" name="selectedTrainingItems" value="${item.id}" onclick="checkIfAnySelectedTraining()" class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500 cursor-pointer">
                </td>
                <td class="px-6 py-4 text-gray-900 font-medium text-base">${index + 1}</td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-gray-900 text-base">${judulSafe}</div>
                    <div class="text-sm text-gray-600 mt-1 flex items-center">
                        <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                        ${formatDate(item.created_at)}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <code class="font-mono text-sm font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded border border-blue-100">${item.kode_ddc || '-'}</code>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border ${badgeColor}">${item.nama_kategori || 'Tanpa Kategori'}</span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editDataTraining(${item.id})" class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition" title="Edit"><i data-feather="edit" class="w-4 h-4"></i></button>
                        <button onclick="hapusDataTraining(${item.id})" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition" title="Hapus"><i data-feather="trash-2" class="w-4 h-4"></i></button>
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

// 3. SIMPAN DATA (ADD/UPDATE)
async function simpanDataTraining() {
    const id = document.getElementById('inputIdData').value;
    const judulRaw = document.getElementById('inputJudulBuku').value.trim();
    const deskripsi = document.getElementById('inputDeskripsiBuku').value.trim();
    const kategoriId = document.getElementById('selectKategoriDDC').value;

    const judul = formatJudulBuku(judulRaw); // Auto Title Case

    if (!judul) { showNotification('error', 'Judul Kosong', 'Harap masukkan judul buku.'); return; }
    if (!deskripsi) { showNotification('error', 'Deskripsi Kosong', 'Harap isi deskripsi.'); return; }
    if (!kategoriId) { showNotification('error', 'Kategori Kosong', 'Pilih kategori.'); return; }

    // Cek Duplikat: Judul Sama && Deskripsi Sama = DITOLAK
    const isDuplicate = globalDataTraining.some(item => {
        if (id && item.id == id) return false; 
        return item.judul_buku.toLowerCase().trim() === judul.toLowerCase() &&
               item.deskripsi.toLowerCase().trim() === deskripsi.toLowerCase().trim();
    });

    if (isDuplicate) {
        Swal.fire({ icon: 'error', title: 'Data Duplikat!', text: 'Judul dan deskripsi yang sama persis sudah ada.' });
        return;
    }

    const action = id ? 'update' : 'add';
    const url = `${API_URL}?action=${action}&id=${id}&judul=${encodeURIComponent(judul)}&deskripsi=${encodeURIComponent(deskripsi)}&kategori_id=${kategoriId}`;

    try {
        const res = await fetch(url);
        const json = await res.json();

        if (json.status === 'success') {
            showNotification('success', 'Berhasil', json.message);
            tutupModalDataTraining();
            loadDataToTable(); 
        } else {
            showNotification('error', 'Gagal', json.message);
        }
    } catch (error) {
        console.error(error);
        showNotification('error', 'Error', 'Gagal menyimpan data.');
    }
}

// 4. IMPORT EXCEL
function importDataTraining() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.xlsx, .xls';
    input.style.display = 'none';
    input.onchange = function(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {type: 'array'});
            const jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
            processImportedData(jsonData);
        };
        reader.readAsArrayBuffer(file);
    };
    document.body.appendChild(input);
    input.click();
    document.body.removeChild(input);
}

async function processImportedData(dataArray) {
    let successCount = 0;
    let failCount = 0;

    Swal.fire({
        title: 'Memproses Import...',
        html: 'Mohon tunggu, sedang menyimpan ke database.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    for (const item of dataArray) {
        const judulRaw = item['Judul Buku'] || item['judul'] || item['Judul'];
        const deskripsi = item['Deskripsi'] || item['deskripsi'];
        const kodeDDC = item['Kode DDC'] || item['kode'] || item['Kode'];

        if (!judulRaw || !kodeDDC) { failCount++; continue; }

        const kat = globalKategori.find(k => k.kode_ddc == kodeDDC);
        if (!kat) { failCount++; continue; }

        const judul = formatJudulBuku(judulRaw.toString());

        // Cek Duplikat: Judul Sama && Deskripsi Sama = SKIP
        const isDuplicate = globalDataTraining.some(existing => 
            existing.judul_buku.toLowerCase() === judul.toLowerCase() &&
            existing.deskripsi.toLowerCase() === deskripsi.toString().toLowerCase().trim()
        );

        if (isDuplicate) { failCount++; continue; }

        try {
            const url = `${API_URL}?action=add&judul=${encodeURIComponent(judul)}&deskripsi=${encodeURIComponent(deskripsi)}&kategori_id=${kat.id}`;
            await fetch(url);
            successCount++;
        } catch (e) { failCount++; }
    }

    Swal.close();
    Swal.fire({
        icon: 'info',
        title: 'Import Selesai',
        html: `Berhasil: <b>${successCount}</b><br>Gagal/Duplikat: <b>${failCount}</b>`
    }).then(() => {
        loadDataToTable();
    });
}

// 5. HELPER & UTILS
function populateFilterAndModal() {
    const filterSelect = document.getElementById("filterCategory");
    const modalSelect = document.getElementById("selectKategoriDDC");
    filterSelect.innerHTML = '<option value="">Semua Kategori</option>';
    modalSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';

    globalKategori.forEach(k => {
        // Filter: Value = Kode DDC
        const optFilter = document.createElement("option");
        optFilter.value = k.kode_ddc;
        optFilter.textContent = `${k.kode_ddc} - ${k.nama_kategori}`;
        filterSelect.appendChild(optFilter);

        // Modal: Value = ID (untuk Insert DB)
        const optModal = document.createElement("option");
        optModal.value = k.id; 
        optModal.textContent = `${k.kode_ddc} - ${k.nama_kategori}`;
        modalSelect.appendChild(optModal);
    });
}

function openModalDataTraining(id = null) {
    document.getElementById('modal-data-training').classList.remove('hidden');
    if (id) {
        document.getElementById('modal-data-training-title').textContent = 'Edit Data Training';
        const data = globalDataTraining.find(i => i.id == id);
        if (data) {
            document.getElementById('inputIdData').value = data.id;
            document.getElementById('inputJudulBuku').value = data.judul_buku;
            document.getElementById('inputDeskripsiBuku').value = data.deskripsi;
            if(data.kategori_id) document.getElementById('selectKategoriDDC').value = data.kategori_id;
        }
    } else {
        document.getElementById('modal-data-training-title').textContent = 'Tambah Data Training Baru';
        document.getElementById('inputIdData').value = '';
        document.getElementById('inputJudulBuku').value = '';
        document.getElementById('inputDeskripsiBuku').value = '';
        document.getElementById('selectKategoriDDC').value = '';
    }
}

function editDataTraining(id) { openModalDataTraining(id); }
function tutupModalDataTraining() { document.getElementById('modal-data-training').classList.add('hidden'); }

function hapusDataTraining(id) {
    Swal.fire({ title: 'Hapus Data?', text: "Data akan dihapus permanen.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Hapus' })
    .then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await fetch(`${API_URL}?action=delete&id=${id}`);
                const json = await res.json();
                if (json.status === 'success') {
                    showNotification('success', 'Terhapus', 'Data berhasil dihapus.');
                    loadDataToTable();
                } else showNotification('error', 'Gagal', json.message);
            } catch (error) { showNotification('error', 'Error', 'Gagal menghapus data.'); }
        }
    });
}

function hapusDataTerpilihTraining() {
    const checkboxes = document.querySelectorAll('input[name="selectedTrainingItems"]:checked');
    if (checkboxes.length === 0) return;
    Swal.fire({ title: 'Hapus Terpilih?', text: `Hapus ${checkboxes.length} data?`, icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya' })
    .then(async (res) => {
        if (res.isConfirmed) {
            for (const cb of checkboxes) { await fetch(`${API_URL}?action=delete&id=${cb.value}`); }
            showNotification('success', 'Selesai', 'Data terpilih dihapus.');
            loadDataToTable();
        }
    });
}

function updateStatistics() {
    const total = globalDataTraining.length;
    document.getElementById('totalData').textContent = total;
    document.getElementById('data-count').textContent = `${total} data training tersimpan`;
    document.getElementById('totalCategories').textContent = new Set(globalDataTraining.map(d => d.kode_ddc)).size;
    if (globalDataTraining.length > 0) {
        const last = new Date(Math.max(...globalDataTraining.map(e => new Date(e.created_at))));
        document.getElementById('lastUpdate').textContent = last.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }
}

function exportDataTraining() {
    if (globalDataTraining.length === 0) { showNotification('warning', 'Kosong', 'Tidak ada data.'); return; }
    const exportData = globalDataTraining.map((item, index) => ({
        "No": index + 1,
        "Judul Buku": item.judul_buku,
        "Deskripsi": item.deskripsi,
        "Kode DDC": item.kode_ddc,
        "Nama Kategori": item.nama_kategori,
        "Tanggal Input": formatDate(item.created_at)
    }));
    const worksheet = XLSX.utils.json_to_sheet(exportData);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Data Training");
    XLSX.writeFile(workbook, `Data_Training_SmartDDC.xlsx`);
}

function getCategoryColorForBadge(code) {
    if (!code) return "bg-gray-100 text-gray-600 border-gray-200";
    const prefix = code.split('.')[0];
    const colors = { '004': 'bg-blue-100 text-blue-800 border-blue-200', '005': 'bg-green-100 text-green-800 border-green-200' };
    return colors[prefix] || "bg-gray-100 text-gray-600 border-gray-200";
}

function formatDate(iso) { try { return new Date(iso).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}); } catch(e){return '-';} }
function showNotification(icon, title, text) { Swal.fire({ icon, title, text, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }); }
function toggleSelectAllTraining(cb) { document.querySelectorAll('input[name="selectedTrainingItems"]').forEach(c => c.checked = cb.checked); checkIfAnySelectedTraining(); }
function checkIfAnySelectedTraining() { 
    const count = document.querySelectorAll('input[name="selectedTrainingItems"]:checked').length;
    const btn = document.getElementById('btnDeleteSelectedTraining');
    if(btn) btn.style.display = count > 0 ? 'flex' : 'none';
}
function debounce(func, wait) { let timeout; return function(...args) { clearTimeout(timeout); timeout = setTimeout(() => func.apply(this, args), wait); }; }
function resetFilterDataTraining() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterCategory').value = '';
    document.getElementById('sortBy').value = 'newest';
    renderTable();
}

document.addEventListener("DOMContentLoaded", function() {
    loadDataToTable();
    document.getElementById('searchInput')?.addEventListener('input', debounce(() => renderTable(), 300));
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !document.getElementById('modal-data-training').classList.contains('hidden')) {
            tutupModalDataTraining();
        }
    });
});
</script>