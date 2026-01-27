<?php
// Halaman Klasifikasi Smart DDC - Full Logic + Local Calculation + Auto Save to History DB
?>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<div id="page-klasifikasi" class="font-sans text-gray-800">
  
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Klasifikasi Buku DDC</h1>
    <p class="text-gray-600">
      Masukkan detail buku untuk menentukan kelas DDC menggunakan algoritma Naive Bayes berdasarkan data training.
    </p>
  </div>

  <div class="mb-6">
    <div class="border-b border-gray-200">
      <nav class="flex -mb-px">
        <button id="tab-single" onclick="switchTab('single')" class="tab-button active py-4 px-6 text-sm font-bold text-center border-b-2 border-blue-600 text-blue-600 transition-all duration-300 flex items-center">
          <i data-feather="book" class="w-4 h-4 mr-2"></i> Input Tunggal
        </button>
        <button id="tab-multiple" onclick="switchTab('multiple')" class="tab-button py-4 px-6 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-300 transition-all duration-300 flex items-center">
          <i data-feather="list" class="w-4 h-4 mr-2"></i> Input Multiple
        </button>
      </nav>
    </div>
  </div>

  <div class="space-y-8">
    
    <div id="tab-content-single" class="tab-content">
      
      <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r shadow-sm flex items-start animate-fadeIn">
          <div class="flex-shrink-0">
              <i data-feather="info" class="h-5 w-5 text-blue-500"></i>
          </div>
          <div class="ml-3">
              <p class="text-sm text-blue-800 font-medium">
                  Petunjuk Pengisian:
              </p>
              <p class="text-sm text-blue-700 mt-1">
                  Masukkan <strong>Judul Buku</strong> dan <strong>Deskripsi</strong> secara lengkap untuk hasil yang akurat. Sistem akan otomatis memprediksi klasifikasi DDC.
              </p>
              <p class="text-xs text-blue-500 mt-2 border-t border-blue-200 pt-2 font-mono" id="model-status-text">
                  Status Model: Memeriksa...
              </p>
          </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
           <i data-feather="edit-3" class="mr-2 w-5 h-5 text-blue-600"></i> Form Input Buku
        </h2>

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
          <input type="text" id="inputJudul" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-lg placeholder-gray-400 transition-all"
            placeholder="Contoh: Belajar Jaringan Komputer" required />
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Deskripsi Singkat <span class="text-gray-400 text-xs">(Opsional - meningkatkan akurasi)</span>
          </label>
          <textarea id="inputDeskripsi" rows="4" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none placeholder-gray-400 transition-all"
            placeholder="Deskripsi singkat buku..."></textarea>
        </div>

        <div class="flex gap-4">
            <button onclick="resetInput()" class="w-1/3 bg-gray-100 text-gray-600 border border-gray-300 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-all duration-300 shadow-sm flex items-center justify-center card-hover">
              <i data-feather="trash-2" class="mr-2 w-5 h-5"></i> Reset
            </button>
            
            <button onclick="prosesKlasifikasi()" class="w-2/3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-bold shadow-md hover:shadow-lg flex items-center justify-center text-lg transition-all duration-300 transform hover:-translate-y-0.5">
              <i data-feather="cpu" class="mr-2 w-5 h-5"></i> Proses Klasifikasi
            </button>
        </div>
      </div>

      <div id="hasil-klasifikasi-card" class="hidden bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-8 transition-all duration-300 card-hover">
         <div class="p-8 bg-white relative z-10">
            <h3 class="text-xl font-semibold text-gray-700 mb-6 flex items-center">
               <i data-feather="check-square" class="w-6 h-6 mr-2 text-blue-600"></i> Hasil Prediksi Sistem
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
               <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                  <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Kode DDC</span>
                  <div id="result-code" class="text-4xl font-extrabold text-blue-900 mt-2 font-mono">-</div>
               </div>
               <div class="text-center p-4 bg-green-50 rounded-xl border border-green-100">
                  <span class="text-xs font-bold text-green-600 uppercase tracking-widest">Kategori</span>
                  <div id="result-category" class="text-2xl font-bold text-gray-800 mt-2">-</div>
                  <div class="text-sm text-gray-600 mt-1 italic">Kategori terdeteksi</div>
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
               <i id="btn-icon" data-feather="chevron-down" class="ml-2 w-4 h-4 transition-transform duration-300"></i>
            </button>
         </div>
      </div>

      <div id="preprocessing-card" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover mb-8">
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

      <div id="detail-container" class="hidden bg-gray-50 rounded-xl border border-gray-200 p-8 card-hover mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
          <i data-feather="cpu" class="mr-2 w-5 h-5 text-blue-600"></i> Detail Perhitungan Naive Bayes
        </h2>

        <div class="mb-8 p-6 bg-white rounded-lg border border-gray-300 shadow-sm text-center">
           <h4 class="font-bold text-lg text-blue-800 mb-4">Rumus Naive Bayes</h4>
           <div class="text-xl font-bold text-gray-800 mb-2">P(Kelas|Data) = P(Kelas) × Π P(Kata|Kelas)</div>
           <div class="text-sm text-gray-600">Menggunakan logaritma: log(P(Kelas)) + Σ log(P(Kata|Kelas))</div>
           <div class="text-xs text-blue-600 mt-2 font-bold">Total Dokumen Dipelajari: <span id="total-training">0</span></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
           <div>
              <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">1. Kata Kunci Hasil Preprocessing</h4>
              <div id="calc-stem-badges" class="flex flex-wrap gap-2 p-4 bg-white rounded border border-gray-200 min-h-[60px]"></div>
           </div>
           <div>
              <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">2. Prior Probability P(Kelas)</h4>
              <div id="calc-prior-scores" class="bg-white p-4 rounded border border-gray-200 space-y-2">
                 <div id="prior-calc-detail"></div>
              </div>
           </div>
        </div>

        <div class="mb-8">
           <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">3. Likelihood P(Kata|Kelas)</h4>
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
                 <tbody id="calc-table-body" class="divide-y divide-gray-200"></tbody>
              </table>
           </div>
        </div>

        <div>
           <h4 class="font-bold text-sm uppercase text-gray-500 mb-3">4. Skor Akhir (Log Scale)</h4>
           <div id="calc-final-scores" class="bg-white p-4 rounded-lg border border-gray-200 space-y-2 shadow-sm">
              <div id="final-calculation-detail"></div>
           </div>
        </div>
      </div>

    </div>

    <div id="tab-content-multiple" class="tab-content hidden">
       <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover">
          <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
             <i data-feather="list" class="mr-2 w-5 h-5 text-blue-600"></i> Input Buku Multiple
          </h2>

          <div class="mb-8 bg-blue-50 rounded-xl border border-blue-100 p-6">
             <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
                <i data-feather="upload" class="w-5 h-5 mr-2"></i> Impor dari Excel (Opsional)
             </h3>
             
             <div class="mb-4">
                <div class="border-2 border-dashed border-blue-300 rounded-xl p-6 text-center hover:border-blue-400 hover:bg-blue-100 transition-all duration-300 cursor-pointer" onclick="document.getElementById('excelFile').click()">
                   <div class="mb-3"><i data-feather="file" class="w-10 h-10 text-blue-500 mx-auto"></i></div>
                   <input type="file" id="excelFile" accept=".xlsx,.xls,.csv" class="hidden">
                   <div class="text-blue-700 font-medium mb-1">Klik untuk upload file Excel/CSV</div>
                   <div class="text-xs text-gray-500 mt-2">Format kolom: <strong>judul</strong>, <strong>deskripsi</strong></div>
                </div>
             </div>
             
             <div id="excelPreview" class="hidden mt-4 bg-white p-4 rounded border border-blue-200">
                <div class="flex justify-between items-center mb-2">
                   <span class="text-xs font-bold text-gray-500 uppercase">Preview Data (<span id="excelDataCount">0</span>)</span>
                   <button onclick="resetExcelImport()" class="text-red-600 text-xs hover:underline font-medium">Hapus File</button>
                </div>
                <div class="overflow-x-auto mb-3 border rounded border-gray-100 max-h-40">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-gray-50 text-gray-600"><tr><th class="p-2">No</th><th class="p-2">Judul</th><th class="p-2">Deskripsi</th></tr></thead>
                        <tbody id="excelPreviewBody" class="divide-y divide-gray-100 text-gray-500"></tbody>
                    </table>
                </div>
             </div>

             <div class="flex gap-3 mt-4">
                <button onclick="importFromExcel()" id="importExcelBtn" disabled class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2 rounded-lg font-medium shadow-md transition-all flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                   <i data-feather="check" class="w-4 h-4 mr-2"></i> Gunakan Data Excel
                </button>
                <button onclick="resetExcelImport()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-all flex items-center">
                   <i data-feather="x" class="w-4 h-4 mr-2"></i> Hapus
                </button>
             </div>
          </div>

          <div class="mb-6">
             <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                   <i data-feather="edit-2" class="w-5 h-5 mr-2 text-blue-600"></i> Input Manual
                </h3>
                <div class="text-sm text-gray-600"><span id="manualCount">0</span> buku ditambahkan</div>
             </div>
             
             <div id="multiple-input-container" class="space-y-4"></div>
             
             <button onclick="addMultipleInput()" class="w-full py-3 mt-4 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:text-blue-600 hover:border-blue-400 transition-all duration-300 flex items-center justify-center">
                <i data-feather="plus" class="w-4 h-4 mr-2"></i> Tambah Baris Buku
             </button>
          </div>

          <div class="flex gap-4">
             <button onclick="resetMultipleInput()" class="w-1/3 bg-gray-100 text-gray-600 border border-gray-300 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-all duration-300 shadow-sm flex items-center justify-center card-hover">
                <i data-feather="trash-2" class="mr-2 w-5 h-5"></i> Reset All
             </button>
             <button onclick="prosesKlasifikasiMultiple()" class="w-2/3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-bold shadow-lg flex items-center justify-center text-lg transition-all duration-300 transform hover:-translate-y-0.5">
                <i data-feather="cpu" class="mr-2 w-5 h-5"></i> Proses Semua Buku
             </button>
          </div>
       </div>

       <div id="multiple-results-container" class="hidden mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover">
          <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
             <i data-feather="check-circle" class="mr-2 w-5 h-5 text-green-600"></i> Hasil Klasifikasi Multiple
          </h2>
          
          <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
             <div class="text-sm text-gray-600">
                Total: <span id="total-books-count" class="font-bold">0</span> | Waktu: <span id="processing-time" class="font-bold">0</span>s
             </div>
             <div class="flex gap-2">
                <button onclick="exportResultsToExcel()" class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg shadow-sm hover:shadow-md transition-all text-sm flex items-center"><i data-feather="download" class="w-4 h-4 mr-2"></i> Excel</button>
                <button onclick="exportResultsToPDF()" class="px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg shadow-sm hover:shadow-md transition-all text-sm flex items-center"><i data-feather="file-text" class="w-4 h-4 mr-2"></i> PDF</button>
                <button onclick="closeMultipleResults()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all text-sm">Kembali</button>
             </div>
          </div>
          
          <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
             <table class="w-full text-sm text-left">
                <thead class="bg-gray-50">
                   <tr>
                      <th class="p-4 border-b">No</th><th class="p-4 border-b">Judul Buku</th><th class="p-4 border-b">Kode</th><th class="p-4 border-b">Kategori</th><th class="p-4 border-b">Conf.</th><th class="p-4 border-b">Aksi</th>
                   </tr>
                </thead>
                <tbody id="multiple-results-body" class="divide-y divide-gray-200"></tbody>
             </table>
          </div>
          <div id="multiple-details-area" class="mt-6 space-y-6"></div>
       </div>
    </div>

  </div>

  <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
     <div class="bg-white p-6 rounded-xl shadow-2xl text-center max-w-sm w-full">
         <div class="animate-spin w-10 h-10 border-4 border-blue-200 border-t-blue-600 rounded-full mx-auto mb-3"></div>
         <h3 class="font-bold text-gray-800 mb-1" id="loading-message">Memproses...</h3>
         <div class="text-sm text-gray-500" id="loading-percentage">0%</div>
         <div class="mt-2 h-1.5 w-full bg-gray-200 rounded-full"><div id="loading-progress" class="h-full bg-blue-600 rounded-full transition-all" style="width: 0%"></div></div>
     </div>
  </div>

