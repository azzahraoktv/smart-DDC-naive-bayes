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