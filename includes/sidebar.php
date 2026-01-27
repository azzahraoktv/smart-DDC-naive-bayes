<aside class="w-64 bg-blue-900 text-white flex flex-col flex-shrink-0 shadow-2xl z-20">
    <div class="p-6 flex items-center border-b border-blue-800 bg-blue-950">
        <div class="mr-3">
            <img src="assets/image/logo-stikom-putih.png" alt="Logo" class="w-12 h-12 object-contain">
        </div>
        <span class="font-bold text-lg tracking-wide text-white">Smart DDC</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        
        <a href="index.php?page=beranda" class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'beranda') || !isset($_GET['page']) ? 'bg-blue-700 text-white shadow-lg border border-blue-600' : 'text-blue-100 hover:bg-blue-800 hover:text-white'; ?> flex items-center px-4 py-3 rounded-lg transition-all duration-200 cursor-pointer">
            <i data-feather="home" class="mr-3 w-5 h-5"></i> Beranda
        </a>

        <div class="pt-6 pb-2 px-4 text-xs font-bold text-blue-300 uppercase tracking-wider">
            APLIKASI UTAMA
        </div>

        <a href="index.php?page=klasifikasi" class="nav-item <?php echo isset($_GET['page']) && $_GET['page'] == 'klasifikasi' ? 'bg-blue-700 text-white shadow-lg border border-blue-600' : 'text-blue-100 hover:bg-blue-800 hover:text-white'; ?> flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 cursor-pointer">
            <i data-feather="search" class="mr-3 w-5 h-5"></i> Klasifikasi (Utama)
        </a>

        <a href="index.php?page=riwayat-klasifikasi" class="nav-item <?php echo isset($_GET['page']) && $_GET['page'] == 'riwayat-klasifikasi' ? 'bg-blue-700 text-white shadow-lg border border-blue-600' : 'text-blue-100 hover:bg-blue-800 hover:text-white'; ?> flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 cursor-pointer">
            <i data-feather="save" class="mr-3 w-5 h-5"></i> Riwayat Klasifikasi
        </a>

        <a href="index.php?page=pengujian" class="nav-item <?php echo isset($_GET['page']) && $_GET['page'] == 'pengujian' ? 'bg-blue-700 text-white shadow-lg border border-blue-600' : 'text-blue-100 hover:bg-blue-800 hover:text-white'; ?> flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 cursor-pointer">
            <i data-feather="activity" class="mr-3 w-5 h-5"></i> Pengujian (Testing)
        </a>

        <a href="index.php?page=hasil-terverifikasi" class="nav-item <?php echo isset($_GET['page']) && $_GET['page'] == 'hasil-terverifikasi' ? 'bg-blue-700 text-white shadow-lg border border-blue-600' : 'text-blue-100 hover:bg-blue-800 hover:text-white'; ?> flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 cursor-pointer">
            <i data-feather="check-circle" class="mr-3 w-5 h-5"></i> Hasil Terverifikasi
        </a>

        <div class="pt-6 pb-2 px-4 text-xs font-bold text-blue-300 uppercase tracking-wider">
            MASTER DATA
        </div>

        <a href="index.php?page=datalatih" class="nav-item <?php echo isset($_GET['page']) && $_GET['page'] == 'datalatih' ? 'bg-blue-700 text-white shadow-lg border border-blue-600' : 'text-blue-100 hover:bg-blue-800 hover:text-white'; ?> flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 cursor-pointer">
            <i data-feather="database" class="mr-3 w-5 h-5"></i> Data Training
        </a>

        <a href="index.php?page=kategori" class="nav-item <?php echo isset($_GET['page']) && $_GET['page'] == 'kategori' ? 'bg-blue-700 text-white shadow-lg border border-blue-600' : 'text-blue-100 hover:bg-blue-800 hover:text-white'; ?> flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 cursor-pointer">
            <i data-feather="layers" class="mr-3 w-5 h-5"></i> Kategori DDC
        </a>
    </nav>

    <div class="p-4 border-t border-blue-800 bg-blue-900">
        <div class="flex items-center mb-4 px-2">
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-sm font-bold mr-3 border-2 border-blue-400 text-white">
                <?php echo substr($_SESSION['nama_lengkap'] ?? 'P', 0, 1); ?>
            </div>
            <div>
                <p class="text-sm font-bold text-white"><?php echo $_SESSION['nama_lengkap'] ?? 'Pustakawan'; ?></p>
                <p class="text-xs text-emerald-300 flex items-center font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span>
                    Online
                </p>
            </div>
        </div>
        
        <button onclick="handleLogout()" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition-all duration-200 text-sm font-bold text-white shadow-sm border border-red-800">
            <i data-feather="log-out" class="mr-2 w-4 h-4"></i> Keluar
        </button>

        <div class="mt-4 pt-3 border-t border-blue-800 text-center">
            <p class="text-[10px] text-blue-300 leading-tight">
                &copy; 2026 <strong>Smart DDC</strong><br>
                Perpustakaan STIKOM El Rahma
            </p>
        </div>
    </div>
</aside>