</div>

<script>
// ==========================================
// 1. CONFIGURATION & VARIABLES
// ==========================================
// Endpoint API
const API_TRAINING = 'php_backend/api/get_data_training.php'; 
const API_SAVE = 'php_backend/api/simpan_riwayat.php'; 
const API_MODEL = 'php_backend/api/get_model.php'; // Integrasi API Model Baru

let naiveBayesModel = null; // Ini "Otak" AI kita
let kategoriDDC = [];
let multipleResults = []; 
let importedExcelData = [];
let startTime = 0;
let multipleInputCounter = 0;

// ==========================================
// 2. UI INTERACTION
// ==========================================
function switchTab(tabName) {
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'border-blue-600', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    const activeBtn = document.getElementById(`tab-${tabName}`);
    activeBtn.classList.add('active', 'border-blue-600', 'text-blue-600');
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    
    document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
    document.getElementById(`tab-content-${tabName}`).classList.remove('hidden');
    
    feather.replace();
}

function resetInput() {
    document.getElementById("inputJudul").value = "";
    document.getElementById("inputDeskripsi").value = "";
    document.getElementById("hasil-klasifikasi-card").classList.add("hidden");
    document.getElementById("preprocessing-card").classList.add("hidden");
    document.getElementById("detail-container").classList.add("hidden");
    // Hapus logika yang menampilkan kotak kosong lama
    
    document.getElementById("btn-text").textContent = "Tampilkan Detail Perhitungan Naive Bayes";
    document.getElementById("btn-icon").style.transform = "rotate(0deg)";
}

