<div id="page-kategori">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen Kategori DDC</h1>
        <p class="text-gray-600">Kelola database Dewey Decimal Classification untuk bidang Informatika</p>
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

    <div class="mb-6 flex flex-wrap gap-3">
        <button onclick="bukaModalTambahKategori()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition card-hover">
            <i data-feather="plus" class="mr-2 w-4 h-4"></i> Tambah Kategori
        </button>
        <button onclick="window.syncKategori()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition card-hover">
            <i data-feather="refresh-cw" class="mr-2 w-4 h-4"></i> Sync Kategori Standar (32)
        </button>
        <button onclick="window.exportKategori()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition card-hover">
            <i data-feather="download" class="mr-2 w-4 h-4"></i> Export Kategori
        </button>
        <button onclick="window.importKategori()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition card-hover">
            <i data-feather="upload" class="mr-2 w-4 h-4"></i> Import Kategori
        </button>
    </div>

    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-start">
            <i data-feather="info" class="w-5 h-5 text-blue-600 mr-3 mt-0.5"></i>
            <div>
                <p class="text-sm font-medium text-blue-800 mb-1">32 Kategori Standar DDC (Informatika)</p>
                <div class="text-xs text-blue-700">
                    <p>Kategori standar sudah ditetapkan. Klik "Sync Kategori Standar" untuk memuat ulang 32 kategori.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden card-hover">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kode DDC</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Jumlah Data Training</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-kategori" class="divide-y divide-gray-200 text-sm">
                    <!-- Data akan diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH/EDIT KATEGORI -->
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
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode DDC <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="inputKodeDDC" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Contoh: 004.0288, 005.1, 006.6">
                    <p class="text-xs text-gray-500 mt-1">Format: 3 digit utama (004-999) diikuti titik dan maksimal 3 digit</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="inputNamaKategori" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Masukkan nama kategori">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi (Opsional)
                    </label>
                    <textarea id="inputDeskripsiKategori" rows="3"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Deskripsi singkat tentang kategori"></textarea>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <button onclick="tutupModalKategori()" 
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    Batal
                </button>
                <button onclick="simpanKategori()" 
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition flex items-center">
                    <i data-feather="save" class="w-4 h-4 mr-2"></i>
                    Simpan Kategori
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ===============================
// VARIABEL GLOBAL
// ===============================
let kategoriSedangDiedit = null;

// ===============================
// FUNGSI UTAMA: LOAD DATA
// ===============================
function loadDataKategori() {
    console.log("🔄 Memuat data kategori...");
    
    // 1. Load kategori dari localStorage
    const savedKategori = localStorage.getItem('kategoriDDC');
    if (savedKategori) {
        try {
            window.kategoriDDC = JSON.parse(savedKategori);
            console.log("✅ Kategori loaded:", window.kategoriDDC.length, "items");
        } catch (e) {
            console.error("❌ Error parsing kategori:", e);
            window.kategoriDDC = [];
        }
    } else {
        console.log("ℹ️ Tidak ada data kategori di localStorage");
        window.kategoriDDC = [];
    }
    
    // 2. Load data training dari localStorage
    const savedTraining = localStorage.getItem('dataTraining');
    if (savedTraining) {
        try {
            window.dataTraining = JSON.parse(savedTraining);
            console.log("✅ Data training loaded:", window.dataTraining.length, "items");
        } catch (e) {
            console.error("❌ Error parsing data training:", e);
            window.dataTraining = [];
        }
    } else {
        window.dataTraining = [];
    }
    
    // 3. Update statistik
    updateStatistikKategori();
    
    return window.kategoriDDC;
}

