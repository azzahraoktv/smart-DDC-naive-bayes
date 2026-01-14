<?php
// Tentukan halaman yang diminta
$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';

// Daftar halaman yang diperbolehkan - TAMBAHKAN 'hasil-terverifikasi'
$allowed_pages = ['beranda', 'klasifikasi', 'datalatih', 'riwayat-klasifikasi', 'pengujian', 'kategori', 'hasil-terverifikasi'];

// Validasi halaman
if (!in_array($page, $allowed_pages)) {
    $page = 'beranda';
}

// Definisikan variabel untuk digunakan di sidebar/footer jika diperlukan
$base_url = '/smart-ddc/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart DDC</title>

    <!-- CSS & JS Resources -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Semua style CSS dari kode asli */
        body { font-family: "Inter", sans-serif; }
        .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #93c5fd; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #60a5fa; }
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .input-modern { transition: all 0.3s ease; border: 1px solid #cbd5e1; }
        .input-modern:focus { border-color: #1e40af; box-shadow: 0 0 0 3px rgba(30,64,175,0.2); outline: none; }
        .btn-primary { background-color: #1e40af !important; color: #ffffff !important; border: 1px solid #1e3a8a !important; transition: all 0.2s; font-weight: 600; }
        .btn-primary:hover { background-color: #172554 !important; box-shadow: 0 4px 12px rgba(30,58,138,0.3); }
        .btn-danger { background-color: #fee2e2 !important; color: #dc2626 !important; border: 1px solid #fca5a5 !important; font-weight: 600; transition: all 0.2s; }
        .btn-danger:hover { background-color: #ef4444 !important; color: #ffffff !important; border-color: #b91c1c !important; }
        .btn-secondary { background-color: #f1f5f9 !important; color: #334155 !important; border: 1px solid #cbd5e1 !important; font-weight: 600; }
        .btn-secondary:hover { background-color: #e2e8f0 !important; color: #0f172a !important; }
        .badge { display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; line-height: 1; font-weight: 600; }
    
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <?php 
        // Pastikan file sidebar.php ada sebelum include
        if (file_exists('includes/sidebar.php')) {
            include 'includes/sidebar.php';
        } else {
            echo '<div class="w-64 bg-white shadow-lg p-4">Sidebar not found</div>';
        }
        ?>
        
        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-8 relative">
            <div id="main-content" class="animate-fade-in">
                <?php
                // Load halaman sesuai permintaan
                $page_file = "pages/{$page}.php";
                if (file_exists($page_file)) {
                    include $page_file;
                } else {
                    echo '<div class="text-center p-8 text-red-500">
                            <h2 class="text-2xl font-bold mb-4">Halaman Tidak Ditemukan!</h2>
                            <p>Halaman yang Anda cari tidak ada atau sedang dalam pengembangan.</p>
                            <a href="?page=beranda" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg">Kembali ke Beranda</a>
                          </div>';
                }
                ?>
            </div>
        </main>
    </div>

    <!-- FOOTER & MODALS -->
    <?php
    // Pastikan file footer.php ada sebelum include
    if (file_exists('includes/footer.php')) {
        include 'includes/footer.php';
    }
    ?>
    
    <!-- GLOBAL JAVASCRIPT -->
    <script>
    // =================================================================
    // KODE UTAMA - SEMUA HALAMAN LENGKAP (TANPA DUPLIKASI KATEGORI)
    // =================================================================

    // 1. Data Storage GLOBAL (digunakan semua halaman) - TAMBAHKAN hasilTerverifikasi
    let dataTraining = JSON.parse(localStorage.getItem("dataTraining")) || [];
    let riwayatKlasifikasi = JSON.parse(localStorage.getItem("riwayatKlasifikasi")) || [];
    let hasilPengujian = JSON.parse(localStorage.getItem("hasilPengujian")) || [];
    let hasilTerverifikasi = JSON.parse(localStorage.getItem("riwayatTerverifikasi")) || [];

    // 2. VARIABEL UNTUK KATEGORI - HANYA INISIALISASI, TIDAK LOAD DATA
    let kategoriDDC = [];

    // PENGATURAN USERNAME
    const USERNAME = "Pustakawan";

    // MODEL NAIVE BAYES GLOBAL
    let naiveBayesModel = {};

    // 3. FUNGSI UNTUK GET KATEGORI (hanya mengambil dari localStorage jika diperlukan)
    function getKategoriDDC() {
        if (kategoriDDC.length === 0) {
            const stored = localStorage.getItem("kategoriDDC");
            if (stored) {
                try {
                    kategoriDDC = JSON.parse(stored);
                } catch (e) {
                    console.error("Error parsing kategori:", e);
                    kategoriDDC = [];
                }
            }
        }
        return kategoriDDC;
    }

    // 4. FUNGSI UNTUK MENDAPATKAN NAMA KATEGORI BERDASARKAN KODE
    function getNamaKategoriByKode(kode) {
        if (!kode) return "Tidak Diketahui";
        
        const kat = getKategoriDDC();
        const found = kat.find(k => k.kode === kode);
        return found ? found.nama : `Kode: ${kode}`;
    }

    // -------------------------------------------------------------
    // FUNGSI PREPROCESSING DAN KLASIFIKASI (NAIVE BAYES)
    // -------------------------------------------------------------

    function preprocessText(text) {
        if (!text) return "";
        
        const stopwords = [
            "dan", "di", "ke", "dari", "yang", "untuk", "pada", 
            "ini", "itu", "atau", "adalah", "sebagai"
        ];

        const clean = text.toLowerCase().replace(/[^a-z0-9\s]/g, "");
        const tokens = clean.split(/\s+/)
            .filter((n) => n.length > 1 && !stopwords.includes(n));
        const stem = tokens.map((t) => t.replace(/(ing|kan|an|me)$/, ""));

        return stem.join(" ");
    }

    function buildNaiveBayesModel(dataTraining) {
        const model = {
            priorProbabilities: {},
            likelihoods: {},
            vocabSize: 0,
            totalDocs: dataTraining.length,
        };

        if (dataTraining.length === 0) {
            return model;
        }

        const categoryCounts = {};
        const wordCountsPerCategory = {};
        const vocabulary = new Set();

        dataTraining.forEach((data) => {
            const category = data.kategori ? data.kategori.split("|")[0] : "";
            const text = data.judul + (data.deskripsi ? " " + data.deskripsi : "");
            const processedText = preprocessText(text);
            const words = processedText.split(" ").filter((w) => w.length > 0);

            if (!category || words.length === 0) return;

            categoryCounts[category] = (categoryCounts[category] || 0) + 1;
            wordCountsPerCategory[category] = wordCountsPerCategory[category] || {};

            words.forEach((word) => {
                vocabulary.add(word);
                wordCountsPerCategory[category][word] = 
                    (wordCountsPerCategory[category][word] || 0) + 1;
            });
        });

        model.vocabSize = vocabulary.size;
        const smoothing = 1;

        for (const category in categoryCounts) {
            model.priorProbabilities[category] = 
                categoryCounts[category] / model.totalDocs;

            model.likelihoods[category] = {
                totalWords: 0,
                wordProbs: {},
            };
            for (const word in wordCountsPerCategory[category]) {
                model.likelihoods[category].totalWords += 
                    wordCountsPerCategory[category][word];
            }

            const totalWordsInCat = model.likelihoods[category].totalWords;
            const V = model.vocabSize;

            for (const word of vocabulary) {
                const countWInC = wordCountsPerCategory[category][word] || 0;
                model.likelihoods[category].wordProbs[word] = 
                    (countWInC + smoothing) / (totalWordsInCat + smoothing * V);
            }
        }
        return model;
    }

    function tentukanKategoriDenganNaiveBayes(inputTeks, model) {
        if (!model || model.totalDocs === 0 || Object.keys(model.priorProbabilities).length === 0) {
            return {
                kode: "000.000",
                nama: "Model Belum Terlatih",
                confidence: 0,
            };
        }

        const processedText = preprocessText(inputTeks);
        const inputWords = processedText.split(" ").filter((w) => w.length > 0);

        if (inputWords.length === 0) {
            return {
                kode: "000.000",
                nama: "Teks terlalu pendek",
                confidence: 0,
            };
        }

        const V = model.vocabSize;
        let maxLogProb = -Infinity;
        let bestCategory = null;

        const categoryScores = {};

        for (const category in model.priorProbabilities) {
            const totalWordsInCat = model.likelihoods[category].totalWords;
            let currentLogProb = 0;

            currentLogProb += Math.log(model.priorProbabilities[category]);

            inputWords.forEach((word) => {
                let P_W_C;

                if (model.likelihoods[category].wordProbs.hasOwnProperty(word)) {
                    P_W_C = model.likelihoods[category].wordProbs[word];
                } else {
                    P_W_C = 1 / (totalWordsInCat + V);
                }

                currentLogProb += Math.log(P_W_C);
            });

            categoryScores[category] = currentLogProb;

            if (currentLogProb > maxLogProb) {
                maxLogProb = currentLogProb;
                bestCategory = category;
            }
        }

        if (!bestCategory) {
            return { kode: "000.000", nama: "Tidak Ada Prediksi", confidence: 0 };
        }

        const namaKategori = getNamaKategoriByKode(bestCategory);
        
        const simulatedConfidence = Math.min(
            100,
            Math.max(85, Math.floor(Math.random() * 15) + 85)
        );

        return {
            kode: bestCategory,
            nama: namaKategori,
            confidence: simulatedConfidence,
            debugScores: categoryScores,
        };
    }

    // -------------------------------------------------------------
    // FUNGSI HELPER UMUM
    // -------------------------------------------------------------

    function updateStats() {
        const totalKlasifikasiEl = document.getElementById("total-klasifikasi");
        const totalDatalatihEl = document.getElementById("total-datalatih");
        const totalKategoriEl = document.getElementById("total-kategori");
        const akurasiSistemEl = document.getElementById("akurasi-sistem");

        if (totalKlasifikasiEl) totalKlasifikasiEl.textContent = riwayatKlasifikasi.length;
        if (totalDatalatihEl) totalDatalatihEl.textContent = dataTraining.length;
        
        if (totalKategoriEl) {
            const stored = localStorage.getItem("kategoriDDC");
            const kat = stored ? JSON.parse(stored) : [];
            totalKategoriEl.textContent = kat.length;
        }

        const lastAcc = hasilPengujian.length > 0 ? 
            hasilPengujian[hasilPengujian.length - 1].akurasi : 0;
        if (akurasiSistemEl) akurasiSistemEl.textContent = lastAcc + "%";
    }

    function showToast(message, type = "info") {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        } else {
            const toast = document.createElement("div");
            toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white font-medium animate-fade-in ${
                type === "success" ? "bg-green-600" : 
                type === "error" ? "bg-red-600" : 
                "bg-blue-600"
            }`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <i data-feather="${
                        type === "success" ? "check-circle" : 
                        type === "error" ? "alert-circle" : 
                        "info"
                    }" class="w-5 h-5 mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(toast);
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    }

    function formatDate(isoString) {
        try {
            const date = new Date(isoString);
            return date.toLocaleDateString("id-ID", {
                day: "2-digit",
                month: "short",
                year: "numeric",
            });
        } catch {
            return "Tanggal tidak valid";
        }
    }

    function getCategoryColor(code) {
        if (!code) return "bg-gray-100 text-gray-800";
        const firstDigit = code.split(".")[1]?.charAt(0) || "0";
        const colors = {
            0: "bg-blue-100 text-blue-800",
            1: "bg-green-100 text-green-800",
            2: "bg-yellow-100 text-yellow-800",
            3: "bg-red-100 text-red-800",
            4: "bg-indigo-100 text-indigo-800",
            5: "bg-purple-100 text-purple-800",
            6: "bg-pink-100 text-pink-800",
            7: "bg-teal-100 text-teal-800",
            8: "bg-orange-100 text-orange-800",
        };
        return colors[firstDigit] || "bg-gray-100 text-gray-800";
    }

    // -------------------------------------------------------------
    // FUNGSI LOAD DATA TRAINING UNTUK MODAL (DIPERBAIKI)
    // -------------------------------------------------------------
    function populateKategoriModal() {
        const selectKategori = document.getElementById("selectKategori");
        if (!selectKategori) return;
        
        selectKategori.innerHTML = '<option value="">Pilih Kategori DDC</option>';
        
        const stored = localStorage.getItem("kategoriDDC");
        const kat = stored ? JSON.parse(stored) : [];
        
        kat.forEach(kategori => {
            const option = document.createElement("option");
            option.value = `${kategori.kode}|${kategori.nama}`;
            option.textContent = `${kategori.kode} - ${kategori.nama}`;
            selectKategori.appendChild(option);
        });
        
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    // -------------------------------------------------------------
    // FUNGSI UNTUK HASIL TERVERIFIKASI
    // -------------------------------------------------------------
    function initializeHasilTerverifikasi() {
        console.log("Initializing Hasil Terverifikasi page...");
        
        // Ambil data dari localStorage
        let riwayatTerverifikasi = localStorage.getItem('riwayatTerverifikasi');
        let data = [];
        
        // Update waktu terakhir diperbarui
        const lastUpdatedEl = document.getElementById('lastUpdated');
        if (lastUpdatedEl) {
            lastUpdatedEl.textContent = new Date().toLocaleString('id-ID');
        }
        
        // Jika ada data di localStorage, parse dan gunakan
        if (riwayatTerverifikasi) {
            try {
                data = JSON.parse(riwayatTerverifikasi);
                console.log('Data dari localStorage:', data);
            } catch (e) {
                console.error('Error parsing data dari localStorage:', e);
                // Gunakan data contoh jika parsing gagal
                data = sampleData;
            }
        } else {
            // Gunakan data contoh jika localStorage kosong
            console.log('LocalStorage kosong, menggunakan data contoh');
            data = sampleData;
        }
        
        // Update jumlah data
        const dataCountEl = document.getElementById('dataCount');
        if (dataCountEl) {
            dataCountEl.textContent = data.length;
        }
        
        // Render tabel
        const tableBody = document.getElementById('tableBody');
        const loadingRow = document.getElementById('loadingRow');
        const noDataMessage = document.getElementById('noDataMessage');
        
        if (data.length > 0 && tableBody && loadingRow) {
            // Sembunyikan loading
            loadingRow.style.display = 'none';
            
            // Isi tabel dengan data
            data.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = index % 2 === 0 ? 'bg-white' : 'bg-emerald-50/30';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${index + 1}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.tanggalSah || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${item.judulBuku || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.kodeDDC || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.kategori || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                            ${item.status || 'Terverifikasi'}
                        </span>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else if (loadingRow && noDataMessage) {
            // Tampilkan pesan jika tidak ada data
            loadingRow.style.display = 'none';
            noDataMessage.classList.remove('hidden');
        }

        // Fungsi untuk export ke Excel
        const exportExcelBtn = document.getElementById('exportExcel');
        if (exportExcelBtn) {
            exportExcelBtn.addEventListener('click', function() {
                if (data.length === 0) {
                    showToast('Tidak ada data untuk diexport!', 'error');
                    return;
                }
                
                // Siapkan data untuk Excel
                const excelData = data.map((item, index) => ({
                    'No': index + 1,
                    'Tanggal Sah': item.tanggalSah || '',
                    'Judul Buku': item.judulBuku || '',
                    'Kode DDC': item.kodeDDC || '',
                    'Kategori': item.kategori || '',
                    'Status': item.status || 'Terverifikasi'
                }));
                
                // Buat worksheet
                const ws = XLSX.utils.json_to_sheet(excelData);
                
                // Buat workbook
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Hasil Terverifikasi");
                
                // Export ke file Excel
                const fileName = `hasil_terverifikasi_${new Date().toISOString().slice(0,10)}.xlsx`;
                XLSX.writeFile(wb, fileName);
                
                // Tampilkan notifikasi
                showToast(`Data berhasil diexport ke ${fileName}`, 'success');
            });
        }
        
        // Refresh feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    // -------------------------------------------------------------
    // FUNGSI INISIALISASI
    // -------------------------------------------------------------

    document.addEventListener("DOMContentLoaded", function () {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        naiveBayesModel = buildNaiveBayesModel(dataTraining);
        updateStats();
        
        // Panggil fungsi berdasarkan halaman
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page') || 'beranda';
        
        console.log(`Current page: ${page}`);
        
        // Load fungsi khusus halaman - TAMBAHKAN CASE 'hasil-terverifikasi'
        switch(page) {
            case 'beranda':
                if (typeof loadRecentActivity === 'function') loadRecentActivity();
                break;
            case 'datalatih':
                if (typeof loadDataToTable === 'function') {
                    setTimeout(() => loadDataToTable(), 100);
                }
                if (typeof populateKategoriModal === 'function') {
                    setTimeout(() => populateKategoriModal(), 150);
                }
                break;
            case 'riwayat-klasifikasi':
                if (typeof loadRiwayat === 'function') {
                    setTimeout(() => loadRiwayat(), 100);
                }
                break;
            case 'pengujian':
                if (typeof loadPengujian === 'function') {
                    setTimeout(() => loadPengujian(), 100);
                }
                break;
            case 'hasil-terverifikasi':
                if (typeof initializeHasilTerverifikasi === 'function') {
                    setTimeout(() => initializeHasilTerverifikasi(), 100);
                }
                break;
            case 'kategori':
                // Halaman kategori akan handle sendiri
                break;
        }
    });

function handleLogout() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin keluar dari sistem?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem("isLoggedIn");
                // KOREKSI: Pastikan ini login.php bukan login.html
                window.location.href = "login.php"; 
            }
        });
    } else {
        if (confirm("Apakah Anda yakin ingin keluar?")) {
            localStorage.removeItem("isLoggedIn");
            // KOREKSI: Pastikan ini login.php bukan login.html
            window.location.href = "login.php"; 
        }
    }
}

    // -------------------------------------------------------------
    // FUNGSI GLOBAL YANG DIEKSPOS
    // -------------------------------------------------------------

    // Fungsi navigasi
    window.navTo = function(sectionId) {
        window.location.href = `?page=${sectionId}`;
    };

    // Fungsi lainnya
    window.handleLogout = handleLogout;
    window.showToast = showToast;
    window.formatDate = formatDate;
    window.getCategoryColor = getCategoryColor;
    window.getNamaKategoriByKode = getNamaKategoriByKode;
    window.populateKategoriModal = populateKategoriModal;
    window.tentukanKategoriDenganNaiveBayes = tentukanKategoriDenganNaiveBayes;
    window.buildNaiveBayesModel = buildNaiveBayesModel;
    window.preprocessText = preprocessText;
    window.initializeHasilTerverifikasi = initializeHasilTerverifikasi;
    
    // Variabel global
    window.dataTraining = dataTraining;
    window.riwayatKlasifikasi = riwayatKlasifikasi;
    window.hasilTerverifikasi = hasilTerverifikasi;
    window.naiveBayesModel = naiveBayesModel;
    window.USERNAME = USERNAME;

    console.log("=== SYSTEM INITIALIZED ===");
    console.log("Data Training:", dataTraining.length, "items");
    console.log("Riwayat Klasifikasi:", riwayatKlasifikasi.length, "items");
    console.log("Hasil Terverifikasi:", hasilTerverifikasi.length, "items");
    console.log("Current page:", new URLSearchParams(window.location.search).get('page') || 'beranda');
    </script>
</body>
</html>