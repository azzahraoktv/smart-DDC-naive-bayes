<!-- Modal Tambah Data Training -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900 bg-opacity-70 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity modal-overlay">
    <div class="bg-white p-8 rounded-xl w-full max-w-md shadow-2xl card-hover transform transition-all scale-100 border border-gray-200">
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
            <h3 class="text-xl font-bold text-slate-800">Tambah Data Training</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-bold text-slate-700 mb-2">Judul Buku</label>
            <input type="text" id="manualJudul" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600 outline-none input-modern text-slate-800" placeholder="Contoh: Belajar Python Pemula..." />
        </div>
        <div class="mb-8">
            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori DDC</label>
            <select id="manualKategori" class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white outline-none input-modern text-slate-800 cursor-pointer">
                <option value="">-- Pilih Kategori --</option>
            </select>
        </div>
        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
            <button onclick="closeModal()" class="px-6 py-2.5 btn-secondary rounded-lg text-sm font-bold transition shadow-sm">
                Batal
            </button>
            <button onclick="simpanDataTrainingManual()" class="px-6 py-2.5 btn-primary rounded-lg text-sm font-bold shadow-md transition flex items-center">
                <i data-feather="save" class="w-4 h-4 mr-2"></i> Simpan Data
            </button>
        </div>
    </div>
</div>

<!-- Modal Kategori DDC -->
<div id="modalKategori" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 id="modalKategoriTitle" class="text-xl font-bold text-gray-800">
                Tambah Kategori DDC
            </h2>
            <button onclick="closeModalKategori()" class="text-gray-400 hover:text-gray-600">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode DDC *</label>
                <input type="text" id="inputKodeDDC" class="w-full px-4 py-2 border border-gray-300 rounded-lg input-modern" placeholder="Contoh: 004.019, 005.1, 006.3" />
                <p class="text-xs text-gray-500 mt-1">
                    Format: 3 digit (004) atau 3 digit.titik.1-3 digit (005.1, 004.019)
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori *</label>
                <input type="text" id="inputNamaKategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg input-modern" placeholder="Contoh: Interaksi Manusia & Komputer" />
            </div>
            <div id="warningDataTraining" class="hidden bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <div class="flex items-start">
                    <i data-feather="alert-triangle" class="w-5 h-5 text-yellow-600 mr-2 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">Peringatan!</p>
                        <p class="text-xs text-yellow-700">
                            Kategori ini memiliki <span id="jumlahDataTraining">0</span>
                            data training. Mengubah kode DDC dapat mempengaruhi data training yang ada.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex items-start">
                    <i data-feather="info" class="w-4 h-4 text-blue-600 mr-2 mt-0.5"></i>
                    <div>
                        <p class="text-xs font-medium text-blue-800">Contoh Kode DDC yang Valid:</p>
                        <ul class="text-xs text-blue-700 mt-1 space-y-1">
                            <li>• 004 - Computer Science</li>
                            <li>• 004.019 - Human-Computer Interaction</li>
                            <li>• 005.1 - Programming</li>
                            <li>• 005.12 - Programming Techniques</li>
                            <li>• 006.3 - Artificial Intelligence</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
            <button onclick="closeModalKategori()" class="btn-secondary px-4 py-2 rounded-lg text-sm">
                Batal
            </button>
            <button onclick="window.simpanKategori()" id="btnSimpanKategori" class="btn-primary px-4 py-2 rounded-lg text-sm">
                Simpan Kategori
            </button>
        </div>
    </div>
</div>

<!-- Modal Import/Export -->
<div id="modalImportExport" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Import/Export Data</h2>
            <button onclick="document.getElementById('modalImportExport').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="space-y-6">
            <div>
                <h3 class="font-bold text-gray-700 mb-3">Import Data dari Excel</h3>
                <input type="file" id="fileImportInput" accept=".xlsx, .xls, .csv" class="w-full px-4 py-3 border border-gray-300 rounded-lg" />
                <p class="text-xs text-gray-500 mt-2">
                    Format Excel: Kolom "Judul" dan "Kategori"
                </p>
                <button onclick="handleImportExcel()" class="mt-3 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                    <i data-feather="upload" class="w-4 h-4 inline mr-2"></i> Import Data
                </button>
            </div>
            <div class="border-t pt-6">
                <h3 class="font-bold text-gray-700 mb-3">Export Data ke Excel</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Download data training saat ini ke file Excel.
                </p>
                <button onclick="exportDataTrainingToExcel()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    <i data-feather="download" class="w-4 h-4 inline mr-2"></i> Export Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- WATERMARK FOOTER -->
<div class="fixed bottom-4 right-4 z-40 opacity-30 hover:opacity-100 transition-opacity duration-300">
    <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-3 py-2 rounded-lg shadow-sm border border-gray-200">
        <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
            <span class="text-white text-xs font-bold">@</span>
        </div>
    </div>
