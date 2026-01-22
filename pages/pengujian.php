<?php
// pages/pengujian.php
?>
<div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in font-sans">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengujian & Validasi Model</h1>
            <p class="text-lg text-gray-600 mt-2">Analisis performa Naive Bayes menggunakan Confusion Matrix & Diagnosa Probabilitas.</p>
        </div>
    </div>

    <div id="selection-card" class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-10 shadow-sm transition-all hover:shadow-md">
        <div class="p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center border-b border-gray-100 pb-4">
                <div class="bg-indigo-100 p-2 rounded-lg mr-4 text-indigo-700">
                    <i data-feather="database" class="w-6 h-6"></i>
                </div>
                1. Persiapan Data Uji (Ground Truth)
            </h3>
            
            <div id="model-warning" class="hidden mb-6 p-5 bg-amber-50 border border-amber-200 rounded-xl flex items-start">
                <i data-feather="alert-triangle" class="w-6 h-6 text-amber-600 mr-3 mt-1"></i>
                <div>
                    <h4 class="font-bold text-amber-800">Model Belum Siap</h4>
                    <p class="text-amber-700 mt-1">Data Training kosong. Harap isi data latih terlebih dahulu.</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-6">
                <div class="flex-1 relative group">
                    <i data-feather="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors w-5 h-5"></i>
                    <input type="text" id="search-data" placeholder="Cari judul buku dalam riwayat..." onkeyup="filterData()" class="pl-12 pr-4 py-4 text-base border border-gray-300 rounded-xl w-full focus:ring-4 focus:ring-indigo-100 focus:border-indigo-600 transition-all outline-none">
                </div>
                <div class="flex gap-3">
                    <button onclick="selectAll()" class="px-6 py-4 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 font-semibold transition-all">Pilih Semua</button>
                    <button onclick="clearSelected()" class="px-6 py-4 border border-red-200 text-red-700 rounded-xl hover:bg-red-50 hover:border-red-300 font-semibold transition-all">Reset</button>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden max-h-[500px] overflow-y-auto custom-scrollbar">
                <table class="min-w-full divide-y divide-gray-200 relative">
                    <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-8 py-5 text-left w-20 bg-gray-50">
                                <input type="checkbox" id="select-all" onchange="toggleAll()" class="rounded-md text-indigo-600 focus:ring-indigo-500 w-5 h-5 cursor-pointer border-gray-400">
                            </th>
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-600 uppercase tracking-wider bg-gray-50">Judul Buku</th>
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-600 uppercase tracking-wider bg-gray-50">Label Asli</th>
                            <th class="px-8 py-5 text-center text-sm font-bold text-gray-600 uppercase tracking-wider w-48 bg-gray-50">Confidence Awal</th>
                        </tr>
                    </thead>
                    <tbody id="available-data" class="bg-white divide-y divide-gray-100"></tbody>
                </table>
            </div>
            
            <div class="mt-8 flex justify-between items-center bg-gray-50 p-6 rounded-xl border border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 text-white font-bold px-3 py-1 rounded-lg text-sm transition-all" id="selected-badge">0</div>
                    <span class="text-gray-700 font-medium">Data Terpilih</span>
                </div>
                <button onclick="startTesting()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-xl text-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center group">
                    <i data-feather="cpu" class="mr-3 w-5 h-5 group-hover:rotate-90 transition-transform"></i> Jalankan Pengujian
                </button>
            </div>
        </div>
    </div>

    <div id="result-card" class="hidden space-y-10">
        
        <div class="flex items-center justify-between border-b border-gray-200 pb-6">
            <h2 class="text-2xl font-bold text-gray-900">2. Hasil & Diagnosa Performa</h2>
            <button onclick="resetUI()" class="px-4 py-2 text-gray-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg font-medium flex items-center transition-colors">
                <i data-feather="rotate-ccw" class="w-4 h-4 mr-2"></i> Ulangi Pengujian
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-gradient-to-br from-indigo-700 to-violet-800 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 bg-white opacity-10 w-64 h-64 rounded-full blur-3xl group-hover:opacity-20 transition-opacity"></div>
                
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <h3 class="opacity-80 text-sm uppercase tracking-widest font-bold mb-2">Akurasi Global (Confusion Matrix)</h3>
                        <div class="text-7xl font-black tracking-tighter" id="score-percent">0%</div>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-medium border border-white/10">
                            <i data-feather="clock" class="w-4 h-4 text-yellow-300"></i>
                            <span id="execution-time">0s</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-8 pt-8 border-t border-white/10">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-300 mb-1" id="true-positive">0</div>
                        <div class="text-xs uppercase opacity-60">True Positive</div>
                    </div>
                    <div class="text-center border-l border-white/10">
                        <div class="text-3xl font-bold text-red-300 mb-1" id="false-positive">0</div>
                        <div class="text-xs uppercase opacity-60">False Positive</div>
                    </div>
                    <div class="text-center border-l border-white/10">
                        <div class="text-3xl font-bold mb-1" id="total-data-test">0</div>
                        <div class="text-xs uppercase opacity-60">Total Data</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 flex flex-col justify-center items-center text-center shadow-sm hover:border-indigo-300 transition-colors">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3">
                        <i data-feather="target" class="w-6 h-6"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-1" id="metric-prec">0%</div>
                    <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Precision</div>
                </div>
                <div class="bg-white border border-gray-200 rounded-2xl p-6 flex flex-col justify-center items-center text-center shadow-sm hover:border-indigo-300 transition-colors">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3">
                        <i data-feather="crosshair" class="w-6 h-6"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-1" id="metric-rec">0%</div>
                    <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Recall</div>
                </div>
                <div class="bg-white border border-gray-200 rounded-2xl p-6 flex flex-col justify-center items-center text-center shadow-sm hover:border-indigo-300 transition-colors col-span-2">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                            <i data-feather="bar-chart-2" class="w-6 h-6"></i>
                        </div>
                        <div class="text-left">
                            <div class="text-3xl font-bold text-gray-800" id="metric-f1">0%</div>
                            <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">F1-Score (Harmonic Mean)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200 bg-gray-50/50 flex flex-col md:flex-row justify-between md:items-center gap-4">
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Diagnosa Detail Prediksi</h4>
                    <p class="text-sm text-gray-500">Menganalisis mengapa sistem menjawab Benar atau Salah berdasarkan probabilitas.</p>
                </div>
                <div class="flex gap-2">
                    <span class="flex items-center text-xs font-medium bg-green-100 text-green-700 px-3 py-1 rounded-full border border-green-200">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div> TP: Prediksi Benar
                    </span>
                    <span class="flex items-center text-xs font-medium bg-red-100 text-red-700 px-3 py-1 rounded-full border border-red-200">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div> FP: Prediksi Salah
                    </span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase w-16">No</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase w-1/3">Judul Buku</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase">Kategori Asli (Ground Truth)</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase">Prediksi Sistem</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase w-1/4">Analisis Probabilitas</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-hasil" class="text-base divide-y divide-gray-100"></tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 justify-center pt-8 pb-12">
            <button onclick="saveToVerified()" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md font-semibold flex items-center transition-all hover:-translate-y-1">
                <i data-feather="check-circle" class="mr-2 w-5 h-5"></i> Simpan Hasil Valid
            </button>
            <button onclick="saveToTraining()" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-md font-semibold flex items-center transition-all hover:-translate-y-1">
                <i data-feather="database" class="mr-2 w-5 h-5"></i> Tambah ke Data Training
            </button>
            <button onclick="exportToExcel()" class="px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded-xl shadow-md font-semibold flex items-center transition-all hover:-translate-y-1">
                <i data-feather="file-text" class="mr-2 w-5 h-5"></i> Ekspor Laporan
            </button>
        </div>
    </div>