// ===============================
// FUNGSI RENDER TABEL
// ===============================
function renderTabelKategori() {
    console.log("📋 Rendering tabel kategori...");
    
    const tbody = document.getElementById("tabel-kategori");
    if (!tbody) {
        console.error("❌ Element tabel-kategori tidak ditemukan!");
        return;
    }

    // Pastikan data sudah dimuat
    if (!window.kategoriDDC) {
        loadDataKategori();
    }

    // Clear tabel
    tbody.innerHTML = "";

    // Cek apakah ada data
    if (!window.kategoriDDC || window.kategoriDDC.length === 0) {
        console.log("ℹ️ Tidak ada data kategori, tampilkan pesan kosong");
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="p-8 text-center text-gray-400">
                    <div class="flex flex-col items-center">
                        <i data-feather="layers" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                        <p class="text-lg font-medium text-gray-500 mb-2">Belum ada kategori</p>
                        <p class="text-sm text-gray-400 mb-4">Mulai dengan menambahkan kategori atau memuat kategori standar</p>
                        <div class="flex gap-3">
                            <button onclick="bukaModalTambahKategori()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition">
                                <i data-feather="plus" class="mr-2 w-4 h-4"></i> Tambah Kategori
                            </button>
                            <button onclick="window.syncKategori()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition">
                                <i data-feather="refresh-cw" class="mr-2 w-4 h-4"></i> Load 32 Kategori Standar
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        `;
        feather.replace();
        return;
    }

    console.log(`✅ Render ${window.kategoriDDC.length} kategori`);

    // Hitung jumlah data training per kategori
    const jumlahDataTraining = {};
    if (window.dataTraining && window.dataTraining.length > 0) {
        window.dataTraining.forEach((item) => {
            if (item.kategori) {
                const kode = item.kategori.split("|")[0];
                if (kode) {
                    jumlahDataTraining[kode] = (jumlahDataTraining[kode] || 0) + 1;
                }
            }
        });
    }

    // Generate HTML untuk setiap kategori
    let html = "";
    window.kategoriDDC.forEach((kategori, index) => {
        const jumlah = jumlahDataTraining[kategori.kode] || 0;
        const isUsed = jumlah > 0;
        
        // Warna dan status
        const warnaStatus = isUsed 
            ? "bg-green-100 text-green-800 border-green-200" 
            : "bg-gray-100 text-gray-600 border-gray-200";
        const teksStatus = isUsed ? "Terpakai" : "Kosong";
        
        // Icon status
        const iconStatus = isUsed ? 
            '<i data-feather="check-circle" class="w-3 h-3 mr-1"></i>' : 
            '<i data-feather="circle" class="w-3 h-3 mr-1"></i>';

        html += `
            <tr class="hover:bg-gray-50 transition-colors" data-kode="${kategori.kode}">
                <td class="px-6 py-4 text-gray-700 font-medium">${index + 1}</td>
                <td class="px-6 py-4">
                    <code class="font-mono font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded border border-blue-100">
                        ${kategori.kode}
                    </code>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">${kategori.nama}</div>
                    ${kategori.deskripsi ? 
                        `<p class="text-xs text-gray-500 mt-1">${kategori.deskripsi.substring(0, 80)}${kategori.deskripsi.length > 80 ? '...' : ''}</p>` : 
                        ''
                    }
                    ${isUsed ? 
                        `<p class="text-xs text-gray-500 mt-1">
                            Digunakan dalam ${jumlah} data training
                        </p>` : 
                        ""
                    }
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                        ${isUsed ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-500"} 
                        font-bold text-sm">
                        ${jumlah}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border ${warnaStatus}">
                        ${iconStatus}
                        ${teksStatus}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editKategori('${kategori.kode}')" 
                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition" 
                                title="Edit">
                            <i data-feather="edit" class="w-4 h-4"></i>
                        </button>
                        <button onclick="hapusKategori('${kategori.kode}')" 
                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition 
                                       ${isUsed ? "opacity-50 cursor-not-allowed" : ""}" 
                                title="Hapus" 
                                ${isUsed ? "disabled" : ""}>
                            <i data-feather="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
    
    // Update feather icons di dalam tabel
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    console.log("✅ Tabel kategori berhasil dirender");
}

// ===============================
// FUNGSI UPDATE STATISTIK
// ===============================
function updateStatistikKategori() {
    console.log("📈 Memperbarui statistik...");
    
    const totalKategoriDisplay = document.getElementById("total-kategori-display");
    const activeCategories = document.getElementById("active-categories");
    const totalDataTraining = document.getElementById("total-data-training");
    
    if (totalKategoriDisplay) {
        totalKategoriDisplay.textContent = window.kategoriDDC ? window.kategoriDDC.length : 0;
    }
    
    // Hitung kategori yang terpakai (punya data training)
    if (activeCategories) {
        const usedCategories = new Set();
        if (window.dataTraining && window.dataTraining.length > 0) {
            window.dataTraining.forEach(item => {
                if (item.kategori) {
                    const kode = item.kategori.split('|')[0];
                    if (kode) {
                        usedCategories.add(kode);
                    }
                }
            });
        }
        activeCategories.textContent = usedCategories.size;
    }
    
    if (totalDataTraining) {
        totalDataTraining.textContent = window.dataTraining ? window.dataTraining.length : 0;
    }
}

// ===============================
// FUNGSI SYNC 32 KATEGORI STANDAR
// ===============================
window.syncKategori = function() {
    Swal.fire({
        title: 'Sync Kategori Standar?',
        html: `Anda akan memuat <b>32 kategori standar DDC</b> untuk bidang Informatika.<br><br>
               <small class="text-gray-500">Data kategori yang ada akan diganti dengan data standar.</small>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Sync Sekarang!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            syncKategoriStandar();
        }
    });
};

function syncKategoriStandar() {
    // Data 32 kategori DDC Informatika lengkap
    const kategoriStandarDDC = [
        { kode: "004.0288", nama: "Perawatan, Perakitan & Servis Komputer" },
        { kode: "004.03", nama: "Kamus & Ensiklopedia Komputer" },
        { kode: "004.2", nama: "Arsitektur & Analisis Sistem" },
        { kode: "004.42", nama: "Dasar Pemrograman (General)" },
        { kode: "004.6", nama: "Jaringan Komputer & Komunikasi Data" },
        { kode: "004.65", nama: "Administrasi Jaringan & Routing" },
        { kode: "004.678", nama: "Internet & Aplikasi Online" },
        { kode: "004.71", nama: "Periferal Komputer & Grafik" },
        { kode: "005.1", nama: "Algoritma, Rekayasa Perangkat Lunak" },
        { kode: "005.11", nama: "Struktur Data" },
        { kode: "005.117", nama: "Pemrograman Berorientasi Objek (OOP)" },
        { kode: "005.118", nama: "Pemrograman Visual & Computer Vision" },
        { kode: "005.12", nama: "Pemrograman Model Matematika (Matlab)" },
        { kode: "005.13", nama: "Bahasa Pemrograman Spesifik (Ruby, dll)" },
        { kode: "005.133", nama: "Bahasa C, C++, C#" },
        { kode: "005.262", nama: "Pemrograman Web/Desktop Framework" },
        { kode: "005.276", nama: "Aplikasi Pemrograman Lanjut" },
        { kode: "005.3", nama: "Program Aplikasi Umum & Grafis" },
        { kode: "005.34", nama: "Aplikasi Keamanan & Utilitas OS" },
        { kode: "005.36", nama: "Aplikasi Perkantoran: Konsep" },
        { kode: "005.368", nama: "Microsoft Office (Lanjut) & Utilitas Windows" },
        { kode: "005.369", nama: "Aplikasi Desain & Lain-lain (Office)" },
        { kode: "005.43", nama: "OS Spesifik (Windows, Linux)" },
        { kode: "005.478", nama: "Pelaporan & Analisis Data (Excel Lanjut)" },
        { kode: "005.5", nama: "Aplikasi Serba Guna & Kolaborasi" },
        { kode: "005.55", nama: "Aplikasi Statistik dan Analisis Data" },
        { kode: "005.74", nama: "Sistem Manajemen Basis Data (DBMS) & SQL" },
        { kode: "005.8", nama: "Keamanan Data, Jaringan & Hacking" },
        { kode: "005.82", nama: "Kriptografi" },
        { kode: "005.913", nama: "Pemodelan Berorientasi Objek & Desain" },
        { kode: "006.22", nama: "Sistem Tertanam & Mikrokontroler" },
        { kode: "006.6", nama: "Grafika Komputer & Desain Multimedia" }
    ];

    console.log("🔄 Memuat 32 kategori standar DDC...");

    // Simpan ke variabel global
    window.kategoriDDC = kategoriStandarDDC;
    
    // Simpan ke localStorage
    localStorage.setItem('kategoriDDC', JSON.stringify(kategoriStandarDDC));
    
    console.log("✅ 32 kategori standar disimpan ke localStorage");

    // Render ulang tabel
    renderTabelKategori();
    
    // Tampilkan notifikasi sukses
    Swal.fire({
        icon: 'success',
        title: 'Sync Berhasil!',
        text: `32 kategori standar DDC telah dimuat.`,
        timer: 2000,
        showConfirmButton: false
    });
    
    // Update feather icons
    setTimeout(() => {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }, 100);
}

// ===============================
// FUNGSI MODAL TAMBAH/EDIT
// ===============================
function bukaModalTambahKategori() {
    // Reset form
    document.getElementById('inputKodeDDC').value = '';
    document.getElementById('inputNamaKategori').value = '';
    document.getElementById('inputDeskripsiKategori').value = '';
    
    // Set judul modal
    document.getElementById('modal-kategori-title').textContent = 'Tambah Kategori Baru';
    
    // Reset variabel edit
    kategoriSedangDiedit = null;
    
    // Tampilkan modal
    document.getElementById('modal-kategori').classList.remove('hidden');
    
    // Fokus ke input pertama
    setTimeout(() => {
        document.getElementById('inputKodeDDC').focus();
    }, 100);
}

function editKategori(kode) {
    // Cari kategori berdasarkan kode
    const kategori = window.kategoriDDC.find(k => k.kode === kode);
    if (!kategori) {
        showNotification('error', 'Kategori Tidak Ditemukan', `Kategori dengan kode ${kode} tidak ditemukan.`);
        return;
    }
    
    // Isi form dengan data kategori
    document.getElementById('inputKodeDDC').value = kategori.kode;
    document.getElementById('inputNamaKategori').value = kategori.nama;
    document.getElementById('inputDeskripsiKategori').value = kategori.deskripsi || '';
    
    // Set judul modal
    document.getElementById('modal-kategori-title').textContent = 'Edit Kategori';
    
    // Set variabel edit
    kategoriSedangDiedit = kode;
    
    // Tampilkan modal
    document.getElementById('modal-kategori').classList.remove('hidden');
    
    // Fokus ke input nama
    setTimeout(() => {
        document.getElementById('inputNamaKategori').focus();
    }, 100);
}

function tutupModalKategori() {
    document.getElementById('modal-kategori').classList.add('hidden');
}

// ===============================
// FUNGSI VALIDASI KODE DDC
// ===============================
function validasiKodeDDC(kode) {
    if (!kode) return false;
    
    // Format DDC yang valid: 3 digit utama (004-999) diikuti titik dan maksimal 3 digit
    // Contoh: 004.0288, 005.1, 005.12, 005.123, 006.6
    const regexDDC = /^\d{3}(\.\d{1,3})?$/;
    
    // Cek format
    if (!regexDDC.test(kode)) {
        return false;
    }
    
    // Ambil bagian utama (sebelum titik)
    const mainPart = kode.split('.')[0];
    const mainNum = parseInt(mainPart);
    
    // DDC biasanya dimulai dari 000 sampai 999, tapi untuk Informatika kita fokus di 004-006
    if (mainNum < 0 || mainNum > 999) {
        return false;
    }
    
    return true;
}

// ===============================
// FUNGSI SIMPAN KATEGORI
// ===============================
function simpanKategori() {
    const kode = document.getElementById('inputKodeDDC').value.trim();
    const nama = document.getElementById('inputNamaKategori').value.trim();
    const deskripsi = document.getElementById('inputDeskripsiKategori').value.trim();
    
    // Validasi
    if (!kode) {
        showNotification('error', 'Kode DDC Kosong', 'Harap masukkan kode DDC.');
        document.getElementById('inputKodeDDC').focus();
        return;
    }
    
    if (!nama) {
        showNotification('error', 'Nama Kategori Kosong', 'Harap masukkan nama kategori.');
        document.getElementById('inputNamaKategori').focus();
        return;
    }
    
    // Validasi format kode DDC
    if (!validasiKodeDDC(kode)) {
        showNotification('error', 'Format Kode DDC Tidak Valid', 
            'Format kode DDC harus:\n• 3 digit utama (contoh: 004, 005, 006)\n• Dapat diikuti titik dan 1-3 digit (contoh: 004.0288, 005.1, 006.6)');
        document.getElementById('inputKodeDDC').focus();
        return;
    }
    
    if (kategoriSedangDiedit === null) {
        // TAMBAH BARU
        
        // Cek duplikasi kode
        if (window.kategoriDDC.some(k => k.kode === kode)) {
            showNotification('error', 'Kode DDC Sudah Ada', `Kode DDC "${kode}" sudah digunakan. Harap gunakan kode lain.`);
            document.getElementById('inputKodeDDC').focus();
            return;
        }
        
        // Buat objek kategori baru
        const kategoriBaru = {
            kode: kode,
            nama: nama,
            deskripsi: deskripsi || null
        };
        
        // Tambahkan ke array
        window.kategoriDDC.push(kategoriBaru);
        
        // Simpan ke localStorage
        localStorage.setItem('kategoriDDC', JSON.stringify(window.kategoriDDC));
        
        // Tutup modal
        tutupModalKategori();
        
        // Render ulang tabel
        renderTabelKategori();
        
        // Notifikasi
        showNotification('success', 'Berhasil!', `Kategori "${nama}" berhasil ditambahkan.`);
        
    } else {
        // EDIT KATEGORI
        
        // Cari index kategori yang diedit
        const index = window.kategoriDDC.findIndex(k => k.kode === kategoriSedangDiedit);
        if (index === -1) {
            showNotification('error', 'Kategori Tidak Ditemukan', 'Kategori yang akan diedit tidak ditemukan.');
            return;
        }
        
        // Simpan kode lama untuk update data training
        const kodeLama = window.kategoriDDC[index].kode;
        
        // Update kategori
        window.kategoriDDC[index] = {
            kode: kode,
            nama: nama,
            deskripsi: deskripsi || null
        };
        
        // Jika kode berubah, update data training yang terkait
        if (kodeLama !== kode) {
            updateKodePadaDataTraining(kodeLama, kode, nama);
        }
        
        // Simpan ke localStorage
        localStorage.setItem('kategoriDDC', JSON.stringify(window.kategoriDDC));
        
        // Tutup modal
        tutupModalKategori();
        
        // Render ulang tabel
        renderTabelKategori();
        
        // Notifikasi
        showNotification('success', 'Berhasil!', `Kategori "${nama}" berhasil diperbarui.`);
    }
    
    // Update statistik di halaman lain (jika ada)
    if (typeof window.updateStats === 'function') {
        window.updateStats();
    }
}

function updateKodePadaDataTraining(kodeLama, kodeBaru, namaBaru) {
    let updated = false;
    window.dataTraining = window.dataTraining.map((item) => {
        if (item.kategori && item.kategori.startsWith(kodeLama + "|")) {
            updated = true;
            return {
                ...item,
                kategori: `${kodeBaru}|${namaBaru}`,
            };
        }
        return item;
    });

    if (updated) {
        localStorage.setItem("dataTraining", JSON.stringify(window.dataTraining));
        console.log(`🔄 Updated data training: ${kodeLama} -> ${kodeBaru}`);
    }
}

// ===============================
// FUNGSI HAPUS KATEGORI
// ===============================
function hapusKategori(kode) {
    // Cari kategori
    const kategori = window.kategoriDDC.find(k => k.kode === kode);
    if (!kategori) return;
    
    // Cek apakah kategori digunakan dalam data training
    let isUsed = false;
    let jumlahPenggunaan = 0;
    
    if (window.dataTraining && window.dataTraining.length > 0) {
        window.dataTraining.forEach((item) => {
            if (item.kategori && item.kategori.startsWith(kode + "|")) {
                isUsed = true;
                jumlahPenggunaan++;
            }
        });
    }
    
    if (isUsed) {
        Swal.fire({
            icon: 'error',
            title: 'Tidak Dapat Dihapus',
            html: `Kategori <b>${kode} - ${kategori.nama}</b> sedang digunakan dalam <b>${jumlahPenggunaan}</b> data training.<br><br>
                   <small class="text-gray-500">Hapus atau ubah data training terlebih dahulu sebelum menghapus kategori ini.</small>`,
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // Konfirmasi hapus
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Anda akan menghapus kategori:<br>
               <b>${kode} - ${kategori.nama}</b><br><br>
               <small class="text-gray-500">Tindakan ini tidak dapat dibatalkan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Hapus dari array
            window.kategoriDDC = window.kategoriDDC.filter(k => k.kode !== kode);
            
            // Simpan ke localStorage
            localStorage.setItem('kategoriDDC', JSON.stringify(window.kategoriDDC));
            
            // Render ulang tabel
            renderTabelKategori();
            
            // Notifikasi
            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: `Kategori "${kode}" berhasil dihapus.`,
                timer: 2000,
                showConfirmButton: false
            });
            
            // Update statistik di halaman lain (jika ada)
            if (typeof window.updateStats === 'function') {
                window.updateStats();
            }
        }
    });
}

// ===============================
// FUNGSI EXPORT KATEGORI
// ===============================
window.exportKategori = function() {
    if (!window.kategoriDDC || window.kategoriDDC.length === 0) {
        showNotification('warning', 'Data Kosong', 'Tidak ada data kategori untuk diekspor.');
        return;
    }
    
    try {
        // Buat data untuk export
        const exportData = window.kategoriDDC.map((kategori, index) => ({
            No: index + 1,
            Kode_DDC: kategori.kode,
            Nama_Kategori: kategori.nama,
            Deskripsi: kategori.deskripsi || '',
            Jumlah_Data_Training: hitungDataTrainingPerKategori(kategori.kode)
        }));
        
        // Convert ke JSON
        const dataStr = JSON.stringify({
            timestamp: new Date().toISOString(),
            total_kategori: window.kategoriDDC.length,
            data_kategori: exportData
        }, null, 2);
        
        // Buat blob dan download
        const blob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        
        const link = document.createElement('a');
        link.href = url;
        const date = new Date().toISOString().split('T')[0];
        link.download = `kategori-ddc-${date}.json`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
        
        showNotification('success', 'Export Berhasil', `File JSON dengan ${window.kategoriDDC.length} kategori telah diunduh.`);
        
    } catch (error) {
        console.error("Export error:", error);
        showNotification('error', 'Export Gagal', 'Terjadi kesalahan saat mengekspor data.');
    }
};

function hitungDataTrainingPerKategori(kode) {
    if (!window.dataTraining || window.dataTraining.length === 0) return 0;
    
    return window.dataTraining.filter(item => {
        if (!item.kategori) return false;
        const itemKode = item.kategori.split('|')[0];
        return itemKode === kode;
    }).length;
}

// ===============================
// FUNGSI IMPORT KATEGORI
// ===============================
window.importKategori = function() {
    // Buat input file
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.json';
    input.style.display = 'none';
    
    input.onchange = function(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            try {
                const importedData = JSON.parse(e.target.result);
                
                // Validasi format
                if (!importedData.data_kategori || !Array.isArray(importedData.data_kategori)) {
                    throw new Error("Format file tidak valid. Harus berisi array data_kategori.");
                }
                
                // Konfirmasi import
                Swal.fire({
                    title: 'Import Kategori?',
                    html: `File berisi <b>${importedData.data_kategori.length}</b> kategori.<br><br>
                           <small class="text-gray-500">Data kategori yang ada akan diganti dengan data dari file.</small>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Import!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ekstrak data kategori dari struktur import
                        const kategoriImpor = importedData.data_kategori.map(item => ({
                            kode: item.Kode_DDC || item.kode,
                            nama: item.Nama_Kategori || item.nama,
                            deskripsi: item.Deskripsi || item.deskripsi || null
                        })).filter(item => item.kode && item.nama);
                        
                        if (kategoriImpor.length === 0) {
                            showNotification('error', 'Import Gagal', 'Tidak ada data valid dalam file.');
                            return;
                        }
                        
                        // Simpan data
                        window.kategoriDDC = kategoriImpor;
                        localStorage.setItem('kategoriDDC', JSON.stringify(window.kategoriDDC));
                        
                        // Render ulang
                        renderTabelKategori();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Import Berhasil!',
                            text: `${kategoriImpor.length} kategori telah diimport.`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
                
            } catch (error) {
                console.error("Import error:", error);
                showNotification('error', 'Import Gagal', 'Format file tidak valid atau rusak.');
            }
        };
        
        reader.readAsText(file);
    };
    
    document.body.appendChild(input);
    input.click();
    document.body.removeChild(input);
};

// ===============================
// FUNGSI NOTIFIKASI
// ===============================
function showNotification(type, title, message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type,
            title: title,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    } else {
        alert(`${title}\n${message}`);
    }
}

// ===============================
// INISIALISASI SAAT HALAMAN DIMUAT
// ===============================
document.addEventListener("DOMContentLoaded", function() {
    console.log("🚀 Halaman kategori DDC dimuat");
    
    // Load data dari localStorage
    loadDataKategori();
    
    // Render tabel kategori
    renderTabelKategori();
    
    // Update feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Tambahkan event listener untuk escape key pada modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('modal-kategori').classList.contains('hidden')) {
            tutupModalKategori();
        }
    });
    
    console.log("✅ Inisialisasi halaman kategori selesai");
});

// ===============================
// EKSPOR FUNGSI KE GLOBAL SCOPE
// ===============================
window.renderTabelKategori = renderTabelKategori;
window.updateStatistikKategori = updateStatistikKategori;
</script>