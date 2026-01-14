<?php
// Halaman klasifikasi akan menggunakan JavaScript dari file utama
?>
<div id="page-klasifikasi">
<div class="mb-8">
  <h1 class="text-3xl font-bold text-gray-800 mb-2">
    Klasifikasi Buku DDC
  </h1>
  <p class="text-gray-600">
    Masukkan detail buku untuk menentukan kelas DDC menggunakan algoritma Naive Bayes berdasarkan data training.
  </p>
</div>

<!-- TABS UNTUK MODE INPUT -->
<div class="mb-6">
  <div class="border-b border-gray-200">
    <nav class="flex -mb-px">
      <button id="tab-single" onclick="switchTab('single')" class="tab-button active py-4 px-6 text-sm font-medium text-center border-b-2 border-transparent hover:text-blue-600 hover:border-blue-300 transition-all duration-300">
        <i data-feather="book" class="w-4 h-4 mr-2 inline"></i>
        Input Tunggal
      </button>
      <button id="tab-multiple" onclick="switchTab('multiple')" class="tab-button py-4 px-6 text-sm font-medium text-center border-b-2 border-transparent hover:text-blue-600 hover:border-blue-300 transition-all duration-300">
        <i data-feather="list" class="w-4 h-4 mr-2 inline"></i>
        Input Multiple
      </button>
    </nav>
  </div>
</div>