</div>

<script>
// --- STATE MANAGEMENT ---
let allData = [];
let displayedData = [];
let selectedData = [];
let testResults = [];
let naiveBayesModel = null;

// --- INITIALIZATION ---
document.addEventListener('DOMContentLoaded', function() {
    feather.replace();
    trainInternalModel(); 
    loadData();
});

// --- 1. MODEL TRAINING ---
function trainInternalModel() {
    const raw = localStorage.getItem('dataTraining');
    if (!raw || JSON.parse(raw).length === 0) {
        document.getElementById('model-warning').classList.remove('hidden');
        return false;
    }
    const data = JSON.parse(raw);
    
    // Naive Bayes Structure
    const model = { vocab: new Set(), catCounts: {}, catWordCounts: {}, total: 0 };
    
    data.forEach(item => {
        const tokens = tokenize(item.judul);
        const cat = item.kategori;
        
        tokens.forEach(t => model.vocab.add(t));
        
        if(!model.catCounts[cat]) { model.catCounts[cat] = 0; model.catWordCounts[cat] = {}; }
        
        tokens.forEach(t => {
            model.catWordCounts[cat][t] = (model.catWordCounts[cat][t] || 0) + 1;
        });
        
        model.catCounts[cat]++;
        model.total++;
    });
    
    naiveBayesModel = model;
    document.getElementById('model-warning').classList.add('hidden');
    return true;
}

