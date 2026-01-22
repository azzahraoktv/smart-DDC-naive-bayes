<div id="page-kategori" class="max-w-7xl mx-auto">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen Kategori DDC</h1>
        <p class="text-gray-600">Kelola database Dewey Decimal Classification (Terhubung Database)</p>
    </div>

    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                    <i data-feather="layers" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Kategori</p>
                    <p class="text-2xl font-bold text-gray-800" id="total-kategori-display">0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                    <i data-feather="check-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kategori Terpakai</p>
                    <p class="text-2xl font-bold text-gray-800" id="active-categories">0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                    <i data-feather="database" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Data Training</p>
                    <p class="text-2xl font-bold text-gray-800" id="total-data-training">0</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex flex-wrap gap-3">
            <button onclick="bukaModalKategori()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition card-hover">
                <i data-feather="plus" class="mr-2 w-4 h-4"></i> Tambah Kategori
            </button>
            <button onclick="syncKategoriStandar()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition card-hover">
                <i data-feather="refresh-cw" class="mr-2 w-4 h-4"></i> Sync Standar (32)
            </button>
            <button onclick="exportExcel()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition card-hover">
                <i data-feather="download" class="mr-2 w-4 h-4"></i> Export Excel
            </button>
            <button onclick="importExcel()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition card-hover">
                <i data-feather="upload" class="mr-2 w-4 h-4"></i> Import Excel
            </button>
        </div>

        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-feather="search" class="h-4 w-4 text-gray-400"></i>
            </div>
            <input type="text" id="searchInput" onkeyup="handleSearch()" 
                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition" 
                   placeholder="Cari kode atau nama...">
        </div>
    </div>

    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-start">
            <i data-feather="info" class="w-5 h-5 text-blue-600 mr-3 mt-0.5"></i>
            <div>
                <p class="text-sm font-medium text-blue-800 mb-1">Data Terintegrasi Database</p>
                <div class="text-xs text-blue-700">
                    <p>Semua data kategori diambil dan disimpan langsung ke database server (MySQL).</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden card-hover">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase w-16">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase w-32">Kode DDC</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center w-32">Data Training</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center w-32">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-kategori" class="divide-y divide-gray-200 text-sm">
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">
                            <i data-feather="loader" class="animate-spin w-6 h-6 mx-auto mb-2"></i>
                            Memuat data dari database...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-kategori" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 animate-fade-in">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800" id="modal-kategori-title">Tambah Kategori Baru</h3>
                <button onclick="tutupModalKategori()" class="text-gray-400 hover:text-gray-600">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <input type="hidden" id="kodeLama">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode DDC <span class="text-red-500">*</span></label>
                    <input type="text" id="inputKodeDDC" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: 004.0288">
                    <p class="text-xs text-gray-500 mt-1">Format: 3 digit utama (004-999) diikuti titik dan maksimal 3 digit</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" id="inputNamaKategori" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Masukkan nama kategori">
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <button onclick="tutupModalKategori()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
                <button onclick="simpanKategori()" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition flex items-center">
                    <i data-feather="save" class="w-4 h-4 mr-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ==========================================
// CONFIG & VARIABLES
// ==========================================
let localKategoriData = []; 
let dataTrainingCache = []; 
let isEditMode = false;

// PENTING: Path ini disesuaikan dengan struktur folder Anda
const API_URL = 'php_backend/api/get_kategori.php'; 

document.addEventListener("DOMContentLoaded", () => {
    // 1. Load Data Training dari LocalStorage (Untuk Hitungan Statistik)
    const storedTraining = localStorage.getItem('dataTraining');
    if (storedTraining) {
        try { dataTrainingCache = JSON.parse(storedTraining); } catch(e) { dataTrainingCache = []; }
    }
    
    // 2. Load Data Kategori dari Database
    refreshDataKategori();
});