function toggleDetail() {
    const el = document.getElementById("detail-container");
    const pre = document.getElementById("preprocessing-card");
    const btnText = document.getElementById("btn-text");
    const btnIcon = document.getElementById("btn-icon");

    if (el.classList.contains("hidden")) {
        el.classList.remove("hidden");
        pre.classList.remove("hidden");
        btnText.textContent = "Sembunyikan Detail Perhitungan";
        btnIcon.style.transform = "rotate(180deg)";
        pre.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        el.classList.add("hidden");
        pre.classList.add("hidden");
        btnText.textContent = "Tampilkan Detail Perhitungan Naive Bayes";
        btnIcon.style.transform = "rotate(0deg)";
    }
}

// ==========================================
// 3. LOGIC HYBRID SYSTEM (Cache DB + Training)
// ==========================================

async function loadCategories() {
    try {
        const resKat = await fetch(`${API_TRAINING}?action=get_categories`);
        const jsonKat = await resKat.json();
        if(jsonKat.status === 'success') {
            kategoriDDC = jsonKat.data.map(k => ({
                kode: String(k.kode_ddc).trim(),
                nama: k.nama_kategori
            }));
        }
    } catch (e) { console.error("Error loading categories", e); }
}

async function initializeModelSystem() {
    const statusText = document.getElementById("model-status-text");
    
    try {
        // 1. Cek Apakah Model Tersedia di Cache DB?
        const checkRes = await fetch(`${API_MODEL}?action=check_model`);
        const checkJson = await checkRes.json();

        if (checkJson.status === 'found') {
            console.log("Model ditemukan di Cache DB. Memuat...");
            const modelRes = await fetch(`${API_MODEL}?action=get_model`);
            const modelJson = await modelRes.json();
            
            if(modelJson.status === 'success') {
                // Parse JSON
                let rawData = (typeof modelJson.data === 'string') ? JSON.parse(modelJson.data) : modelJson.data;
                // Restore Set (JSON tidak simpan Set)
                if(Array.isArray(rawData.vocab)) rawData.vocab = new Set(rawData.vocab);
                
                naiveBayesModel = rawData;
                
                if(statusText) statusText.textContent = `Status Model: Siap (Dari Cache - ${checkJson.data.total_dokumen} data)`;
                if(document.getElementById('total-training')) document.getElementById('total-training').textContent = checkJson.data.total_dokumen;
                return;
            }
        }
        
        // 2. Jika Tidak Ada -> Latih Baru dari Data Mentah
        console.log("Cache kosong. Melatih model baru...");
        if(statusText) statusText.textContent = "Status Model: Melatih data baru...";
        await trainAndSaveModel();

    } catch (e) { 
        console.error("Error Model System:", e);
        if(statusText) statusText.textContent = "Status Model: Error Koneksi";
    }
}

