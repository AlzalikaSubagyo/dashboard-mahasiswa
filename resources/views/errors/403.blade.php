<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center">
    <div class="text-center">
        <div class="text-9xl font-black text-red-100 mb-4">403</div>
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Akses Ditolak</h1>
        <p class="text-slate-400 mb-6">Kamu tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/dashboard') }}"
           class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>