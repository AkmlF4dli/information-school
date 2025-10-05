<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SISKUL 8</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="public/favicon.ico" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ86dGNB8Co/8Gtr89M0v+3wGoJ4DNYo3/dJ8S/D3n/6F6T/5+FqVl288gG/8Lw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

    </style>
</head>
 <?php 
$cabangList = ['Futsal', 'Basket', 'Pramuka', 'Paskibra', 'IT', 'Paskibraka', 'Jepang', 'Korea'];
?>
 @php
    use Carbon\Carbon;

    // Cek apakah sudah absen hari ini
    $check_absent_guru = \App\Models\Absensi::where('name', Auth::user()->name)
        ->whereDate('created_at', Carbon::today())
        ->exists();

    $check_absent_siswa = \App\Models\Absensi::where('name', Auth::user()->name)
        ->whereDate('created_at', Carbon::today())
        ->exists();

    // Hari ini dalam lowercase (senin, selasa, ...)
    $today = strtolower(Carbon::now()->locale('id')->translatedFormat('l'));
@endphp

{{-- Guru wajib absen sesuai jadwal hari --}}
@if (
    Auth::user()->role == 'guru'
    && !$check_absent_guru
    && Auth::user()->tanggal_tugas == $today
)
    <style>
        #main { display: none; }
    </style>

    <center><p>Silakan isi absensi terlebih dahulu</p></center>

    <form action="/absensi" method="POST"
          class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 border border-blue-300">
        @csrf
        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Form Absensi Guru</h2>

        {{-- Identity --}}
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-blue-700" for="identity">Identity</label>
            <input type="number" name="identity" id="identity"
                   value="{{ Auth::user()->identity }}" readonly
                   class="shadow border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Name --}}
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-blue-700" for="name">Name</label>
            <input type="text" name="name" id="name"
                   value="{{ Auth::user()->name }}" readonly
                   class="shadow border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Role --}}
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-blue-700" for="role">Role</label>
            <input type="text" name="role" id="role"
                   value="{{ Auth::user()->role }}" readonly
                   class="shadow border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit Absensi
            </button>
        </div>
    </form>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="w-full mt-4 px-4 py-2 bg-red-100 hover:bg-red-200 text-red-800 font-semibold rounded-md">
            Logout
        </button>
    </form>

{{-- Siswa & ketua eskul --}}
@elseif (
    !$check_absent_siswa
    && (Auth::user()->role == 'siswa' || Auth::user()->role == 'ketua_eskul')
)
    @if (Auth::user()->role == 'siswa')
        <style>#main { display: none; }</style>
    @endif
<div class="mt-5">
    <center><p>Silakan isi absensi terlebih dahulu</p></center>

    <form action="/absensi" method="POST"
          class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 border border-blue-300">
        @csrf
        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Form Absensi</h2>

        {{-- Identity --}}
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-blue-700" for="identity">Identity</label>
            <input type="number" name="identity" id="identity"
                   value="{{ Auth::user()->identity }}" readonly
                   class="shadow border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Name --}}
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-blue-700" for="name">Name</label>
            <input type="text" name="name" id="name"
                   value="{{ Auth::user()->name }}" readonly
                   class="shadow border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Role --}}
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-blue-700" for="role">Role</label>
            <input type="text" name="role" id="role"
                   value="{{ Auth::user()->role }}" readonly
                   class="shadow border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Kelas --}}
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-blue-700" for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas"
                   value="{{ Auth::user()->kelas }}" readonly
                   class="shadow border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Jurusan --}}
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-blue-700" for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan"
                   value="{{ Auth::user()->jurusan }}" readonly
                   class="shadow border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit Absensi
            </button>
        </div>
    </form>
@endif
</div>