async function trainAndSaveModel() {
    const statusText = document.getElementById("model-status-text");
    try {
        const res = await fetch(`${API_TRAINING}?action=list`);
        const json = await res.json();
        
        if (json.status === 'success' && json.data.length > 0) {
            const data = json.data;
            
            // --- BUILD MODEL ---
            // Gunakan struktur yang sama dengan Pengujian.php (classCounts, classWordCounts)
            const model = { vocab: new Set(), classCounts: {}, classWordCounts: {}, totalDocs: 0 };
            
            data.forEach(item => {
                const text = (item.judul_buku + " " + (item.deskripsi || "")).toLowerCase();
                const label = String(item.kode_ddc).trim();
                
                if(!model.classCounts[label]) {
                    model.classCounts[label] = 0;
                    model.classWordCounts[label] = {};
                }
                model.classCounts[label]++;
                model.totalDocs++;
                
                // Gunakan preprocessTextForDebug agar konsisten dengan UI
                const proc = preprocessTextForDebug(text);
                const tokens = proc.stem; // Kita pakai hasil stemming
                
                tokens.forEach(word => {
                    model.vocab.add(word);
                    model.classWordCounts[label][word] = (model.classWordCounts[label][word] || 0) + 1;
                });
            });
            
            naiveBayesModel = model;

            // --- SAVE TO DB ---
            const modelToSave = { ...model, vocab: Array.from(model.vocab) };
            const formData = new FormData();
            formData.append('total_dokumen', model.totalDocs);
            formData.append('total_kategori', Object.keys(model.classCounts).length);
            formData.append('model_data', JSON.stringify(modelToSave));

            await fetch(`${API_MODEL}?action=save_model`, { method: 'POST', body: formData });
            
            if(statusText) statusText.textContent = `Status Model: Siap (Baru Dilatih - ${model.totalDocs} data)`;
            if(document.getElementById('total-training')) document.getElementById('total-training').textContent = model.totalDocs;
            
        } else {
            alert("Data Training kosong! Harap isi data dulu.");
        }
    } catch (e) { console.error("Training Error:", e); }
}