// --- 2. PREDICTION ENGINE ---
function predictWithProbabilities(judul) {
    if(!naiveBayesModel) return null;
    
    const tokens = tokenize(judul);
    let scores = {};
    let maxScore = -Infinity;
    
    Object.keys(naiveBayesModel.catCounts).forEach(cat => {
        const prior = Math.log(naiveBayesModel.catCounts[cat] / naiveBayesModel.total);
        let likelihood = 0;
        const totalWordsInCat = Object.values(naiveBayesModel.catWordCounts[cat]).reduce((a,b)=>a+b, 0);
        const vocabSize = naiveBayesModel.vocab.size;
        
        tokens.forEach(t => {
            const count = naiveBayesModel.catWordCounts[cat][t] || 0;
            likelihood += Math.log((count + 1) / (totalWordsInCat + vocabSize));
        });
        
        scores[cat] = prior + likelihood;
        if(scores[cat] > maxScore) maxScore = scores[cat];
    });
    
    let probabilities = {};
    let sumExp = 0;
    // Top 20 for stability
    const sortedScores = Object.values(scores).sort((a,b) => b-a).slice(0, 20);
    sortedScores.forEach(s => sumExp += Math.exp(s - maxScore));
    
    Object.keys(scores).forEach(cat => {
        if((scores[cat] - maxScore) < -20) {
            probabilities[cat] = 0;
        } else {
            probabilities[cat] = (Math.exp(scores[cat] - maxScore) / sumExp) * 100;
        }
    });
    
    // Get Best Prediction
    let bestCat = '';
    let bestProb = -1;
    Object.keys(probabilities).forEach(cat => {
        if(probabilities[cat] > bestProb) {
            bestProb = probabilities[cat];
            bestCat = cat;
        }
    });
    
    let predCode = '000', predName = bestCat;
    if(bestCat.includes('|')) {
        const parts = bestCat.split('|');
        predCode = parts[0];
        predName = parts.slice(1).join('|');
    }
    
    return {
        predCategory: bestCat,
        predCode: predCode,
        predName: predName,
        bestProbability: bestProb,
        allProbabilities: probabilities
    };
}

function tokenize(text) {
    return text.toLowerCase().replace(/[^\w\s]/g, '').split(/\s+/).filter(w => w.length > 2);
}

// --- 3. DATA LOADING (SELECTION TABLE) ---
function loadData() {
    const rawRiwayat = localStorage.getItem('riwayatKlasifikasi');
    const rawVerif = localStorage.getItem('riwayatTerverifikasi');
    const verified = rawVerif ? JSON.parse(rawVerif) : [];
    const riwayat = rawRiwayat ? JSON.parse(rawRiwayat) : [];
    
    allData = riwayat.filter(r => {
        const t = r.judul || r.judulBuku;
        return !verified.some(v => (v.judulBuku === t));
    }).map(item => ({
        id: Math.random().toString(36).substr(2,9),
        judul: item.judul || item.judulBuku,
        kode: item.kodeDDC || item.kode,
        kategori: item.kategori || item.nama_kategori,
        fullCategory: (item.kodeDDC || item.kode) + '|' + (item.kategori || item.nama_kategori),
        historyConfidence: item.probabilitas || item.confidence || 0
    }));
    
    displayedData = [...allData];
    renderTable();
}