<body>
<div x-data="{ showForm: 'dashboard' }" 
     class="flex min-h-screen bg-gradient-to-br from-white to-blue-100" 
     id="main">
    @if (Auth::user()->role == "ketua_eskul" && $check_absent_siswa)
     <script>document.getElementById("sidebar").style.display = "none"</script>
    @endif

    @if (Auth::user()->role != 'siswa')
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-6 space-y-4" style="background-color: blue;" class="sidebar">
            {{-- Judul Menu Berdasarkan Role --}}
            @if (Auth::user()->role == 'admin')
                <center><h2 class="text-xl font-semibold mb-4 text-white">Menu Admin</h2></center>
            @elseif (Auth::user()->role == 'guru')
                <center><h2 class="text-xl font-semibold mb-4 text-white">Menu Piket</h2></center>
            @elseif (Auth::user()->role == 'pembina')
                <center><h2 class="text-xl font-semibold mb-4 text-white">Menu Pembina</h2></center>
            @elseif (Auth::user()->role == 'eskul')
                <center>
                    <h2 class="text-xl font-semibold mb-4 text-white">
                        Menu Pelatih Eskul {{ Auth::user()->cabang_eskul }}
                    </h2>
                </center>
            @elseif (Auth::user()->role == 'ketua_eskul')
                <center>
                    <h2 class="text-xl font-semibold mb-4 text-white">
                        Menu Ketua Eskul {{ Auth::user()->cabang_eskul }}
                    </h2>
                </center>
            @endif

            {{-- Navigasi --}}
            <nav class="flex flex-col space-y-2">
                {{-- Foto Profil --}}
                <center>
                    <img src="{{ Auth::user()->picture == '/storage/profile/profile.jpg' 
                                 ? Auth::user()->picture 
                                 : '/storage/' . Auth::user()->picture }}" 
                         alt="Profile Photo"
                         width="100" height="100"
                         class="mb-5 w-32 h-32 rounded-full object-cover border border-gray-300 shadow">
                </center>

                {{-- Tombol My Profile --}}
                <button 
                   onclick="window.location.href = '/myprofile'"
                   class="px-4 py-2 rounded-md bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold">
                   My Profile
                </button>

                {{-- Dashboard --}}
                <button
                    @click="showForm = 'dashboard'"
                    class="px-4 py-2 rounded-md bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold">
                    Dashboard
                </button>

                {{-- Menu Admin --}}
                @if (Auth::user()->role == 'admin')
                    <button
                        @click="showForm = 'lihatPembina'"
                        class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold">
                        Lihat Pembina
                    </button>

                    <button
                        @click="showForm = 'lihatGuru'"
                        class="px-4 py-2 rounded-md bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-semibold">
                        Lihat Guru Piket
                    </button>

                    <button
                        @click="showForm = 'lihatSiswa'"
                        class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold">
                        Lihat Siswa
                    </button>
                @endif

                {{-- Menu Pembina --}}
                @if (Auth::user()->role == 'pembina')
                    <button
                        @click="showForm = 'lihatEskul'"
                        class="px-4 py-2 rounded-md bg-purple-100 hover:bg-purple-200 text-purple-800 font-semibold">
                        Lihat Pelatih Eskul
                    </button>
                    
                    <button
                        @click="showForm = 'lihatKetuaEskul'"
                        class="px-4 py-2 rounded-md bg-pink-100 hover:bg-pink-200 text-pink-800 font-semibold">
                        Lihat Ketua Eskul
                    </button>
                @endif

                {{-- Menu Guru --}}
                @if (Auth::user()->role == 'guru')
                    <button
                        @click="showForm = 'izinSiswa'"
                        class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold">
                        Izin Siswa
                    </button>

                    <button
                        @click="showForm = 'izinGuru'"
                        class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold">
                        Izin Guru
                    </button>
                @endif

                {{-- Menu Pelatih Eskul --}}
                @if (Auth::user()->role == 'eskul')
                    <button
                        @click="showForm = 'TambahkanMateri'"
                        class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold">
                        Berikan Materi
                    </button>
                @endif

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-800 font-semibold rounded-md">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>
    @endif