// ==========================================
// 4. PREPROCESSING & PREDICTION ENGINE
// ==========================================

function preprocessTextForDebug(text) {
    if (!text) return { clean: '', tokens: [], filtered: [], stem: [] };
    
    // 1. Case Folding & Cleaning
    let clean = text.toLowerCase().replace(/[^\w\s]/g, ' ').replace(/\s+/g, ' ').trim();
    
    // 2. Tokenizing
    let tokens = clean.split(' ').filter(t => t.length > 0);
    
    // 3. Stopwords
    const stopwords = ['dan', 'di', 'ke', 'dari', 'yang', 'pada', 'untuk', 'ini', 'itu', 'atau', 'adalah', 'dengan', 'dalam', 'sebagai', 'oleh'];
    let filtered = tokens.filter(t => !stopwords.includes(t) && t.length > 1);
    
    // 4. Stemming (Sederhana untuk demo)
    let stem = filtered.map(t => {
        if(t.endsWith('nya')) return t.slice(0, -3);
        if(t.endsWith('lah')) return t.slice(0, -3);
        if(t.endsWith('kan')) return t.slice(0, -3);
        if(t.endsWith('ing')) return t.slice(0, -3);
        return t;
    });
    return { clean, tokens, filtered, stem };
}

function classifyWithNaiveBayes(text) {
    if(!naiveBayesModel) return { kode: "-", nama: "Model Belum Siap", confidence: 0, details: {} };

    const proc = preprocessTextForDebug(text);
    const words = proc.stem;
    
    // Struktur untuk Debugging UI
    const details = { 
        likelihoods: {}, 
        categoryScores: {}, 
        priorProbabilities: {}, 
        words: words 
    };

    let maxScore = -Infinity;
    let bestClass = null;
    let scores = {};

    // Iterasi Kelas (Menggunakan struktur model baru: classCounts)
    Object.keys(naiveBayesModel.classCounts).forEach(cls => {
        // A. Prior Probability
        const prior = naiveBayesModel.classCounts[cls] / naiveBayesModel.totalDocs;
        details.priorProbabilities[cls] = prior;
        
        let logScore = Math.log(prior);
        details.likelihoods[cls] = {};

        // Denominator Laplace Smoothing
        const totalTermInClass = Object.values(naiveBayesModel.classWordCounts[cls]).reduce((a,b)=>a+b, 0);
        const vocabSize = naiveBayesModel.vocab.size;

        // B. Likelihood
        words.forEach(word => {
            // Cek Hitungan Kata
            const count = naiveBayesModel.classWordCounts[cls][word] || 0;
            const likelihood = (count + 1) / (totalTermInClass + vocabSize);
            
            // Simpan detail untuk tabel debug
            details.likelihoods[cls][word] = likelihood;
            
            // Akumulasi skor logaritma (hanya jika kata ada di vocab global)
            if (naiveBayesModel.vocab.has(word)) { 
                logScore += Math.log(likelihood);
            }
        });

        scores[cls] = logScore;
        details.categoryScores[cls] = { logScore: logScore };

        if (logScore > maxScore) {
            maxScore = logScore;
            bestClass = cls;
        }
    });

    // C. Hitung Confidence (Softmax Approximation)
    let sumExp = 0;
    // Ambil top scores saja untuk menghindari underflow extreme
    const sortedScores = Object.values(scores).sort((a,b) => b-a);
    const topScore = sortedScores[0] || -Infinity;
    
    Object.values(scores).forEach(s => {
        if(s - topScore > -20) sumExp += Math.exp(s - topScore);
    });
    
    const confidence = (sumExp > 0) ? ((1 / sumExp) * 100) : 0;

    // Ambil Nama Kategori
    const catInfo = getCategoryByCode(bestClass);

    return { 
        kode: bestClass, 
        nama: catInfo.nama, 
        confidence: confidence.toFixed(1),
        details: details 
    };
}

function getCategoryByCode(code) {
    if(!code) return { nama: "-" };
    let found = kategoriDDC.find(k => k.kode === code);
    if(found) return found;
    // Fallback search
    found = kategoriDDC.find(k => code.startsWith(k.kode));
    return found || { nama: "Kategori " + code };
}

