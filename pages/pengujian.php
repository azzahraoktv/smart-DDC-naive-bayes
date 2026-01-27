<div id="page-pengujian" class="w-full px-4 py-6 font-sans">
    
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">Pengujian</h1>
        <p class="text-gray-600 text-base">Uji Naive Bayes menggunakan Confusion Matrix.</p>
    </div>

    <div id="section-selection" class="animate-fade-in">
        
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 flex items-center">
                <div class="p-3 bg-blue-100 rounded-full text-blue-600 mr-4">
                    <i data-feather="database" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 text-lg">Knowledge Base (Model AI)</h4>
                    <div class="text-sm text-blue-700 mt-1">
                        Status: <span id="model-status" class="font-bold">Memeriksa...</span>
                    </div>
                    <div id="model-info" class="text-xs text-gray-500 mt-1">-</div>
                </div>
            </div>
            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-full text-indigo-600 mr-4">
                        <i data-feather="check-square" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-indigo-900 text-lg">Pilih Data Uji</h4>
                        <p class="text-sm text-indigo-700"><span id="selected-count">0</span> data dipilih.</p>
                    </div>
                </div>
                <button onclick="startTesting()" id="btn-start" disabled class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-bold shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                    <i data-feather="play" class="w-4 h-4 mr-2"></i> Mulai Uji
                </button>
            </div>
        </div>

        <div class="mb-4 bg-white p-6 rounded-xl shadow-sm border border-gray-200 w-full">
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center w-full">
                <div class="relative w-full md:flex-1">
                    <i data-feather="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    <input type="text" id="search-data" placeholder="Cari judul buku dari riwayat..." onkeyup="filterData()" 
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition shadow-sm">
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button onclick="selectAll()" class="flex-1 md:flex-none bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-3 rounded-lg text-base font-medium transition shadow-sm">
                        Pilih Semua
                    </button>
                    <button onclick="clearSelected()" class="flex-1 md:flex-none bg-white border border-red-200 text-red-600 hover:bg-red-50 px-5 py-3 rounded-lg text-base font-medium transition shadow-sm">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden min-h-[400px]">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-5 text-center w-16">
                                <input type="checkbox" id="check-all-master" onchange="toggleAll()" class="w-5 h-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Judul Buku (Soal Ujian)</th>
                            <th class="px-6 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider w-64">Label Asli (Kunci Jawaban)</th>
                        </tr>
                    </thead>
                    <tbody id="table-selection" class="divide-y divide-gray-100 text-base">
                        <tr><td colspan="3" class="p-8 text-center text-gray-500">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="section-result" class="hidden animate-fade-in">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i data-feather="bar-chart-2" class="mr-3 text-indigo-600"></i> Hasil Diagnosa
            </h2>
            <button onclick="resetUI()" class="bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center shadow-sm">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Uji Ulang
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-indigo-600 text-white p-6 rounded-xl shadow-lg shadow-indigo-200">
                <p class="text-indigo-200 text-sm font-medium mb-1">Akurasi Global</p>
                <div class="flex items-end">
                    <span class="text-4xl font-bold" id="score-accuracy">0%</span>
                </div>
            </div>
            <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm">
                <p class="text-gray-500 text-sm font-medium mb-1">Precision</p>
                <span class="text-3xl font-bold text-gray-800" id="score-precision">0%</span>
            </div>
            <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm">
                <p class="text-gray-500 text-sm font-medium mb-1">Recall</p>
                <span class="text-3xl font-bold text-gray-800" id="score-recall">0%</span>
            </div>
            <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm">
                <p class="text-gray-500 text-sm font-medium mb-1">F1-Score</p>
                <span class="text-3xl font-bold text-gray-800" id="score-f1">0%</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-700">Detail Prediksi vs Aktual</h3>
                <span class="text-xs font-mono bg-gray-100 text-gray-500 px-2 py-1 rounded" id="execution-time">Time: 0s</span>
            </div>
            <div class="overflow-x-auto max-h-[500px] overflow-y-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-white border-b border-gray-200 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase w-12 text-center bg-gray-50">No</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase bg-gray-50">Judul Buku</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase w-48 bg-gray-50">Asli</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase w-48 bg-gray-50">Prediksi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center w-32 bg-gray-50">Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-result" class="divide-y divide-gray-100 text-sm"></tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end gap-3 pb-8">
            <button onclick="simpanLaporanPengujian()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-bold shadow-md transition flex items-center">
                <i data-feather="save" class="w-4 h-4 mr-2"></i> Simpan Laporan
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<script>
// ==========================================
// SYSTEM CORE: HYBRID NAIVE BAYES (Cache + Live)
// ==========================================

