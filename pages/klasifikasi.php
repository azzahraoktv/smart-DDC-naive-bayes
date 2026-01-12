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

<div class="space-y-8">
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 card-hover">
    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
      <i data-feather="edit-3" class="mr-2 w-5 h-5 text-blue-600"></i> Detail Buku
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

  <!-- HASIL KLASIFIKASI (POSISI ATAS) -->
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
// Variabel global untuk data
let dataTraining = [];
let kategoriDDC = [];

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

// Fungsi utama klasifikasi
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

// Simpan ke riwayat
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

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Load data dari localStorage
    loadAllData();
    
    // Update feather icons
    if (typeof feather !== "undefined") {
        feather.replace();
    }
});

// Ekspos fungsi ke global
window.prosesKlasifikasi = prosesKlasifikasi;
window.resetInput = resetInput;
window.toggleDetail = toggleDetail;
window.loadAllData = loadAllData;
</script>