function renderTable() {
    const tbody = document.getElementById('available-data');
    if(displayedData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="p-12 text-center text-gray-400 italic">Tidak ada data riwayat baru.<br>Silakan lakukan klasifikasi terlebih dahulu.</td></tr>';
        document.getElementById('select-all').checked = false;
        return;
    }
    
    // Checkbox master hanya checked jika semua data tampil terpilih
    const allSelected = displayedData.length > 0 && displayedData.every(d => selectedData.some(s => s.id === d.id));
    document.getElementById('select-all').checked = allSelected;
    
    tbody.innerHTML = displayedData.map(d => {
        const confVal = parseFloat(d.historyConfidence);
        const confDisplay = isNaN(confVal) ? '-' : confVal.toFixed(1) + '%';
        const isHigh = !isNaN(confVal) && confVal > 50;
        
        return `
        <tr class="hover:bg-indigo-50/50 border-b border-gray-100 transition-colors group cursor-pointer" onclick="toggleSelectRow('${d.id}', event)">
            <td class="px-8 py-4">
                <input type="checkbox" value="${d.id}" ${selectedData.find(x=>x.id===d.id)?'checked':''} class="rounded text-indigo-600 focus:ring-indigo-600 h-5 w-5 cursor-pointer border-gray-300 pointer-events-none"> 
            </td>
            <td class="px-8 py-4">
                <div class="text-base font-semibold text-gray-800 group-hover:text-indigo-700 transition-colors">${d.judul}</div>
            </td>
            <td class="px-8 py-4">
                <div class="inline-flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-lg border border-gray-200">
                    <span class="font-mono font-bold text-gray-700 text-sm">${d.kode}</span>
                    <span class="text-xs text-gray-500 border-l border-gray-300 pl-2 max-w-[150px] truncate">${d.kategori}</span>
                </div>
            </td>
            <td class="px-8 py-4 text-center">
                 <span class="px-3 py-1 rounded-lg text-xs font-bold ${isHigh ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600'}">
                    ${confDisplay}
                 </span>
            </td>
        </tr>
    `}).join('');
    
    updateCount();
}

// --- 4. SELECTION LOGIC ---
function toggleSelectRow(id, event) {
    // Memungkinkan klik di mana saja pada baris tabel
    toggleSelect(id);
}

function toggleSelect(id) {
    const idx = selectedData.findIndex(x => x.id === id);
    if(idx > -1) selectedData.splice(idx, 1);
    else {
        const item = allData.find(x => x.id === id);
        if(item) selectedData.push(item);
    }
    // Update UI tanpa render ulang tabel penuh agar cepat
    const checkbox = document.querySelector(`input[value="${id}"]`);
    if(checkbox) checkbox.checked = !checkbox.checked;
    
    updateCount();
    
    // Update status "Select All" checkbox
    const allSelected = displayedData.length > 0 && displayedData.every(d => selectedData.some(s => s.id === d.id));
    document.getElementById('select-all').checked = allSelected;
}

function selectAll() {
    // Helper function untuk tombol "Pilih Semua"
    displayedData.forEach(item => {
        if (!selectedData.some(s => s.id === item.id)) selectedData.push(item);
    });
    renderTable();
    updateCount();
}

function toggleAll() {
    const checkbox = document.getElementById('select-all');
    if (checkbox.checked) {
        displayedData.forEach(item => {
            if (!selectedData.some(s => s.id === item.id)) selectedData.push(item);
        });
    } else {
        const ids = displayedData.map(d => d.id);
        selectedData = selectedData.filter(s => !ids.includes(s.id));
    }
    renderTable();
    updateCount();
}