const API_TRAINING = 'php_backend/api/get_data_training.php';
const API_RIWAYAT  = 'php_backend/api/get_riwayat.php';
const API_PENGUJIAN = 'php_backend/api/get_pengujian.php'; 
const API_MODEL    = 'php_backend/api/get_model.php'; // API Baru

let testingCandidates = []; // Daftar Soal (Riwayat)
let selectedIds = new Set();
let naiveBayesModel = null;
let testResultSummary = null; // Menyimpan hasil hitungan untuk disimpan ke DB

document.addEventListener('DOMContentLoaded', async () => {
    feather.replace();
    // 1. Cek Model: Apakah ambil dari DB (Cepat) atau Latih Ulang (Lambat)
    await initializeModelSystem();
    // 2. Load Data Riwayat sebagai soal
    await loadTestingCandidates();
});

// --- 1. MODEL SYSTEM (INTELLIGENT LOADING) ---
async function initializeModelSystem() {
    const statusEl = document.getElementById('model-status');
    const infoEl = document.getElementById('model-info');
    
    try {
        // Cek apakah ada model tersimpan di DB
        const resCheck = await fetch(`${API_MODEL}?action=check_model`);
        const jsonCheck = await resCheck.json();

        if (jsonCheck.status === 'found') {
            // CASE A: Model Ada di DB -> Load (Cepat)
            statusEl.textContent = "Memuat dari Cache Database...";
            statusEl.className = "font-bold text-blue-600";
            
            const resLoad = await fetch(`${API_MODEL}?action=get_model`);
            const jsonLoad = await resLoad.json();
            
            if(jsonLoad.status === 'success') {
                // Parse JSON String dari DB kembali ke Object JS
                let loadedModel = (typeof jsonLoad.data === 'string') ? JSON.parse(jsonLoad.data) : jsonLoad.data;
                
                // PENTING: Konversi Array vocab kembali menjadi Set (karena JSON mengubah Set jadi Array)
                if(Array.isArray(loadedModel.vocab)) {
                    loadedModel.vocab = new Set(loadedModel.vocab);
                }
                
                naiveBayesModel = loadedModel;
                
                statusEl.textContent = "Siap (Cached)";
                statusEl.className = "font-bold text-green-600";
                infoEl.textContent = `Dilatih: ${jsonCheck.data.tgl_training} | ${jsonCheck.data.total_dokumen} Dokumen`;
                return;
            }
        }
        
        // CASE B: Model Kosong/Usang -> Latih Baru dari Data Training (Original Logic)
        statusEl.textContent = "Melatih Ulang dari Data Mentah...";
        statusEl.className = "font-bold text-orange-500";
        await loadAndTrainModel();

    } catch (e) {
        console.error("Error Model System:", e);
        statusEl.textContent = "Error Koneksi";
        statusEl.className = "font-bold text-red-600";
    }
}

// 1. LATIH MODEL & SIMPAN (Modified Original Logic)
async function loadAndTrainModel() {
    const statusEl = document.getElementById('model-status');
    const infoEl = document.getElementById('model-info');

    try {
        const res = await fetch(`${API_TRAINING}?action=list`);
        const json = await res.json();
        
        if (json.status === 'success' && json.data.length > 0) {
            // 1. Latih Model (Logika Asli Anda)
            trainNaiveBayes(json.data); 
            
            // 2. Simpan Hasil Training ke DB (Cache) agar besok2 gak perlu training lagi
            // Konversi Set ke Array agar bisa di-JSON-kan
            const modelToSave = { 
                ...naiveBayesModel, 
                vocab: Array.from(naiveBayesModel.vocab) 
            };
            
            const formData = new FormData();
            formData.append('total_dokumen', naiveBayesModel.totalDocs);
            formData.append('total_kategori', Object.keys(naiveBayesModel.classCounts).length);
            formData.append('model_data', JSON.stringify(modelToSave));

            await fetch(`${API_MODEL}?action=save_model`, { method: 'POST', body: formData });

            statusEl.textContent = "Siap (Baru Dilatih & Disimpan)";
            statusEl.className = "font-bold text-green-600";
            infoEl.textContent = `${naiveBayesModel.totalDocs} data baru dipelajari`;
        } else {
            statusEl.textContent = "Data Kosong";
            alert("Data Training kosong! Silakan isi data latih dulu.");
        }
    } catch (e) { 
        console.error("Error training:", e); 
        statusEl.textContent = "Gagal Training";
    }
}

