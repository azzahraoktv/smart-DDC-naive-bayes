<?php
// pages/hasil-terverifikasi.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Terverifikasi - Sistem Klasifikasi Buku</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif; /* Font User Friendly */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        /* Custom Scrollbar for table */
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">
    
    <div class="p-4 md:p-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 animate-fade-in min-h-[85vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        Hasil Terverifikasi
                    </h1>
                    <p class="text-gray-500 mt-2 text-base">
                        Data riwayat klasifikasi yang telah divalidasi dan disahkan.
                    </p>
                    <div class="text-xs text-gray-400 mt-1 flex items-center gap-2">
                        <i class="fas fa-history"></i>
                        Diperbarui: <span id="lastUpdated" class="font-medium">-</span>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <div class="bg-blue-50 text-blue-700 px-4 py-2.5 rounded-lg border border-blue-100 shadow-sm flex items-center">
                        <i class="fas fa-database mr-2"></i>
                        <span class="font-bold text-lg mr-1" id="dataCount">0</span>
                        <span class="text-sm">Data</span>
                    </div>
                    <button id="exportExcel" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 shadow-sm flex items-center font-medium">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export Excel
                    </button>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-12">No</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Tanggal Sah</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider min-w-[300px]">Judul Buku</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Kode DDC</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-48">Kategori</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-28">
                                    Akurasi
                                    <i class="fas fa-info-circle ml-1 text-gray-400 cursor-help" title="Berdasarkan pengujian Confusion Matrix"></i>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Status</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
                            </tbody>
                    </table>
                </div>

                <div id="noDataMessage" class="hidden p-16 text-center bg-gray-50">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center text-gray-300 mb-4">
                        <i class="fas fa-clipboard-check text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700">Belum ada data terverifikasi</h3>
                    <p class="text-gray-500 mt-2">Data hasil klasifikasi yang disetujui akan muncul di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="toast" class="hidden fixed top-5 right-5 z-50 transform transition-all duration-300"></div>

    <script>
    // --- Data Dummy (Simulasi Database/LocalStorage) ---
    const defaultData = [
        {
            id: 1,
            tanggalSah: "2026-01-04T02:37:00",
            judulBuku: "Panduan Lengkap Instalasi dan Konfigurasi Jaringan LAN-WAN-Wireless-Fiber Optic Berbasis IoT Industry 4.0",
            kodeDDC: "004.6",
            kategori: "Jaringan Komputer & Komunikasi Data",
            nilaiAkurasi: 92, // Dari Confusion Matrix
            status: "Terverifikasi"
        },
        {
            id: 2,
            tanggalSah: "2026-01-19T03:52:00",
            judulBuku: "Kamus Komputer Lengkap Edisi Terbaru Tahun 2026",
            kodeDDC: "004.03",
            kategori: "Kamus & Ensiklopedia Komputer",
            nilaiAkurasi: 95,
            status: "Terverifikasi"
        },
        {
            id: 3,
            tanggalSah: "2026-01-19T03:52:00",
            judulBuku: "212 Tip & Trik Excel 2010 untuk Pemula hingga Mahir",
            kodeDDC: "005.5",
            kategori: "Aplikasi Serba Guna & Kolaborasi",
            nilaiAkurasi: 88,
            status: "Terverifikasi"
        },
        {
            id: 4,
            tanggalSah: "2026-01-21T02:20:00",
            judulBuku: "Buku Pintar Internet : Membuat Aplikasi Web dengan PHP dan MySQL",
            kodeDDC: "005.369",
            kategori: "Aplikasi Desain & Lain-lain (Office)",
            nilaiAkurasi: 90,
            status: "Terverifikasi"
        },
        {
            id: 5,
            tanggalSah: "2026-01-21T02:20:00",
            judulBuku: "Artificial Intelligence : Mengupas Rekayasa Perangkat Lunak Cerdas",
            kodeDDC: "005.1",
            kategori: "Algoritma, Rekayasa Perangkat Lunak",
            nilaiAkurasi: 85,
            status: "Terverifikasi"
        }
    ];

    // --- Main Logic ---
    function initializeApp() {
        // Cek LocalStorage, jika kosong pakai defaultData
        let storedData = localStorage.getItem('riwayatTerverifikasi');
        let data = storedData ? JSON.parse(storedData) : defaultData;

        // Jika data kosong di awal (first run), set default
        if (!storedData) {
            localStorage.setItem('riwayatTerverifikasi', JSON.stringify(data));
        }

        renderTable(data);
        updateHeaderInfo(data);
        setupEventListeners(data);
    }

    function renderTable(data) {
        const tableBody = document.getElementById('tableBody');
        const noDataMessage = document.getElementById('noDataMessage');

        // Bersihkan tabel
        tableBody.innerHTML = '';

        if (data.length === 0) {
            noDataMessage.classList.remove('hidden');
            return;
        }

        noDataMessage.classList.add('hidden');

        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition-colors duration-150';
            
            // Format Tanggal
            const dateObj = new Date(item.tanggalSah);
            const dateStr = dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
            const timeStr = dateObj.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');

            // Render Row
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">${index + 1}</td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <div class="font-medium">${dateStr}</div>
                    <div class="text-xs text-gray-400 mt-0.5">${timeStr}</div>
                </td>
                
                <td class="px-6 py-4 text-sm text-gray-900">
                    <div class="whitespace-normal leading-relaxed font-medium">
                        ${item.judulBuku}
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                    ${item.kodeDDC}
                </td>
                
                <td class="px-6 py-4 text-sm text-gray-600">
                    <div class="whitespace-normal leading-snug">
                        ${item.kategori}
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <span class="font-bold text-base">${item.nilaiAkurasi}%</span>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        <i class="fas fa-check mr-1.5 text-[10px]"></i> Terverifikasi
                    </span>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <button onclick="deleteData(${index})" class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-2 rounded-lg hover:bg-red-50" title="Hapus Data">
                        <i class="fas fa-trash-alt text-base"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function updateHeaderInfo(data) {
        // Update Jumlah Data
        document.getElementById('dataCount').textContent = data.length;

        // Update Tanggal
        const now = new Date();
        document.getElementById('lastUpdated').textContent = now.toLocaleString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
        }).replace('.', ':');
    }

    // --- Delete Functionality ---
    window.deleteData = function(index) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Data yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'rounded-lg px-4 py-2',
                cancelButton: 'rounded-lg px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Ambil data terbaru
                let data = JSON.parse(localStorage.getItem('riwayatTerverifikasi'));
                
                // Hapus item
                data.splice(index, 1);
                
                // Simpan & Render Ulang
                localStorage.setItem('riwayatTerverifikasi', JSON.stringify(data));
                renderTable(data);
                updateHeaderInfo(data);
                
                showToast('Data berhasil dihapus', 'success');
            }
        });
    }

    // --- Excel Export ---
    function setupEventListeners(data) {
        document.getElementById('exportExcel').addEventListener('click', function() {
            // Ambil data terbaru saat tombol diklik
            const currentData = JSON.parse(localStorage.getItem('riwayatTerverifikasi')) || [];

            if (currentData.length === 0) {
                showToast('Tidak ada data untuk diexport', 'error');
                return;
            }

            const exportData = currentData.map((item, idx) => ({
                'No': idx + 1,
                'Tanggal Sah': new Date(item.tanggalSah).toLocaleDateString('id-ID'),
                'Judul Buku': item.judulBuku,
                'Kode DDC': item.kodeDDC,
                'Kategori': item.kategori,
                'Akurasi (%)': item.nilaiAkurasi,
                'Status': 'Terverifikasi'
            }));

            const ws = XLSX.utils.json_to_sheet(exportData);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Hasil Terverifikasi");
            
            // Auto width columns roughly
            const wscols = [
                {wch: 5}, {wch: 15}, {wch: 50}, {wch: 10}, {wch: 30}, {wch: 10}, {wch: 15}
            ];
            ws['!cols'] = wscols;

            XLSX.writeFile(wb, `Hasil_Terverifikasi_${new Date().toISOString().slice(0,10)}.xlsx`);
            
            showToast('File Excel berhasil diunduh', 'success');
        });
    }

    // --- Toast Helper ---
    function showToast(message, type = 'info') {
        const toast = document.getElementById('toast');
        const colors = type === 'success' 
            ? 'bg-emerald-50 text-emerald-800 border-emerald-200' 
            : (type === 'error' ? 'bg-red-50 text-red-800 border-red-200' : 'bg-blue-50 text-blue-800 border-blue-200');
        
        const icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle');

        toast.innerHTML = `
            <div class="${colors} border shadow-lg rounded-lg px-4 py-3 flex items-center gap-3 min-w-[300px]">
                <i class="fas ${icon} text-lg"></i>
                <span class="font-medium text-sm">${message}</span>
            </div>
        `;
        
        toast.classList.remove('hidden', 'translate-y-[-100%]', 'opacity-0');
        
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-[-100%]');
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
    }

    // Run App
    document.addEventListener('DOMContentLoaded', initializeApp);

    </script>
</body>
</html>