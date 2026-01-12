<?php
// pages/hasil-terverifikasi.php
?>
<div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-800">Hasil Terverifikasi</h1>
            <p class="text-gray-600 mt-2">Data riwayat yang telah diverifikasi dan disahkan</p>
        </div>
        <div class="flex space-x-4">
            <button id="exportExcel" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center btn-primary">
                <i data-feather="download" class="mr-2 w-5 h-5"></i>
                Export Excel
            </button>
            <a href="?page=beranda" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center">
                <i data-feather="arrow-left" class="mr-2 w-5 h-5"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Informasi Statistik -->
    <div class="mb-6 flex justify-between items-center">
        <div class="text-gray-700">
            <p>Jumlah Data: <span id="dataCount" class="font-bold text-blue-600">0</span> entri</p>
        </div>
        <div class="text-sm text-gray-500">
            <p>Terakhir diperbarui: <span id="lastUpdated">-</span></p>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Tanggal Sah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Judul Buku</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Kode DDC</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Kategori</th>
                        <!-- TAMBAH KOLOM DATA PENGUJIAN -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Hasil Pengujian</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Akurasi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data akan diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Pesan jika tidak ada data -->
        <div id="noDataMessage" class="hidden p-12 text-center">
            <div class="mx-auto w-24 h-24 text-gray-200">
                <i data-feather="file-text" class="w-full h-full"></i>
            </div>
            <h3 class="mt-6 text-lg font-medium text-gray-900">Tidak ada data</h3>
            <p class="mt-2 text-gray-500">Belum ada data riwayat terverifikasi yang tersimpan di localStorage.</p>
            <div class="mt-6">
                <a href="?page=beranda" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Load XLSX library jika belum ada
if (typeof XLSX === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js';
    script.onload = initializeHasilTerverifikasi;
    document.head.appendChild(script);
} else {
    initializeHasilTerverifikasi();
}

function initializeHasilTerverifikasi() {
    // Pastikan feather icons dirender
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

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
            // Jika parsing gagal, data tetap kosong
            data = [];
        }
    } else {
        // Jika localStorage kosong, data tetap kosong
        console.log('LocalStorage kosong untuk riwayatTerverifikasi');
        data = [];
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
        
        // Isi tabel dengan data
        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${formatTanggal(item.tanggalSah) || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${item.judulBuku || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.kodeDDC || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.kategori || '-'}</td>
                <!-- TAMBAHKAN DATA PENGUJIAN -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.hasilPengujian || item.metodePengujian || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    ${item.nilaiAkurasi ? `${item.nilaiAkurasi}%` : '-'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        ${item.status || 'Terverifikasi'}
                    </span>
                </td>
            `;
            tableBody.appendChild(row);
        });
    } else if (noDataMessage) {
        // Tampilkan pesan jika tidak ada data
        noDataMessage.classList.remove('hidden');
        // Hapus semua baris dari tabel
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
                // TAMBAHKAN DATA PENGUJIAN
                'Hasil Pengujian': item.hasilPengujian || '',
                'Nilai Akurasi': item.nilaiAkurasi ? `${item.nilaiAkurasi}%` : '',
                'Metode Pengujian': item.metodePengujian || '',
                'Catatan': item.catatan || '',
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
    
    // Refresh feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}
</script>