</div>

<!-- FLOATING WATERMARK -->
<div class="fixed bottom-4 left-4 z-40 opacity-20 hover:opacity-50 transition-opacity duration-300">
    <div class="flex items-center space-x-1">
        <div class="text-xs text-gray-500 italic">
            <span class="font-bold text-blue-400">©</span> 2024 • DDC Classification System
        </div>
    </div>
</div>

<!-- CORNER WATERMARK (di pojok kanan bawah) -->
<div class="fixed bottom-2 right-2 z-30 opacity-10 hover:opacity-30 transition-opacity duration-300">
    <div class="text-[10px] text-gray-400 font-mono">
        <span class="text-blue-300">@</span>pustakawan<span class="text-purple-300">_</span>ai
    </div>
</div>

<!-- BOTTOM CENTER WATERMARK -->
<div class="fixed bottom-3 left-1/2 transform -translate-x-1/2 z-30 opacity-15 hover:opacity-25 transition-opacity duration-300">
    <div class="text-[11px] text-gray-500 tracking-wider">
        SMART DDC CLASSIFIER • NAIVE BAYES
    </div>
</div>

<script>
// Fungsi modal kategori
function bukaModalTambahKategori() {
    window.kategoriSedangDiedit = null;
    document.getElementById("modalKategoriTitle").textContent = "Tambah Kategori DDC";
    document.getElementById("inputKodeDDC").value = "";
    document.getElementById("inputNamaKategori").value = "";
    document.getElementById("inputKodeDDC").removeAttribute("readonly");
    document.getElementById("warningDataTraining").classList.add("hidden");
    document.getElementById("btnSimpanKategori").textContent = "Simpan Kategori";
    document.getElementById("modalKategori").classList.remove("hidden");
}

function editKategori(kode) {
    const kategori = window.kategoriDDC.find((k) => k.kode === kode);
    if (!kategori) return;

    window.kategoriSedangDiedit = kode;
    document.getElementById("modalKategoriTitle").textContent = "Edit Kategori DDC";
    document.getElementById("inputKodeDDC").value = kategori.kode;
    document.getElementById("inputNamaKategori").value = kategori.nama;

    const jumlahData = window.hitungDataTrainingPerKategori(kode);
    if (jumlahData > 0) {
        document.getElementById("jumlahDataTraining").textContent = jumlahData;
        document.getElementById("warningDataTraining").classList.remove("hidden");
        document.getElementById("inputKodeDDC").setAttribute("readonly", "true");
    } else {
        document.getElementById("warningDataTraining").classList.add("hidden");
        document.getElementById("inputKodeDDC").removeAttribute("readonly");
    }

    document.getElementById("btnSimpanKategori").textContent = "Update Kategori";
    document.getElementById("modalKategori").classList.remove("hidden");
}

function hapusKategori(kode) {
    const jumlahData = window.hitungDataTrainingPerKategori(kode);
    if (jumlahData > 0) {
        window.showToast(`Tidak bisa menghapus! Kategori ini digunakan di ${jumlahData} data training.`, "error");
        return;
    }

    if (confirm(`Yakin menghapus kategori "${kode}"?`)) {
        window.kategoriDDC = window.kategoriDDC.filter((k) => k.kode !== kode);
        localStorage.setItem("kategoriDDC", JSON.stringify(window.kategoriDDC));
        window.showToast("Kategori berhasil dihapus!", "success");
        
        if (typeof renderTabelKategori === 'function') {
            renderTabelKategori();
        }
        window.updateStats();
    }
}

function closeModalKategori() {
    document.getElementById("modalKategori").classList.add("hidden");
    window.kategoriSedangDiedit = null;
}

// Fungsi untuk Data Training Modal
function populateKategoriModal() {
    const select = document.getElementById("manualKategori");
    if (!select) return;

    select.innerHTML = '<option value="">-- Pilih Kategori --</option>';
    window.kategoriDDC.forEach((kategori) => {
        const option = document.createElement("option");
        option.value = kategori.kode;
        option.textContent = `[${kategori.kode}] ${kategori.nama}`;
        select.appendChild(option);
    });
}

function openModal() {
    document.getElementById("modalTambah").classList.remove("hidden");
    populateKategoriModal();
}

function closeModal() {
    document.getElementById("modalTambah").classList.add("hidden");
    document.getElementById("manualJudul").value = "";
    delete document.getElementById("manualJudul").dataset.editIndex;
}