function clearSelected() { selectedData = []; renderTable(); updateCount(); }

function updateCount() { 
    document.getElementById('selected-badge').innerText = selectedData.length; 
}

function filterData() { 
    const search = document.getElementById('search-data').value.toLowerCase();
    displayedData = allData.filter(d => d.judul.toLowerCase().includes(search));
    renderTable(); 
}

// --- 5. EXECUTION & DIAGNOSIS ---
function startTesting() {
    // VALIDASI UTAMA: Apakah ada data yang dipilih?
    if(selectedData.length === 0) {
        // Tampilkan peringatan visual yang ramah
        alert("Mohon pilih minimal satu data buku dari tabel di atas untuk memulai pengujian.");
        return;
    }
    
    if(!naiveBayesModel && !trainInternalModel()) return alert("Data Training kosong! Silakan isi data latih dahulu.");
    
    const startTime = performance.now();

    document.getElementById('selection-card').classList.add('hidden');
    document.getElementById('result-card').classList.remove('hidden');
    
    testResults = [];
    let tp = 0, fp = 0;
    
    selectedData.forEach(item => {
        const prediction = predictWithProbabilities(item.judul);
        if (!prediction) return;
        
        const isCorrect = String(prediction.predCode).trim() === String(item.kode).trim();
        if(isCorrect) tp++; else fp++;
        
        let actualProbability = 0;
        const groundTruthKey = item.fullCategory;
        const matchedKey = Object.keys(prediction.allProbabilities).find(k => k === groundTruthKey);
        
        if (matchedKey) {
            actualProbability = prediction.allProbabilities[matchedKey];
        } else {
            const codeKey = Object.keys(prediction.allProbabilities).find(k => k.startsWith(item.kode + '|'));
            actualProbability = codeKey ? prediction.allProbabilities[codeKey] : 0;
        }
        
        testResults.push({
            ...item,
            predCode: prediction.predCode,
            predName: prediction.predName,
            predProbability: prediction.bestProbability, 
            actualProbability: actualProbability, 
            correct: isCorrect
        });
    });
    
    const endTime = performance.now();
    document.getElementById('execution-time').innerText = ((endTime - startTime) / 1000).toFixed(4) + 's';
    
    renderResults(tp, fp, testResults.length);
}

function renderResults(tp, fp, total) {
    const acc = total > 0 ? (tp/total)*100 : 0;
    const prec = tp + fp > 0 ? (tp/(tp+fp))*100 : 0;
    const rec = tp > 0 ? 100 : 0;
    const f1 = (prec + rec) > 0 ? (2 * prec * rec) / (prec + rec) : 0;
    
    document.getElementById('score-percent').innerText = acc.toFixed(1) + '%';
    document.getElementById('true-positive').innerText = tp;
    document.getElementById('false-positive').innerText = fp;
    document.getElementById('total-data-test').innerText = total;
    
    document.getElementById('metric-prec').innerText = prec.toFixed(1) + '%';
    document.getElementById('metric-rec').innerText = rec.toFixed(1) + '%';
    document.getElementById('metric-f1').innerText = f1.toFixed(1) + '%';
    
    const tbody = document.getElementById('tabel-hasil');
    tbody.innerHTML = testResults.map((r, i) => {
        let diagHtml = '';
        if(r.correct) {
            diagHtml = `
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-green-700 uppercase mb-1">✓ Prediksi Tepat</span>
                    <div class="flex items-center gap-2">
                        <div class="w-full bg-green-100 rounded-full h-2 max-w-[100px]">
                            <div class="bg-green-500 h-2 rounded-full" style="width: ${r.predProbability}%"></div>
                        </div>
                        <span class="text-sm font-bold text-green-700">${r.predProbability.toFixed(1)}%</span>
                    </div>
                    <span class="text-[10px] text-gray-500 mt-1">Sistem cukup yakin.</span>
                </div>
            `;
        } else {
            diagHtml = `
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-gray-500">Pilihan Sistem:</span>
                        <span class="text-xs font-bold text-red-600">${r.predProbability.toFixed(1)}%</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-red-100 pt-1">
                        <span class="text-[10px] text-gray-500">Peluang Asli:</span>
                        <span class="text-xs font-bold text-indigo-600">${r.actualProbability.toFixed(1)}%</span>
                    </div>
                    <span class="text-[10px] text-red-500 italic mt-1">⚠ Probabilitas kategori asli terlalu rendah.</span>
                </div>
            `;
        }

        return `
        <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
            <td class="px-8 py-5 text-center text-sm text-gray-400 font-mono">${i+1}</td>
            <td class="px-8 py-5">
                <div class="text-sm font-bold text-gray-800">${r.judul}</div>
            </td>
            <td class="px-8 py-5">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-2">
                    <div class="text-xs font-bold text-gray-600">${r.kode}</div>
                    <div class="text-xs text-gray-500 truncate max-w-[180px]">${r.kategori}</div>
                </div>
            </td>
            <td class="px-8 py-5">
                <div class="${r.correct ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'} border rounded-lg p-2">
                    <div class="text-xs font-bold ${r.correct ? 'text-green-700' : 'text-red-700'}">${r.predCode}</div>
                    <div class="text-xs ${r.correct ? 'text-green-600' : 'text-red-600'} truncate max-w-[180px]">${r.predName}</div>
                </div>
            </td>
            <td class="px-8 py-5">
                ${diagHtml}
            </td>
        </tr>`;
    }).join('');
}

