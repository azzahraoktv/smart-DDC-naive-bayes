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
            <select id="sortBy" onchange="loadDataToTable()"
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
            <select id="filterCategory"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition">
                <option value="">Semua Kategori</option>
            </select>
        </div>

        <div class="self-end">
            <button id="btnResetFilter" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <i data-feather="filter" class="w-4 h-4 mr-1"></i> Reset
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
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="inputJudulBuku" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Masukkan judul buku lengkap">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Buku <span class="text-red-500">*</span></label>
                    <textarea id="inputDeskripsiBuku" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Masukkan deskripsi atau sinopsis buku"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori DDC <span class="text-red-500">*</span></label>
                    <select id="selectKategoriDDC" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori DDC</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pastikan kategori sudah tersedia. Jika belum, tambah dulu di halaman Kategori.</p>
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

<script>
// ===============================
// KODE LOGIKA UTAMA (FULL FEATURED)
// ===============================

// 1. VARIABEL GLOBAL
let dataTrainingSedangDiedit = null;

// 2. LOAD DATA KE TABEL
function loadDataToTable() {
    console.log("📚 Memuat data training...");
    
    const tbody = document.getElementById("tabel-datalatih");
    if (!tbody) return;

    if (!window.dataTraining) {
        const stored = localStorage.getItem('dataTraining');
        window.dataTraining = stored ? JSON.parse(stored) : [];
    }

    updateStatisticsForDataTraining();
    const filteredData = filterDataTraining(); 

    if (filteredData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="p-8 text-center text-gray-400">
                    <div class="flex flex-col items-center">
                        <i data-feather="book-open" class="w-12 h-12 mb-3 text-gray-300"></i>
                        <p class="text-lg font-medium text-gray-500 mb-2">${window.dataTraining.length === 0 ? 'Belum ada data training.' : 'Data tidak ditemukan'}</p>
                    </div>
                </td>
            </tr>`;
        if (typeof feather !== 'undefined') feather.replace();
        return;
    }

    let html = "";
    filteredData.forEach((item, index) => {
        // [PENTING] Ambil Index Asli untuk ID
        const realIndex = window.dataTraining.indexOf(item);
        const dataId = item.id || realIndex; 

        let code = "", name = "";
        if (item.kategori && item.kategori.includes("|")) {
            [code, name] = item.kategori.split("|");
        } else {
            code = item.kategori || "";
            name = getNamaKategoriByKode(code);
        }

        const badgeColor = getCategoryColorForBadge(code);
        const judulSafe = item.judul ? item.judul.replace(/'/g, "\\'") : "";
        
        // Tampilan Tabel (Tanpa Deskripsi)
        html += `
            <tr class="hover:bg-gray-50 transition-colors fade-in" data-id="${dataId}">
                <td class="px-4 py-4 text-center">
                    <input type="checkbox" name="selectedTrainingItems" value="${dataId}" 
                           onclick="checkIfAnySelectedTraining()"
                           class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500 cursor-pointer">
                </td>
                <td class="px-6 py-4 text-gray-700 font-medium">${index + 1}</td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">${judulSafe}</div>
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
                        <button onclick="editDataTraining('${dataId}')" 
                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition" title="Edit">
                            <i data-feather="edit" class="w-4 h-4"></i>
                        </button>
                        <button onclick="hapusDataTraining('${dataId}')" 
                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition" title="Hapus">
                            <i data-feather="trash-2" class="w-4 h-4"></i>
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

// 3. FILTER & SORTING
function filterDataTraining() {
    const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const filterCategory = document.getElementById('filterCategory')?.value || '';
    const sortBy = document.getElementById('sortBy')?.value || 'newest';
    
    if (!window.dataTraining) return [];

    // Filter
    let result = window.dataTraining.filter(item => {
        const matchSearch = !searchTerm || 
            (item.judul && item.judul.toLowerCase().includes(searchTerm)) ||
            (item.deskripsi && item.deskripsi.toLowerCase().includes(searchTerm));
        
        let itemKode = '';
        if (item.kategori && item.kategori.includes('|')) {
            itemKode = item.kategori.split('|')[0];
        } else {
            itemKode = item.kategori || '';
        }
        
        const matchCategory = !filterCategory || itemKode === filterCategory;
        return matchSearch && matchCategory;
    });

    // Sorting Logic
    result.sort((a, b) => {
        const dateA = new Date(a.tanggalDitambah || a.tanggal || 0);
        const dateB = new Date(b.tanggalDitambah || b.tanggal || 0);
        const titleA = (a.judul || "").toLowerCase();
        const titleB = (b.judul || "").toLowerCase();
        const codeA = a.kategori ? a.kategori.split('|')[0] : '';
        const codeB = b.kategori ? b.kategori.split('|')[0] : '';

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

    return result;
}

// 4. SIMPAN DATA (VALIDASI VARIATIF)
function simpanDataTraining() {
    const judul = document.getElementById('inputJudulBuku').value.trim();
    const deskripsi = document.getElementById('inputDeskripsiBuku').value.trim();
    const kategori = document.getElementById('selectKategoriDDC').value;

    if (!judul) { showNotification('error', 'Judul Kosong', 'Harap masukkan judul buku.'); return; }
    if (!deskripsi) { showNotification('error', 'Deskripsi Kosong', 'Harap masukkan deskripsi buku.'); return; }
    if (!kategori) { showNotification('error', 'Kategori Kosong', 'Harap pilih kategori DDC.'); return; }

    // [VALIDASI CERDAS]
    // Ditolak JIKA Judul SAMA *DAN* Deskripsi SAMA (Duplikat Persis)
    // Diterima JIKA Judul SAMA *TAPI* Deskripsi BEDA (Variasi)
    const isDuplicate = window.dataTraining.some(item => {
        const judulSama = item.judul.toLowerCase().trim() === judul.toLowerCase();
        const deskripsiSama = item.deskripsi.toLowerCase().trim() === deskripsi.toLowerCase().trim();
        const bukanDiriSendiri = dataTrainingSedangDiedit === null || item.id !== window.dataTraining[dataTrainingSedangDiedit].id;
        
        return judulSama && deskripsiSama && bukanDiriSendiri;
    });

    if (isDuplicate) {
        Swal.fire({
            icon: 'error',
            title: 'Data Duplikat!',
            text: `Data dengan judul "${judul}" DAN deskripsi yang sama persis sudah ada. Mohon ubah deskripsi jika ini adalah variasi buku yang berbeda.`,
            confirmButtonText: 'Oke'
        });
        return;
    }

    const dataTraining = {
        id: dataTrainingSedangDiedit === null ? 'temp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9) : window.dataTraining[dataTrainingSedangDiedit].id,
        judul: judul,
        deskripsi: deskripsi,
        kategori: kategori,
        tanggalDitambah: dataTrainingSedangDiedit === null ? new Date().toISOString() : window.dataTraining[dataTrainingSedangDiedit].tanggalDitambah,
        tanggalDiupdate: new Date().toISOString()
    };

    if (dataTrainingSedangDiedit === null) {
        window.dataTraining.push(dataTraining);
        showNotification('success', 'Berhasil!', 'Data training berhasil ditambahkan.');
    } else {
        window.dataTraining[dataTrainingSedangDiedit] = dataTraining;
        showNotification('success', 'Berhasil!', 'Data training berhasil diperbarui.');
    }

    localStorage.setItem('dataTraining', JSON.stringify(window.dataTraining));
    tutupModalDataTraining();
    loadDataToTable();

    if (typeof window.buildNaiveBayesModel === 'function') window.naiveBayesModel = window.buildNaiveBayesModel(window.dataTraining);
    if (typeof window.updateStats === 'function') window.updateStats();
}

// 5. CRUD LAINNYA & HELPER
function openModalDataTraining(dataId = null) {
    populateKategoriSelect();
    if (dataId === null) {
        document.getElementById('modal-data-training-title').textContent = 'Tambah Data Training Baru';
        document.getElementById('inputJudulBuku').value = '';
        document.getElementById('inputDeskripsiBuku').value = '';
        document.getElementById('selectKategoriDDC').value = '';
        dataTrainingSedangDiedit = null;
    } else {
        document.getElementById('modal-data-training-title').textContent = 'Edit Data Training';
        let dataIndex;
        if (typeof dataId === 'string' && dataId.includes('temp_')) {
            dataIndex = window.dataTraining.findIndex(item => item.id === dataId);
        } else {
            dataIndex = parseInt(dataId);
        }
        
        if (dataIndex === -1 || dataIndex >= window.dataTraining.length) {
            showNotification('error', 'Data Tidak Ditemukan', 'Data yang akan diedit tidak ditemukan.');
            return;
        }
        
        const data = window.dataTraining[dataIndex];
        document.getElementById('inputJudulBuku').value = data.judul || '';
        document.getElementById('inputDeskripsiBuku').value = data.deskripsi || '';
        document.getElementById('selectKategoriDDC').value = data.kategori || '';
        dataTrainingSedangDiedit = dataIndex;
    }
    document.getElementById('modal-data-training').classList.remove('hidden');
    setTimeout(() => { document.getElementById('inputJudulBuku').focus(); }, 100);
}

function tutupModalDataTraining() {
    document.getElementById('modal-data-training').classList.add('hidden');
}

function editDataTraining(dataId) { openModalDataTraining(dataId); }

function hapusDataTraining(dataId) {
    let dataIndex;
    if (typeof dataId === 'string' && dataId.includes('temp_')) {
        dataIndex = window.dataTraining.findIndex(item => item.id === dataId);
    } else {
        dataIndex = parseInt(dataId);
    }
    
    if (isNaN(dataIndex) || dataIndex === -1 || dataIndex >= window.dataTraining.length) {
        showNotification('error', 'Gagal', 'Data tidak ditemukan.');
        return;
    }
    
    const data = window.dataTraining[dataIndex];
    
    Swal.fire({
        title: 'Hapus Data?',
        html: `Hapus data: <b>"${data.judul}"</b>?<br><small class="text-gray-500">Tindakan ini tidak dapat dibatalkan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.dataTraining.splice(dataIndex, 1);
            localStorage.setItem('dataTraining', JSON.stringify(window.dataTraining));
            loadDataToTable();
            if (typeof window.buildNaiveBayesModel === 'function') window.naiveBayesModel = window.buildNaiveBayesModel(window.dataTraining);
            if (typeof window.updateStats === 'function') window.updateStats();
            Swal.fire({ icon: 'success', title: 'Terhapus!', timer: 1500, showConfirmButton: false });
        }
    });
}

function hapusDataTerpilihTraining() {
    const checkboxes = document.querySelectorAll('input[name="selectedTrainingItems"]:checked');
    if (checkboxes.length === 0) {
        showNotification('warning', 'Pilih Data', 'Tidak ada data yang dipilih.');
        return;
    }

    Swal.fire({
        title: 'Hapus Terpilih?',
        html: `Anda akan menghapus <b>${checkboxes.length}</b> data.<br><small class="text-gray-500">Tindakan ini permanen.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Semua'
    }).then((result) => {
        if (result.isConfirmed) {
            const idsToDelete = Array.from(checkboxes).map(cb => cb.value);
            const newData = window.dataTraining.filter((item, index) => {
                const itemId = item.id ? item.id.toString() : index.toString();
                return !idsToDelete.includes(itemId);
            });
            window.dataTraining = newData;
            localStorage.setItem('dataTraining', JSON.stringify(window.dataTraining));
            loadDataToTable();
            if (typeof window.buildNaiveBayesModel === 'function') window.naiveBayesModel = window.buildNaiveBayesModel(window.dataTraining);
            if (typeof window.updateStats === 'function') window.updateStats();
            Swal.fire({ icon: 'success', title: 'Berhasil Dihapus', timer: 1500, showConfirmButton: false });
        }
    });
}

function updateStatisticsForDataTraining() {
    const totalDataEl = document.getElementById("totalData");
    const totalCategoriesEl = document.getElementById("totalCategories");
    const dataCountEl = document.getElementById("data-count");
    const lastUpdateEl = document.getElementById("lastUpdate");

    const count = window.dataTraining ? window.dataTraining.length : 0;
    if (totalDataEl) totalDataEl.textContent = count;
    if (dataCountEl) dataCountEl.textContent = `${count} data training tersimpan`;

    const uniqueCategories = new Set();
    let latestDate = null;

    if (window.dataTraining) {
        window.dataTraining.forEach(item => {
            if (item.kategori) {
                const kode = item.kategori.includes('|') ? item.kategori.split('|')[0] : item.kategori;
                if (kode) uniqueCategories.add(kode);
            }
            const itemDate = new Date(item.tanggalDitambah || item.tanggal || item.createdAt);
            if (!latestDate || itemDate > latestDate) latestDate = itemDate;
        });
    }
    
    if (totalCategoriesEl) totalCategoriesEl.textContent = uniqueCategories.size;
    if (lastUpdateEl) {
        lastUpdateEl.textContent = latestDate ? latestDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
    }
}

function populateFilterCategory() {
    const filterSelect = document.getElementById("filterCategory");
    if (!filterSelect) return;
    while (filterSelect.options.length > 1) filterSelect.remove(1);
    const storedKategori = localStorage.getItem('kategoriDDC');
    const kategoriList = storedKategori ? JSON.parse(storedKategori) : [];
    kategoriList.forEach(kategori => {
        const option = document.createElement("option");
        option.value = kategori.kode;
        option.textContent = `${kategori.kode} - ${kategori.nama}`;
        filterSelect.appendChild(option);
    });
}

function populateKategoriSelect() {
    const select = document.getElementById("selectKategoriDDC");
    if (!select) return;
    while (select.options.length > 1) select.remove(1);
    const storedKategori = localStorage.getItem('kategoriDDC');
    const kategoriList = storedKategori ? JSON.parse(storedKategori) : [];
    kategoriList.forEach(kategori => {
        const option = document.createElement("option");
        option.value = `${kategori.kode}|${kategori.nama}`;
        option.textContent = `${kategori.kode} - ${kategori.nama}`;
        select.appendChild(option);
    });
}

function toggleSelectAllTraining(checkbox) {
    const checkboxes = document.querySelectorAll('input[name="selectedTrainingItems"]');
    checkboxes.forEach(cb => { cb.checked = checkbox.checked; });
    checkIfAnySelectedTraining();
}

function checkIfAnySelectedTraining() {
    const checkboxes = document.querySelectorAll('input[name="selectedTrainingItems"]:checked');
    const deleteBtn = document.getElementById('btnDeleteSelectedTraining');
    if (deleteBtn) {
        if (checkboxes.length > 0) {
            deleteBtn.style.display = 'flex';
            deleteBtn.innerHTML = `<i data-feather="trash-2" class="mr-2 w-4 h-4"></i> Hapus ${checkboxes.length} Data Terpilih`;
            if (typeof feather !== 'undefined') feather.replace();
        } else deleteBtn.style.display = 'none';
    }
}

function getNamaKategoriByKode(kode) {
    if (!kode) return "Tanpa Kategori";
    if (!window.kategoriDDC) window.kategoriDDC = JSON.parse(localStorage.getItem('kategoriDDC') || '[]');
    const kategori = window.kategoriDDC.find(k => k.kode === kode);
    return kategori ? kategori.nama : `Kode: ${kode}`;
}

function getCategoryColorForBadge(code) {
    if (!code) return "bg-gray-100 text-gray-600 border-gray-200";
    const prefix = code.split('.')[0];
    const colors = { '004': 'bg-blue-100 text-blue-800 border-blue-200', '005': 'bg-green-100 text-green-800 border-green-200', '006': 'bg-purple-100 text-purple-800 border-purple-200' };
    return colors[prefix] || "bg-gray-100 text-gray-600 border-gray-200";
}

function formatDate(isoString) {
    try { return new Date(isoString).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }); } 
    catch (e) { return '-'; }
}

function showNotification(type, title, message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: type, title: title, text: message, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
    } else alert(`${title}\n${message}`);
}

function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function resetFilterDataTraining() {
    if (document.getElementById('searchInput')) document.getElementById('searchInput').value = '';
    if (document.getElementById('filterCategory')) document.getElementById('filterCategory').value = '';
    if (document.getElementById('sortBy')) document.getElementById('sortBy').value = 'newest';
    loadDataToTable();
}

// 6. IMPORT & EXPORT
function importDataTraining() {
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
                if (file.name.endsWith('.json')) handleJsonImport(e.target.result);
                else if (file.name.endsWith('.xlsx') || file.name.endsWith('.xls')) handleExcelImport(e.target.result, file);
                else if (file.name.endsWith('.csv')) handleCsvImport(e.target.result, file);
                else throw new Error("Format file tidak didukung.");
            } catch (error) { showNotification('error', 'Import Gagal', error.message); }
        };
        if (file.name.endsWith('.json') || file.name.endsWith('.csv')) reader.readAsText(file);
        else reader.readAsArrayBuffer(file);
    };
    document.body.appendChild(input);
    input.click();
    document.body.removeChild(input);
}

