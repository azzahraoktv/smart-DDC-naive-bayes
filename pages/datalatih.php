<!-- Tambahkan SheetJS di HEADER (pastikan sudah ada di index.php) -->
<!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script> -->

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
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori</label>
            <select id="filterCategory"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
                <option value="">Semua Kategori</option>
                <!-- Kategori akan diisi oleh JavaScript -->
            </select>
        </div>
        <div class="self-end">
            <button id="btnResetFilter" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <i data-feather="filter" class="w-4 h-4 mr-1"></i> Reset Filter
            </button>
        </div>
    </div>
    
    <div class="mb-6 flex flex-wrap gap-2 md:gap-3">
        <button onclick="importDataTraining()" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition-all duration-300 card-hover">
            <i data-feather="upload" class="mr-2 w-4 h-4"></i> Impor Data
        </button>
        <button onclick="exportDataTraining()" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition-all duration-300 card-hover">
            <i data-feather="download" class="mr-2 w-4 h-4"></i> Ekspor Data
        </button>
        <button onclick="openModalDataTraining()" class="btn-primary text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm card-hover">
            <i data-feather="plus" class="mr-2 w-4 h-4"></i> Tambah Manual
        </button>
        
        <button id="btnDeleteSelectedTraining" onclick="hapusDataTerpilihTraining()" class="btn-danger px-4 py-2 rounded-lg text-sm font-bold shadow-sm flex items-center transition" style="display:none;">
            <i data-feather="trash-2" class="mr-2 w-4 h-4"></i> Hapus Data Terpilih
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden card-hover fade-in">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-4 text-center">
                            <input type="checkbox" id="selectAllTraining" onclick="toggleSelectAllTraining(this)" class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Judul Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kode DDC</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-datalatih" class="divide-y divide-gray-200 text-sm">
                    <!-- Data akan diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH/EDIT DATA TRAINING -->
<div id="modal-data-training" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 animate-fade-in max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800" id="modal-data-training-title">Tambah Data Training Baru</h3>
                <button onclick="tutupModalDataTraining()" class="text-gray-400 hover:text-gray-600">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Judul Buku <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="inputJudulBuku" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Masukkan judul buku lengkap">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Buku <span class="text-red-500">*</span>
                    </label>
                    <textarea id="inputDeskripsiBuku" rows="4"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Masukkan deskripsi atau sinopsis buku"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori DDC <span class="text-red-500">*</span>
                    </label>
                    <select id="selectKategoriDDC"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori DDC</option>
                        <!-- Kategori akan diisi oleh JavaScript -->
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pastikan kategori sudah tersedia. Jika belum, tambah dulu di halaman Kategori.</p>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <button onclick="tutupModalDataTraining()" 
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    Batal
                </button>
                <button onclick="simpanDataTraining()" 
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition flex items-center">
                    <i data-feather="save" class="w-4 h-4 mr-2"></i>
                    Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ===============================
// KODE UTAMA DATA TRAINING - SEMUA FUNGSI BERJALAN
// ===============================

// ===============================
// 1. VARIABEL GLOBAL
// ===============================
let dataTrainingSedangDiedit = null;