function resetUI() {
    selectedData = [];
    document.getElementById('selection-card').classList.remove('hidden');
    document.getElementById('result-card').classList.add('hidden');
    document.getElementById('select-all').checked = false;
    loadData();
}

function saveToVerified() {
    const valid = testResults.filter(r => r.correct);
    if(valid.length === 0) return alert("Tidak ada data benar (TP) untuk disimpan.");
    let db = JSON.parse(localStorage.getItem('riwayatTerverifikasi') || '[]');
    let count = 0;
    valid.forEach(d => {
        if(!db.some(x => x.judulBuku === d.judul)) {
            db.push({
                judulBuku: d.judul, kodeDDC: d.kode, kategori: d.kategori,
                tanggalSah: new Date().toISOString(), status: 'Terverifikasi', confidence: d.predProbability
            });
            count++;
        }
    });
    localStorage.setItem('riwayatTerverifikasi', JSON.stringify(db));
    alert(count + " data valid disimpan!");
    resetUI();
}

function saveToTraining() {
    const valid = testResults.filter(r => r.correct);
    if(valid.length === 0) return alert("Tidak ada data benar.");
    let db = JSON.parse(localStorage.getItem('dataTraining') || '[]');
    let count = 0;
    valid.forEach(d => {
        const catFull = d.kode + '|' + d.kategori;
        if(!db.some(x => x.judul === d.judul)) {
            db.push({ judul: d.judul, kategori: catFull, waktu: new Date().toISOString() });
            count++;
        }
    });
    localStorage.setItem('dataTraining', JSON.stringify(db));
    trainInternalModel();
    alert(count + " data ditambahkan ke Training Set!");
}

function exportToExcel() {
    if(testResults.length === 0) return alert("Belum ada hasil.");
    let html = `<h3>Laporan Diagnosa Sistem</h3><table border="1"><thead><tr><th>Judul</th><th>Asli</th><th>Prediksi</th><th>Status</th><th>Probabilitas Prediksi</th><th>Probabilitas Asli</th></tr></thead><tbody>${testResults.map(r => `<tr><td>${r.judul}</td><td>${r.kode}</td><td>${r.predCode}</td><td>${r.correct?'TP':'FP'}</td><td>${r.predProbability.toFixed(2)}%</td><td>${r.actualProbability.toFixed(2)}%</td></tr>`).join('')}</tbody></table>`;
    const a = document.createElement('a');
    a.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    a.download = 'Laporan_Diagnosa.xls';
    a.click();
}
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 8px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
.animate-fade-in { animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
@keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>