// ==========================================
// CRUD (DATABASE)
// ==========================================
async function refreshDataKategori() {
    try {
        const res = await fetch(`${API_URL}?action=read`);
        const data = await res.json();
        
        if (Array.isArray(data)) {
            localKategoriData = data;
            // Update Global Cache untuk halaman lain
            localStorage.setItem("kategoriDDC", JSON.stringify(data));
            
            renderTabelKategori(data);
            updateStatistikKategori();
        } else {
            console.error("Format data salah:", data);
            document.getElementById('tabel-kategori').innerHTML = `<tr><td colspan="6" class="p-8 text-center text-red-500">Error: Format data tidak valid.</td></tr>`;
        }
    } catch (err) {
        console.error("Gagal load kategori:", err);
        // Pesan Error Lebih Jelas
        document.getElementById('tabel-kategori').innerHTML = `
            <tr>
                <td colspan="6" class="p-8 text-center text-red-500">
                    <div class="flex flex-col items-center">
                        <i data-feather="alert-triangle" class="w-8 h-8 mb-2"></i>
                        <span class="font-bold">Gagal terhubung ke Database.</span>
                        <span class="text-sm mt-1">Cek apakah file <b>${API_URL}</b> ada dan XAMPP aktif.</span>
                    </div>
                </td>
            </tr>`;
        if (typeof feather !== 'undefined') feather.replace();
    }
}

function renderTabelKategori(data) {
    const tbody = document.getElementById('tabel-kategori');
    tbody.innerHTML = '';

    if (data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="p-8 text-center text-gray-400">
                    <div class="flex flex-col items-center">
                        <i data-feather="layers" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                        <p class="text-lg font-medium text-gray-500 mb-2">Belum ada kategori</p>
                        <button onclick="syncKategoriStandar()" class="text-blue-600 hover:text-blue-800 underline text-sm">
                            Muat 32 Kategori Standar
                        </button>
                    </div>
                </td>
            </tr>`;
        feather.replace();
        return;
    }

    // Hitung Penggunaan di Data Training
    const usageCount = {};
    dataTrainingCache.forEach(item => {
        if(item.kategori) {
            const code = item.kategori.split('|')[0];
            usageCount[code] = (usageCount[code] || 0) + 1;
        }
    });

    let html = '';
    data.forEach((item, index) => {
        const jumlah = usageCount[item.kode] || 0;
        const isUsed = jumlah > 0;
        const warnaStatus = isUsed ? "bg-green-100 text-green-800 border-green-200" : "bg-gray-100 text-gray-600 border-gray-200";
        const teksStatus = isUsed ? "Terpakai" : "Kosong";
        const iconStatus = isUsed ? '<i data-feather="check-circle" class="w-3 h-3 mr-1"></i>' : '<i data-feather="circle" class="w-3 h-3 mr-1"></i>';

        html += `
            <tr class="hover:bg-gray-50 transition-colors" data-kode="${item.kode}">
                <td class="px-6 py-4 text-gray-700 font-medium">${index + 1}</td>
                <td class="px-6 py-4">
                    <code class="font-mono font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded border border-blue-100">${item.kode}</code>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">${item.nama}</div>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full ${isUsed ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-500"} font-bold text-sm">
                        ${jumlah}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border ${warnaStatus}">
                        ${iconStatus} ${teksStatus}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editKategori('${item.kode}')" class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition" title="Edit">
                            <i data-feather="edit" class="w-4 h-4"></i>
                        </button>
                        <button onclick="hapusKategori('${item.kode}')" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition ${isUsed ? "opacity-50 cursor-not-allowed" : ""}" title="Hapus" ${isUsed ? "disabled" : ""}>
                            <i data-feather="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
    });
    tbody.innerHTML = html;
    feather.replace();
}

function handleSearch() {
    const key = document.getElementById('searchInput').value.toLowerCase();
    const filtered = localKategoriData.filter(item => 
        item.kode.toLowerCase().includes(key) || item.nama.toLowerCase().includes(key)
    );
    renderTabelKategori(filtered);
}

function updateStatistikKategori() {
    document.getElementById("total-kategori-display").textContent = localKategoriData.length;
    document.getElementById("total-data-training").textContent = dataTrainingCache.length;
    const usedCodes = new Set(dataTrainingCache.map(d => d.kategori ? d.kategori.split('|')[0] : null).filter(k => k));
    document.getElementById("active-categories").textContent = usedCodes.size;
}

// ==========================================
// MODAL & CRUD API
// ==========================================
function bukaModalKategori() {
    isEditMode = false;
    document.getElementById('modal-kategori-title').textContent = 'Tambah Kategori Baru';
    document.getElementById('inputKodeDDC').value = '';
    document.getElementById('inputKodeDDC').readOnly = false;
    document.getElementById('inputNamaKategori').value = '';
    document.getElementById('modal-kategori').classList.remove('hidden');
}