// ===============================
// 2. FUNGSI UTAMA: LOAD DATA KE TABEL
// ===============================
function loadDataToTable() {
    console.log("📚 Memuat data training ke tabel...");
    
    const tbody = document.getElementById("tabel-datalatih");
    if (!tbody) {
        console.error("❌ Element tabel-datalatih tidak ditemukan!");
        return;
    }

    // Pastikan dataTraining ada
    if (!window.dataTraining) {
        const stored = localStorage.getItem('dataTraining');
        window.dataTraining = stored ? JSON.parse(stored) : [];
    }

    // Update statistik
    updateStatisticsForDataTraining();

    // Filter data berdasarkan pencarian dan kategori
    const filteredData = filterDataTraining();

    if (filteredData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="p-8 text-center text-gray-400">
                    <div class="flex flex-col items-center">
                        <i data-feather="book-open" class="w-12 h-12 mb-3 text-gray-300"></i>
                        <p class="text-lg font-medium text-gray-500 mb-2">${window.dataTraining.length === 0 ? 'Belum ada data training.' : 'Data tidak ditemukan'}</p>
                        <p class="text-sm text-gray-400 mb-4">${window.dataTraining.length === 0 ? 'Klik "Tambah Manual" untuk menambahkan data pertama' : 'Coba ubah kata kunci pencarian atau filter kategori'}</p>
                        ${window.dataTraining.length === 0 ? '' : 
                            `<button onclick="resetFilterDataTraining()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-sm transition">
                                <i data-feather="filter" class="mr-2 w-4 h-4"></i> Reset Filter
                            </button>`
                        }
                    </div>
                </td>
            </tr>
        `;
        feather.replace();
        return;
    }

    console.log(`✅ Render ${filteredData.length} data training`);

    // Generate HTML untuk setiap data training
    let html = "";
    filteredData.forEach((item, index) => {
        let code = "", name = "";
        
        // Parse kategori
        if (item.kategori && item.kategori.includes("|")) {
            [code, name] = item.kategori.split("|");
        } else {
            code = item.kategori || "";
            name = getNamaKategoriByKode(code);
        }

        // Warna badge berdasarkan kode
        const badgeColor = getCategoryColorForBadge(code);

        // Escape karakter untuk mencegah error
        const judulSafe = item.judul ? item.judul.replace(/'/g, "\\'") : "";
        const deskripsiSafe = item.deskripsi ? item.deskripsi.substring(0, 100).replace(/'/g, "\\'") : "";

        html += `
            <tr class="hover:bg-gray-50 transition-colors fade-in" data-id="${item.id || index}">
                <td class="px-4 py-4 text-center">
                    <input type="checkbox" name="selectedTrainingItems" value="${item.id || index}" 
                           onclick="checkIfAnySelectedTraining()"
                           class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500 cursor-pointer">
                </td>
                <td class="px-6 py-4 text-gray-700 font-medium">${index + 1}</td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">${judulSafe}</div>
                    ${item.deskripsi ? 
                        `<div class="text-xs text-gray-500 mt-1 truncate max-w-xs">${deskripsiSafe}${item.deskripsi.length > 100 ? '...' : ''}</div>` : 
                        ''
                    }
                    <div class="text-xs text-gray-400 mt-1 flex items-center">
                        <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                        ${formatDate(item.tanggalDitambah || item.tanggal || new Date().toISOString())}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <code class="font-mono text-sm font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded border border-blue-100">
                        ${code}
                    </code>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border ${badgeColor}">
                        ${name || 'Tanpa Kategori'}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editDataTraining('${item.id || index}')" 
                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition" 
                                title="Edit">
                            <i data-feather="edit" class="w-4 h-4"></i>
                        </button>
                        <button onclick="hapusDataTraining('${item.id || index}')" 
                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition" 
                                title="Hapus">
                            <i data-feather="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
    
    // Update feather icons
    feather.replace();

    // Reset select all
    const selectAll = document.getElementById("selectAllTraining");
    if (selectAll) selectAll.checked = false;
    
    // Cek selected items
    checkIfAnySelectedTraining();
}

function filterDataTraining() {
    const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const filterCategory = document.getElementById('filterCategory')?.value || '';
    
    return window.dataTraining.filter(item => {
        // Filter berdasarkan pencarian
        const matchSearch = !searchTerm || 
            (item.judul && item.judul.toLowerCase().includes(searchTerm)) ||
            (item.deskripsi && item.deskripsi.toLowerCase().includes(searchTerm));
        
        // Filter berdasarkan kategori
        let itemKode = '';
        if (item.kategori && item.kategori.includes('|')) {
            itemKode = item.kategori.split('|')[0];
        } else {
            itemKode = item.kategori || '';
        }
        
        const matchCategory = !filterCategory || itemKode === filterCategory;
        
        return matchSearch && matchCategory;
    });
}

// ===============================
// 3. FUNGSI UPDATE STATISTIK
// ===============================
function updateStatisticsForDataTraining() {
    console.log("📊 Memperbarui statistik data training...");
    
    const totalDataEl = document.getElementById("totalData");
    const totalCategoriesEl = document.getElementById("totalCategories");
    const dataCountEl = document.getElementById("data-count");
    const lastUpdateEl = document.getElementById("lastUpdate");

    if (totalDataEl) totalDataEl.textContent = window.dataTraining ? window.dataTraining.length : 0;

    // Hitung kategori unik
    const uniqueCategories = new Set();
    if (window.dataTraining) {
        window.dataTraining.forEach(item => {
            if (item.kategori) {
                const kode = item.kategori.includes('|') ? item.kategori.split('|')[0] : item.kategori;
                if (kode) uniqueCategories.add(kode);
            }
        });
    }
    
    if (totalCategoriesEl) totalCategoriesEl.textContent = uniqueCategories.size;

    if (dataCountEl) {
        dataCountEl.textContent = `${window.dataTraining ? window.dataTraining.length : 0} data training tersimpan`;
    }

    if (lastUpdateEl) {
        if (window.dataTraining && window.dataTraining.length > 0) {
            // Cari tanggal terbaru
            let latestDate = null;
            window.dataTraining.forEach(item => {
                const itemDate = new Date(item.tanggalDitambah || item.tanggal || item.createdAt);
                if (!latestDate || itemDate > latestDate) {
                    latestDate = itemDate;
                }
            });
            
            if (latestDate) {
                lastUpdateEl.textContent = latestDate.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            } else {
                lastUpdateEl.textContent = '-';
            }
        } else {
            lastUpdateEl.textContent = '-';
        }
    }
}

// ===============================
// 4. FUNGSI POPULASI FILTER KATEGORI
// ===============================
function populateFilterCategory() {
    const filterSelect = document.getElementById("filterCategory");
    if (!filterSelect) return;

    // Hapus opsi selain "Semua Kategori"
    while (filterSelect.options.length > 1) {
        filterSelect.remove(1);
    }

    // Ambil kategori dari localStorage
    const storedKategori = localStorage.getItem('kategoriDDC');
    const kategoriList = storedKategori ? JSON.parse(storedKategori) : [];

    // Tambahkan opsi kategori
    kategoriList.forEach(kategori => {
        const option = document.createElement("option");
        option.value = kategori.kode;
        option.textContent = `${kategori.kode} - ${kategori.nama}`;
        filterSelect.appendChild(option);
    });
}

// ===============================
// 5. FUNGSI POPULASI SELECT KATEGORI DI MODAL
// ===============================
function populateKategoriSelect() {
    const select = document.getElementById("selectKategoriDDC");
    if (!select) return;

    // Hapus semua opsi kecuali yang pertama
    while (select.options.length > 1) {
        select.remove(1);
    }

    // Ambil kategori dari localStorage
    const storedKategori = localStorage.getItem('kategoriDDC');
    const kategoriList = storedKategori ? JSON.parse(storedKategori) : [];

    // Tambahkan opsi kategori
    kategoriList.forEach(kategori => {
        const option = document.createElement("option");
        option.value = `${kategori.kode}|${kategori.nama}`;
        option.textContent = `${kategori.kode} - ${kategori.nama}`;
        select.appendChild(option);
    });
}

// ===============================
// 6. FUNGSI MODAL TAMBAH/EDIT DATA TRAINING
// ===============================
function openModalDataTraining(dataId = null) {
    // Populasi select kategori
    populateKategoriSelect();
    
    if (dataId === null) {
        // Mode tambah baru
        document.getElementById('modal-data-training-title').textContent = 'Tambah Data Training Baru';
        
        // Reset form
        document.getElementById('inputJudulBuku').value = '';
        document.getElementById('inputDeskripsiBuku').value = '';
        document.getElementById('selectKategoriDDC').value = '';
        
        dataTrainingSedangDiedit = null;
    } else {
        // Mode edit
        document.getElementById('modal-data-training-title').textContent = 'Edit Data Training';
        
        // Cari data berdasarkan ID
        let dataIndex;
        if (typeof dataId === 'string' && dataId.includes('temp_')) {
            // ID sementara
            dataIndex = window.dataTraining.findIndex(item => item.id === dataId);
        } else {
            // Index numerik
            dataIndex = parseInt(dataId);
        }
        
        if (dataIndex === -1 || dataIndex >= window.dataTraining.length) {
            showNotification('error', 'Data Tidak Ditemukan', 'Data yang akan diedit tidak ditemukan.');
            return;
        }
        
        const data = window.dataTraining[dataIndex];
        
        // Isi form dengan data
        document.getElementById('inputJudulBuku').value = data.judul || '';
        document.getElementById('inputDeskripsiBuku').value = data.deskripsi || '';
        document.getElementById('selectKategoriDDC').value = data.kategori || '';
        
        dataTrainingSedangDiedit = dataIndex;
    }
    
    // Tampilkan modal
    document.getElementById('modal-data-training').classList.remove('hidden');
    
    // Fokus ke input pertama
    setTimeout(() => {
        document.getElementById('inputJudulBuku').focus();
    }, 100);
}

function tutupModalDataTraining() {
    document.getElementById('modal-data-training').classList.add('hidden');
}

// ===============================
// 7. FUNGSI SIMPAN DATA TRAINING
// ===============================
function simpanDataTraining() {
    const judul = document.getElementById('inputJudulBuku').value.trim();
    const deskripsi = document.getElementById('inputDeskripsiBuku').value.trim();
    const kategori = document.getElementById('selectKategoriDDC').value;

    // Validasi
    if (!judul) {
        showNotification('error', 'Judul Kosong', 'Harap masukkan judul buku.');
        document.getElementById('inputJudulBuku').focus();
        return;
    }

    if (!deskripsi) {
        showNotification('error', 'Deskripsi Kosong', 'Harap masukkan deskripsi buku.');
        document.getElementById('inputDeskripsiBuku').focus();
        return;
    }

    if (!kategori) {
        showNotification('error', 'Kategori Kosong', 'Harap pilih kategori DDC.');
        document.getElementById('selectKategoriDDC').focus();
        return;
    }

    // Buat objek data training
    const dataTraining = {
        id: dataTrainingSedangDiedit === null ? 'temp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9) : window.dataTraining[dataTrainingSedangDiedit].id,
        judul: judul,
        deskripsi: deskripsi,
        kategori: kategori,
        tanggalDitambah: dataTrainingSedangDiedit === null ? new Date().toISOString() : window.dataTraining[dataTrainingSedangDiedit].tanggalDitambah,
        tanggalDiupdate: new Date().toISOString()
    };

    if (dataTrainingSedangDiedit === null) {
        // Tambah data baru
        window.dataTraining.push(dataTraining);
        showNotification('success', 'Berhasil!', 'Data training berhasil ditambahkan.');
    } else {
        // Edit data existing
        window.dataTraining[dataTrainingSedangDiedit] = dataTraining;
        showNotification('success', 'Berhasil!', 'Data training berhasil diperbarui.');
    }

    // Simpan ke localStorage
    localStorage.setItem('dataTraining', JSON.stringify(window.dataTraining));

    // Tutup modal
    tutupModalDataTraining();

    // Render ulang tabel
    loadDataToTable();

    // Update model Naive Bayes
    if (typeof window.buildNaiveBayesModel === 'function') {
        window.naiveBayesModel = window.buildNaiveBayesModel(window.dataTraining);
        console.log('✅ Model Naive Bayes diperbarui');
    }

    // Update statistik di halaman lain
    if (typeof window.updateStats === 'function') {
        window.updateStats();
    }
}

// ===============================
// 8. FUNGSI EDIT DATA TRAINING
// ===============================
function editDataTraining(dataId) {
    openModalDataTraining(dataId);
}

// ===============================
// 9. FUNGSI HAPUS DATA TRAINING
// ===============================
function hapusDataTraining(dataId) {
    // Cari data berdasarkan ID
    let dataIndex;
    if (typeof dataId === 'string' && dataId.includes('temp_')) {
        // ID sementara
        dataIndex = window.dataTraining.findIndex(item => item.id === dataId);
    } else {
        // Index numerik
        dataIndex = parseInt(dataId);
    }
    
    if (dataIndex === -1 || dataIndex >= window.dataTraining.length) {
        showNotification('error', 'Data Tidak Ditemukan', 'Data yang akan dihapus tidak ditemukan.');
        return;
    }
    
    const data = window.dataTraining[dataIndex];
    
    // Konfirmasi hapus
    Swal.fire({
        title: 'Hapus Data Training?',
        html: `Anda akan menghapus data training:<br>
               <b>"${data.judul}"</b><br><br>
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
            window.dataTraining.splice(dataIndex, 1);
            
            // Simpan ke localStorage
            localStorage.setItem('dataTraining', JSON.stringify(window.dataTraining));
            
            // Render ulang tabel
            loadDataToTable();
            
            // Update model Naive Bayes
            if (typeof window.buildNaiveBayesModel === 'function') {
                window.naiveBayesModel = window.buildNaiveBayesModel(window.dataTraining);
                console.log('✅ Model Naive Bayes diperbarui');
            }
            
            // Notifikasi
            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: 'Data training berhasil dihapus.',
                timer: 2000,
                showConfirmButton: false
            });
            
            // Update statistik di halaman lain
            if (typeof window.updateStats === 'function') {
                window.updateStats();
            }
        }
    });
}

// ===============================
// 10. FUNGSI HAPUS DATA TERPILIH
// ===============================
function hapusDataTerpilihTraining() {
    const checkboxes = document.querySelectorAll('input[name="selectedTrainingItems"]:checked');
    if (checkboxes.length === 0) {
        showNotification('warning', 'Tidak Ada Data Terpilih', 'Pilih data yang akan dihapus terlebih dahulu.');
        return;
    }

    Swal.fire({
        title: 'Hapus Data Terpilih?',
        html: `Anda akan menghapus <b>${checkboxes.length}</b> data training.<br><br>
               <small class="text-gray-500">Tindakan ini tidak dapat dibatalkan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kumpulkan ID yang akan dihapus
            const idsToDelete = [];
            checkboxes.forEach(cb => {
                idsToDelete.push(cb.value);
            });

            // Hapus dari array (dari belakang ke depan agar index tidak bergeser)
            let deletedCount = 0;
            for (let i = window.dataTraining.length - 1; i >= 0; i--) {
                const dataId = window.dataTraining[i].id || i.toString();
                if (idsToDelete.includes(dataId.toString())) {
                    window.dataTraining.splice(i, 1);
                    deletedCount++;
                }
            }

            // Simpan ke localStorage
            localStorage.setItem('dataTraining', JSON.stringify(window.dataTraining));

            // Render ulang tabel
            loadDataToTable();

            // Update model Naive Bayes
            if (typeof window.buildNaiveBayesModel === 'function') {
                window.naiveBayesModel = window.buildNaiveBayesModel(window.dataTraining);
                console.log('✅ Model Naive Bayes diperbarui');
            }

            // Notifikasi
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: `${deletedCount} data training berhasil dihapus.`,
                timer: 2000,
                showConfirmButton: false
            });

            // Update statistik di halaman lain
            if (typeof window.updateStats === 'function') {
                window.updateStats();
            }
        }
    });
}