function handleExcelImport(arrayBuffer, file) {
    if (typeof XLSX === 'undefined') { showNotification('error', 'Error', 'Library XLSX belum dimuat.'); return; }
    const workbook = XLSX.read(arrayBuffer, { type: 'array' });
    const jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
    processImportedData(jsonData, file.name);
}

function handleJsonImport(jsonString) {
    const importedData = JSON.parse(jsonString);
    const dataArray = Array.isArray(importedData) ? importedData : (importedData.data_training || importedData.data || []);
    processImportedData(dataArray, 'JSON File');
}

function handleCsvImport(csvString, file) {
    const lines = csvString.split('\n');
    if (lines.length < 2) { showNotification('error', 'CSV Kosong', 'File tidak valid'); return; }
    const headers = lines[0].split(',').map(h => h.trim());
    const jsonData = [];
    for (let i = 1; i < lines.length; i++) {
        if (!lines[i].trim()) continue;
        const values = lines[i].split(',').map(v => v.trim());
        const row = {};
        headers.forEach((h, idx) => { if (values[idx]) row[h] = values[idx]; });
        jsonData.push(row);
    }
    processImportedData(jsonData, file.name);
}

function processImportedData(dataArray, fileName) {
    const validData = [];
    dataArray.forEach((item, index) => {
        const judul = item.Judul_Buku || item.judul;
        const kodeDDC = item.Kode_DDC || item.kode;
        if (!judul || !kodeDDC) return;
        const kategoriObj = window.kategoriDDC ? window.kategoriDDC.find(k => k.kode === kodeDDC) : null;
        if (!kategoriObj) return;

        validData.push({
            id: 'temp_' + Date.now() + '_' + index,
            judul: judul,
            deskripsi: judul,
            kategori: `${kodeDDC}|${kategoriObj.nama}`,
            tanggalDitambah: new Date().toISOString(),
            tanggalDiupdate: new Date().toISOString()
        });
    });

    if (validData.length === 0) {
        Swal.fire({ icon: 'error', title: 'Import Gagal', text: 'Tidak ada data valid yang ditemukan.' });
        return;
    }

    Swal.fire({
        title: 'Import Data?',
        text: `Ditemukan ${validData.length} data valid.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Import'
    }).then((res) => {
        if (res.isConfirmed) {
            window.dataTraining.push(...validData);
            localStorage.setItem('dataTraining', JSON.stringify(window.dataTraining));
            loadDataToTable();
            if (typeof window.buildNaiveBayesModel === 'function') window.naiveBayesModel = window.buildNaiveBayesModel(window.dataTraining);
            if (typeof window.updateStats === 'function') window.updateStats();
            Swal.fire({ icon: 'success', title: 'Berhasil' });
        }
    });
}

function exportDataTraining() {
    if (!window.dataTraining || window.dataTraining.length === 0) { showNotification('warning', 'Kosong', 'Tidak ada data.'); return; }
    const exportData = window.dataTraining.map((item, index) => {
        let code = "", name = "";
        if (item.kategori && item.kategori.includes("|")) [code, name] = item.kategori.split("|");
        else { code = item.kategori || ""; name = getNamaKategoriByKode(code); }
        return {
            No: index + 1, Judul_Buku: item.judul, Deskripsi: item.deskripsi || '', 
            Kode_DDC: code, Nama_Kategori: name, 
            Tanggal_Ditambah: formatDate(item.tanggalDitambah || item.tanggal)
        };
    });
    const blob = new Blob([JSON.stringify({ timestamp: new Date().toISOString(), total: window.dataTraining.length, data_training: exportData }, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `data-training-${new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    showNotification('success', 'Export Berhasil', 'File diunduh.');
}

// 7. INIT
document.addEventListener("DOMContentLoaded", function() {
    if (!window.dataTraining) {
        const stored = localStorage.getItem('dataTraining');
        window.dataTraining = stored ? JSON.parse(stored) : [];
    }
    if (!window.kategoriDDC) {
        try { window.kategoriDDC = JSON.parse(localStorage.getItem('kategoriDDC') || '[]'); }
        catch(e) { window.kategoriDDC = []; }
    }
    
    populateFilterCategory();
    document.getElementById('searchInput')?.addEventListener('input', debounce(() => loadDataToTable(), 300));
    document.getElementById('filterCategory')?.addEventListener('change', () => loadDataToTable());
    document.getElementById('btnResetFilter')?.addEventListener('click', resetFilterDataTraining);
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('modal-data-training').classList.contains('hidden')) {
            tutupModalDataTraining();
        }
    });

    loadDataToTable();
    if (typeof feather !== 'undefined') feather.replace();
});

// Expose Global
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
window.simpanDataTraining = simpanDataTraining;
</script>