// ==========================================
// 5. MAIN PROCESS (SINGLE INPUT)
// ==========================================
async function prosesKlasifikasi() {
    const judul = document.getElementById("inputJudul").value.trim();
    if (!judul) { alert("Harap isi Judul Buku!"); return; }
    
    // Pastikan model ada
    if(!naiveBayesModel) await initializeModelSystem();
    if(!naiveBayesModel) { alert("Sistem belum siap. Cek koneksi database."); return; }

    const deskripsi = document.getElementById("inputDeskripsi").value.trim();
    const textFull = judul + " " + deskripsi;
    
    // Lakukan Prediksi
    const result = classifyWithNaiveBayes(textFull);
    const debug = preprocessTextForDebug(textFull);
    
    // Update UI
    // Hapus baris yang memanipulasi kotak kosong
    document.getElementById("hasil-klasifikasi-card").classList.remove("hidden");
    
    document.getElementById("result-code").textContent = result.kode;
    document.getElementById("result-category").textContent = result.nama;
    document.getElementById("result-prob-text").textContent = result.confidence + "%";
    
    const bar = document.getElementById("result-prob-bar");
    bar.style.width = "0%";
    setTimeout(() => { bar.style.width = result.confidence + "%"; }, 100);
    
    if(result.confidence >= 80) confetti({ particleCount: 80, spread: 60, origin: { y: 0.6 } });
    
    // Render Debugging Info
    document.getElementById("preprocessing-cleaning").textContent = debug.clean;
    const badge = (arr, cls) => arr.map(t => `<span class="px-2 py-1 rounded border text-xs font-medium ${cls}">${t}</span>`).join(' ');
    document.getElementById("preprocessing-tokenizing").innerHTML = badge(debug.tokens, "bg-gray-100");
    document.getElementById("preprocessing-stopword").innerHTML = badge(debug.filtered, "bg-blue-50 text-blue-700");
    document.getElementById("preprocessing-stemming").innerHTML = badge(debug.stem, "bg-indigo-50 text-indigo-700");
    document.getElementById("calc-stem-badges").innerHTML = badge(debug.stem, "bg-indigo-50 text-indigo-700");
    
    renderDetailTable(result.details, result.kode);
    
    // Simpan Otomatis
    simpanKeRiwayat(judul, result.kode, result.nama, result.confidence);
}

function simpanKeRiwayat(judul, kode, kategori, confidence) {
    const formData = new FormData();
    formData.append('judul_buku', judul);
    formData.append('kategori_hasil', `${kode} - ${kategori}`); 
    formData.append('confidence', confidence);
    
    fetch(API_SAVE, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => { console.log('Saved:', data); })
        .catch(err => console.error('Save Error:', err));
}

function renderDetailTable(details, winner) {
    // Urutkan kategori berdasarkan skor tertinggi
    const cats = Object.keys(details.categoryScores)
        .sort((a,b) => details.categoryScores[b].logScore - details.categoryScores[a].logScore)
        .slice(0, 3); // Ambil Top 3
    
    // Render Header Tabel
    cats.forEach((c, i) => {
        const titleId = i===0 ? 'cat-a-title' : (i===1 ? 'cat-b-title' : 'cat-c-title');
        const info = getCategoryByCode(c);
        document.getElementById(titleId).innerHTML = `${c} <div class='text-[10px] font-normal text-gray-500 truncate w-24'>${info.nama}</div>`;
    });
    
    // Render Body Tabel (Kata-kata)
    const tbody = document.getElementById("calc-table-body");
    const wordsToShow = details.words.slice(0, 10); // Batasi 10 kata
    
    if(wordsToShow.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" class="p-4 text-center text-gray-400 italic">Tidak ada kata kunci valid</td></tr>`;
    } else {
        tbody.innerHTML = wordsToShow.map(w => `
            <tr class="hover:bg-gray-50 border-b border-gray-200">
                <td class="p-3 font-medium text-gray-700">${w}</td>
                ${cats.map(c => `<td class="p-3 text-center text-xs text-gray-500 font-mono">${(details.likelihoods[c][w]||0).toFixed(5)}</td>`).join('')}
            </tr>
        `).join('');
    }
    
    // Render Prior
    document.getElementById("prior-calc-detail").innerHTML = cats.map(c => `
        <div class="flex justify-between p-2 rounded bg-gray-50 mb-1 border border-gray-100">
            <span class="font-bold text-gray-700 text-xs">${c}</span>
            <span class="font-mono text-gray-500 text-xs">${(details.priorProbabilities[c]||0).toFixed(4)}</span>
        </div>
    `).join('');

    // Render Final Score
    document.getElementById("final-calculation-detail").innerHTML = cats.map(c => `
        <div class="p-3 rounded border ${c==winner ? 'bg-green-50 border-green-200 shadow-sm' : 'bg-white border-gray-200'}">
            <div class="flex justify-between items-center mb-1">
                <span class="font-bold text-sm ${c==winner ? 'text-green-700' : 'text-gray-700'}">${c}</span>
                ${c==winner ? '<span class="text-[10px] font-bold text-white bg-green-600 px-1.5 rounded">WIN</span>' : ''}
            </div>
            <div class="text-xs text-gray-500">Log Score: <span class="font-mono font-bold">${(details.categoryScores[c].logScore).toFixed(2)}</span></div>
        </div>
    `).join('');
}