// ===============================
// 11. FUNGSI SELECT ALL
// ===============================
function toggleSelectAllTraining(checkbox) {
    const checkboxes = document.querySelectorAll('input[name="selectedTrainingItems"]');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    checkIfAnySelectedTraining();
}

function checkIfAnySelectedTraining() {
    const checkboxes = document.querySelectorAll('input[name="selectedTrainingItems"]:checked');
    const deleteBtn = document.getElementById('btnDeleteSelectedTraining');
    
    if (deleteBtn) {
        if (checkboxes.length > 0) {
            deleteBtn.style.display = 'flex';
            deleteBtn.innerHTML = `<i data-feather="trash-2" class="mr-2 w-4 h-4"></i> Hapus ${checkboxes.length} Data Terpilih`;
            feather.replace();
        } else {
            deleteBtn.style.display = 'none';
        }
    }
}

// ===============================
// 12. FUNGSI EXPORT DATA TRAINING
// ===============================
function exportDataTraining() {
    if (!window.dataTraining || window.dataTraining.length === 0) {
        showNotification('warning', 'Data Kosong', 'Tidak ada data training untuk diekspor.');
        return;
    }

    try {
        // Buat data untuk export
        const exportData = window.dataTraining.map((item, index) => {
            let code = "", name = "";
            if (item.kategori && item.kategori.includes("|")) {
                [code, name] = item.kategori.split("|");
            } else {
                code = item.kategori || "";
                name = getNamaKategoriByKode(code);
            }

            return {
                No: index + 1,
                Judul_Buku: item.judul,
                Deskripsi: item.deskripsi || '',
                Kode_DDC: code,
                Nama_Kategori: name,
                Tanggal_Ditambah: formatDate(item.tanggalDitambah || item.tanggal),
                Tanggal_Diupdate: formatDate(item.tanggalDiupdate)
            };
        });

        // Convert ke JSON
        const dataStr = JSON.stringify({
            timestamp: new Date().toISOString(),
            total_data: window.dataTraining.length,
            data_training: exportData
        }, null, 2);

        // Buat blob dan download
        const blob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        const date = new Date().toISOString().split('T')[0];
        link.download = `data-training-${date}.json`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);

        showNotification('success', 'Export Berhasil', `File JSON dengan ${window.dataTraining.length} data training telah diunduh.`);

    } catch (error) {
        console.error("Export error:", error);
        showNotification('error', 'Export Gagal', 'Terjadi kesalahan saat mengekspor data.');
    }
}

