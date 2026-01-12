<div id="page-beranda">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">
            Selamat Datang, 
            <span id="display-username" class="text-blue-600">
                <?php 
                    // Mengambil data 'nama_lengkap' (Pustakawan) dari session
                    echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'User'; 
                ?>
            </span>!
        </h1>
        
        <p class="text-lg text-gray-500 font-medium">
            Dashboard Klasifikasi DDC Otomatis berbasis Naive Bayes.
        </p>

        <div class="mt-2 flex items-center">
            <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1 rounded-full uppercase tracking-wider border border-blue-100">
                Akses: <?php echo isset($_SESSION['role']) ? $_SESSION['role'] : '-'; ?>
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 text-white">
        
        <div class="relative overflow-hidden rounded-xl shadow-lg bg-[#8E44AD] transition-transform hover:scale-[1.02]">
            <div class="p-6">
                <p class="text-sm font-bold opacity-80 uppercase tracking-wider">Total Klasifikasi</p>
                <p class="text-4xl font-black mt-2" id="total-klasifikasi">0</p>
            </div>
            <i data-feather="bar-chart-2" class="absolute right-[-10px] top-1/2 -translate-y-1/2 w-24 h-24 opacity-20 rotate-12"></i>
            <div class="bg-black/10 py-2 px-6 text-[10px] flex justify-between items-center uppercase font-bold tracking-widest">
                <span>Update Realtime</span>
                <i data-feather="chevron-right" class="w-3 h-3"></i>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl shadow-lg bg-[#EC407A] transition-transform hover:scale-[1.02]">
            <div class="p-6">
                <p class="text-sm font-bold opacity-80 uppercase tracking-wider">Data Training</p>
                <p class="text-4xl font-black mt-2" id="total-datalatih">0</p>
            </div>
            <i data-feather="database" class="absolute right-[-10px] top-1/2 -translate-y-1/2 w-24 h-24 opacity-20 rotate-12"></i>
            <div class="bg-black/10 py-2 px-6 text-[10px] flex justify-between items-center uppercase font-bold tracking-widest">
                <span>Database Latih</span>
                <i data-feather="chevron-right" class="w-3 h-3"></i>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl shadow-lg bg-[#26C6DA] transition-transform hover:scale-[1.02]">
            <div class="p-6">
                <p class="text-sm font-bold opacity-80 uppercase tracking-wider">Kategori DDC</p>
                <p class="text-4xl font-black mt-2" id="total-kategori">0</p>
            </div>
            <i data-feather="layers" class="absolute right-[-10px] top-1/2 -translate-y-1/2 w-24 h-24 opacity-20 rotate-12"></i>
            <div class="bg-black/10 py-2 px-6 text-[10px] flex justify-between items-center uppercase font-bold tracking-widest">
                <span>Kelas DDC</span>
                <i data-feather="chevron-right" class="w-3 h-3"></i>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl shadow-lg bg-[#3F51B5] transition-transform hover:scale-[1.02]">
            <div class="p-6">
                <p class="text-sm font-bold opacity-80 uppercase tracking-wider">Akurasi Sistem</p>
                <p class="text-4xl font-black mt-2" id="akurasi-sistem">0%</p>
            </div>
            <i data-feather="target" class="absolute right-[-10px] top-1/2 -translate-y-1/2 w-24 h-24 opacity-20 rotate-12"></i>
            <div class="bg-black/10 py-2 px-6 text-[10px] flex justify-between items-center uppercase font-bold tracking-widest">
                <span>Naive Bayes</span>
                <i data-feather="chevron-right" class="w-3 h-3"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-extrabold text-gray-800 text-xl flex items-center">
                <i data-feather="help-circle" class="w-6 h-6 mr-3 text-blue-600"></i>
                Petunjuk Penggunaan
            </h3>
            <span class="text-xs font-bold bg-blue-50 text-blue-600 px-4 py-1 rounded-full uppercase">Panduan Cepat</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-blue-200 transition-all group">
                <h4 class="font-bold text-gray-800 mb-2 group-hover:text-blue-600">1. Klasifikasi</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Input judul buku untuk mendapatkan klasifikasi DDC secara otomatis.</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-pink-200 transition-all group">
                <h4 class="font-bold text-gray-800 mb-2 group-hover:text-pink-600">2. Training</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Kelola data latih untuk meningkatkan kecerdasan model klasifikasi.</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-emerald-200 transition-all group">
                <h4 class="font-bold text-gray-800 mb-2 group-hover:text-emerald-600">3. Pengujian</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Gunakan data testing untuk mengukur tingkat akurasi Naive Bayes.</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-indigo-200 transition-all group">
                <h4 class="font-bold text-gray-800 mb-2 group-hover:text-indigo-600">4. Sinkronisasi</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Sinkronkan database kategori DDC agar data tetap akurat.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between mb-8 border-b border-gray-50 pb-4">
            <h3 class="font-extrabold text-gray-800 text-xl flex items-center">
                <i data-feather="clock" class="w-6 h-6 mr-3 text-blue-500"></i>
                Aktivitas Terbaru
            </h3>
            <div class="flex items-center space-x-2">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-[10px] font-bold text-green-600 uppercase tracking-widest">Live Updates</span>
            </div>
        </div>
        <div id="recent-activity" class="space-y-4">
            <div class="text-center py-12 text-gray-400 italic text-sm">
                Menunggu aktivitas sistem...
            </div>
        </div>
    </div>
</div>

<script>
function loadRecentActivity() {
    const container = document.getElementById("recent-activity");
    if (!container) return;

    // Ambil data global dari window
    const rKlasifikasi = window.riwayatKlasifikasi || [];
    const hPengujian = window.hasilPengujian || [];

    // 1. Update Akurasi
    const akurasiEl = document.getElementById("akurasi-sistem");
    if (akurasiEl) {
        if (hPengujian.length > 0) {
            const acc = hPengujian[hPengujian.length - 1].akurasi;
            akurasiEl.textContent = (acc !== undefined ? acc : 0) + "%";
        } else {
            akurasiEl.textContent = "0%";
        }
    }

    // 2. Render List Aktivitas
    if (rKlasifikasi.length === 0) {
        container.innerHTML = '<div class="text-center py-10 text-gray-400 italic bg-gray-50 rounded-xl border border-dashed">Belum ada aktivitas terbaru.</div>';
        return;
    }

    const recentData = rKlasifikasi.slice(0, 5);
    container.innerHTML = recentData.map((item) => `
        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-transparent hover:border-blue-100 transition-all">
            <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center mr-5 text-white shadow-sm flex-shrink-0">
                <i data-feather="check" class="w-6 h-6"></i>
            </div>
            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-bold text-gray-800 truncate" title="${item.judul}">${item.judul}</p>
                <div class="flex items-center mt-1 space-x-4">
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 uppercase">DDC: ${item.kode}</span>
                    <span class="text-[10px] text-gray-400 flex items-center">
                        <i data-feather="calendar" class="w-3 h-3 mr-1"></i> ${item.waktu || 'Baru saja'}
                    </span>
                </div>
            </div>
        </div>
    `).join("");

    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(loadRecentActivity, 100);
});

window.loadRecentActivity = loadRecentActivity;
</script>