<div class="space-y-8">
  <!-- TAB INPUT TUNGGAL -->
  <div id="tab-content-single" class="tab-content">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover">
      <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i data-feather="edit-3" class="mr-2 w-5 h-5 text-blue-600"></i> Detail Buku (Tunggal)
      </h2>

      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2"
          >Judul Buku <span class="text-red-500">*</span></label
        >
        <input
          type="text"
          id="inputJudul"
          class="w-full px-4 py-3 input-modern rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-lg"
          placeholder="Contoh: Belajar Jaringan Komputer"
          required
        />
      </div>

      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2"
          >Deskripsi Singkat
          <span class="text-gray-400 text-xs">(Opsional - meningkatkan akurasi)</span></label
        >
        <textarea
          id="inputDeskripsi"
          rows="4"
          class="w-full px-4 py-3 input-modern rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
          placeholder="Deskripsi singkat buku..."
        ></textarea>
      </div>

      <div class="flex gap-4">
        <button
          onclick="resetInput()"
          class="w-1/3 bg-gray-100 text-gray-600 border border-gray-300 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-all duration-300 shadow-sm flex items-center justify-center card-hover"
        >
          <i data-feather="trash-2" class="mr-2 w-5 h-5"></i> Hapus
        </button>
        <button
          onclick="prosesKlasifikasi()"
          class="w-2/3 btn-primary text-white px-6 py-3 rounded-lg font-medium shadow-sm flex items-center justify-center text-lg"
        >
          <i data-feather="cpu" class="mr-2 w-5 h-5"></i> Proses Klasifikasi
        </button>
      </div>
    </div>
  </div>

  <!-- TAB INPUT MULTIPLE (DENGAN FITUR IMPORT EXCEL) -->
  <div id="tab-content-multiple" class="tab-content hidden">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover">
      <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i data-feather="list" class="mr-2 w-5 h-5 text-blue-600"></i> Input Buku Multiple
      </h2>
      
      <!-- CARD IMPOR EXCEL -->
      <div class="mb-8 bg-blue-50 rounded-xl border border-blue-100 p-6">
        <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
          <i data-feather="upload" class="w-5 h-5 mr-2"></i>
          Impor dari Excel (Opsional)
        </h3>
        
        <div class="text-sm text-blue-700 mb-4">
          <p class="mb-2">Format file Excel/CSV yang didukung:</p>
          <ul class="list-disc pl-5 space-y-1">
            <li><strong>judul</strong> atau <strong>judul_buku</strong> (wajib)</li>
            <li><strong>deskripsi</strong> atau <strong>keterangan</strong> (opsional)</li>
            <li>File Excel (.xlsx, .xls) atau CSV (.csv)</li>
          </ul>
        </div>
        
        <div class="mb-4">
          <div class="border-2 border-dashed border-blue-300 rounded-xl p-6 text-center hover:border-blue-400 hover:bg-blue-100 transition-all duration-300 cursor-pointer" onclick="document.getElementById('excelFile').click()">
            <div class="mb-3">
              <i data-feather="file" class="w-10 h-10 text-blue-500 mx-auto"></i>
            </div>
            <input type="file" id="excelFile" accept=".xlsx,.xls,.csv" class="hidden">
            <div class="text-blue-700 font-medium mb-1">Klik untuk upload file Excel/CSV</div>
            <div class="text-xs text-blue-600">atau drag & drop file di sini</div>
            <div class="text-xs text-gray-500 mt-2">Maksimal 5MB, maksimal 100 data</div>
          </div>
        </div>
        
        <div class="flex gap-3">
          <button onclick="importFromExcel()" id="importExcelBtn" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-all duration-300 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            <i data-feather="check" class="w-4 h-4 mr-2"></i>
            Impor Data
          </button>
          <button onclick="resetExcelImport()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-all duration-300 flex items-center">
            <i data-feather="x" class="w-4 h-4 mr-2"></i>
            Hapus
          </button>
        </div>
        
        <div id="excelPreview" class="mt-4 hidden">
          <div class="flex justify-between items-center mb-2">
            <h4 class="font-bold text-gray-700">Preview Data</h4>
            <div class="text-sm text-gray-600">
              <span id="excelDataCount">0</span> data ditemukan
            </div>
          </div>
          <div class="overflow-x-auto border border-gray-200 rounded-lg max-h-60 overflow-y-auto">
            <table class="w-full text-sm">
              <thead class="bg-gray-50 sticky top-0">
                <tr>
                  <th class="p-3 text-left font-medium text-gray-700 border-b">No</th>
                  <th class="p-3 text-left font-medium text-gray-700 border-b">Judul Buku</th>
                  <th class="p-3 text-left font-medium text-gray-700 border-b">Deskripsi</th>
                </tr>
              </thead>
              <tbody id="excelPreviewBody" class="divide-y divide-gray-200"></tbody>
            </table>
          </div>
        </div>
      </div>
      
      <!-- INPUT MANUAL MULTIPLE -->
      <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <i data-feather="edit-2" class="w-5 h-5 mr-2 text-blue-600"></i>
            Input Manual
          </h3>
          <div class="text-sm text-gray-600">
            <span id="manualCount">1</span> buku ditambahkan
          </div>
        </div>
        
        <div id="multiple-input-container">
          <div class="multiple-input-item mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
            <div class="flex justify-between items-center mb-2">
              <span class="text-sm font-medium text-gray-700">Buku #1</span>
              <button type="button" onclick="removeMultipleInput(this)" class="text-red-500 hover:text-red-700">
                <i data-feather="x" class="w-4 h-4"></i>
              </button>
            </div>
            <input type="text" 
                   class="multiple-judul w-full px-4 py-2 input-modern rounded-lg focus:ring-2 focus:ring-blue-500 outline-none mb-3" 
                   placeholder="Judul buku"
                   required>
            <textarea class="multiple-deskripsi w-full px-4 py-2 input-modern rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm" 
                      rows="2" 
                      placeholder="Deskripsi (opsional)"></textarea>
          </div>
        </div>
        
        <button onclick="addMultipleInput()" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:text-blue-600 hover:border-blue-400 transition-all duration-300 flex items-center justify-center">
          <i data-feather="plus" class="w-4 h-4 mr-2"></i>
          Tambah Buku
        </button>
      </div>
      
      <div class="flex gap-4">
        <button onclick="resetMultipleInput()" class="w-1/3 bg-gray-100 text-gray-600 border border-gray-300 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-all duration-300 shadow-sm flex items-center justify-center card-hover">
          <i data-feather="trash-2" class="mr-2 w-5 h-5"></i> Reset All
        </button>
        <button onclick="prosesKlasifikasiMultiple()" class="w-2/3 btn-primary text-white px-6 py-3 rounded-lg font-medium shadow-sm flex items-center justify-center text-lg">
          <i data-feather="cpu" class="mr-2 w-5 h-5"></i> Proses Semua Buku
        </button>
      </div>
    </div>
  </div>

  <!-- TABEL HASIL MULTIPLE -->
  <div id="multiple-results-container" class="hidden">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover">
      <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i data-feather="check-circle" class="mr-2 w-5 h-5 text-green-600"></i> Hasil Klasifikasi Multiple
      </h2>
      
      <div class="mb-6">
        <div class="flex flex-wrap gap-4 justify-between items-center mb-4">
          <div class="flex items-center gap-4">
            <div class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
              Total: <span id="total-books-count" class="font-bold">0</span> buku
            </div>
            <div class="text-sm text-gray-600 bg-blue-100 px-3 py-1 rounded-full">
              Waktu: <span id="processing-time" class="font-bold">0</span> detik
            </div>
          </div>
          <div class="flex gap-2">
            <button onclick="exportResultsToExcel()" class="px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-all duration-300 flex items-center text-sm">
              <i data-feather="download" class="w-4 h-4 mr-2"></i> Export Excel
            </button>
            <button onclick="exportResultsToPDF()" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all duration-300 flex items-center text-sm">
              <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export PDF
            </button>
          </div>
        </div>
        
        <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
          <table class="w-full text-sm">
            <thead class="bg-gray-50">
              <tr>
                <th class="p-4 text-left font-bold text-gray-700 border-b">No</th>
                <th class="p-4 text-left font-bold text-gray-700 border-b">Judul Buku</th>
                <th class="p-4 text-left font-bold text-gray-700 border-b">Deskripsi</th>
                <th class="p-4 text-left font-bold text-gray-700 border-b">Kode DDC</th>
                <th class="p-4 text-left font-bold text-gray-700 border-b">Kategori</th>
                <th class="p-4 text-left font-bold text-gray-700 border-b">Confidence</th>
                <th class="p-4 text-left font-bold text-gray-700 border-b">Aksi</th>
              </tr>
            </thead>
            <tbody id="multiple-results-body" class="divide-y divide-gray-200"></tbody>
          </table>
        </div>
      </div>
      
      <div class="flex justify-center">
        <button onclick="closeMultipleResults()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-300 flex items-center">
          <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Input
        </button>
      </div>
    </div>
  </div>

  <!-- HASIL KLASIFIKASI (POSISI ATAS) - UNTUK SINGLE -->
  <div id="hasil-klasifikasi-card" class="hidden bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden transition-all duration-300 card-hover">
    <div class="p-8 bg-white relative z-10">
      <h3 class="text-xl font-semibold text-gray-700 mb-6 flex items-center">
        <i data-feather="check-square" class="w-6 h-6 mr-2 text-blue-600"></i>
        Hasil Prediksi Sistem
      </h3>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-100">
          <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Kode DDC</span>
          <div id="result-code" class="text-4xl font-extrabold text-blue-900 mt-2 font-mono">-</div>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-xl border border-green-100">
          <span class="text-xs font-bold text-green-600 uppercase tracking-widest">Kategori</span>
          <div id="result-category" class="text-2xl font-bold text-gray-800 mt-2">-</div>
          <div id="result-category-desc" class="text-sm text-gray-600 mt-1 italic">Kategori terdeteksi</div>
        </div>
        <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-100">
          <span class="text-xs font-bold text-purple-600 uppercase tracking-widest">Confidence</span>
          <div id="result-prob-text" class="text-4xl font-extrabold text-purple-600 mt-2">0%</div>
          <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3">
            <div id="result-prob-bar" class="bg-gradient-to-r from-purple-500 to-pink-500 h-2.5 rounded-full transition-all duration-1000" style="width: 0%"></div>
          </div>
        </div>
      </div>

      <button onclick="toggleDetail()" class="w-full flex items-center justify-center text-sm font-bold text-gray-500 hover:text-blue-700 py-3 border border-dashed border-gray-300 rounded-lg hover:bg-blue-50 transition-all duration-300">
        <span id="btn-text">Tampilkan Detail Perhitungan Naive Bayes</span>
        <i data-feather="chevron-down" class="ml-2 w-4 h-4 transition-transform duration-300" id="btn-icon"></i>
      </button>
    </div>
  </div>

  <!-- PREPROCESSING TEKS (POSISI TENGAH) -->
  <div id="preprocessing-card" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover">
    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
      <i data-feather="filter" class="mr-2 w-5 h-5 text-blue-600"></i> Proses Preprocessing Teks
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">1. Case Folding & Cleaning</h4>
        <div id="preprocessing-cleaning" class="p-4 bg-gray-50 rounded border border-gray-200 min-h-[60px] text-sm text-gray-600"></div>
      </div>
      <div>
        <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">2. Tokenizing</h4>
        <div id="preprocessing-tokenizing" class="flex flex-wrap gap-2 p-4 bg-gray-50 rounded border border-gray-200 min-h-[60px]"></div>
      </div>
      <div>
        <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">3. Stopword Removal</h4>
        <div id="preprocessing-stopword" class="flex flex-wrap gap-2 p-4 bg-gray-50 rounded border border-gray-200 min-h-[60px]"></div>
      </div>
      <div>
        <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">4. Stemming (Kata Dasar)</h4>
        <div id="preprocessing-stemming" class="flex flex-wrap gap-2 p-4 bg-gray-50 rounded border border-gray-200 min-h-[60px]"></div>
      </div>
    </div>
  </div>

  <!-- DETAIL PERHITUNGAN (POSISI BAWAH) -->
  <div id="detail-container" class="hidden bg-gray-50 rounded-xl border border-gray-200 p-8 card-hover">
    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
      <i data-feather="calculator" class="mr-2 w-5 h-5 text-blue-600"></i> Detail Perhitungan Naive Bayes
    </h2>

    <div class="mb-8 p-6 bg-white rounded-lg border border-gray-300 shadow-sm">
      <h4 class="font-bold text-lg text-blue-800 mb-4 text-center">Rumus Naive Bayes</h4>
      <div class="text-center mb-4">
        <div class="text-xl font-bold text-gray-800 mb-2">
          P(Kelas|Data) = P(Kelas) × Π P(Kata|Kelas)
        </div>
        <div class="text-sm text-gray-600">
          Menggunakan logaritma untuk menghindari underflow: log(P(Kelas)) + Σ log(P(Kata|Kelas))
        </div>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
          <div class="text-sm font-bold text-blue-800 mb-2">Prior Probability</div>
          <div class="text-xs font-mono">P(Kelas) = Jumlah dokumen kelas / Total dokumen</div>
          <div class="text-xs text-blue-600 mt-1">Dari data training: <span id="total-training">0</span> data</div>
        </div>
        <div class="p-4 bg-green-50 rounded-lg border border-green-200">
          <div class="text-sm font-bold text-green-800 mb-2">Likelihood</div>
          <div class="text-xs font-mono">P(Kata|Kelas) = (count + 1) / (total_kata + vocab)</div>
          <div class="text-xs text-green-600 mt-1">(Add-One Smoothing)</div>
        </div>
        <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
          <div class="text-sm font-bold text-purple-800 mb-2">Skor Akhir</div>
          <div class="text-xs font-mono">Skor = log(P(Kelas)) + Σ log(P(Kata|Kelas))</div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
      <div>
        <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">1. Kata Kunci Hasil Preprocessing</h4>
        <div id="calc-stem-badges" class="flex flex-wrap gap-2 p-4 bg-white rounded border border-gray-200 min-h-[60px]">
          <span class="text-gray-400 italic">Proses klasifikasi untuk melihat kata kunci</span>
        </div>
      </div>

      <div>
        <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">2. Prior Probability P(Kelas)</h4>
        <div id="calc-prior-scores" class="bg-white p-4 rounded border border-gray-200 space-y-2">
          <div class="text-xs text-gray-600 italic mb-2">
            P(Kelas) = Jumlah Data di Kelas / Total Data Training
          </div>
          <div id="prior-calc-detail">
            <div class="text-gray-400 italic">Data akan muncul setelah klasifikasi</div>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-8">
      <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">3. Likelihood P(Kata|Kelas)</h4>
      <div class="text-xs text-gray-600 italic mb-2">
        Probabilitas setiap kata dalam masing-masing kelas
      </div>
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow">
        <table class="w-full text-sm text-left">
          <thead class="bg-gray-100 text-gray-600 uppercase font-bold text-xs">
            <tr>
              <th class="p-4 border-b border-gray-300">Kata Dasar</th>
              <th class="p-4 border-b border-gray-300 text-center" id="cat-a-title">Kelas A</th>
              <th class="p-4 border-b border-gray-300 text-center" id="cat-b-title">Kelas B</th>
              <th class="p-4 border-b border-gray-300 text-center" id="cat-c-title">Kelas C</th>
            </tr>
          </thead>
          <tbody id="calc-table-body" class="divide-y divide-gray-200">
            <tr>
              <td colspan="4" class="p-4 text-center text-gray-400 italic">
                Masukkan judul dan proses klasifikasi untuk melihat detail.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div>
      <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">4. Skor Akhir (Log Scale)</h4>
      <div id="calc-final-scores" class="bg-white p-4 rounded-lg border border-gray-200 space-y-2 shadow-sm">
        <div class="text-xs text-gray-600 italic mb-2">
          Skor tertinggi menentukan kategori pemenang
        </div>
        <div id="final-calculation-detail">
          <div class="text-gray-400 italic">Perhitungan akan muncul setelah klasifikasi</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// ==================== VARIABEL GLOBAL ====================
