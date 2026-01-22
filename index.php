<?php
// Tentukan halaman yang diminta
$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';

// Daftar halaman yang diperbolehkan
$allowed_pages = ['beranda', 'klasifikasi', 'datalatih', 'riwayat-klasifikasi', 'pengujian', 'kategori', 'hasil-terverifikasi'];

// Validasi halaman
if (!in_array($page, $allowed_pages)) {
    $page = 'beranda';
}

// Definisikan variabel dasar
$base_url = '/smart-ddc/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart DDC - Sistem Klasifikasi</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: "Inter", sans-serif; }
        .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #93c5fd; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #60a5fa; }
        
        /* Utility Classes */
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .input-modern { transition: all 0.3s ease; border: 1px solid #cbd5e1; }
        .input-modern:focus { border-color: #1e40af; box-shadow: 0 0 0 3px rgba(30,64,175,0.2); outline: none; }
        
        /* Loading Overlay */
        .loading-overlay { position: fixed; inset: 0; background: rgba(255,255,255,0.8); z-index: 50; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <?php 
        if (file_exists('includes/sidebar.php')) {
            include 'includes/sidebar.php';
        } else {
            // Fallback Sidebar (Jika file belum ada)
            echo '<div class="w-64 bg-white shadow-lg p-4 flex flex-col hidden md:flex">
                    <div class="font-bold text-xl mb-6 text-blue-800 flex items-center gap-2">
                        <i data-feather="book-open"></i> Smart DDC
                    </div>
                    <nav class="space-y-1">
                        <a href="?page=beranda" class="block p-2 hover:bg-blue-50 rounded text-gray-700">Beranda</a>
                        <a href="?page=kategori" class="block p-2 hover:bg-blue-50 rounded text-gray-700">Kategori DDC</a>
                        <a href="?page=hasil-terverifikasi" class="block p-2 hover:bg-blue-50 rounded text-gray-700 font-medium text-blue-600">Hasil Terverifikasi</a>
                    </nav>
                  </div>';
        }
        ?>
        
        <main class="flex-1 overflow-y-auto bg-gray-100 p-4 md:p-8 relative">
            <div id="main-content" class="animate-fade-in">
                <?php
                $page_file = "pages/{$page}.php";
                if (file_exists($page_file)) {
                    include $page_file;
                } else {
                    echo '<div class="flex flex-col items-center justify-center h-64 text-center">
                            <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm max-w-md">
                                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-feather="alert-octagon"></i>
                                </div>
                                <h2 class="text-xl font-bold text-gray-800">Halaman Belum Tersedia</h2>
                                <p class="text-sm text-gray-500 mt-2 mb-4">File <code>pages/'.$page.'.php</code> belum dibuat di folder proyek.</p>
                                <a href="?page=beranda" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Beranda
                                </a>
                            </div>
                          </div>';
                }
                ?>
            </div>
        </main>
    </div>

    <?php
    if (file_exists('includes/footer.php')) {
        include 'includes/footer.php';
    }
    ?>
    
    <script>
    // =================================================================
    // KONFIGURASI SISTEM UTAMA
    // =================================================================

    // 1. Data Storage GLOBAL (LocalStorage)
    let dataTraining = JSON.parse(localStorage.getItem("dataTraining")) || [];
    let riwayatKlasifikasi = JSON.parse(localStorage.getItem("riwayatKlasifikasi")) || [];
    let hasilPengujian = JSON.parse(localStorage.getItem("hasilPengujian")) || [];
    let hasilTerverifikasi = JSON.parse(localStorage.getItem("riwayatTerverifikasi")) || [];

    // 2. Kategori DDC (Default kosong, akan diisi dari Database)
    let kategoriDDC = [];

    // 3. Konstanta & API
    const USERNAME = "Pustakawan";
    const API_KATEGORI = 'get_kategori.php'; // Backend PHP
    let naiveBayesModel = {};

    // -------------------------------------------------------------
    // FUNGSI LOAD KATEGORI DARI DATABASE (AUTO SYNC)
    // -------------------------------------------------------------
    async function fetchGlobalCategories() {
        try {
            const response = await fetch(`${API_KATEGORI}?action=read`);
            const data = await response.json();
            
            if (Array.isArray(data)) {
                kategoriDDC = data;
                // Simpan cache agar cepat, tapi tetap diupdate tiap reload
                localStorage.setItem("kategoriDDC", JSON.stringify(data));
                console.log(`[System] Berhasil memuat ${data.length} kategori dari Database.`);
            }
        } catch (error) {
            console.warn("[System] Gagal koneksi database, menggunakan cache lokal.", error);
            const stored = localStorage.getItem("kategoriDDC");
            if (stored) kategoriDDC = JSON.parse(stored);
        }
    }

    // Helper akses kategori
    function getKategoriDDC() { return kategoriDDC; }

    function getNamaKategoriByKode(kode) {
        if (!kode) return "Tidak Diketahui";
        const found = kategoriDDC.find(k => k.kode === kode);
        return found ? found.nama : `Kode: ${kode}`;
    }

    // -------------------------------------------------------------
    // FUNGSI UTILITIES (Toast, Date, Warna)
    // -------------------------------------------------------------
    function formatDate(isoString) {
        try {
            if (!isoString) return "-";
            return new Date(isoString).toLocaleDateString("id-ID", {
                day: "2-digit", month: "short", year: "numeric", hour: "2-digit", minute: "2-digit"
            });
        } catch { return isoString; }
    }

    function showToast(message, type = "info") {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true, position: 'top-end', icon: type, title: message,
                showConfirmButton: false, timer: 3000, timerProgressBar: true
            });
        } else {
            alert(message);
        }
    }

    function getCategoryColor(code) {
        if (!code) return "bg-gray-100 text-gray-800";
        const firstDigit = code.split(".")[1]?.charAt(0) || "0";
        const colors = {
            0: "bg-blue-100 text-blue-800", 1: "bg-green-100 text-green-800",
            2: "bg-yellow-100 text-yellow-800", 3: "bg-red-100 text-red-800",
            4: "bg-indigo-100 text-indigo-800", 5: "bg-purple-100 text-purple-800",
            6: "bg-pink-100 text-pink-800", 7: "bg-teal-100 text-teal-800",
            8: "bg-orange-100 text-orange-800",
        };
        return colors[firstDigit] || "bg-gray-100 text-gray-800";
    }

    // -------------------------------------------------------------
    // FUNGSI MODAL PILIH KATEGORI (Untuk Halaman Data Latih)
    // -------------------------------------------------------------
    function populateKategoriModal() {
        const selectKategori = document.getElementById("selectKategori");
        if (!selectKategori) return;
        
        selectKategori.innerHTML = '<option value="">Pilih Kategori DDC</option>';
        kategoriDDC.forEach(kategori => {
            const option = document.createElement("option");
            option.value = `${kategori.kode}|${kategori.nama}`;
            option.textContent = `${kategori.kode} - ${kategori.nama}`;
            selectKategori.appendChild(option);
        });
        if (typeof feather !== 'undefined') feather.replace();
    }

    // -------------------------------------------------------------
    // FUNGSI KHUSUS HALAMAN: HASIL TERVERIFIKASI
    // -------------------------------------------------------------
    function initializeHasilTerverifikasi() {
        // 1. Ambil data
        let data = JSON.parse(localStorage.getItem('riwayatTerverifikasi')) || [];
        
        // 2. Elemen DOM
        const tableBody = document.getElementById('tableBody');
        const loadingRow = document.getElementById('loadingRow');
        const noDataMessage = document.getElementById('noDataMessage');
        const dataCountEl = document.getElementById('dataCount');
        const lastUpdatedEl = document.getElementById('lastUpdated');

        // 3. Update Header Info
        if(dataCountEl) dataCountEl.textContent = data.length;
        if(lastUpdatedEl) lastUpdatedEl.textContent = new Date().toLocaleString('id-ID');
        
        // 4. Render Tabel
        if (tableBody) {
            tableBody.innerHTML = ''; 
            if (data.length > 0) {
                if(loadingRow) loadingRow.style.display = 'none';
                if(noDataMessage) noDataMessage.classList.add('hidden');

                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50 transition-colors border-b border-gray-100';
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.tanggalSah || '-'}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">${item.judulBuku || '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-mono text-xs font-bold">${item.kodeDDC || '-'}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${item.kategori || '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <i data-feather="check-circle" class="w-3 h-3 mr-1 mt-0.5"></i> Valid
                            </span>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                if(loadingRow) loadingRow.style.display = 'none';
                if(noDataMessage) noDataMessage.classList.remove('hidden');
            }
        }

        // 5. Setup Export Excel
        const exportExcelBtn = document.getElementById('exportExcel');
        if (exportExcelBtn) {
            const newBtn = exportExcelBtn.cloneNode(true); // Hapus listener lama
            exportExcelBtn.parentNode.replaceChild(newBtn, exportExcelBtn);
            
            newBtn.addEventListener('click', function() {
                if (data.length === 0) return showToast('Tidak ada data!', 'error');
                
                const excelData = data.map((item, index) => ({
                    'No': index + 1, 'Tanggal': item.tanggalSah, 'Judul': item.judulBuku,
                    'Kode': item.kodeDDC, 'Kategori': item.kategori, 'Status': 'Terverifikasi'
                }));
                
                const ws = XLSX.utils.json_to_sheet(excelData);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Laporan Verifikasi");
                XLSX.writeFile(wb, `Laporan_Verifikasi_${new Date().toISOString().slice(0,10)}.xlsx`);
                
                showToast('Export Berhasil', 'success');
            });
        }
        if (typeof feather !== 'undefined') feather.replace();
    }

    // -------------------------------------------------------------
    // LOGIKA NAIVE BAYES (Placeholder Index)
    // -------------------------------------------------------------
    function preprocessText(text) { return text ? text.toLowerCase().replace(/[^a-z0-9\s]/g, "") : ""; }
    function buildNaiveBayesModel(data) { return { totalDocs: data.length, ready: true }; }
    function tentukanKategoriDenganNaiveBayes(text, model) { return { kode: "000", nama: "Belum", confidence: 0 }; }

    // -------------------------------------------------------------
    // INISIALISASI SISTEM (PAGE ROUTER)
    // -------------------------------------------------------------
    document.addEventListener("DOMContentLoaded", async function () {
        if (typeof feather !== 'undefined') feather.replace();

        // 1. Fetch Data Kategori dari Database (Async)
        await fetchGlobalCategories();

        // 2. Init Model
        naiveBayesModel = buildNaiveBayesModel(dataTraining);
        
        // 3. Routing Halaman Berdasarkan Parameter URL
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page') || 'beranda';
        
        console.log(`[System] Halaman Aktif: ${page}`);
        
        switch(page) {
            case 'beranda':
                // Dashboard logic jika ada
                break;
            case 'datalatih':
                // Pastikan dropdown kategori terisi
                if (typeof loadDataToTable === 'function') setTimeout(() => loadDataToTable(), 100);
                if (typeof populateKategoriModal === 'function') setTimeout(() => populateKategoriModal(), 200);
                break;
            case 'riwayat-klasifikasi':
                if (typeof loadRiwayat === 'function') setTimeout(() => loadRiwayat(), 100);
                break;
            case 'hasil-terverifikasi':
                initializeHasilTerverifikasi();
                break;
            case 'kategori':
                // Refresh data saat buka halaman kategori
                await fetchGlobalCategories();
                break;
        }
    });

    // Fungsi Logout Global
    function handleLogout() {
        Swal.fire({
            title: 'Keluar Sistem?', text: "Sesi Anda akan berakhir.", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Keluar'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = "login.php";
        });
    }

    // Expose ke Window (Global Scope)
    window.handleLogout = handleLogout;
    window.showToast = showToast;
    window.initializeHasilTerverifikasi = initializeHasilTerverifikasi;
    window.getKategoriDDC = getKategoriDDC;
    window.populateKategoriModal = populateKategoriModal;
    </script>
</body>
</html>