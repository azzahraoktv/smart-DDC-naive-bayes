<?php
// 1. WAJIB: Panggil file keamanan yang sudah kita buat
// File ini otomatis melakukan session_start(), cek login, dan cek timeout
require_once 'auth_check.php';

// 2. Routing Halaman
$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';
// Daftar halaman yang diizinkan (Whitelist)
$allowed_pages = ['beranda', 'klasifikasi', 'datalatih', 'riwayat-klasifikasi', 'pengujian', 'kategori', 'hasil-terverifikasi'];

if (!in_array($page, $allowed_pages)) {
    $page = 'beranda';
}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        body { font-family: "Inter", sans-serif; }
        .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Scrollbar Custom */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #93c5fd; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #60a5fa; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <?php 
        // Load Sidebar
        if (file_exists('includes/sidebar.php')) {
            include 'includes/sidebar.php';
        } else {
            // FALLBACK SIDEBAR (Jika file sidebar.php belum dibuat)
            ?>
            <div class="w-64 bg-white shadow-lg p-6 hidden md:flex flex-col border-r border-gray-200">
                <div class="font-extrabold text-2xl mb-8 text-blue-700 flex items-center gap-2">
                    <i data-feather="book"></i> Smart DDC
                </div>
                <nav class="space-y-2 flex-1">
                    <a href="?page=beranda" class="flex items-center gap-3 p-3 <?php echo $page=='beranda' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg font-medium">
                        <i data-feather="home" class="w-5 h-5"></i> Beranda
                    </a>
                    <a href="?page=klasifikasi" class="flex items-center gap-3 p-3 <?php echo $page=='klasifikasi' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg">
                        <i data-feather="search" class="w-5 h-5"></i> Klasifikasi
                    </a>
                    <a href="?page=datalatih" class="flex items-center gap-3 p-3 <?php echo $page=='datalatih' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50'; ?> rounded-lg">
                        <i data-feather="database" class="w-5 h-5"></i> Data Latih
                    </a>
                </nav>
                
                <div class="border-t pt-4">
                     <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                            <?php echo substr($_SESSION['nama_lengkap'] ?? 'U', 0, 1); ?>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700 truncate w-32"><?php echo $_SESSION['nama_lengkap'] ?? 'User'; ?></p>
                            <p class="text-xs text-gray-500 capitalize"><?php echo $_SESSION['role'] ?? 'Guest'; ?></p>
                        </div>
                     </div>
                     <button onclick="handleLogout()" class="w-full flex items-center justify-center gap-2 p-2 text-red-600 hover:bg-red-50 rounded-lg transition text-sm font-medium">
                        <i data-feather="log-out" class="w-4 h-4"></i> Keluar
                     </button>
                </div>
            </div>
            <?php
        }
        ?>
        
        <main class="flex-1 overflow-y-auto bg-slate-100 p-4 md:p-8 relative">
            <div class="md:hidden flex justify-between items-center mb-6">
                <h1 class="font-bold text-xl text-blue-800">Smart DDC</h1>
                <button onclick="handleLogout()" class="text-gray-500"><i data-feather="log-out"></i></button>
            </div>

            <div id="main-content" class="animate-fade-in max-w-7xl mx-auto">
                <?php
                // Logika pemanggilan halaman dinamis
                $page_file = "pages/{$page}.php";
                if (file_exists($page_file)) {
                    include $page_file;
                } else {
                    echo '<div class="flex flex-col items-center justify-center h-96 text-center">
                            <div class="text-red-500 mb-4"><i data-feather="alert-triangle" class="w-16 h-16"></i></div>
                            <h2 class="text-2xl font-bold text-gray-800">Halaman Tidak Ditemukan</h2>
                            <p class="text-gray-500 mt-2">File <code>'.$page_file.'</code> belum dibuat.</p>
                          </div>';
                }
                ?>
            </div>
        </main>
    </div>

    <script>
    // 1. Inisialisasi Icon Feather
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof feather !== 'undefined') feather.replace();
    });

    // 2. Data Global User
    const USER_INFO = {
        nama: "<?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'User'; ?>",
        role: "<?php echo isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest'; ?>"
    };

    // 3. Fungsi Logout Manual
    function handleLogout() {
        Swal.fire({
            title: 'Keluar Sistem?',
            text: "Anda harus login kembali untuk masuk.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = "php_backend/logout.php";
        });
    }

    // 4. AUTO LOGOUT SCRIPT (IDLE DETECTION)
    // Sesuai dengan timeout PHP (30 menit = 1800000 ms)
    (function() {
        const idleDuration = 1800000; // 30 Menit
        let idleTimer;

        function resetTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(() => {
                // Jangan pakai alert biasa, pakai SweetAlert biar cantik
                Swal.fire({
                    title: 'Sesi Habis',
                    text: 'Anda tidak aktif selama 30 menit. Silakan login kembali.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = "php_backend/logout.php";
                });
            }, idleDuration);
        }

        // Event listener untuk aktivitas user
        ['mousemove', 'mousedown', 'keypress', 'touchmove', 'scroll'].forEach(evt => {
            document.addEventListener(evt, resetTimer, false);
        });

        resetTimer(); // Start timer saat load
    })();
    </script>
    
</body>
</html>