// ==========================================
// 6. MULTIPLE INPUT & EXCEL (PRESERVED)
// ==========================================
// (Bagian ini tidak saya ubah logiknya, hanya panggil fungsi klasifikasi baru)

function addMultipleInput() {
    multipleInputCounter++;
    const div = document.createElement('div');
    div.className = "multiple-input-item mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50";
    div.innerHTML = `
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Buku #${multipleInputCounter}</span>
            <button onclick="this.closest('.multiple-input-item').remove(); updateManualCount();" class="text-red-500"><i data-feather="x" class="w-4 h-4"></i></button>
        </div>
        <input type="text" class="multiple-judul w-full px-4 py-2 border rounded-lg mb-2" placeholder="Judul Buku">
        <textarea class="multiple-deskripsi w-full px-4 py-2 border rounded-lg" rows="1" placeholder="Deskripsi"></textarea>`;
    document.getElementById("multiple-input-container").appendChild(div);
    updateManualCount();
    feather.replace();
}
function updateManualCount() {
    document.getElementById("manualCount").textContent = document.querySelectorAll(".multiple-input-item").length;
}
function resetMultipleInput() {
    document.getElementById("multiple-input-container").innerHTML = "";
    multipleInputCounter = 0;
    addMultipleInput();
    resetExcelImport();
}

function initExcelUpload() {
    const input = document.getElementById('excelFile');
    if(!input) return;
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if(!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const wb = XLSX.read(e.target.result, {type:'binary'});
                const json = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]]);
                importedExcelData = json.map(r => ({ 
                    judul: r.judul || r['Judul'] || r['Judul Buku'] || "", 
                    deskripsi: r.deskripsi || r['Deskripsi'] || "" 
                })).filter(r=>r.judul);
                
                document.getElementById("excelDataCount").textContent = importedExcelData.length;
                document.getElementById("excelPreview").classList.remove("hidden");
                document.getElementById("importExcelBtn").disabled = false;
                
                document.getElementById("excelPreviewBody").innerHTML = importedExcelData.slice(0,5).map((r,i) => `
                    <tr class="border-b"><td class="p-2">${i+1}</td><td class="p-2 font-medium">${r.judul}</td><td class="p-2 text-gray-500 truncate max-w-xs">${r.deskripsi}</td></tr>
                `).join('') + (importedExcelData.length > 5 ? `<tr><td colspan="3" class="p-2 text-center text-xs text-gray-400">...dan ${importedExcelData.length-5} lainnya</td></tr>` : '');
                
            } catch(err) { alert("Gagal baca file Excel: " + err.message); }
        };
        reader.readAsBinaryString(file);
    });
}
function resetExcelImport() {
    importedExcelData = [];
    document.getElementById("excelFile").value = "";
    document.getElementById("excelPreview").classList.add("hidden");
    document.getElementById("importExcelBtn").disabled = true;
}
function importFromExcel() { 
    document.getElementById('importExcelBtn').textContent = "Data Tersimpan!";
    setTimeout(() => document.getElementById('importExcelBtn').textContent = "Gunakan Data Ini", 2000);
}

async function prosesKlasifikasiMultiple() {
    let inputs = [];
    document.querySelectorAll(".multiple-input-item").forEach(el => {
        const j = el.querySelector(".multiple-judul").value;
        const d = el.querySelector(".multiple-deskripsi").value;
        if(j) inputs.push({judul:j, deskripsi:d});
    });
    importedExcelData.forEach(d => inputs.push(d));
    
    if(inputs.length === 0) { alert("Tidak ada data input."); return; }
    
    if(!naiveBayesModel) await initializeModelSystem();
    
    document.getElementById("loading-overlay").classList.remove("hidden");
    
    multipleResults = [];
    startTime = Date.now();
    const tbody = document.getElementById("multiple-results-body");
    tbody.innerHTML = "";
    
    for(let i=0; i<inputs.length; i++) {
        // Jeda sedikit agar UI tidak freeze
        if(i%5===0) await new Promise(r=>setTimeout(r,5));
        
        const text = inputs[i].judul + " " + inputs[i].deskripsi;
        const res = classifyWithNaiveBayes(text); // PAKE FUNGSI BARU
        
        multipleResults.push({...inputs[i], ...res, no:i+1, text: text});
        
        document.getElementById("loading-progress").style.width = Math.round(((i+1)/inputs.length)*100)+"%";
        document.getElementById("loading-percentage").textContent = Math.round(((i+1)/inputs.length)*100)+"%";
        
        simpanKeRiwayat(inputs[i].judul, res.kode, res.nama, res.confidence);
    }
    
    renderMultipleTable();
    document.getElementById("loading-overlay").classList.add("hidden");
    document.getElementById("multiple-results-container").classList.remove("hidden");
    document.getElementById("multiple-results-container").scrollIntoView({behavior:'smooth'});
}

