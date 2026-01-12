// FILE: assets/components/security_monitor.js

// Durasi Timeout: 45 menit
const INACTIVITY_TIMEOUT = 2700000;

let timeoutHandler;

function resetTimer() {
  clearTimeout(timeoutHandler);
  timeoutHandler = setTimeout(autoLogout, INACTIVITY_TIMEOUT);
}

function autoLogout() {
  localStorage.removeItem("isLoggedIn");
  localStorage.removeItem("userName");
  alert("Sesi Anda telah berakhir karena tidak ada aktivitas.");
  window.location.href = "login.php";
}

function startInactivityMonitor() {
  window.addEventListener("load", resetTimer);
  document.addEventListener("mousemove", resetTimer);
  document.addEventListener("keypress", resetTimer);
  document.addEventListener("scroll", resetTimer);
  document.addEventListener("click", resetTimer);
}

// --- VALIDASI DAN START POINT ---

// Pastikan pengguna sudah login sebelum menjalankan monitor
if (localStorage.getItem("isLoggedIn") !== "true") {
  // Jika belum login, paksa ke halaman login
  window.location.href = "login.php";
} else {
  // Jika sudah login, mulai monitor aktivitas
  startInactivityMonitor();
}