// ===============================
// 13. FUNGSI IMPORT DATA TRAINING (EXCEL & JSON)
// ===============================
function importDataTraining() {
    // Buat input file
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.json,.xlsx,.xls,.csv';
    input.style.display = 'none';

    input.onchange = function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function(e) {
            try {
                if (file.name.endsWith('.json')) {
                    // Handle JSON
                    handleJsonImport(e.target.result);
                } else if (file.name.endsWith('.xlsx') || file.name.endsWith('.xls')) {
                    // Handle Excel
                    handleExcelImport(e.target.result, file);
                } else if (file.name.endsWith('.csv')) {
                    // Handle CSV
                    handleCsvImport(e.target.result, file);
                } else {
                    throw new Error("Format file tidak didukung. Gunakan format JSON, Excel, atau CSV.");
                }

            } catch (error) {
                console.error("Import error:", error);
                showNotification('error', 'Import Gagal', error.message || 'Format file tidak valid atau rusak.');
            }
        };

        if (file.name.endsWith('.json') || file.name.endsWith('.csv')) {
            reader.readAsText(file);
        } else {
            reader.readAsArrayBuffer(file);
        }
    };

    document.body.appendChild(input);
    input.click();
    document.body.removeChild(input);
}

// ===============================
// 14. HANDLE EXCEL IMPORT
// ===============================
function handleExcelImport(arrayBuffer, file) {
    try {
        // Pastikan XLSX tersedia
        if (typeof XLSX === 'undefined') {
            throw new Error("Library SheetJS (XLSX) tidak ditemukan. Pastikan script dimuat.");
        }
        
        // Baca workbook Excel
        const workbook = XLSX.read(arrayBuffer, { type: 'array' });
        
        // Ambil sheet pertama
        const firstSheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[firstSheetName];
        
        // Convert ke JSON
        const jsonData = XLSX.utils.sheet_to_json(worksheet);
        
        if (jsonData.length === 0) {
            showNotification('warning', 'File Kosong', 'File Excel tidak berisi data.');
            return;
        }

        console.log('📊 Data Excel ditemukan:', jsonData.length, 'baris');
        console.log('Struktur data:', jsonData[0]);

        // Proses data Excel
        processImportedData(jsonData, file.name);

    } catch (error) {
        console.error("Excel import error:", error);
        showNotification('error', 'Error Membaca Excel', 'Tidak dapat membaca file Excel. Pastikan format file benar.');
    }
}