function editKategori(kode) {
    const item = localKategoriData.find(k => k.kode === kode);
    if(!item) return;

    isEditMode = true;
    document.getElementById('modal-kategori-title').textContent = 'Edit Kategori';
    document.getElementById('kodeLama').value = item.kode;
    document.getElementById('inputKodeDDC').value = item.kode;
    document.getElementById('inputKodeDDC').readOnly = false;
    document.getElementById('inputNamaKategori').value = item.nama;
    document.getElementById('modal-kategori').classList.remove('hidden');
}

function tutupModalKategori() {
    document.getElementById('modal-kategori').classList.add('hidden');
}

async function simpanKategori() {
    const kode = document.getElementById('inputKodeDDC').value.trim();
    const nama = document.getElementById('inputNamaKategori').value.trim();
    const kodeLama = document.getElementById('kodeLama').value;

    if (!kode || !nama) return Swal.fire('Gagal', 'Kode dan Nama wajib diisi.', 'warning');

    const formData = new FormData();
    formData.append('kode', kode);
    formData.append('nama', nama);
    
    let action = isEditMode ? 'update' : 'create';
    if (isEditMode) formData.append('kode_lama', kodeLama);

    try {
        Swal.fire({title: 'Menyimpan...', didOpen: () => Swal.showLoading()});
        const res = await fetch(`${API_URL}?action=${action}`, { method: 'POST', body: formData });
        const result = await res.json();
        
        if (result.status === 'success') {
            await Swal.fire({ icon: 'success', title: 'Berhasil!', timer: 1000, showConfirmButton: false });
            tutupModalKategori();
            refreshDataKategori();
        } else {
            Swal.fire('Gagal', result.message, 'error');
        }
    } catch (err) { 
        console.error(err);
        Swal.fire('Error', 'Kesalahan server', 'error'); 
    }
}

function hapusKategori(kode) {
    const isUsed = dataTrainingCache.some(d => d.kategori && d.kategori.startsWith(kode + '|'));
    if (isUsed) {
        return Swal.fire({ icon: 'error', title: 'Gagal Hapus', text: 'Kategori ini sedang digunakan.' });
    }

    Swal.fire({
        title: 'Hapus Kategori?', text: `Kode ${kode} akan dihapus.`, icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Hapus'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('kode', kode);
            try {
                await fetch(`${API_URL}?action=delete`, { method: 'POST', body: formData });
                Swal.fire({ icon: 'success', title: 'Terhapus!', timer: 1000, showConfirmButton: false });
                refreshDataKategori();
            } catch(e) { Swal.fire('Error', 'Gagal menghapus', 'error'); }
        }
    });
}

// ==========================================
// IMPORT & EXPORT EXCEL (.xlsx)
// ==========================================

// 1. Export Excel
function exportExcel() {
    if (localKategoriData.length === 0) return Swal.fire('Info', 'Data kosong.', 'info');

    const dataExport = localKategoriData.map((item, index) => ({
        "No": index + 1,
        "Kode DDC": item.kode,
        "Nama Kategori": item.nama
    }));

    const ws = XLSX.utils.json_to_sheet(dataExport);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Kategori DDC");
    ws['!cols'] = [{wch: 5}, {wch: 15}, {wch: 50}];

    XLSX.writeFile(wb, `Kategori_DDC_${new Date().toISOString().slice(0,10)}.xlsx`);
    Swal.fire({ icon: 'success', title: 'Export Berhasil', timer: 2000, showConfirmButton: false });
}

// 2. Import Excel
function importExcel() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.xlsx, .xls';
    
    input.onchange = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        Swal.fire({ title: 'Memproses Excel...', text: 'Mohon tunggu', didOpen: () => Swal.showLoading() });

        const reader = new FileReader();
        reader.onload = async function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                const jsonData = XLSX.utils.sheet_to_json(firstSheet);

                if (jsonData.length === 0) throw new Error("File Excel kosong.");

                // Kirim JSON ke PHP
                const res = await fetch(`${API_URL}?action=import_excel`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(jsonData)
                });
                
                const result = await res.json();
                if (result.status === 'success') {
                    Swal.fire('Selesai', result.message, 'success');
                    refreshDataKategori();
                } else {
                    throw new Error(result.message);
                }
            } catch (err) {
                console.error(err);
                Swal.fire('Gagal', 'Pastikan format Excel valid.', 'error');
            }
        };
        reader.readAsArrayBuffer(file);
    };
    input.click();
}