let dataTraining = [];
let kategoriDDC = [];
let multipleResults = []; // Untuk menyimpan hasil multiple
let importedExcelData = []; // Untuk menyimpan data Excel yang diimpor
let startTime = 0; // Untuk menghitung waktu processing

// ==================== FUNGSI TAB SWITCHING ====================
function switchTab(tabName) {
    // Update tab buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'text-blue-600', 'border-blue-500');
        btn.classList.add('text-gray-500');
    });
    
    const activeBtn = document.getElementById(`tab-${tabName}`);
    if (activeBtn) {
        activeBtn.classList.add('active', 'text-blue-600', 'border-blue-500');
        activeBtn.classList.remove('text-gray-500');
    }
    
    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    const activeContent = document.getElementById(`tab-content-${tabName}`);
    if (activeContent) {
        activeContent.classList.remove('hidden');
    }
    
    // Reset results view
    document.getElementById('multiple-results-container').classList.add('hidden');
    document.getElementById('hasil-klasifikasi-card').classList.add('hidden');
    document.getElementById('preprocessing-card').classList.add('hidden');
    document.getElementById('detail-container').classList.add('hidden');
    
    feather.replace();
}

// ==================== FUNGSI INPUT MULTIPLE ====================
let multipleInputCounter = 1;

function addMultipleInput() {
    multipleInputCounter++;
    if (multipleInputCounter > 50) { // Maksimal 50 input manual
        alert('Maksimal 50 buku untuk input manual');
        return;
    }
    
    const container = document.getElementById('multiple-input-container');
    const newItem = document.createElement('div');
    newItem.className = 'multiple-input-item mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50';
    newItem.innerHTML = `
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Buku #${multipleInputCounter}</span>
            <button type="button" onclick="removeMultipleInput(this)" class="text-red-500 hover:text-red-700">
                <i data-feather="x" class="w-4 h-4"></i>
            </button>
        </div>
        <input type="text" 
               class="multiple-judul w-full px-4 py-2 input-modern rounded-lg focus:ring-2 focus:ring-blue-500 outline-none mb-3" 
               placeholder="Judul buku"
               required>
        <textarea class="multiple-deskripsi w-full px-4 py-2 input-modern rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm" 
                  rows="2" 
                  placeholder="Deskripsi (opsional)"></textarea>
    `;
    
    container.appendChild(newItem);
    updateManualCount();
    feather.replace();
}

function removeMultipleInput(button) {
    if (multipleInputCounter <= 1) {
        alert('Minimal harus ada 1 input buku');
        return;
    }
    
    const item = button.closest('.multiple-input-item');
    if (item) {
        item.remove();
        multipleInputCounter--;
        
        // Update nomor urut
        updateMultipleInputNumbers();
        updateManualCount();
    }
}

function updateMultipleInputNumbers() {
    const items = document.querySelectorAll('.multiple-input-item');
    items.forEach((item, index) => {
        const titleSpan = item.querySelector('.text-sm.font-medium.text-gray-700');
        if (titleSpan) {
            titleSpan.textContent = `Buku #${index + 1}`;
        }
    });
    multipleInputCounter = items.length;
}

function updateManualCount() {
    const items = document.querySelectorAll('.multiple-input-item');
    const countElement = document.getElementById('manualCount');
    if (countElement) {
        countElement.textContent = items.length;
    }
}

function getMultipleInputData() {
    const manualItems = document.querySelectorAll('.multiple-input-item');
    const data = [];
    let idCounter = 1;
    
    // Ambil data dari input manual
    manualItems.forEach((item, index) => {
        const judul = item.querySelector('.multiple-judul').value.trim();
        const deskripsi = item.querySelector('.multiple-deskripsi').value.trim();
        
        if (judul) { // Hanya ambil yang ada judulnya
            data.push({
                no: idCounter++,
                judul: judul,
                deskripsi: deskripsi,
                source: 'manual'
            });
        }
    });
    
    // Tambahkan data dari Excel jika ada
    importedExcelData.forEach((item, index) => {
        data.push({
            no: idCounter++,
            judul: item.judul,
            deskripsi: item.deskripsi || '',
            source: 'excel'
        });
    });
    
    return data;
}

function resetMultipleInput() {
    const container = document.getElementById('multiple-input-container');
    container.innerHTML = '';
    
    // Reset counter dan tambahkan satu input default
    multipleInputCounter = 0;
    addMultipleInput(); // Ini akan membuat #1
    
    // Reset data Excel
    resetExcelImport();
    
    feather.replace();
}

// ==================== FUNGSI IMPORT EXCEL ====================
function initExcelUpload() {
    const excelFileInput = document.getElementById('excelFile');
    
    excelFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validasi tipe file
        const validTypes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
            'text/csv'
        ];
        
        if (!validTypes.includes(file.type) && !file.name.match(/\.(xlsx|xls|csv)$/i)) {
            alert('Format file tidak didukung. Harap upload file Excel (.xlsx, .xls) atau CSV.');
            resetExcelImport();
            return;
        }
        
        // Validasi ukuran file (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 5MB.');
            resetExcelImport();
            return;
        }
        
        // Parse file Excel
        parseExcelFile(file);
    });
    
    // Drag and drop functionality
    const dropZone = excelFileInput.parentElement;
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-100');
    });
    
    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-100');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-100');
        
        if (e.dataTransfer.files.length) {
            excelFileInput.files = e.dataTransfer.files;
            const event = new Event('change');
            excelFileInput.dispatchEvent(event);
        }
    });
}

function parseExcelFile(file) {
    importedExcelData = []; // Reset data
    
    const reader = new FileReader();
    
    reader.onload = function(e) {
        try {
            const data = e.target.result;
            let workbook;
            
            if (file.name.match(/\.csv$/i)) {
                // Parse CSV
                parseCSVData(data);
            } else {
                // Parse Excel menggunakan SheetJS
                workbook = XLSX.read(data, { type: 'binary' });
                parseExcelData(workbook);
            }
            
            if (importedExcelData.length === 0) {
                throw new Error('Tidak ada data valid yang ditemukan dalam file.');
            }
            
            // Tampilkan preview
            showExcelPreview();
            
            // Aktifkan tombol import
            document.getElementById('importExcelBtn').disabled = false;
            
        } catch (error) {
            console.error('Error parsing Excel:', error);
            alert('Gagal memproses file: ' + error.message);
            resetExcelImport();
        }
    };
    
    reader.onerror = function() {
        alert('Gagal membaca file. Pastikan file tidak rusak.');
        resetExcelImport();
    };
    
    if (file.name.match(/\.csv$/i)) {
        reader.readAsText(file);
    } else {
        reader.readAsBinaryString(file);
    }
}