// ===============================
// 15. HANDLE JSON IMPORT
// ===============================
function handleJsonImport(jsonString) {
    try {
        const importedData = JSON.parse(jsonString);
        
        if (!importedData.data_training && !importedData.data) {
            // Coba parse sebagai array langsung
            if (Array.isArray(importedData)) {
                processImportedData(importedData, 'JSON Array');
            } else {
                throw new Error("Format JSON tidak valid. Harus berisi 'data_training' atau array langsung.");
            }
        } else {
            const dataArray = importedData.data_training || importedData.data || [];
            processImportedData(dataArray, 'JSON File');
        }
    } catch (error) {
        throw new Error("Format JSON tidak valid: " + error.message);
    }
}

// ===============================
// 16. HANDLE CSV IMPORT
// ===============================
function handleCsvImport(csvString, file) {
    try {
        // Parse CSV sederhana
        const lines = csvString.split('\n');
        if (lines.length === 0) {
            throw new Error("File CSV kosong");
        }
        
        const headers = lines[0].split(',').map(h => h.trim());
        const jsonData = [];

        for (let i = 1; i < lines.length; i++) {
            if (lines[i].trim() === '') continue;
            
            const values = lines[i].split(',').map(v => v.trim());
            const row = {};
            
            headers.forEach((header, index) => {
                if (values[index] !== undefined) {
                    row[header] = values[index];
                }
            });
            
            jsonData.push(row);
        }

        if (jsonData.length === 0) {
            showNotification('warning', 'File CSV Kosong', 'File CSV tidak berisi data.');
            return;
        }

        processImportedData(jsonData, file.name);

    } catch (error) {
        throw new Error("Error parsing CSV: " + error.message);
    }
}

