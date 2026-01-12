<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Sistem DDC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Inter", sans-serif;
        /* Latar belakang Biru Gradient sesuai permintaan */
        background: radial-gradient(circle at center, #1e40af, #1e3a8a);
      }
      /* Opsional: menambah sedikit transparansi agar gradient terlihat di balik kotak */
      .glass-card {
        background: rgba(255, 255, 255, 0.98);
      }
    </style>
  </head>
  <body class="min-h-screen flex items-center justify-center p-4">
    <div
      class="glass-card p-8 rounded-xl shadow-2xl w-full max-w-md border-t-4 border-blue-800"
    >
      <div class="text-center mb-8">
        <div class="mb-4">
            <img src="assets/image/logo-stikom-elrahma.png" alt="Logo STIKOM El Rahma" class="h-20 mx-auto object-contain">
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800">SMART DDC</h1>
        <p class="text-sm text-gray-500">Sistem Klasifikasi Judul Buku berdasarkan aturan DDC dengan Algoritma Naive Bayes</p>
      </div>

      <form id="loginForm">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1"
            >Username</label
          >
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i data-feather="user" class="w-4 h-4"></i>
            </span>
            <input
                type="text"
                id="username"
                name="username"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 outline-none"
                placeholder="Username"
                required
            />
          </div>
        </div>

        <div class="mb-6 relative">
          <label class="block text-sm font-medium text-gray-700 mb-1"
            >Password</label
          >
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i data-feather="lock" class="w-4 h-4"></i>
            </span>
            <input
              type="password"
              id="password"
              name="password"
              class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 outline-none"
              placeholder="Password"
              required
            />
            <button
              type="button"
              onclick="togglePassword()"
              class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-blue-800 focus:outline-none"
            >
              <i data-feather="eye" id="eyeIcon" class="w-5 h-5"></i>
            </button>
          </div>
        </div>

        <button
          type="submit"
          id="btnLogin"
          class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-2.5 rounded-lg transition shadow-md active:transform active:scale-95"
        >
          Masuk ke Sistem
        </button>
      </form>

      <div class="mt-6 text-center">
        <p class="text-xs text-gray-500">
          Lupa password? Hubungi Administrator
        </p>
      </div>
    </div>

    <script>
      feather.replace();

      function togglePassword() {
        const passInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");
        if (passInput.type === "password") {
          passInput.type = "text";
          eyeIcon.setAttribute("data-feather", "eye-off");
        } else {
          passInput.type = "password";
          eyeIcon.setAttribute("data-feather", "eye");
        }
        feather.replace();
      }

      // 1. CEK STATUS LOGIN
      if (localStorage.getItem("isLoggedIn") === "true") {
        window.location.href = "index.php";
      }

      document
        .getElementById("loginForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();
          const btn = document.getElementById("btnLogin");
          const originalText = btn.innerText;

          btn.innerText = "Memeriksa...";
          btn.disabled = true;

          // 2. FETCH KE BACKEND
          fetch("php_backend/cek_login.php", {
            method: "POST",
            body: new FormData(this),
          })
            .then((response) => {
              const contentType = response.headers.get("content-type");
              if (!contentType || !contentType.includes("application/json")) {
                return response.text().then((text) => {
                  throw new Error("Server Error: " + text);
                });
              }
              return response.json();
            })
            .then((result) => {
              if (result.status === "success") {
                localStorage.setItem("isLoggedIn", "true");
                localStorage.setItem("userName", result.nama || "Admin");
                window.location.href = "index.php";
              } else {
                alert(result.message);
                btn.innerText = originalText;
                btn.disabled = false;
              }
            })
            .catch((error) => {
              console.error(error);
              alert("Gagal Login: " + error.message);
              btn.innerText = originalText;
              btn.disabled = false;
            });
        });
    </script>
  </body>
</html>