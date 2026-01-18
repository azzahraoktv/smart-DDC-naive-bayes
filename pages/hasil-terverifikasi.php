<?php
// pages/hasil-terverifikasi.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Terverifikasi - Sistem Klasifikasi Buku</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        .progress-bar {
            width: 80px;
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background-color: #3b82f6;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Main Content - FULL SCREEN -->
    <div class="min-h-screen p-4 md:p-6">
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 animate-fade-in h-full">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                            <i class="fas fa-check-circle text-blue-600 mr-2"></i>
                            Hasil Terverifikasi
                        </h1>
                        <p class="text-gray-600 mt-1">Data riwayat yang telah diverifikasi dan disahkan</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="text-sm bg-blue-50 text-blue-700 px-3 py-2 rounded-lg">
                            <i class="fas fa-database mr-1"></i>
                            <span class="font-bold" id="dataCount">0</span> data
                        </div>
                        <button id="exportExcel" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                            <i class="fas fa-file-excel mr-2"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
                
                <!-- Info -->
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Diperbarui: <span id="lastUpdated" class="font-medium">-</span>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tanggal Sah</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kode DDC</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Akurasi</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Pesan jika tidak ada data -->
                <div id="noDataMessage" class="hidden p-8 md:p-12 text-center">
                    <div class="mx-auto w-20 h-20 text-gray-300 mb-4">
                        <i class="fas fa-file-alt text-5xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700">Belum ada data terverifikasi</h3>
                    <p class="text-gray-500 mt-1">Data hasil terverifikasi akan muncul setelah verifikasi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="hidden fixed top-5 right-5 z-50"></div>

    <!-- Modal Detail Data -->
    <div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-4 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-lg font-bold text-gray-800">Detail Data Terverifikasi</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalContent" class="py-4">
                <!-- Konten modal akan diisi oleh JavaScript -->
            </div>
            <div class="pt-3 border-t flex justify-end">
                <button onclick="closeDetailModal()" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
    // Data contoh jika localStorage kosong
    const sampleData = [
        {
            id: 1,
            tanggalSah: "2026-01-04T02:37:00",
            judulBuku: "Panduan Lengkap Instalasi dan Konfigurasi Jaringan LAN-WAN-Wireless-Fiber Optic Berbasis IoT Industry 4.0",
            kodeDDC: "004.6",
            kategori: "Jaringan Komputer & Komunikasi Data",
            nilaiAkurasi: 92,
            metodePengujian: "Naive Bayes",
            status: "Terverifikasi",
            catatan: "Klasifikasi sesuai dengan konten buku"
        },
        {
            id: 2,
            tanggalSah: "2026-01-19T03:52:00",
            judulBuku: "Kamus Komputer Lengkap",
            kodeDDC: "004.03",
            kategori: "Kamus & Ensiklopedia Komputer",
            nilaiAkurasi: 95,
            metodePengujian: "Naive Bayes",
            status: "Terverifikasi",
            catatan: "Terdapat beberapa istilah yang perlu diperbarui"
        },
        {
            id: 3,
            tanggalSah: "2026-01-19T03:52:00",
            judulBuku: "212 Tip & Trik Excel 2010",
            kodeDDC: "005.5",
            kategori: "Aplikasi Serba Guna & Kolaborasi",
            nilaiAkurasi: 88,
            metodePengujian: "K-Nearest Neighbors",
            status: "Terverifikasi",
            catatan: "Klasifikasi akurat untuk aplikasi spreadsheet"
        }
    ];

    // Load XLSX library
    if (typeof XLSX === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js';
        script.onload = initializeHasilTerverifikasi;
        document.head.appendChild(script);
    } else {
        initializeHasilTerverifikasi();
    }

    function initializeHasilTerverifikasi() {
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
            } catch (e) {
                data = sampleData;
                localStorage.setItem('riwayatTerverifikasi', JSON.stringify(data));
            }
        } else {
            data = sampleData;
            localStorage.setItem('riwayatTerverifikasi', JSON.stringify(data));
        }
        
        // Update jumlah data
        const dataCountEl = document.getElementById('dataCount');
        if (dataCountEl) {
            dataCountEl.textContent = data.length;
        }
        
        // Render tabel
        const tableBody = document.getElementById('tableBody');
        const noDataMessage = document.getElementById('noDataMessage');
        
        if (data.length > 0 && tableBody) {
            // Sembunyikan pesan tidak ada data
            noDataMessage.classList.add('hidden');
            
            // Kosongkan tabel
            tableBody.innerHTML = '';
            
            // Isi tabel dengan data
            data.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-4 md:px-6 py-4 text-center text-sm text-gray-900">${index + 1}</td>
                    <td class="px-4 md:px-6 py-4 text-sm text-gray-700">${formatTanggal(item.tanggalSah) || '-'}</td>
                    <td class="px-4 md:px-6 py-4 text-sm text-gray-900 max-w-xs">
                        <div class="truncate" title="${item.judulBuku || '-'}">${item.judulBuku || '-'}</div>
                    </td>
                    <td class="px-4 md:px-6 py-4 text-sm font-medium text-blue-600">${item.kodeDDC || '-'}</td>
                    <td class="px-4 md:px-6 py-4 text-sm text-gray-700">${item.kategori || '-'}</td>
                    <td class="px-4 md:px-6 py-4">
                        <div class="flex items-center">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${item.nilaiAkurasi || 0}%"></div>
                            </div>
                            <span class="ml-2 text-sm font-medium">${item.nilaiAkurasi || 0}%</span>
                        </div>
                    </td>
                    <td class="px-4 md:px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            ${item.status || 'Terverifikasi'}
                        </span>
                    </td>
                    <td class="px-4 md:px-6 py-4 text-sm">
                        <button onclick="showDetail(${index})" class="text-blue-600 hover:text-blue-800 mr-3" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="deleteData(${index})" class="text-red-600 hover:text-red-800" title="Hapus Data">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            // Tampilkan pesan jika tidak ada data
            noDataMessage.classList.remove('hidden');
            if (tableBody) {
                tableBody.innerHTML = '';
            }
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
                    'Tanggal Sah': item.tanggalSah ? formatTanggal(item.tanggalSah) : '',
                    'Judul Buku': item.judulBuku || '',
                    'Kode DDC': item.kodeDDC || '',
                    'Kategori': item.kategori || '',
                    'Akurasi': item.nilaiAkurasi ? `${item.nilaiAkurasi}%` : '',
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
    }
    
    // Fungsi untuk format tanggal
    function formatTanggal(tanggal) {
        if (!tanggal) return '-';
        try {
            const date = new Date(tanggal);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (e) {
            return tanggal;
        }
    }
    
    // Fungsi untuk menampilkan detail data
    function showDetail(index) {
        const riwayatTerverifikasi = localStorage.getItem('riwayatTerverifikasi');
        if (!riwayatTerverifikasi) return;
        
        const data = JSON.parse(riwayatTerverifikasi);
        if (!data[index]) return;
        
        const item = data[index];
        
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = `
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Sah</p>
                        <p class="font-medium">${formatTanggal(item.tanggalSah) || '-'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            ${item.status || 'Terverifikasi'}
                        </span>
                    </div>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500">Judul Buku</p>
                    <p class="font-medium mt-1 p-3 bg-gray-50 rounded">${item.judulBuku || '-'}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Kode DDC</p>
                        <p class="font-medium">${item.kodeDDC || '-'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <p class="font-medium">${item.kategori || '-'}</p>
                    </div>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500">Akurasi</p>
                    <div class="flex items-center mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mr-3">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: ${item.nilaiAkurasi || 0}%"></div>
                        </div>
                        <span class="font-bold">${item.nilaiAkurasi || 0}%</span>
                    </div>
                </div>
                
                ${item.catatan ? `
                <div>
                    <p class="text-sm text-gray-500">Catatan</p>
                    <p class="mt-1 p-3 bg-gray-50 rounded">${item.catatan}</p>
                </div>
                ` : ''}
            </div>
        `;
        
        document.getElementById('detailModal').classList.remove('hidden');
    }
    
    // Fungsi untuk menutup modal detail
    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
    
    // Fungsi untuk menghapus data
    function deleteData(index) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const riwayatTerverifikasi = localStorage.getItem('riwayatTerverifikasi');
                if (!riwayatTerverifikasi) return;
                
                const data = JSON.parse(riwayatTerverifikasi);
                data.splice(index, 1);
                
                localStorage.setItem('riwayatTerverifikasi', JSON.stringify(data));
                
                showToast('Data berhasil dihapus!', 'success');
                
                // Refresh halaman
                setTimeout(() => {
                    initializeHasilTerverifikasi();
                }, 300);
            }
        });
    }
    
    // Fungsi untuk menampilkan toast notification
    function showToast(message, type = 'info') {
        const toast = document.getElementById('toast');
        
        let bgColor, icon;
        if (type === 'success') {
            bgColor = 'bg-green-100 border-green-500 text-green-800';
            icon = '<i class="fas fa-check-circle mr-2"></i>';
        } else if (type === 'error') {
            bgColor = 'bg-red-100 border-red-500 text-red-800';
            icon = '<i class="fas fa-exclamation-circle mr-2"></i>';
        } else {
            bgColor = 'bg-blue-100 border-blue-500 text-blue-800';
            icon = '<i class="fas fa-info-circle mr-2"></i>';
        }
        
        toast.innerHTML = `
            <div class="${bgColor} border-l-4 p-3 rounded shadow-md max-w-sm">
                <div class="flex items-center">
                    ${icon}
                    <span class="font-medium">${message}</span>
                    <button onclick="this.parentElement.parentElement.parentElement.classList.add('hidden')" class="ml-auto text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        toast.classList.remove('hidden');
        
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }
    
    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        initializeHasilTerverifikasi();
        
        // Tutup modal jika klik di luar modal
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    });
    </script>
</body>
</html>