function renderMultipleTable() {
    document.getElementById("total-books-count").textContent = multipleResults.length;
    document.getElementById("processing-time").textContent = ((Date.now()-startTime)/1000).toFixed(2);
    document.getElementById("multiple-results-body").innerHTML = multipleResults.map((r, i) => `
        <tr class="border-b hover:bg-gray-50 transition-colors">
            <td class="p-4 text-gray-500 font-mono text-center">${r.no}</td>
            <td class="p-4 font-medium text-gray-800">${r.judul}</td>
            <td class="p-4"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-mono font-bold">${r.kode}</span></td>
            <td class="p-4 text-gray-600 text-xs">${r.nama}</td>
            <td class="p-4 text-xs font-bold ${r.confidence>80?'text-green-600':'text-yellow-600'}">${r.confidence}%</td>
            <td class="p-4 text-center"><button onclick="toggleDetailMultiple(${i})" class="text-blue-600 hover:underline text-xs font-bold">Detail</button></td>
        </tr>
    `).join('');
}

function toggleDetailMultiple(idx) {
    const r = multipleResults[idx];
    const d = preprocessTextForDebug(r.text);
    const sortedCats = Object.keys(r.details.categoryScores).sort((a,b)=>r.details.categoryScores[b].logScore-r.details.categoryScores[a].logScore).slice(0,3);
    
    document.getElementById("multiple-details-area").innerHTML = `
        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200 shadow-sm animate-fadeIn">
            <div class="flex justify-between mb-3 border-b border-blue-200 pb-2">
                <h4 class="font-bold text-blue-800 text-sm">Analisis Detail Buku #${r.no}: "${r.judul}"</h4>
                <button onclick="document.getElementById('multiple-details-area').innerHTML=''" class="text-gray-400 hover:text-red-500"><i data-feather="x" class="w-4 h-4"></i></button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-3 rounded-lg border border-gray-200">
                    <span class="text-xs font-bold text-gray-500 uppercase">Kata Kunci Ditemukan</span>
                    <div class="mt-1 flex flex-wrap gap-1">
                        ${d.stem.map(t=>`<span class="text-xs bg-indigo-50 text-indigo-700 px-1.5 py-0.5 rounded border border-indigo-100">${t}</span>`).join('')}
                    </div>
                </div>
                <div class="bg-white p-3 rounded-lg border border-gray-200">
                    <span class="text-xs font-bold text-gray-500 uppercase">Top 3 Prediksi</span>
                    <div class="mt-1 space-y-1">
                        ${sortedCats.map(c => `
                            <div class="flex justify-between text-xs bg-gray-50 p-1.5 rounded border border-gray-100">
                                <span>${c}</span>
                                <span class="font-mono font-bold">${r.details.categoryScores[c].logScore.toFixed(2)}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
    document.getElementById("multiple-details-area").scrollIntoView({behavior:'smooth', block:'end'});
    feather.replace();
}

function closeMultipleResults() { document.getElementById("multiple-results-container").classList.add("hidden"); }

function exportResultsToExcel() {
    if(multipleResults.length===0) return alert("Belum ada hasil.");
    const ws = XLSX.utils.json_to_sheet(multipleResults.map(r=>({No:r.no, Judul:r.judul, Kode:r.kode, Kategori:r.nama, Conf:r.confidence+"%"})));
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Hasil Klasifikasi");
    XLSX.writeFile(wb, "Hasil_Klasifikasi_DDC.xlsx");
}
function exportResultsToPDF() {
    if(multipleResults.length===0) return alert("Belum ada hasil.");
    const doc = new window.jspdf.jsPDF();
    doc.text("Laporan Hasil Klasifikasi DDC", 14, 15);
    doc.setFontSize(10);
    doc.text("Tanggal: " + new Date().toLocaleDateString(), 14, 22);
    doc.autoTable({ head: [['No','Judul','Kode','Kategori','Conf']], body: multipleResults.map(r=>[r.no, r.judul, r.kode, r.nama, r.confidence+"%"]), startY: 25 });
    doc.save("Laporan_Klasifikasi.pdf");
}

// Init
document.addEventListener('DOMContentLoaded', async () => {
    feather.replace();
    await loadCategories();
    await initializeModelSystem();
    addMultipleInput();
    initExcelUpload();
    switchTab('single');
});
</script>

<style>
/* Utility Animation */
@keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
.animate-fadeIn { animation: fadeIn 0.3s ease-out forwards; }
/* Scrollbar halus */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
/* Modern Input Style */
.input-modern { border: 1px solid #e2e8f0; transition: all 0.3s; }
.input-modern:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
</style>