// ===============================
// 17. PROSES DATA IMPORT (SEDERHANA)
// ===============================
function processImportedData(dataArray, fileName) {
    // Validasi dan transformasi data
    const validData = [];
    const invalidData = [];

    console.log('🔄 Memproses', dataArray.length, 'data dari', fileName);

    dataArray.forEach((item, index) => {
        const rowNumber = index + 1;
        
        // Ambil judul dan kode DDC langsung
        const judul = item.Judul_Buku || item.judul;
        const kodeDDC = item.Kode_DDC || item.kode;
        
        // Validasi sederhana
        if (!judul || !kodeDDC) {
            invalidData.push(`Baris ${rowNumber}: Data tidak lengkap`);
            return;
        }

        // Cari kategori di database
        const kategoriObj = window.kategoriDDC ? window.kategoriDDC.find(k => k.kode === kodeDDC) : null;
        
        if (!kategoriObj) {
            invalidData.push(`Baris ${rowNumber}: Kode DDC "${kodeDDC}" tidak ditemukan`);
            return;
        }

        // Buat objek data training sederhana
        const dataTraining = {
            id: 'temp_' + Date.now() + '_' + index,
            judul: judul,
            deskripsi: judul, // Gunakan judul sebagai deskripsi
            kategori: `${kodeDDC}|${kategoriObj.nama}`,
            tanggalDitambah: new Date().toISOString(),
            tanggalDiupdate: new Date().toISOString()
        };

        validData.push(dataTraining);
    });

    if (validData.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Import Gagal',
            html: `Tidak ada data yang berhasil diimport.<br><br>
                   <b>Format Excel harus:</b><br>
                   • Kolom A: Judul_Buku<br>
                   • Kolom B: Kode_DDC<br><br>
                   Pastikan file Excel Anda sesuai format.`,
            confirmButtonText: 'OK'
        });
        return;
    }

    // Konfirmasi import sederhana
    Swal.fire({
        title: 'Import Data?',
        html: `Ditemukan <b>${validData.length}</b> data valid dari ${dataArray.length} baris.<br><br>
               ${invalidData.length > 0 ? `<small style="color: red;">${invalidData.length} data tidak valid diabaikan.</small><br>` : ''}
               <small style="color: gray;">Data akan ditambahkan ke database.</small>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Import',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Tambahkan data baru
            if (!window.dataTraining) window.dataTraining = [];
            window.dataTraining.push(...validData);
            
            // Simpan ke localStorage
            localStorage.setItem('dataTraining', JSON.stringify(window.dataTraining));
            
            // Render ulang tabel
            loadDataToTable();
            
            // Update model
            if (typeof window.buildNaiveBayesModel === 'function') {
                window.naiveBayesModel = window.buildNaiveBayesModel(window.dataTraining);
            }
            
            // Notifikasi sukses
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: `${validData.length} data training telah diimport.`,
                timer: 2000,
                showConfirmButton: false
            });
            
            // Update statistik
            if (typeof window.updateStats === 'function') {
                window.updateStats();
            }
        }
    });
}
// ===============================
// 18. FUNGSI HELPER
// ===============================
function getNamaKategoriByKode(kode) {
    if (!kode) return "Tanpa Kategori";
    
    if (!window.kategoriDDC || window.kategoriDDC.length === 0) {
        const storedKategori = localStorage.getItem('kategoriDDC');
        window.kategoriDDC = storedKategori ? JSON.parse(storedKategori) : [];
    }
    
    const kategori = window.kategoriDDC.find(k => k.kode === kode);
    return kategori ? kategori.nama : `Kode: ${kode}`;
}

function getCategoryColorForBadge(code) {
    if (!code) return "bg-gray-100 text-gray-600 border-gray-200";
    
    const colors = {
        '004': 'bg-blue-100 text-blue-800 border-blue-200',
        '005': 'bg-green-100 text-green-800 border-green-200',
        '006': 'bg-purple-100 text-purple-800 border-purple-200',
        'default': 'bg-gray-100 text-gray-600 border-gray-200'
    };
    
    const prefix = code.split('.')[0];
    return colors[prefix] || colors['default'];
}

function resetFilterDataTraining() {
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterCategory');
    
    if (searchInput) searchInput.value = '';
    if (filterSelect) filterSelect.value = '';
    
    loadDataToTable();
}

function formatDate(isoString) {
    try {
        const date = new Date(isoString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    } catch (error) {
        return 'Tanggal tidak valid';
    }
}

// ===============================
// 19. NOTIFIKASI HELPER
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
// 20. SETUP EVENT LISTENERS
// ===============================
function setupDataTrainingEventListeners() {
    // Search input
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(() => {
            loadDataToTable();
        }, 300));
    }
    
    // Filter category
    const filterSelect = document.getElementById('filterCategory');
    if (filterSelect) {
        filterSelect.addEventListener('change', () => {
            loadDataToTable();
        });
    }
    
    // Reset filter button
    const resetBtn = document.getElementById('btnResetFilter');
    if (resetBtn) {
        resetBtn.addEventListener('click', resetFilterDataTraining);
    }
    
    // Close modal dengan escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('modal-data-training').classList.contains('hidden')) {
            tutupModalDataTraining();
        }
    });
}

// ===============================
// 21. DEBOUNCE HELPER
// ===============================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ===============================
// 22. INISIALISASI SAAT HALAMAN DIMUAT
// ===============================
document.addEventListener("DOMContentLoaded", function() {
    console.log("📚 Halaman Data Training dimuat");
    
    // Inisialisasi variabel jika belum ada
    if (!window.dataTraining) {
        const stored = localStorage.getItem('dataTraining');
        window.dataTraining = stored ? JSON.parse(stored) : [];
        console.log('📂 Data training loaded:', window.dataTraining.length);
    }
    
    // Load kategori dari localStorage jika belum ada
    if (!window.kategoriDDC || window.kategoriDDC.length === 0) {
        const storedKategori = localStorage.getItem('kategoriDDC');
        if (storedKategori) {
            try {
                window.kategoriDDC = JSON.parse(storedKategori);
                console.log('📂 Kategori loaded:', window.kategoriDDC.length);
            } catch (e) {
                console.error('Error loading kategori:', e);
                window.kategoriDDC = [];
            }
        } else {
            window.kategoriDDC = [];
            console.log('ℹ️ Tidak ada kategori di localStorage');
        }
    }
    
    // Populasi filter kategori
    populateFilterCategory();
    
    // Setup event listeners
    setupDataTrainingEventListeners();
    
    // Load data ke tabel
    loadDataToTable();
    
    // Update feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    console.log("✅ Inisialisasi halaman data training selesai");
    
    // Debug info
    console.log('=== DEBUG INFO ===');
    console.log('Data Training:', window.dataTraining ? window.dataTraining.length : 0);
    console.log('Kategori DDC:', window.kategoriDDC ? window.kategoriDDC.length : 0);
});

// ===============================
// 23. EKSPOR FUNGSI KE GLOBAL SCOPE
// ===============================
window.loadDataToTable = loadDataToTable;
window.openModalDataTraining = openModalDataTraining;
window.tutupModalDataTraining = tutupModalDataTraining;
window.editDataTraining = editDataTraining;
window.hapusDataTraining = hapusDataTraining;
window.hapusDataTerpilihTraining = hapusDataTerpilihTraining;
window.toggleSelectAllTraining = toggleSelectAllTraining;
window.checkIfAnySelectedTraining = checkIfAnySelectedTraining;
window.exportDataTraining = exportDataTraining;
window.importDataTraining = importDataTraining;
window.resetFilterDataTraining = resetFilterDataTraining;
window.updateStatisticsForDataTraining = updateStatisticsForDataTraining;
window.populateFilterCategory = populateFilterCategory;
window.populateKategoriSelect = populateKategoriSelect;
</script>