// 2. BANGUN MODEL NAIVE BAYES (Client Side - Original Logic)
function trainNaiveBayes(data) {
    const model = { vocab: new Set(), classCounts: {}, classWordCounts: {}, totalDocs: 0 };
    
    data.forEach(item => {
        // Gabung Judul + Deskripsi
        const text = (item.judul_buku + " " + (item.deskripsi || "")).toLowerCase();
        // Kategori = Label Kelas
        const label = item.kode_ddc; 
        
        if(!model.classCounts[label]) {
            model.classCounts[label] = 0;
            model.classWordCounts[label] = {};
        }
        
        const tokens = tokenize(text);
        tokens.forEach(word => {
            model.vocab.add(word);
            model.classWordCounts[label][word] = (model.classWordCounts[label][word] || 0) + 1;
        });
        
        model.classCounts[label]++;
        model.totalDocs++;
    });
    
    naiveBayesModel = model;
    console.log("Model Naive Bayes Siap. Vocab size:", model.vocab.size);
}

function tokenize(text) {
    return text.replace(/[^a-zA-Z0-9\s]/g, '').split(/\s+/).filter(w => w.length > 2);
}

// 3. AMBIL KANDIDAT DATA UJI (Original Logic)
async function loadTestingCandidates() {
    try {
        const res = await fetch('php_backend/api/get_riwayat.php?action=list');
        const json = await res.json();
        
        if (json.status === 'success') {
            testingCandidates = json.data.filter(d => d.kategori_hasil && d.kategori_hasil !== '-');
            renderSelectionTable(testingCandidates);
        }
    } catch (e) { console.error("Error loading candidates:", e); }
}