// 3. Sync Standar (Menggunakan Endpoint Import Excel)
function syncKategoriStandar() {
    Swal.fire({
        title: 'Sync Kategori Standar?',
        html: `Memuat <b>32 Kategori DDC</b> ke database.<br><small class="text-gray-500">Data yang sudah ada akan diperbarui.</small>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        confirmButtonText: 'Ya, Sync Sekarang'
    }).then(async (result) => {
        if (result.isConfirmed) {
            // Data Standar 32 Kategori
            const standarData = [
                { "Kode DDC": "004.0288", "Nama Kategori": "Perawatan, Perakitan & Servis Komputer" },
                { "Kode DDC": "004.03", "Nama Kategori": "Kamus & Ensiklopedia Komputer" },
                { "Kode DDC": "004.2", "Nama Kategori": "Arsitektur & Analisis Sistem" },
                { "Kode DDC": "004.42", "Nama Kategori": "Dasar Pemrograman (General)" },
                { "Kode DDC": "004.6", "Nama Kategori": "Jaringan Komputer & Komunikasi Data" },
                { "Kode DDC": "004.65", "Nama Kategori": "Administrasi Jaringan & Routing" },
                { "Kode DDC": "004.678", "Nama Kategori": "Internet & Aplikasi Online" },
                { "Kode DDC": "004.71", "Nama Kategori": "Periferal Komputer & Grafik" },
                { "Kode DDC": "005.1", "Nama Kategori": "Algoritma, Rekayasa Perangkat Lunak" },
                { "Kode DDC": "005.11", "Nama Kategori": "Struktur Data" },
                { "Kode DDC": "005.117", "Nama Kategori": "Pemrograman Berorientasi Objek (OOP)" },
                { "Kode DDC": "005.118", "Nama Kategori": "Pemrograman Visual & Computer Vision" },
                { "Kode DDC": "005.12", "Nama Kategori": "Pemrograman Model Matematika (Matlab)" },
                { "Kode DDC": "005.13", "Nama Kategori": "Bahasa Pemrograman Spesifik (Ruby, dll)" },
                { "Kode DDC": "005.133", "Nama Kategori": "Bahasa C, C++, C#" },
                { "Kode DDC": "005.262", "Nama Kategori": "Pemrograman Web/Desktop Framework" },
                { "Kode DDC": "005.276", "Nama Kategori": "Aplikasi Pemrograman Lanjut" },
                { "Kode DDC": "005.3", "Nama Kategori": "Program Aplikasi Umum & Grafis" },
                { "Kode DDC": "005.34", "Nama Kategori": "Aplikasi Keamanan & Utilitas OS" },
                { "Kode DDC": "005.36", "Nama Kategori": "Aplikasi Perkantoran: Konsep" },
                { "Kode DDC": "005.368", "Nama Kategori": "Microsoft Office (Lanjut) & Utilitas Windows" },
                { "Kode DDC": "005.369", "Nama Kategori": "Aplikasi Desain & Lain-lain (Office)" },
                { "Kode DDC": "005.43", "Nama Kategori": "OS Spesifik (Windows, Linux)" },
                { "Kode DDC": "005.478", "Nama Kategori": "Pelaporan & Analisis Data (Excel Lanjut)" },
                { "Kode DDC": "005.5", "Nama Kategori": "Aplikasi Serba Guna & Kolaborasi" },
                { "Kode DDC": "005.55", "Nama Kategori": "Aplikasi Statistik dan Analisis Data" },
                { "Kode DDC": "005.74", "Nama Kategori": "Sistem Manajemen Basis Data (DBMS) & SQL" },
                { "Kode DDC": "005.8", "Nama Kategori": "Keamanan Data, Jaringan & Hacking" },
                { "Kode DDC": "005.82", "Nama Kategori": "Kriptografi" },
                { "Kode DDC": "005.913", "Nama Kategori": "Pemodelan Berorientasi Objek & Desain" },
                { "Kode DDC": "006.22", "Nama Kategori": "Sistem Tertanam & Mikrokontroler" },
                { "Kode DDC": "006.6", "Nama Kategori": "Grafika Komputer & Desain Multimedia" }
            ];

            Swal.fire({ title: 'Syncing...', didOpen: () => Swal.showLoading() });

            try {
                const res = await fetch(`${API_URL}?action=import_excel`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(standarData)
                });
                const result = await res.json();
                
                if (result.status === 'success') {
                    Swal.fire('Berhasil', '32 Kategori Standar telah ditambahkan.', 'success');
                    refreshDataKategori();
                } else {
                    throw new Error(result.message);
                }
            } catch (err) {
                Swal.fire('Gagal', 'Terjadi kesalahan saat sync.', 'error');
            }
        }
    });
}

if (typeof feather !== 'undefined') feather.replace();
</script>