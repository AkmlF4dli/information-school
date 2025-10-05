<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url={{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-white to-blue-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-md w-full">
        <h1 class="text-2xl font-bold text-yellow-600 mb-4">Akun Tidak Ditemukan 😕</h1>
        <p class="text-gray-700">Kami tidak menemukan akun dengan informasi yang Anda masukkan.</p>
        <p class="mt-2 text-sm text-gray-500">Anda akan diarahkan kembali ke halaman utama dalam 5 detik...</p>

        <a href="{{ url('/') }}" class="mt-6 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
            Kembali Sekarang
        </a>
    </div>

</body>
</html>