function parseCSVData(data) {
    const lines = data.split('\n');
    
    // Cari delimiter (koma atau titik koma)
    let delimiter = ',';
    if (lines[0].includes(';') && !lines[0].includes(',')) {
        delimiter = ';';
    }
    
    const headers = lines[0].split(delimiter).map(h => h.trim().toLowerCase()
        .replace(/[\r\n\"]/g, '')
        .replace(/^\uFEFF/, '') // Remove BOM
    );
    
    // Cari kolom yang dibutuhkan
    const judulIndex = headers.findIndex(h => 
        h.includes('judul') || h.includes('title') || h.includes('nama')
    );
    
    if (judulIndex === -1) {
        throw new Error('Kolom judul tidak ditemukan. Pastikan file memiliki kolom "judul" atau "judul_buku".');
    }
    
    const deskripsiIndex = headers.findIndex(h => 
        h.includes('deskripsi') || h.includes('keterangan') || h.includes('desc')
    );
    
    // Parse data (maks 100 baris)
    for (let i = 1; i < Math.min(lines.length, 101); i++) {
        if (lines[i].trim()) {
            const cells = lines[i].split(delimiter).map(cell => 
                cell.trim().replace(/^"|"$/g, '')
            );
            const judul = cells[judulIndex] ? cells[judulIndex].trim() : '';
            
            if (judul) {
                importedExcelData.push({
                    judul: judul,
                    deskripsi: deskripsiIndex >= 0 ? (cells[deskripsiIndex] || '').trim() : ''
                });
            }
        }
    }
}

function parseExcelData(workbook) {
    const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
    const jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
    
    if (jsonData.length < 2) {
        throw new Error('File Excel kosong atau hanya memiliki header');
    }
    
    // Ambil header (baris pertama)
    const headers = jsonData[0].map(h => 
        h ? h.toString().toLowerCase().trim().replace(/[\r\n\"]/g, '') : ''
    );
    
    // Cari kolom yang dibutuhkan
    const judulIndex = headers.findIndex(h => 
        h && (h.includes('judul') || h.includes('title') || h.includes('nama'))
    );
    
    if (judulIndex === -1) {
        throw new Error('Kolom judul tidak ditemukan. Pastikan file memiliki kolom "judul" atau "judul_buku".');
    }
    
    const deskripsiIndex = headers.findIndex(h => 
        h && (h.includes('deskripsi') || h.includes('keterangan') || h.includes('desc'))
    );
    
    // Parse data (maks 100 baris)
    for (let i = 1; i < Math.min(jsonData.length, 101); i++) {
        const row = jsonData[i];
        if (row && row[judulIndex]) {
            const judul = row[judulIndex].toString().trim();
            
            if (judul) {
                importedExcelData.push({
                    judul: judul,
                    deskripsi: deskripsiIndex >= 0 && row[deskripsiIndex] ? 
                              row[deskripsiIndex].toString().trim() : ''
                });
            }
        }
    }
}

function showExcelPreview() {
    const previewBody = document.getElementById('excelPreviewBody');
    const previewContainer = document.getElementById('excelPreview');
    const dataCountElement = document.getElementById('excelDataCount');
    
    // Update count
    if (dataCountElement) {
        dataCountElement.textContent = importedExcelData.length;
    }
    
    // Tampilkan data (maks 10 baris preview)
    let bodyHTML = '';
    const previewLimit = Math.min(importedExcelData.length, 10);
    
    for (let i = 0; i < previewLimit; i++) {
        const item = importedExcelData[i];
        bodyHTML += `
            <tr class="${i % 2 === 0 ? 'bg-white' : 'bg-gray-50'}">
                <td class="p-3 text-sm text-gray-700 font-mono">${i + 1}</td>
                <td class="p-3 text-sm text-gray-800 font-medium">${item.judul.substring(0, 40)}${item.judul.length > 40 ? '...' : ''}</td>
                <td class="p-3 text-sm text-gray-600">${item.deskripsi ? item.deskripsi.substring(0, 30) + (item.deskripsi.length > 30 ? '...' : '') : '-'}</td>
            </tr>
        `;
    }
    
    if (importedExcelData.length > 10) {
        bodyHTML += `
            <tr class="bg-blue-50">
                <td colspan="3" class="p-3 text-center text-sm text-blue-700 font-medium">
                    + ${importedExcelData.length - 10} data lainnya...
                </td>
            </tr>
        `;
    }
    
    previewBody.innerHTML = bodyHTML;
    previewContainer.classList.remove('hidden');
    
    feather.replace();
}

function importFromExcel() {
    if (importedExcelData.length === 0) {
        alert('Tidak ada data Excel yang diimpor. Silakan upload file terlebih dahulu.');
        return;
    }
    
    // Tambahkan data ke input manual (opsional)
    // Atau biarkan hanya di preview, akan diproses bersama saat klasifikasi
    
    alert(`Berhasil mengimpor ${importedExcelData.length} data dari Excel. Data akan diproses bersama dengan input manual.`);
}

function resetExcelImport() {
    document.getElementById('excelFile').value = '';
    document.getElementById('excelPreview').classList.add('hidden');
    document.getElementById('importExcelBtn').disabled = true;
    importedExcelData = [];
}

// ==================== FUNGSI KLASIFIKASI MULTIPLE ====================
async function prosesKlasifikasiMultiple() {
    startTime = Date.now();
    
    const inputData = getMultipleInputData();
    
    if (inputData.length === 0) {
        alert('Silakan masukkan minimal satu judul buku (manual atau dari Excel)');
        return;
    }
    
    // Validasi data
    const manualItems = document.querySelectorAll('.multiple-input-item');
    let hasManualData = false;
    
    manualItems.forEach(item => {
        const judul = item.querySelector('.multiple-judul').value.trim();
        if (judul) hasManualData = true;
    });
    
    if (!hasManualData && importedExcelData.length === 0) {
        alert('Silakan masukkan minimal satu judul buku');
        return;
    }
    
    // Tampilkan loading
    showLoading('Memproses ' + inputData.length + ' buku...');
    
    // Load data training
    loadAllData();
    
    if (dataTraining.length === 0) {
        hideLoading();
        alert('Data training kosong. Silakan tambah data training terlebih dahulu.');
        return;
    }
    
    // Build model sekali saja
    const model = buildNaiveBayesModel(dataTraining);
    if (!model) {
        hideLoading();
        alert('Gagal membangun model dari data training');
        return;
    }
    
    multipleResults = [];
    
    // Proses setiap buku dengan delay untuk UI yang responsif
    for (let i = 0; i < inputData.length; i++) {
        const item = inputData[i];
        const teksGabungan = item.deskripsi ? `${item.judul} ${item.deskripsi}` : item.judul;
        
        const result = classifyWithNaiveBayes(teksGabungan, model);
        
        multipleResults.push({
            no: item.no,
            judul: item.judul,
            deskripsi: item.deskripsi || '',
            kode: result.kode,
            kategori: result.nama,
            confidence: result.confidence,
            waktu: new Date().toLocaleString('id-ID'),
            source: item.source
        });
        
        // Update progress
        updateLoadingProgress(Math.round(((i + 1) / inputData.length) * 100));
        
        // Beri sedikit delay untuk UI yang responsif (untuk jumlah data banyak)
        if (inputData.length > 20 && i < inputData.length - 1) {
            await new Promise(resolve => setTimeout(resolve, 10));
        }
    }
    
    hideLoading();
    showMultipleResults();
}

function showMultipleResults() {
    // Sembunyikan semua tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Tampilkan results container
    const resultsContainer = document.getElementById('multiple-results-container');
    resultsContainer.classList.remove('hidden');
    
    // Hitung waktu processing
    const processingTime = ((Date.now() - startTime) / 1000).toFixed(2);
    document.getElementById('processing-time').textContent = processingTime;
    
    // Update total count
    document.getElementById('total-books-count').textContent = multipleResults.length;
    
    // Tampilkan data dalam tabel
    const tbody = document.getElementById('multiple-results-body');
    let html = '';
    
    multipleResults.forEach((result, index) => {
        const confidenceColor = result.confidence >= 80 ? 'text-green-600' : 
                              result.confidence >= 60 ? 'text-yellow-600' : 'text-red-600';
        const confidenceBg = result.confidence >= 80 ? 'bg-green-100' : 
                           result.confidence >= 60 ? 'bg-yellow-100' : 'bg-red-100';
        
        html += `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-4 text-sm text-gray-700 font-mono">${result.no}</td>
                <td class="p-4">
                    <div class="font-medium text-gray-800">${result.judul}</div>
                    ${result.source === 'excel' ? 
                      `<span class="inline-block mt-1 px-2 py-0.5 text-xs bg-blue-100 text-blue-700 rounded">Excel</span>` : 
                      `<span class="inline-block mt-1 px-2 py-0.5 text-xs bg-gray-100 text-gray-700 rounded">Manual</span>`}
                </td>
                <td class="p-4 text-sm text-gray-600">${result.deskripsi || '-'}</td>
                <td class="p-4">
                    <div class="font-bold text-blue-700 font-mono text-center">${result.kode}</div>
                </td>
                <td class="p-4">
                    <div class="font-medium text-gray-800">${result.kategori}</div>
                </td>
                <td class="p-4">
                    <div class="flex items-center">
                        <div class="w-16 mr-3">
                            <div class="text-sm font-bold ${confidenceColor}">${result.confidence}%</div>
                        </div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full ${result.confidence >= 80 ? 'bg-green-500' : result.confidence >= 60 ? 'bg-yellow-500' : 'bg-red-500'}" 
                                     style="width: ${result.confidence}%"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="p-4">
                    <button onclick="viewSingleResult(${index})" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-all duration-300 text-xs flex items-center">
                        <i data-feather="eye" class="w-3 h-3 mr-1"></i> Detail
                    </button>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    
    // Simpan ke riwayat batch
    saveBatchToHistory();
    
    feather.replace();
}

function closeMultipleResults() {
    document.getElementById('multiple-results-container').classList.add('hidden');
    // Kembali ke tab multiple
    switchTab('multiple');
}

function viewSingleResult(index) {
    if (multipleResults[index]) {
        const result = multipleResults[index];
        
        // Set nilai input di tab single
        document.getElementById('inputJudul').value = result.judul;
        document.getElementById('inputDeskripsi').value = result.deskripsi;
        
        // Switch ke tab single
        switchTab('single');
        
        // Trigger klasifikasi
        setTimeout(() => {
            prosesKlasifikasi();
            
            // Scroll ke hasil
            const hasilCard = document.getElementById('hasil-klasifikasi-card');
            if (hasilCard) {
                hasilCard.scrollIntoView({ behavior: 'smooth' });
            }
        }, 100);
    }
}

// ==================== FUNGSI EKSPOR HASIL ====================
function exportResultsToExcel() {
    if (multipleResults.length === 0) {
        alert('Tidak ada data untuk diexport');
        return;
    }
    
    // Buat worksheet
    const wsData = [
        ['No', 'Judul Buku', 'Deskripsi', 'Kode DDC', 'Kategori', 'Confidence (%)', 'Waktu Prediksi', 'Sumber']
    ];
    
    multipleResults.forEach(result => {
        wsData.push([
            result.no,
            result.judul,
            result.deskripsi || '',
            result.kode,
            result.kategori,
            result.confidence,
            result.waktu,
            result.source === 'excel' ? 'Impor Excel' : 'Input Manual'
        ]);
    });
    
    const ws = XLSX.utils.aoa_to_sheet(wsData);
    
    // Set column widths
    const wscols = [
        { wch: 5 },  // No
        { wch: 50 }, // Judul
        { wch: 40 }, // Deskripsi
        { wch: 10 }, // Kode
        { wch: 30 }, // Kategori
        { wch: 12 }, // Confidence
        { wch: 20 }, // Waktu
        { wch: 12 }  // Sumber
    ];
    ws['!cols'] = wscols;
    
    // Style header
    if (ws['!ref']) {
        const range = XLSX.utils.decode_range(ws['!ref']);
        for (let C = range.s.c; C <= range.e.c; ++C) {
            const cell = XLSX.utils.encode_cell({r: 0, c: C});
            if (!ws[cell]) continue;
            ws[cell].s = {
                fill: { fgColor: { rgb: "4F81BD" } },
                font: { bold: true, color: { rgb: "FFFFFF" } },
                alignment: { horizontal: "center" }
            };
        }
    }
    
    // Buat workbook
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Hasil Klasifikasi');
    
    // Export ke file
    const fileName = `hasil_klasifikasi_ddc_${new Date().toISOString().slice(0,10)}.xlsx`;
    XLSX.writeFile(wb, fileName);
}

function exportResultsToPDF() {
    if (multipleResults.length === 0) {
        alert('Tidak ada data untuk diexport');
        return;
    }
    
    // Buat konten PDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');
    
    // Judul
    doc.setFontSize(16);
    doc.text('Hasil Klasifikasi DDC', 105, 20, { align: 'center' });
    doc.setFontSize(10);
    doc.text(`Dicetak pada: ${new Date().toLocaleString('id-ID')}`, 105, 27, { align: 'center' });
    doc.text(`Total data: ${multipleResults.length} buku | Waktu proses: ${((Date.now() - startTime) / 1000).toFixed(2)} detik`, 105, 32, { align: 'center' });
    
    // Buat tabel
    const startY = 40;
    const headers = [['No', 'Judul Buku', 'Kode DDC', 'Kategori', 'Confidence']];
    
    const rows = multipleResults.map(result => [
        result.no.toString(),
        result.judul.substring(0, 30) + (result.judul.length > 30 ? '...' : ''),
        result.kode,
        result.kategori,
        result.confidence + '%'
    ]);
    
    doc.autoTable({
        head: headers,
        body: rows,
        startY: startY,
        theme: 'grid',
        headStyles: { 
            fillColor: [59, 130, 246],
            textColor: 255,
            fontStyle: 'bold'
        },
        columnStyles: {
            0: { cellWidth: 10, halign: 'center' },
            1: { cellWidth: 80 },
            2: { cellWidth: 20, halign: 'center' },
            3: { cellWidth: 40 },
            4: { cellWidth: 25, halign: 'center' }
        },
        margin: { left: 10, right: 10 },
        styles: { fontSize: 8 },
        headStyles: { fontSize: 9 }
    });
    
    // Footer
    const pageCount = doc.internal.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(8);
        doc.text(`Halaman ${i} dari ${pageCount}`, 105, 287, { align: 'center' });
    }
    
    // Simpan PDF
    doc.save(`hasil_klasifikasi_ddc_${new Date().toISOString().slice(0,10)}.pdf`);
}

// ==================== FUNGSI LOADING ====================
function showLoading(message = 'Memproses...') {
    // Create loading overlay if not exists
    let loadingOverlay = document.getElementById('loading-overlay');
    if (!loadingOverlay) {
        loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loading-overlay';
        loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        loadingOverlay.innerHTML = `
            <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl">
                <div class="flex flex-col items-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                    <div id="loading-message" class="text-lg font-medium text-gray-800 mb-2">${message}</div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                        <div id="loading-progress" class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <div id="loading-percentage" class="text-sm text-gray-600">0%</div>
                </div>
            </div>
        `;
        document.body.appendChild(loadingOverlay);
    } else {
        loadingOverlay.classList.remove('hidden');
        document.getElementById('loading-message').textContent = message;
        document.getElementById('loading-progress').style.width = '0%';
        document.getElementById('loading-percentage').textContent = '0%';
    }
}

function updateLoadingProgress(percent) {
    const progressBar = document.getElementById('loading-progress');
    const percentageText = document.getElementById('loading-percentage');
    
    if (progressBar && percentageText) {
        progressBar.style.width = percent + '%';
        percentageText.textContent = percent + '%';
    }
}

function hideLoading() {
    const loadingOverlay = document.getElementById('loading-overlay');
    if (loadingOverlay) {
        setTimeout(() => {
            loadingOverlay.classList.add('hidden');
        }, 500);
    }
}

// ==================== FUNGSI BATCH HISTORY ====================
function saveBatchToHistory() {
    if (!window.riwayatKlasifikasi) {
        window.riwayatKlasifikasi = [];
    }
    
    multipleResults.forEach(result => {
        const newEntry = {
            id: Date.now() + Math.random(),
            judul: result.judul,
            kode: result.kode,
            kategori: result.kategori,
            waktu: result.waktu,
            confidence: result.confidence,
            batch: true,
            source: result.source
        };
        
        window.riwayatKlasifikasi.unshift(newEntry);
    });
    
    // Simpan ke localStorage
    localStorage.setItem("riwayatKlasifikasi", JSON.stringify(window.riwayatKlasifikasi));
    
    if (window.updateStats) {
        window.updateStats();
    }
}

// ==================== FUNGSI YANG SUDAH ADA (DIMODIFIKASI) ====================
// Fungsi untuk memuat data dari localStorage
function loadAllData() {
    console.log('Loading data from localStorage...');
    
    // Load data training dari localStorage
    try {
        const storedTraining = localStorage.getItem('dataTraining');
        if (storedTraining) {
            dataTraining = JSON.parse(storedTraining);
            console.log('Data training loaded:', dataTraining.length, 'items');
        } else {
            console.log('No data training found in localStorage');
            dataTraining = [];
        }
    } catch (error) {
        console.error('Error loading training data:', error);
        dataTraining = [];
    }
    
    // Load kategori DDC dari localStorage
    try {
        const storedKategori = localStorage.getItem('kategoriDDC');
        if (storedKategori) {
            kategoriDDC = JSON.parse(storedKategori);
            console.log('Kategori DDC loaded:', kategoriDDC.length, 'categories');
        } else {
            // Fallback ke data default jika tidak ada di localStorage
            kategoriDDC = [
                { kode: "000", nama: "Karya Umum" },
                { kode: "001", nama: "Pengetahuan" },
                { kode: "002", nama: "Buku" },
                { kode: "003", nama: "Sistem" },
                { kode: "004", nama: "Ilmu Komputer" },
                { kode: "005", nama: "Pemrograman" },
                { kode: "006", nama: "Data Processing" },
                { kode: "010", nama: "Bibliografi" },
                { kode: "020", nama: "Ilmu Perpustakaan" },
                { kode: "030", nama: "Ensiklopedia" },
                { kode: "050", nama: "Majalah" },
                { kode: "060", nama: "Organisasi" },
                { kode: "070", nama: "Jurnalisme" },
                { kode: "080", nama: "Kumpulan Karya" },
                { kode: "090", nama: "Manuskrip" },
                { kode: "100", nama: "Filsafat dan Psikologi" },
                { kode: "200", nama: "Agama" },
                { kode: "300", nama: "Ilmu Sosial" },
                { kode: "400", nama: "Bahasa" },
                { kode: "500", nama: "Ilmu Pengetahuan Alam" },
                { kode: "510", nama: "Matematika" },
                { kode: "520", nama: "Astronomi" },
                { kode: "530", nama: "Fisika" },
                { kode: "540", nama: "Kimia" },
                { kode: "550", nama: "Geologi" },
                { kode: "560", nama: "Paleontologi" },
                { kode: "570", nama: "Biologi" },
                { kode: "600", nama: "Teknologi" },
                { kode: "700", nama: "Kesenian dan Olahraga" },
                { kode: "800", nama: "Kesusastraan" },
                { kode: "900", nama: "Sejarah dan Geografi" },
                { kode: "910", nama: "Geografi dan Perjalanan" }
            ];
            console.log('Using default kategori DDC');
        }
    } catch (error) {
        console.error('Error loading kategori DDC:', error);
    }
    
    // Update display
    updateDataDisplay();
}

// Update tampilan data
function updateDataDisplay() {
    // Update total training data di rumus
    const totalTrainingEl = document.getElementById('total-training');
    if (totalTrainingEl) {
        totalTrainingEl.textContent = dataTraining.length;
    }
}

// Preprocessing teks
function preprocessText(text) {
    if (!text) return '';
    
    text = text.toLowerCase()
        .replace(/[^\w\s]/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();
    
    let tokens = text.split(' ');
    
    const stopwords = ['dan', 'di', 'ke', 'dari', 'untuk', 'pada', 'yang', 'dengan', 
                      'adalah', 'atau', 'ini', 'itu', 'sebagai', 'oleh', 'dalam',
                      'tidak', 'bisa', 'dapat', 'akan', 'telah', 'sudah', 'agar',
                      'karena', 'jika', 'seperti', 'dari', 'pada', 'dalam', 'untuk'];
    
    tokens = tokens.filter(token => {
        return !stopwords.includes(token) && token.length > 1;
    });
    
    tokens = tokens.map(token => {
        if (token.endsWith('nya')) return token.slice(0, -3);
        if (token.endsWith('lah')) return token.slice(0, -3);
        if (token.endsWith('kah')) return token.slice(0, -3);
        if (token.endsWith('pun')) return token.slice(0, -3);
        if (token.endsWith('an') && token.length > 3) return token.slice(0, -2);
        if (token.endsWith('i') && token.length > 3) return token.slice(0, -1);
        return token;
    });
    
    return tokens.join(' ');
}

// Preprocessing untuk debug
function preprocessTextForDebug(text) {
    const result = { clean: '', tokens: [], filtered: [], stem: [] };
    
    if (!text) return result;
    
    result.clean = text.toLowerCase()
        .replace(/[^\w\s]/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();
    
    result.tokens = result.clean.split(' ').filter(t => t.length > 0);
    
    const stopwords = ['dan', 'di', 'ke', 'dari', 'untuk', 'pada', 'yang', 'dengan', 
                      'adalah', 'atau', 'ini', 'itu', 'sebagai', 'oleh', 'dalam'];
    
    result.filtered = result.tokens.filter(token => 
        !stopwords.includes(token) && token.length > 1
    );
    
    result.stem = result.filtered.map(token => {
        if (token.endsWith('nya')) return token.slice(0, -3);
        if (token.endsWith('lah')) return token.slice(0, -3);
        if (token.endsWith('kah')) return token.slice(0, -3);
        if (token.endsWith('pun')) return token.slice(0, -3);
        if (token.endsWith('an') && token.length > 3) return token.slice(0, -2);
        if (token.endsWith('i') && token.length > 3) return token.slice(0, -1);
        return token;
    });
    
    return result;
}

// Cari kategori berdasarkan kode
function getCategoryByCode(kode) {
    if (!kode || !kategoriDDC || kategoriDDC.length === 0) {
        return { kode: kode || "000", nama: "Tidak Diketahui" };
    }
    
    // Cari exact match
    const exactMatch = kategoriDDC.find(c => c.kode === kode);
    if (exactMatch) {
        return exactMatch;
    }
    
    // Cari partial match (3 digit pertama)
    if (kode.length >= 3) {
        const prefix = kode.substring(0, 3);
        const prefixMatch = kategoriDDC.find(c => c.kode === prefix);
        if (prefixMatch) {
            return prefixMatch;
        }
    }
    
    // Fallback ke kode terdekat
    const closest = kategoriDDC.find(c => kode.startsWith(c.kode.substring(0, 2)));
    if (closest) {
        return closest;
    }
    
    // Default
    return { kode: kode, nama: "Kategori " + kode };
}

// Build model Naive Bayes dari data training
function buildNaiveBayesModel(trainingData) {
    if (!trainingData || trainingData.length === 0) {
        console.error('No training data available');
        return null;
    }

    console.log('Building model from', trainingData.length, 'training data');
    
    const model = {
        categories: {},
        vocabulary: new Set(),
        totalDocs: trainingData.length,
        categoryDocs: {},
        categoryWordCounts: {},
        categoryWordFreq: {}
    };

    trainingData.forEach((item, index) => {
        // Ambil kode kategori dari data training
        let category = "000"; // default
        
        if (item.kode) {
            category = item.kode;
        } else if (item.kategori) {
            // Format: "kode|nama" atau "nama" saja
            if (item.kategori.includes('|')) {
                category = item.kategori.split('|')[0];
            } else {
                // Cari kode dari nama kategori
                const foundCat = kategoriDDC.find(c => c.nama === item.kategori);
                if (foundCat) {
                    category = foundCat.kode;
                }
            }
        }
        
        const text = preprocessText(item.judul + ' ' + (item.deskripsi || ''));
        const words = text.split(' ').filter(w => w.length > 0);

        if (!model.categories[category]) {
            model.categories[category] = true;
            model.categoryDocs[category] = 0;
            model.categoryWordCounts[category] = 0;
            model.categoryWordFreq[category] = {};
        }

        model.categoryDocs[category]++;
        model.categoryWordCounts[category] += words.length;

        words.forEach(word => {
            model.vocabulary.add(word);
            if (!model.categoryWordFreq[category][word]) {
                model.categoryWordFreq[category][word] = 0;
            }
            model.categoryWordFreq[category][word]++;
        });
    });

    console.log('Model built with categories:', Object.keys(model.categories));
    return model;
}

// Klasifikasi dengan Naive Bayes
function classifyWithNaiveBayes(text, model) {
    if (!model || model.totalDocs === 0) {
        const defaultCat = getCategoryByCode("000");
        return { 
            kode: defaultCat.kode, 
            nama: defaultCat.nama, 
            confidence: 0,
            details: {} 
        };
    }

    const processedText = preprocessText(text);
    const words = processedText.split(' ').filter(w => w.length > 0);
    
    const scores = {};
    const details = {
        words: words,
        priorProbabilities: {},
        likelihoods: {},
        categoryScores: {}
    };

    const vocabularySize = model.vocabulary.size;
    const categories = Object.keys(model.categories);

    console.log('Classifying with categories:', categories);

    categories.forEach(category => {
        const totalDocsInCategory = model.categoryDocs[category] || 1;
        const totalWordsInCategory = model.categoryWordCounts[category] || 1;
        
        const prior = totalDocsInCategory / model.totalDocs;
        details.priorProbabilities[category] = prior;
        
        let logScore = Math.log(prior);
        
        const wordLikelihoods = {};
        words.forEach(word => {
            const wordFreq = model.categoryWordFreq[category][word] || 0;
            const likelihood = (wordFreq + 1) / (totalWordsInCategory + vocabularySize);
            wordLikelihoods[word] = likelihood;
            logScore += Math.log(likelihood);
        });
        
        details.likelihoods[category] = wordLikelihoods;
        scores[category] = { 
            logScore: logScore, 
            score: Math.exp(logScore),
            prior: prior
        };
    });

    const sortedCategories = Object.keys(scores)
        .sort((a, b) => scores[b].logScore - scores[a].logScore);

    const winnerCode = sortedCategories[0] || "000";
    const secondCode = sortedCategories[1];
    
    let confidence = 0;
    if (winnerCode && scores[winnerCode] && secondCode && scores[secondCode]) {
        const winnerExp = Math.exp(scores[winnerCode].logScore);
        const secondExp = Math.exp(scores[secondCode].logScore);
        confidence = Math.round((winnerExp / (winnerExp + secondExp)) * 100);
    } else {
        confidence = 100;
    }
    
    const categoryInfo = getCategoryByCode(winnerCode);
    
    details.categoryScores = scores;
    
    console.log('Classification result:', {
        kode: winnerCode,
        nama: categoryInfo.nama,
        confidence: confidence,
        top3: sortedCategories.slice(0, 3)
    });
    
    return {
        kode: winnerCode,
        nama: categoryInfo.nama,
        confidence: confidence,
        details: details,
        sortedCategories: sortedCategories
    };
}

// Fungsi utama klasifikasi (untuk single)
function prosesKlasifikasi() {
    const judulInput = document.getElementById("inputJudul");
    const judul = judulInput.value.trim();
    
    if (!judul) {
        // Tampilkan hasil dengan pesan error
        document.getElementById("hasil-klasifikasi-card").classList.remove("hidden");
        document.getElementById("result-category").textContent = "Judul harus diisi";
        document.getElementById("result-code").textContent = "000";
        document.getElementById("result-category-desc").textContent = "Silakan masukkan judul buku";
        document.getElementById("result-prob-text").textContent = "0%";
        document.getElementById("result-prob-bar").style.width = "0%";
        return;
    }

    // Load data terbaru
    loadAllData();
    
    // Cek data training
    if (dataTraining.length === 0) {
        document.getElementById("hasil-klasifikasi-card").classList.remove("hidden");
        document.getElementById("result-category").textContent = "Data Training Kosong";
        document.getElementById("result-code").textContent = "000";
        document.getElementById("result-category-desc").textContent = "Silakan tambah data training terlebih dahulu";
        document.getElementById("result-prob-text").textContent = "0%";
        document.getElementById("result-prob-bar").style.width = "0%";
        return;
    }

    const deskripsiInput = document.getElementById("inputDeskripsi");
    const deskripsi = deskripsiInput.value.trim();
    const teksGabungan = deskripsi ? `${judul} ${deskripsi}` : judul;

    // Build model dari data training
    const model = buildNaiveBayesModel(dataTraining);
    
    if (!model) {
        document.getElementById("hasil-klasifikasi-card").classList.remove("hidden");
        document.getElementById("result-category").textContent = "Gagal Membuat Model";
        document.getElementById("result-code").textContent = "000";
        document.getElementById("result-category-desc").textContent = "Data training tidak valid";
        document.getElementById("result-prob-text").textContent = "0%";
        document.getElementById("result-prob-bar").style.width = "0%";
        return;
    }

    // Tampilkan HASIL KLASIFIKASI di POSISI ATAS
    document.getElementById("hasil-klasifikasi-card").classList.remove("hidden");
    
    // Lakukan klasifikasi
    const result = classifyWithNaiveBayes(teksGabungan, model);
    
    // Tampilkan hasil klasifikasi
    document.getElementById("result-category").textContent = result.nama;
    document.getElementById("result-code").textContent = result.kode;
    document.getElementById("result-category-desc").textContent = "Kategori terdeteksi dari data training";
    document.getElementById("result-prob-text").textContent = result.confidence + "%";
    
    const bar = document.getElementById("result-prob-bar");
    bar.style.width = "0%";
    setTimeout(() => {
        bar.style.width = result.confidence + "%";
    }, 100);

    // Tampilkan PREPROCESSING di POSISI TENGAH
    document.getElementById("preprocessing-card").classList.remove("hidden");
    const debugResult = preprocessTextForDebug(teksGabungan);
    
    document.getElementById("preprocessing-cleaning").textContent = debugResult.clean || "(tidak ada teks)";
    document.getElementById("preprocessing-tokenizing").innerHTML = debugResult.tokens.map(
        t => `<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded border border-gray-200 text-xs font-mono mr-1 mb-1 inline-block">${t}</span>`
    ).join('') || '<span class="text-gray-400 italic">Tidak ada token</span>';
    
    document.getElementById("preprocessing-stopword").innerHTML = debugResult.filtered.map(
        t => `<span class="bg-blue-50 text-blue-700 px-2 py-1 rounded border border-blue-100 text-xs font-semibold mr-1 mb-1 inline-block">${t}</span>`
    ).join('') || '<span class="text-gray-400 italic">Semua token dihapus sebagai stopword</span>';
    
    document.getElementById("preprocessing-stemming").innerHTML = debugResult.stem.map(
        t => `<span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded border border-indigo-100 text-xs font-bold mr-1 mb-1 inline-block">${t}</span>`
    ).join('') || '<span class="text-gray-400 italic">Tidak ada kata dasar</span>';

    // Tampilkan DETAIL PERHITUNGAN di POSISI BAWAH
    showNaiveBayesDetails(result.details, result.kode, debugResult.stem, model);

    // Simpan ke riwayat
    saveToHistory(judul, result.kode, result.nama, result.confidence);
    
    // Update feather icons
    if (typeof feather !== "undefined") {
        feather.replace();
    }
}

// Tampilkan detail perhitungan
function showNaiveBayesDetails(details, winnerCode, stemTokens, model) {
    // Tampilkan kata kunci
    const stemBadges = document.getElementById("calc-stem-badges");
    if (stemTokens && stemTokens.length > 0) {
        stemBadges.innerHTML = stemTokens.map(
            t => `<span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded border border-indigo-100 text-xs font-bold mr-1 mb-1 inline-block">${t}</span>`
        ).join('');
    } else {
        stemBadges.innerHTML = '<span class="text-gray-400 italic">Tidak ada kata kunci yang valid</span>';
    }

    // Ambil 3 kategori teratas
    const categories = Object.keys(details.categoryScores || {})
        .sort((a, b) => (details.categoryScores[b]?.logScore || 0) - (details.categoryScores[a]?.logScore || 0))
        .slice(0, 3);

    // Set judul kolom dengan nama kategori
    if (categories[0]) {
        const catAInfo = getCategoryByCode(categories[0]);
        document.getElementById("cat-a-title").innerHTML = 
            `<div class="font-bold">${categories[0]}</div>
             <div class="text-xs text-gray-600">${catAInfo.nama}</div>`;
    }
    if (categories[1]) {
        const catBInfo = getCategoryByCode(categories[1]);
        document.getElementById("cat-b-title").innerHTML = 
            `<div>${categories[1]}</div>
             <div class="text-xs text-gray-600">${catBInfo.nama}</div>`;
    }
    if (categories[2]) {
        const catCInfo = getCategoryByCode(categories[2]);
        document.getElementById("cat-c-title").innerHTML = 
            `<div>${categories[2]}</div>
             <div class="text-xs text-gray-600">${catCInfo.nama}</div>`;
    }

    // Tampilkan prior probabilities
    const priorDetail = document.getElementById("prior-calc-detail");
    if (categories.length > 0 && model) {
        priorDetail.innerHTML = categories.map(cat => {
            const prior = details.priorProbabilities[cat] || 0;
            const catInfo = getCategoryByCode(cat);
            const docCount = model.categoryDocs[cat] || 0;
            const totalDocs = model.totalDocs;
            const isWinner = cat === winnerCode;
            
            return `
                <div class="flex justify-between items-center text-xs text-gray-700 ${isWinner ? 'bg-green-50 font-bold p-2 rounded' : 'p-1'}">
                    <div>
                        <div class="font-medium">${catInfo.nama}</div>
                        <div class="text-gray-500 text-xs">${cat} (${docCount}/${totalDocs} data)</div>
                    </div>
                    <span class="font-mono font-bold">${prior.toFixed(4)}</span>
                </div>
            `;
        }).join('');
    }

    // Tampilkan likelihood table
    const tbody = document.getElementById("calc-table-body");
    const wordsToShow = details.words ? details.words.slice(0, 6) : [];
    
    if (wordsToShow.length === 0 || categories.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-400 italic">
                    Tidak ada data perhitungan
                </td>
            </tr>
        `;
    } else {
        let tableHTML = '';
        wordsToShow.forEach(word => {
            tableHTML += `<tr class="border-b border-gray-200 hover:bg-gray-50">`;
            tableHTML += `<td class="p-3 font-medium text-sm text-gray-700">${word}</td>`;
            
            categories.forEach((cat, idx) => {
                const likelihood = details.likelihoods?.[cat]?.[word] || 0.0001;
                const isWinner = cat === winnerCode;
                const cellClass = `p-3 text-center text-xs ${isWinner ? 'text-green-700 font-bold bg-green-50' : 'text-gray-600'}`;
                
                tableHTML += `<td class="${cellClass}">${likelihood.toFixed(4)}</td>`;
            });
            
            tableHTML += `</tr>`;
        });
        tbody.innerHTML = tableHTML;
    }

    // Tampilkan skor akhir
    const finalDetail = document.getElementById("final-calculation-detail");
    if (categories.length > 0) {
        finalDetail.innerHTML = categories.map(cat => {
            const score = details.categoryScores?.[cat]?.logScore || 0;
            const catInfo = getCategoryByCode(cat);
            const isWinner = cat === winnerCode;
            
            return `
                <div class="flex justify-between items-center text-xs p-3 rounded-lg ${isWinner ? 'bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 font-bold' : 'bg-gray-100'}">
                    <div>
                        <div class="font-medium">${catInfo.nama}</div>
                        <div class="text-gray-500 text-xs">${cat}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-mono font-bold text-lg ${isWinner ? 'text-green-700' : 'text-gray-700'}">${score.toFixed(4)}</div>
                        ${isWinner ? '<div class="text-xs text-green-600 font-bold">PEMENANG</div>' : ''}
                    </div>
                </div>
            `;
        }).join('');
    }
}

// Simpan ke riwayat (single)
function saveToHistory(judul, kode, kategori, confidence) {
    const newEntry = {
        id: Date.now(),
        judul: judul,
        kode: kode,
        kategori: kategori,
        waktu: new Date().toLocaleString('id-ID'),
        confidence: confidence
    };

    if (!window.riwayatKlasifikasi) {
        window.riwayatKlasifikasi = [];
    }
    
    window.riwayatKlasifikasi.unshift(newEntry);
    localStorage.setItem("riwayatKlasifikasi", JSON.stringify(window.riwayatKlasifikasi));

    if (window.updateStats) {
        window.updateStats();
    }
}

// Reset input
function resetInput() {
    document.getElementById("inputJudul").value = "";
    document.getElementById("inputDeskripsi").value = "";
    
    // Sembunyikan semua card
    document.getElementById("hasil-klasifikasi-card").classList.add("hidden");
    document.getElementById("preprocessing-card").classList.add("hidden");
    document.getElementById("detail-container").classList.add("hidden");
    
    // Reset tombol detail
    const btnText = document.getElementById("btn-text");
    const btnIcon = document.getElementById("btn-icon");
    
    if (btnText) btnText.textContent = "Tampilkan Detail Perhitungan Naive Bayes";
    if (btnIcon) btnIcon.style.transform = "rotate(0deg)";
}

// Toggle detail perhitungan
function toggleDetail() {
    const el = document.getElementById("detail-container");
    const btnText = document.getElementById("btn-text");
    const btnIcon = document.getElementById("btn-icon");

    if (!el || !btnText || !btnIcon) return;

    if (el.classList.contains("hidden")) {
        el.classList.remove("hidden");
        btnText.textContent = "Sembunyikan Detail Perhitungan";
        btnIcon.style.transform = "rotate(180deg)";
    } else {
        el.classList.add("hidden");
        btnText.textContent = "Tampilkan Detail Perhitungan Naive Bayes";
        btnIcon.style.transform = "rotate(0deg)";
    }
    
    if (typeof feather !== "undefined") {
        feather.replace();
    }
}

// ==================== INISIALISASI ====================
document.addEventListener('DOMContentLoaded', function() {
    // Load data dari localStorage
    loadAllData();
    
    // Inisialisasi Excel upload
    initExcelUpload();
    
    // Load SheetJS library jika belum ada
    if (typeof XLSX === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js';
        script.onload = function() {
            console.log('SheetJS library loaded');
        };
        document.head.appendChild(script);
    }
    
    // Load jsPDF library jika belum ada
    if (typeof window.jspdf === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
        script.onload = function() {
            const script2 = document.createElement('script');
            script2.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js';
            document.head.appendChild(script2);
        };
        document.head.appendChild(script);
    }
    
    // Update feather icons
    if (typeof feather !== "undefined") {
        feather.replace();
    }
});

// ==================== EKSPOS FUNGSI KE GLOBAL ====================
window.prosesKlasifikasi = prosesKlasifikasi;
window.prosesKlasifikasiMultiple = prosesKlasifikasiMultiple;
window.resetInput = resetInput;
window.toggleDetail = toggleDetail;
window.loadAllData = loadAllData;
window.switchTab = switchTab;
window.addMultipleInput = addMultipleInput;
window.removeMultipleInput = removeMultipleInput;
window.resetMultipleInput = resetMultipleInput;
window.resetExcelImport = resetExcelImport;
window.importFromExcel = importFromExcel;
window.closeMultipleResults = closeMultipleResults;
window.viewSingleResult = viewSingleResult;
window.exportResultsToExcel = exportResultsToExcel;
window.exportResultsToPDF = exportResultsToPDF;
</script>