// 4. RENDER TABEL SELEKSI
function renderSelectionTable(data) {
    const tbody = document.getElementById('table-selection');
    tbody.innerHTML = '';
    
    if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="3" class="p-8 text-center text-gray-500">Tidak ada data riwayat untuk diuji.</td></tr>`;
        return;
    }

    data.forEach(item => {
        let label = item.kategori_hasil.split('-')[0].trim();
        const isChecked = selectedIds.has(item.id);
        const tr = document.createElement('tr');
        tr.className = `hover:bg-indigo-50/50 transition border-b border-gray-100 cursor-pointer ${isChecked ? 'bg-indigo-50' : ''}`;
        tr.onclick = (e) => {
            if(e.target.type !== 'checkbox') toggleSelection(item.id);
        };

        tr.innerHTML = `
            <td class="px-6 py-4 text-center">
                <input type="checkbox" ${isChecked ? 'checked' : ''} onchange="toggleSelection(${item.id})" class="w-5 h-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 cursor-pointer pointer-events-none">
            </td>
            <td class="px-6 py-4">
                <div class="font-bold text-gray-800">${item.judul_buku}</div>
            </td>
            <td class="px-6 py-4">
                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm font-mono font-bold border border-gray-200">${label}</span>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// 5. SELECTION LOGIC
function toggleSelection(id) {
    if (selectedIds.has(id)) selectedIds.delete(id);
    else selectedIds.add(id);
    updateUISelection();
    // Re-render filtering current view
    renderSelectionTable(testingCandidates.filter(d => d.judul_buku.toLowerCase().includes(document.getElementById('search-data').value.toLowerCase())));
}

function selectAll() {
    testingCandidates.forEach(d => selectedIds.add(d.id));
    updateUISelection();
    renderSelectionTable(testingCandidates);
}

function clearSelected() {
    selectedIds.clear();
    updateUISelection();
    renderSelectionTable(testingCandidates);
}

function updateUISelection() {
    const count = selectedIds.size;
    document.getElementById('selected-count').textContent = count;
    document.getElementById('btn-start').disabled = count === 0;
    document.getElementById('check-all-master').checked = (count === testingCandidates.length && count > 0);
}

function filterData() {
    const key = document.getElementById('search-data').value.toLowerCase();
    const filtered = testingCandidates.filter(d => d.judul_buku.toLowerCase().includes(key));
    renderSelectionTable(filtered);
}

// 6. ENGINE PENGUJIAN (Original Logic)
function startTesting() {
    if (!naiveBayesModel) return alert("Model belum siap.");
    
    const startTime = performance.now();
    const testSet = testingCandidates.filter(d => selectedIds.has(d.id));
    
    let tp = 0, fp = 0, total = testSet.length;
    let results = [];

    testSet.forEach((item, idx) => {
        const prediction = predict(item.judul_buku);
        const labelAsliFull = item.kategori_hasil || "";
        const labelAsliKode = labelAsliFull.split('-')[0].trim();
        const isCorrect = (prediction.code === labelAsliKode);
        
        if (isCorrect) tp++; else fp++;

        results.push({
            no: idx + 1,
            judul: item.judul_buku,
            asli: labelAsliKode,
            prediksi: prediction.code,
            correct: isCorrect,
            conf: prediction.conf
        });
    });

    const accuracy = total > 0 ? (tp / total) * 100 : 0;
    const precision = (tp + fp) > 0 ? (tp / (tp + fp)) * 100 : 0;
    const recall = total > 0 ? (tp / total) * 100 : 0; 
    const f1 = (precision + recall) > 0 ? (2 * precision * recall) / (precision + recall) : 0;

    testResultSummary = { total, accuracy, precision, recall, f1, details: results };
    
    const endTime = performance.now();
    document.getElementById('execution-time').textContent = `Time: ${((endTime - startTime) / 1000).toFixed(2)}s`;

    showResultsUI(testResultSummary);
}

function predict(text) {
    if (!naiveBayesModel) return { code: '-', conf: 0 };

    const tokens = tokenize(text.toLowerCase());
    let maxScore = -Infinity;
    let bestClass = null;
    let scores = {};

    Object.keys(naiveBayesModel.classCounts).forEach(cls => {
        let score = Math.log(naiveBayesModel.classCounts[cls] / naiveBayesModel.totalDocs);
        const totalTermInClass = Object.values(naiveBayesModel.classWordCounts[cls]).reduce((a,b)=>a+b, 0);
        const vocabSize = naiveBayesModel.vocab.size;

        tokens.forEach(token => {
            // Cek vocab (Set) - bekerja baik untuk model Live maupun Cache (karena Cache sudah dikonversi balik ke Set)
            if (naiveBayesModel.vocab.has(token)) {
                const count = naiveBayesModel.classWordCounts[cls][token] || 0;
                score += Math.log((count + 1) / (totalTermInClass + vocabSize));
            }
        });

        scores[cls] = score;
        if (score > maxScore) {
            maxScore = score;
            bestClass = cls;
        }
    });

    let sumExp = 0;
    Object.values(scores).forEach(s => sumExp += Math.exp(s - maxScore));
    const confidence = (1 / sumExp) * 100;

    return { code: bestClass, conf: confidence };
}

// 7. TAMPILKAN HASIL UI
function showResultsUI(summary) {
    document.getElementById('section-selection').classList.add('hidden');
    document.getElementById('section-result').classList.remove('hidden');

    animateValue("score-accuracy", summary.acc);
    document.getElementById('score-precision').textContent = summary.prec.toFixed(1) + "%";
    document.getElementById('score-recall').textContent = summary.rec.toFixed(1) + "%";
    document.getElementById('score-f1').textContent = summary.f1.toFixed(1) + "%";

    const tbody = document.getElementById('table-result');
    tbody.innerHTML = '';
    summary.details.forEach(r => {
        const badge = r.correct 
            ? `<span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-bold border border-green-200">Tepat</span>`
            : `<span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs font-bold border border-red-200">Meleset</span>`;
        
        tbody.innerHTML += `
            <tr class="hover:bg-gray-50 border-b border-gray-100">
                <td class="px-6 py-4 text-center text-gray-500">${r.no}</td>
                <td class="px-6 py-4 font-bold text-gray-800">${r.judul}</td>
                <td class="px-6 py-4"><code class="bg-gray-100 px-2 py-1 rounded border border-gray-200 font-bold text-gray-700">${r.asli}</code></td>
                <td class="px-6 py-4"><code class="bg-indigo-50 px-2 py-1 rounded border border-indigo-100 font-bold text-indigo-700">${r.prediksi}</code></td>
                <td class="px-6 py-4 text-center">${badge}</td>
            </tr>
        `;
    });
}

function animateValue(id, end) {
    const obj = document.getElementById(id);
    let start = 0;
    const duration = 1000;
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = (progress * end).toFixed(1) + "%";
        if (progress < 1) window.requestAnimationFrame(step);
    };
    window.requestAnimationFrame(step);
}

function resetUI() {
    document.getElementById('section-result').classList.add('hidden');
    document.getElementById('section-selection').classList.remove('hidden');
    clearSelected();
}

// 8. SIMPAN KE DATABASE (Tabel hasil_pengujian)
async function simpanLaporanPengujian() {
    if(!testResultSummary) return;

    if(!confirm("Simpan laporan pengujian ini ke database?")) return;

    const payload = {
        jumlah_data: testResultSummary.total,
        akurasi: testResultSummary.acc,
        precision: testResultSummary.prec,
        recall: testResultSummary.rec,
        f1: testResultSummary.f1,
        detail_json: JSON.stringify(testResultSummary.details) 
    };

    try {
        const formData = new FormData();
        for (const key in payload) {
            formData.append(key, payload[key]);
        }

        const res = await fetch(`${API_PENGUJIAN}?action=simpan_laporan`, {
            method: 'POST',
            body: formData
        });
        const json = await res.json();

        if (json.status === 'success') {
            alert("Laporan berhasil disimpan!");
        } else {
            alert("Gagal simpan: " + json.message);
        }
    } catch(e) {
        console.error(e);
        alert("Gagal koneksi ke server.");
    }
}
</script>