function simpanDataTrainingManual() {
    const judul = document.getElementById("manualJudul").value;
    const kategoriCode = document.getElementById("manualKategori").value;
    const editIndex = document.getElementById("manualJudul").dataset.editIndex;

    if (!judul) {
        window.showToast("Judul tidak boleh kosong", "error");
        return;
    }
    if (!kategoriCode) {
        window.showToast("Pilih kategori", "error");
        return;
    }

    const kategoriObj = window.kategoriDDC.find((k) => k.kode === kategoriCode);
    if (!kategoriObj) {
        window.showToast("Kategori tidak valid", "error");
        return;
    }

    const kategori = `${kategoriObj.kode}|${kategoriObj.nama}`;

    // Validasi duplikasi judul
    const isDuplicate = window.dataTraining.some((d, index) => {
        const isSameTitle = d.judul.toLowerCase() === judul.toLowerCase();
        if (editIndex !== undefined) {
            return isSameTitle && index !== parseInt(editIndex);
        }
        return isSameTitle;
    });

    if (isDuplicate) {
        window.showToast("Judul buku ini sudah ada di Data Training. Tidak boleh ada duplikasi judul.", "error");
        return;
    }

    if (editIndex !== undefined) {
        window.dataTraining[editIndex].judul = judul;
        window.dataTraining[editIndex].kategori = kategori;
        window.showToast("Data berhasil diperbarui", "success");
    } else {
        window.dataTraining.push({
            id: `manual-${Date.now()}`,
            judul: judul,
            kategori: kategori,
            sumber: "tambah_manual",
            tanggal: new Date().toISOString(),
        });
        window.showToast("Data berhasil ditambahkan", "success");
    }

    localStorage.setItem("dataTraining", JSON.stringify(window.dataTraining));
    closeModal();
    
    // Reload halaman data training jika sedang aktif
    if (window.location.href.includes('page=datalatih')) {
        if (typeof loadDataToTable === 'function') {
            loadDataToTable();
        }
    }
    window.updateStats();
}

function editDataTraining(index) {
    if (index >= 0 && index < window.dataTraining.length) {
        const data = window.dataTraining[index];
        document.getElementById("manualJudul").value = data.judul;

        let code;
        if (data.kategori && data.kategori.includes("|")) {
            code = data.kategori.split("|")[0];
        } else {
            code = data.kategori;
        }

        document.getElementById("manualKategori").value = code;
        document.getElementById("manualJudul").dataset.editIndex = index;
        openModal();
    } else {
        alert("Data tidak ditemukan!");
    }
}

function deleteDataTraining(index) {
    if (index < 0 || index >= window.dataTraining.length) {
        alert("Data tidak ditemukan!");
        return;
    }

    const item = window.dataTraining[index];

    if (confirm(`Yakin hapus data:\n"${item.judul}"?`)) {
        window.dataTraining.splice(index, 1);
        localStorage.setItem("dataTraining", JSON.stringify(window.dataTraining));
        
        if (typeof loadDataToTable === 'function') {
            loadDataToTable();
        }
        window.updateStats();
        window.showToast("Data berhasil dihapus!", "success");
    }
}

// Ekspos fungsi ke global scope
window.populateKategoriModal = populateKategoriModal;
window.openModal = openModal;
window.closeModal = closeModal;
window.bukaModalTambahKategori = bukaModalTambahKategori;
window.editKategori = editKategori;
window.hapusKategori = hapusKategori;
window.closeModalKategori = closeModalKategori;
window.simpanDataTrainingManual = simpanDataTrainingManual;
window.editDataTraining = editDataTraining;
window.deleteDataTraining = deleteDataTraining;
<!-- MINIMALIST WATERMARK FOOTER -->
<div class="fixed bottom-4 right-4 z-40">
    <div class="group">
        <div class="flex items-center space-x-2 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg shadow-sm border border-gray-200 
                    transition-all duration-300 hover:shadow-md hover:border-blue-200 hover:bg-white">
            <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center 
                        group-hover:scale-110 transition-transform duration-300">
                <span class="text-white text-xs font-bold">@</span>
            </div>
            <div class="text-xs">
                <div class="text-gray-700 font-semibold">Smart DDC</div>
                <div class="text-gray-400 text-[10px]">DDC Classification v2.3</div>
            </div>
        </div>
        <div class="absolute -top-8 right-0 bg-black/80 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 
                    transition-opacity duration-300 whitespace-nowrap">
            Smart Library System • Naive Bayes
        </div>
    </div>
</div>

<!-- BOTTOM LEFT SIMPLE WATERMARK -->
<div class="fixed bottom-3 left-3 z-30 opacity-40 hover:opacity-70 transition-opacity duration-300">
    <div class="flex items-center space-x-1">
        <div class="w-3 h-3 rounded-full bg-blue-400"></div>
        <div class="text-[10px] text-gray-500 font-mono">
            <span class="text-blue-400">@</span>pustakawan_ai
        </div>
    </div>
</div>
</script>