<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SISKUL 8</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js" defer></script>
    <link rel="public/favicon.ico" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ86dGNB8Co/8Gtr89M0v+3wGoJ4DNYo3/dJ8S/D3n/6F6T/5+FqVl288gG/8Lw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

    </style>
</head>
 <?php 
 use \App\Models\User;
 use \App\Models\Eskul;
 use \App\Models\Absensi;
 use Illuminate\Support\Facades\Date;

$cabangList = Eskul::query()->get();
$eskulList = Eskul::all();
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
@elseif (Auth::user()->role == "guru" && Auth::user()->tanggal_tugas != $today) 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tidak Bertugas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Script redirect setelah 5 detik -->
    <script>
        setTimeout(function() {
            document.getElementById('logoutForm').submit();
        }, 5000);
    </script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="p-8 bg-white rounded-lg shadow text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Kamu tidak bertugas hari ini</h1>
        <p class="text-gray-600">
            Kamu akan keluar secara otomatis dalam 
            <span id="countdown" class="font-semibold text-red-500">5</span> detik...
        </p>

        <!-- Form logout (hidden) -->
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>

    <script>
        // Hitung mundur 5 detik
        let timeLeft = 5;
        const countdown = document.getElementById('countdown');
        const timer = setInterval(function() {
            timeLeft--;
            if (timeLeft > 0) {
                countdown.textContent = timeLeft;
            } else {
                clearInterval(timer);
            }
        }, 1000);
    </script>
        <style>#main { display: none; }</style>
</body>
</html>
@endif

{{-- Siswa & ketua eskul --}}
@if (
    !isset($check_absent_siswa)
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
            <div style="display: flex; justify-content: center; align-items: center;">
                  <i class="fas fa-school text-2xl mr-3" style="color: white; "></i>
                <h3 class="text-white">SISKUL v1.0 Beta</h3>
            </div>
            {{-- Navigasi --}}
            <nav class="flex flex-col space-y-2">
                {{-- Foto Profil --}}
 <div class="w-full h-32 bg-blue-600 flex items-center rounded-md shadow-md px-4">
    <!-- Foto Profil -->
    <div class="flex-shrink-0">
        <img 
            src="{{ Auth::user()->picture == '/storage/profile/profile.jpg' 
                     ? Auth::user()->picture 
                     : '/storage/' . Auth::user()->picture }}" 
            alt="Profile Photo"
            class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md"
        >
    </div>

    <!-- Judul & Keterangan -->
    <div class="ml-4 text-left flex-1">
        @if (Auth::user()->role == 'admin')
            <h3 class="text-lg font-semibold text-white">Menu Admin</h3>
        @elseif (Auth::user()->role == 'guru')
            <h3 class="text-lg font-semibold text-white">Menu Piket</h3>
            <p class="text-xs text-white opacity-90 mt-1">
                Hari Piket: <span class="font-medium">{{ Auth::user()->tanggal_tugas }}</span>
            </p>
        @elseif (Auth::user()->role == 'pembina')
            <h3 class="text-lg font-semibold text-white">Pembina</h3>
            <p class="text-xs text-white opacity-90 mt-1">
                {{ Auth::user()->cabang_eskul }}
            </p>
        @elseif (Auth::user()->role == 'kesiswaan')
            <h3 class="text-lg font-semibold text-white">Kesiswaan</h3>
        @elseif (Auth::user()->role == 'eskul')
            <h3 class="text-lg font-semibold text-white">Pelatih</h3>
            <p class="text-xs text-white opacity-90 mt-1">
                {{ Auth::user()->cabang_eskul }}
            </p>
        @elseif (Auth::user()->role == 'ketua_eskul')
            <h3 class="text-lg font-semibold text-white">
                Ketua
            </h3>
            <p class="text-xs text-white opacity-90 mt-1">
                {{ Auth::user()->cabang_eskul }}
            </p>
        @endif
    </div>
</div>
                {{-- Tombol My Profile --}}
                <button 
                   onclick="window.location.href = '/myprofile'"
                   class="px-4 py-2 rounded-md bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold">
                   My Profile
                </button>

                {{-- Dashboard --}}
                <button
                    @click="window.location.href = '/dashboard'"
                    class="px-4 py-2 rounded-md bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold">
                    Dashboard
                </button>

                {{-- Menu Admin --}}
                @if (Auth::user()->role == 'admin')
                    <button
                        @click="showForm = 'lihatGuru'"
                        class="px-4 py-2 rounded-md bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-semibold">
                        Guru Piket
                    </button>

                    <button
                        @click="showForm = 'lihatSiswa'"
                        class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold">
                        Siswa
                    </button>
                    <button
                        @click="showForm = 'lihatcabangEskul'"
                        class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold">
                        Cabang Eskul
                    </button>
                @endif

                @if(Auth::user()->role == "guru")
                    <button
                        @click="showForm = 'lihatSiswa'"
                        class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold">
                        Siswa
                    </button>
                @endif

                {{-- Menu Pembina --}}
                @if (Auth::user()->role == 'pembina')
                    <button
                        @click="showForm = 'lihatEskul'"
                        class="px-4 py-2 rounded-md bg-purple-100 hover:bg-purple-200 text-purple-800 font-semibold">
                        Lihat Pelatih Eskul
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
<footer style="margin-top: max-content" class="text-center py-4 text-sm text-white shadow-inner">
    <p>
        © 2025 <span class="font-semibold">SISKUL 8 JAKARTA</span> - All rights reserved.
    </p>
</footer>
            </nav>
        </aside>
    @endif

    <!-- Main Content -->
    <main class="flex-1 p-10 space-y-6">

        <!-- Dashboard Welcome -->
<div x-show="showForm === 'dashboard'" class="p-4">
    <!-- Kesiswaan Dashboard -->
    @if (Auth::user()->role == 'kesiswaan')
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Ekstrakurikuler</title>
  <style>
    body {
      font-family: "Poppins", Arial, sans-serif;
      background: #f2f6fc;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 90%;
      max-width: 1200px;
      margin: 40px auto;
    }

    .title {
      text-align: center;
      font-size: 30px;
      font-weight: 700;
      color: #1e3a8a;
      margin-bottom: 30px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .flex-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .card {
      background: linear-gradient(135deg, #2563eb, #1e40af);
      color: white;
      border-radius: 14px;
      width: 240px;
      padding: 25px 20px;
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.4);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 6px 14px rgba(37, 99, 235, 0.6);
    }

    .card .name {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .card .desc {
      font-size: 14px;
      opacity: 0.9;
    }
  </style>
</head>
<body>

  <!-- Flex Card Container -->
        <center><h1 class="title">Daftar Ekstrakurikuler</h1></center>
    <div class="flex flex-wrap justify-center gap-6">
      @foreach ($eskulList as $eskul)
      <a href="/eskul?cabang={{ $eskul->cabang_eskul }}">
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl shadow-lg w-60 p-5 text-center cursor-pointer hover:scale-105 transition">
          <div class="text-lg font-semibold mb-1">{{ $eskul->cabang_eskul }}</div>
        </div>
      </a>
      @endforeach
    </div>
</body>
</html>
@endif

<!-- pembina -->
@if (Auth::user()->role == "pembina")

<?php
$currentCabang = Auth::user()->cabang_eskul;

// Ambil jadwal dari tabel Eskul
$jadwalList = Eskul::where('cabang_eskul', $currentCabang)->get();

// Ambil pelatih dan ketua dari tabel User
$pelatihList = User::where('role', 'eskul')
                    ->where('cabang_eskul', $currentCabang)
                    ->get();

$pembinaList = User::where('role', 'pembina')
                  ->where('cabang_eskul', $currentCabang)
                  ->get();
?>

<div x-data="{ showForm: 'dashboard' }" class="p-6 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-100 to-blue-200">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    body {
      font-family: 'Poppins', sans-serif;
    }

    .dashboard-title {
      text-align: center;
      font-size: 2rem;
      font-weight: 700;
      color: #1e3a8a;
      margin-bottom: 2rem;
      letter-spacing: 1px;
    }

    /* --- JADWAL SECTION --- */
    .jadwal-container {
      background: linear-gradient(135deg, #2563eb, #1e40af);
      color: white;
      border-radius: 16px;
      padding: 35px 30px;
      margin-bottom: 40px;
      box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
      text-align: center;
      width: 100%;
      transition: all 0.3s ease;
    }

    .jadwal-container:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(37, 99, 235, 0.6);
    }

    .jadwal-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 15px;
      letter-spacing: 1px;
    }

    .jadwal-info {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 25px;
      font-size: 1rem;
    }

    .jadwal-info div {
      background: rgba(255, 255, 255, 0.15);
      padding: 12px 25px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
      min-width: 160px;
    }

    .section-container {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      padding: 25px 30px;
      flex: 1;
      transition: all 0.3s ease;
    }

    .section-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: #1e40af;
      margin-bottom: 15px;
      text-align: center;
      text-transform: uppercase;
    }

    .flex-container {
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
    }

    .grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .card {
      background: linear-gradient(135deg, #2563eb, #1e40af);
      color: white;
      border-radius: 16px;
      width: 220px;
      padding: 25px 20px;
      text-align: center;
      box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .card:hover {
      transform: translateY(-6px) scale(1.03);
      box-shadow: 0 10px 22px rgba(37, 99, 235, 0.6);
    }

    .name {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .role, .cabang {
      font-size: 0.9rem;
      opacity: 0.9;
      margin-bottom: 4px;
    }

    .empty {
      text-align: center;
      color: #4b5563;
      font-size: 0.95rem;
      padding: 10px 0;
    }
  </style>

  <div x-show="showForm === 'dashboard'" x-transition>
    <div class="dashboard-title">Dashboard {{ Auth::user()->cabang_eskul }}</div>

    <!-- Jadwal Eskul (Full Width) -->
    @forelse ($jadwalList as $jadwal)
      <div class="jadwal-container">
        <div class="jadwal-title">Jadwal {{ $jadwal->cabang_eskul }}</div>
        <div class="jadwal-info">
          @if (!empty($jadwal->hari))
            <div>🗓 <strong>{{ $jadwal->hari }}</strong></div>
          @endif
          @if (!empty($jadwal->waktu))
            <div>⏰ <strong>{{ $jadwal->waktu }}</strong></div>
          @endif
          @if (!empty($jadwal->tempat))
            <div>📍 <strong>{{ $jadwal->tempat }}</strong></div>
          @endif
        </div>
      </div>
    @empty
      <div class="empty">Belum ada jadwal untuk cabang ini.</div>
    @endforelse

    <!-- Pelatih & Ketua Section -->
    <div class="flex-container">
      
      <!-- Pembina -->
      <div class="section-container">
        <div class="section-title">Pembina Eskul</div>
        <div class="grid">
          @forelse ($pembinaList as $pembina)
            <div class="card">
              <div class="name">{{ $pembina->name }}</div>
              <div class="cabang">Cabang: {{ $pembina->cabang_eskul }}</div>
            </div>
          @empty
            <div class="empty">Belum ada pembina di cabang ini.</div>
          @endforelse
        </div>
      </div>

      <!-- Pelatih -->
      <div class="section-container">
        <div class="section-title">Pelatih Eskul</div>
        <div class="grid">
          @forelse ($pelatihList as $pelatih)
            <div class="card">
              <div class="name">{{ $pelatih->name }}</div>
              <div class="cabang">Cabang: {{ $pelatih->cabang_eskul }}</div>
            </div>
          @empty
            <div class="empty">Belum ada pelatih di cabang ini.</div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>
@endif

@if(Auth::user()->role == "admin" or Auth::user()->role == "guru")

<form method="GET" action="{{ route('dashboard') }}" class="mb-6">
    <div class="flex flex-col sm:flex-row items-end sm:items-center gap-3 bg-white shadow-md rounded-xl p-4 border border-gray-200">
        
        {{-- Date Input --}}
        <div class="flex flex-col w-full sm:w-auto">
            <label for="tanggal" class="text-gray-700 font-semibold mb-1">📅 Pilih Tanggal</label>
            <small>Bulan/Tanggal/Tahun</small>
            <input 
                type="date" 
                id="tanggal" 
                name="tanggal" 
                value="{{ $tanggal }}" 
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            >
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-2">
            <button 
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm transition"
            >
                🔍 Cari
            </button>

            <a 
                href="{{ route('dashboard') }}" 
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-5 py-2.5 rounded-lg shadow-sm transition"
            >
                🔄 Reset
            </a>
        </div>
    </div>
</form>



<div class="flex gap-6 mb-9">

    {{-- Left: Siswa --}}
    <div class="w-1/2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Siswa</h2>
        <div>
            <canvas id="siswaChart"></canvas>
        </div>

        <h3 class="font-semibold mt-6 mb-2">List Siswa yang Izin:</h3>
        <div class="max-h-64 overflow-auto border p-2 rounded">
    @php
            $siswaIzinList = \App\Models\Absensi::where('role', 'siswa')->orWhere('role', 'ketua_eskul')->get();
        @endphp

        @if (count($siswaIzin) > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach ($siswaIzin as $izin)
                   @if (isset($izin->role) != NULL)
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow hover:shadow-lg transition">
                        <div class="font-bold text-gray-800">{{ $izin->name }} (NISN: {{ $izin->identity }})</div>
                        <div class="text-sm text-green-700">Kelas: {{ $izin->kelas ?? '-' }} / Jurusan: {{ $izin->jurusan ?? '-' }}</div>
                        <div class="text-sm text-green-700">Mapel: {{ $izin->mata_pelajaran ?? '-' }}</div>
                        <div class="text-sm text-gray-600 mt-1">
                            <span class="font-semibold">Tanggal:</span> {{ $izin->created_at }}
                        </div>
                        <div class="text-sm text-gray-600 italic truncate" title="{{ $izin->alasan_izin }}">
                            Alasan: "{{ $izin->alasan_izin }}"
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex gap-2">

                            <!-- Delete -->
                            <form action="{{ route('siswa.izin.destroy', $izin->identity) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data izin ini?');"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada pengajuan izin siswa yang tercatat hari ini.</p>
        @endif
        </div>
    </div>

    {{-- Right: Guru --}}
    <div class="w-1/2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Guru</h2>
        <div>
            <canvas id="guruChart"></canvas>
        </div>

        <h3 class="font-semibold mt-6 mb-2">List Guru yang Izin:</h3>
        <div class="max-h-64 overflow-auto border p-2 rounded">
            @if ($guruIzin->count() > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach ($guruIzin as $izin)
                    @if($izin->role && $izin->alasan_izin)
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow hover:shadow-lg transition">
                        <div class="font-bold text-gray-800">{{ $izin->name }} (NIP: {{ $izin->identity }})</div>
                        <div class="text-sm text-green-700">Mapel: {{ $izin->mata_pelajaran ?? '-' }}</div>
                        <div class="text-sm text-gray-600 mt-1">
                            <span class="font-semibold">Tanggal:</span> {{ $izin->created_at->format('d M Y H:i') }}
                        </div>
                        <div class="text-sm text-gray-600"><span class="font-semibold">Jam Pelajaran:</span> {{ $izin->jam_pelajaran ?? '-' }}</div>
                        <div class="text-sm text-gray-600 italic truncate" title="{{ $izin->alasan_izin }}">
                            Alasan: "{{ $izin->alasan_izin }}"
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex gap-2">
                            <form action="{{ route('guru.izin.destroy', $izin->identity) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus data izin ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada pengajuan izin guru yang tercatat hari ini.</p>
        @endif
        </div>
    </div>

</div>

<!-- Halaman Untuk Guru Piket -->
@if (Auth::user()->role == "guru")


<div class="container py-4 text-center w-100">

    <style>
        .btn-dark-blue {
            background-color: #0b3d91; /* biru tua */
            color: #fff;
        }
        .btn-dark-blue:hover {
            background-color: #092f6a;
            color: #fff;
        }

        .btn-light-blue {
            background-color: #60a5fa; /* biru muda */
            color: #fff;
        }
        .btn-light-blue:hover {
            background-color: #3b82f6;
            color: #fff;
        }
    </style>

    <div class="d-flex justify-content-between gap-3 mt-4">
        <button type="button" id="bgguru" onclick="guru()" class="btn btn-dark-blue px-4 py-2 rounded">Izin Guru</button>
        <button type="button" id="bgsiswa" onclick="siswa()"class="btn btn-light-blue px-4 py-2 rounded">Izin Siswa</button>
    </div>

</div>

@php
    // Fetch today's absensi/izin
    $today = now()->format('Y-m-d');
    $guruIzinList = \App\Models\User::where('role', 'guru')->get();
@endphp

<div x-data="izinGuruComponent()" id="izinguru" class="flex gap-12 max-w-6xl mx-auto mt-6">

    <!-- LEFT COLUMN: Form Pengajuan Izin -->
    <div class="flex-1 bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Pengajuan Izin Guru</h1>

        <!-- Search Bar -->
        <input type="text" x-model="searchQuery" placeholder="Cari Guru berdasarkan Nama..."
               class="mb-6 w-full border rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">

        <!-- List of Guru -->
        <template x-if="filteredList.length > 0">
            <template x-for="guru in filteredList" :key="guru.id">
                <div class="max-w-md bg-white rounded-xl shadow p-5 border border-gray-100 mb-4">
                    <form :action="`{{ route('guru.izin.store') }}`" method="POST" class="space-y-3">
                        @csrf

                        <!-- Hidden Fields -->
                        <input type="hidden" name="name" :value="guru.name">
                        <input type="hidden" name="identity" :value="guru.identity">
                        <input type="hidden" name="email" :value="guru.email">
                        <input type="hidden" name="role" :value="guru.role">
                        <input type="hidden" name="tanggal_tugas" value="{{ now()->translatedFormat('l') }}">

                        <!-- Info Ringkas -->
                        <div class="text-sm text-gray-700 space-y-0.5">
                            <p><span class="font-medium">Nama:</span> <span x-text="guru.name"></span></p>
                            <p><span class="font-medium">NIP:</span> <span x-text="guru.identity"></span></p>
                            <p><span class="font-medium">Email:</span> <span x-text="guru.email"></span></p>
                        </div>

                        <!-- Mata Pelajaran -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                            <textarea name="mata_pelajaran" rows="3"
                                      class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none"
                                      placeholder="Tuliskan Mata pelajaran saat izin..." required></textarea>
                        </div>

                        <!-- Jam Pelajaran -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Pelajaran</label>
                            <input type="number" name="jam_pelajaran"
                                   min="1" max="10"
                                   class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none"
                                   placeholder="Contoh: 1-2, 3-4" required>
                        </div>

                        <!-- Alasan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
                            <textarea name="alasan" rows="3"
                                      class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none"
                                      placeholder="Tuliskan alasan izin..." required></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="flex gap-2">
                            <a href="{{ url()->previous() }}"
                               class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg border text-sm hover:bg-gray-200 transition">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm shadow hover:bg-blue-700 transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </template>
        </template>

        <!-- No Data -->
        <template x-if="filteredList.length === 0">
            <div class="text-gray-600">
                <span x-show="searchQuery.length > 0">Tidak ditemukan guru dengan nama tersebut.</span>
                <span x-show="searchQuery.length === 0">Belum ada guru yang dapat diajukan izin.</span>
            </div>
        </template>
    </div>
</div>


<!-- Alpine Component -->
<script>
function izinGuruComponent() {
    return {
        searchQuery: '',
        izinData: @js($guruIzinList),
        get filteredList() {
            const query = this.searchQuery.toLowerCase();
            return this.izinData.filter(item =>
                item.role === 'guru' &&
                item.name.toLowerCase().includes(query)
            );
        }
    }
}
</script>


@php
    // Fetch all student ABSENCES (leave requests) to pass to Alpine.js
    // Corrected to fetch Absensi records, not general User records.
    $siswaIzinList = \App\Models\User::where('role', 'siswa')->orWhere('role', 'ketua_eskul')->get();
@endphp

<div 
    x-data="{
        izinData: @js($siswaIzinList), // Data dari controller (siswa + ketua_eskul)
        searchQuery: '',
        filteredList: [],
        init() {
            // Tampilkan semua data dengan role siswa atau ketua_eskul saat awal
            this.filteredList = this.izinData.filter(item => 
                item.role === 'siswa' || item.role === 'ketua_eskul'
            );
        },
        searchList() {
            const query = this.searchQuery.toLowerCase();
            
            // Filter by name + role siswa/ketua_eskul
            this.filteredList = this.izinData.filter(item => {
                const nameMatch = item.name && item.name.toLowerCase().includes(query);
                const roleMatch = (item.role === 'siswa' || item.role === 'ketua_eskul');
                
                return roleMatch && nameMatch;
            });
        }
    }" 
    x-transition 
    id="izinsiswa" class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-12"
>
    <!-- LEFT COLUMN: Search Bar and Form Pengajuan Izin Siswa -->
    <div class="flex-1">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Pengajuan Izin Siswa</h1>

        <!-- Search Bar (ON THE LEFT) -->
        <div class="mb-6">
            <x-text-input 
                x-model="searchQuery" 
                x-on:input.debounce.300="searchList" 
                class="block w-full" 
                type="text" 
                placeholder="Cari Siswa berdasarkan Nama..." 
            />
        </div>
        
        <template x-if="filteredList.length > 0">
        @if (count($siswaIzinList) > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach ($siswaIzinList as $izin)
<!-- Card Form Izin Siswa -->
<div class="max-w-md bg-white rounded-xl shadow p-5 border border-gray-100">
    <form action="{{ route('siswa.izin.store') }}" method="POST" class="space-y-3">
        @csrf

        <!-- Hidden Fields -->
        <input type="hidden" name="name" value="{{ old('name', $izin->name ?? '') }}">
        <input type="hidden" name="identity" value="{{ old('identity', $izin->identity ?? '') }}">
        <input type="hidden" name="email" value="{{ old('email', $izin->email ?? '') }}">
        <input type="hidden" name="kelas" value="{{ old('kelas', $izin->kelas ?? '') }}">
        <input type="hidden" name="jurusan" value="{{ old('jurusan', $izin->jurusan ?? '') }}">
        <input type="hidden" name="role" value="{{ old('role', $izin->role ?? '') }}">
        <input type="hidden" name="tanggal_tugas" value="{{ old('tanggal_tugas', $izin->tanggal_tugas ?? '')}}">

        <!-- Info Ringkas -->
        <div class="text-sm text-gray-700 space-y-0.5">
            <p><span class="font-medium"><b>Nama:</b></span> {{ $izin->name ?? '-' }}</p>
            <p><span class="font-medium"><b>NISN:</b></span> {{ $izin->identity ?? '-' }}</p>
            <p><span class="font-medium"><b>Kelas:</b></span> {{ $izin->kelas ?? '-' }}</p>
            <p><span class="font-medium"><b>Jurusan:</b></span> {{ $izin->jurusan ?? '-' }}</p>
        </div>

        <!-- Mata Pelajaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <textarea name="mata_pelajaran" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none"
                      placeholder="Tuliskan Mata pelajaran saat  izin...">{{ old('alasan', $izin->mata_pelajaran ?? '') }}</textarea>
        </div>
        
        <!-- Jam Pelajaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Pelajaran</label>
            <input type="text" name="jam_pelajaran"
                   value="{{ old('jam_pelajaran', $izin->jam_pelajaran ?? '') }}"
                   min="1" max="10"
                   class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none"
                   placeholder="Contoh: 1-2, 3-4">
        </div>

        <!-- Alasan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
            <textarea name="alasan" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none"
                      placeholder="Tuliskan alasan izin...">{{ old('alasan', $izin->alasan ?? '') }}</textarea>
        </div>

        <!-- Tombol -->
        <div class="flex gap-2">
            <a href="{{ url()->previous() }}"
               class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg border text-sm hover:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm shadow hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endforeach
        @else
            <p class="text-gray-600">Belum ada pengajuan izin siswa yang tercatat hari ini.</p>
        @endif
    </template>

                <!-- No data message -->
        <template x-if="filteredList.length === 0">
            <p class="text-gray-600">
                <span x-show="searchQuery.length > 0">Tidak ditemukan pengajuan izin siswa dengan nama tersebut.</span>
                <span x-show="searchQuery.length === 0">Belum ada pengajuan izin siswa yang tercatat hari ini.</span>
            </p>
        </template>
    </div>
        <!-- End Search Bar -->
         
  </div>

@endif

<script>
const izinSiswa = document.getElementById('izinsiswa');
const izinGuru = document.getElementById('izinguru');

const bgguru = document.getElementById('bgguru');
const bgsiswa = document.getElementById('bgsiswa');

// run once DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    izinGuru.style.display = "block";
    izinSiswa.style.display = "none";
});

function guru() {
    bgguru.style.backgroundColor = "#0b3d91"
    izinGuru.style.display = "block";
    bgsiswa.style.backgroundColor = "#60a5fa"
    izinSiswa.style.display = "none";
}

function siswa() {
    bgguru.style.backgroundColor = "#60a5fa"
    izinGuru.style.display = "none";
    bgsiswa.style.backgroundColor = "#0b3d91"
    izinSiswa.style.display = "block";
}
</script>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Ekstrakurikuler</title>
  <style>
    body {
      font-family: "Poppins", Arial, sans-serif;
      background: #f2f6fc;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 90%;
      max-width: 1200px;
      margin: 40px auto;
    }

    .title {
      text-align: center;
      font-size: 30px;
      font-weight: 700;
      color: #1e3a8a;
      margin-bottom: 30px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .flex-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .card {
      background: linear-gradient(135deg, #2563eb, #1e40af);
      color: white;
      border-radius: 14px;
      width: 240px;
      padding: 25px 20px;
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.4);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 6px 14px rgba(37, 99, 235, 0.6);
    }

    .card .name {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .card .desc {
      font-size: 14px;
      opacity: 0.9;
    }
  </style>
</head>
<body>

@if (Auth::user()->role == "admin")
  <!-- Flex Card Container -->
        <center><h1 class="title">Daftar Ekstrakurikuler</h1></center>
    <div class="flex flex-wrap justify-center gap-6">
      @foreach ($eskulList as $eskul)
      <a href="/eskul?cabang={{ $eskul->cabang_eskul }}">
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl shadow-lg w-60 p-5 text-center cursor-pointer hover:scale-105 transition">
          <div class="text-lg font-semibold mb-1">{{ $eskul->cabang_eskul }}</div>
        </div>
      </a>
      <a href="/deleteeskul/{{ $eskul->cabang_eskul }}">HAPUS</a>
      @endforeach
    </div>
</body>
</html>
@endif


{{-- Chart.js Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const siswaCtx = document.getElementById('siswaChart').getContext('2d');
    const guruCtx  = document.getElementById('guruChart').getContext('2d');

    new Chart(siswaCtx, {
        type: 'bar',
        data: {
            labels: ['Total Siswa','Siswa Izin'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $totalSiswa }}, {{ $siswaIzin->count()}}],
                backgroundColor: ['#3b82f6','#93c5fd']
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    new Chart(guruCtx, {
        type: 'bar',
        data: {
            labels: ['Total Guru','Guru Izin'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $totalGuru }}, {{ $guruIzin->count()}}],
                backgroundColor: ['#f59e0b','#fde68a']
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script>
    @endif
            {{-- Siswa --}}
            @if (Auth::user()->role == 'siswa')
            <form action="/logout" method="POST">
    <!-- biasanya di Laravel, Django, atau framework lain perlu CSRF token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <button type="submit">Logout</button>
</form>

                <div id="clock" class="text-4xl font-bold text-center"></div>
                <div id="date" class="text-lg text-center mt-2"></div>

                <div class="text-center mt-5">
                    <img src="{{ Auth::user()->picture == '/storage/profile/profile.jpg' ? Auth::user()->picture : '/storage/' . Auth::user()->picture }}"
                         alt="Profile Photo"
                         class="mb-5 w-32 h-32 rounded-full object-cover border border-gray-300 shadow">
                </div>

                @php
                    $user = Auth::user();
                    $eskuls = [$user->cabang_eskul, $user->cabang_eskul2, $user->cabang_eskul3];
                @endphp

                <div class="flex flex-wrap gap-6 justify-center mt-5">
                    <!-- Eskul diikuti -->
                    <div class="w-80">
                        <h3 class="font-bold mb-2">Eskul yang Kamu Ikuti:</h3>
                        <ul class="list-disc pl-5">
                            @foreach ($eskuls as $eskul)
                                @if ($eskul)
                                    <li class="flex justify-between items-center">
                                        {{ $eskul }}
                                        <form action="{{ route('eskul.hapus', $eskul) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Keluar</button>
                                        </form>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <!-- Semua daftar cabang -->
                    <div class="flex flex-wrap gap-4">
                        @foreach ($cabangList as $cabang)
                            <div onclick="window.location.href='{{ url('/eskul?cabang=' . urlencode($cabang)) }}'"
                                 class="px-4 py-2 rounded-lg shadow bg-white cursor-pointer hover:bg-blue-500 hover:text-white">
                                {{ $cabang }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

                @if (Auth::user()->role == "ketua_eskul" && $check_absent_siswa)
                <div class="flex-1">
                    <bold><h1 style="font-size: 1cm;">Hallo Ketua Eskul {{ Auth::user()->cabang_eskul }}</h1></bold>
                </div>
                @endif
        </div>


<!-- Tambahkan Daftar Eskul oleh Kesiswaan -->
<div x-show="showForm === 'lihatcabangEskul'" class="p-4">

<div x-data="{
    search: '',
    results: [],
    eskulData: @js($eskulList),
    searchEskul() {
        const query = this.search.toLowerCase();
        if (!query) {
            this.results = [];
            return;
        }

        // Filter eskul berdasarkan nama (max 3 hasil)
        this.results = this.eskulData
            .filter(item => item.cabang_eskul.toLowerCase().includes(query))
            .slice(0, 3);
    }
}">

<h1 class="text-2xl font-bold mb-6 text-gray-800">Update Jadwal Eskul</h1>
{{-- Input Pencarian --}}
    <div class="mb-6">
        <x-input-label for="search" :value="__('Cari Eskul')" />
        <x-text-input id="search" class="block mt-1 w-full"
            type="text" x-model="search" x-on:input.debounce.300ms="searchEskul()"
            placeholder="Ketik nama cabang eskul..." autocomplete="off" />
    </div>

    {{-- Hasil Pencarian --}}
    <template x-if="results.length > 0">
        <div>
            <template x-for="eskul in results" :key="eskul.id">
                <div class="bg-white shadow p-4 rounded-lg mb-4 border border-gray-200">
                    <form method="POST" :action="`/updateeskul/${eskul.id}`">
                        @csrf
                        {{-- kalau mau RESTful, bisa pakai @method('PUT') --}}
                        {{-- @method('PUT') --}}

                        {{-- Cabang Eskul --}}
                        <div class="mb-3">
                            <x-input-label :value="__('Cabang Eskul')" />
                            <x-text-input class="block w-full mt-1" type="text"
                                name="cabang_eskul" x-model="eskul.cabang_eskul" required />
                        </div>

                        {{-- Hari --}}
                        <div class="mb-3">
                            <x-input-label :value="__('Hari')" />
                            <select name="hari" x-model="eskul.hari"
                                class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Hari</option>
                                <template x-for="hari in ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']">
                                    <option :value="hari.toLowerCase()" x-text="hari"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Waktu --}}
                        <div class="mb-3">
                            <x-text-input type="time" name="waktu" required />
                        </div>

                        {{-- Tempat --}}
                        <div class="mb-4">
                            <x-input-label :value="__('Tempat')" />
                            <x-text-input class="block w-full mt-1" type="text"
                                name="tempat" x-model="eskul.tempat" required />
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex justify-end">
                            <x-primary-button>Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </template>
        </div>
    </template>

    {{-- Jika tidak ada hasil --}}
    <template x-if="search && results.length === 0">
        <p class="text-gray-500 mt-4">Tidak ada hasil untuk pencarian tersebut.</p>
    </template>
</div>


<div class="flex-1">
    <form method="POST" action="{{ route('addeskul') }}">
        @csrf
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Jadwal Ekstrakurikuler</h1>

        {{-- Cabang Eskul --}}
        <div class="mb-4">
            <x-input-label for="cabang_eskul" :value="__('Cabang Eskul')" />
            <x-text-input id="cabang_eskul" class="block mt-1 w-full" type="text" name="cabang_eskul"
                :value="old('cabang_eskul')" required autofocus autocomplete="off"
                placeholder="Contoh: Basket, Pramuka, Tari" />
            <x-input-error :messages="$errors->get('cabang_eskul')" class="mt-2" />
        </div>

        {{-- Hari --}}
        <div class="mb-4">
            <x-input-label for="hari" :value="__('Hari')" />
            <select id="hari" name="hari" required
                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                <option value="">Pilih Hari</option>
                @php
                    $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                @endphp
                @foreach ($hariList as $hari)
                    <option value="{{ strtolower($hari) }}" {{ old('hari') === strtolower($hari) ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('hari')" class="mt-2" />
        </div>

        {{-- Waktu --}}
        <div class="mb-4">
            <x-input-label for="waktu" :value="__('Waktu')" />
            <x-text-input id="waktu" class="block mt-1 w-full" type="text" name="waktu"
                :value="old('waktu')" required autocomplete="off"
                placeholder="Contoh: 15.00 - 17.00" />
            <x-input-error :messages="$errors->get('waktu')" class="mt-2" />
        </div>

        {{-- Tempat --}}
        <div class="mb-6">
            <x-input-label for="tempat" :value="__('Tempat')" />
            <x-text-input id="tempat" class="block mt-1 w-full" type="text" name="tempat"
                :value="old('tempat')" required autocomplete="off"
                placeholder="Contoh: Lapangan Basket, Aula, Ruang Musik" />
            <x-input-error :messages="$errors->get('tempat')" class="mt-2" />
        </div>
        
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pembina Baru</h1>

            <div class="mb-4">
                <x-input-label for="identity" :value="__('NIP/Nomor Telp')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                    :value="old('NIP/Nomor Telp')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="pembina" selected>Pembina</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-text-input id="password" class="block mt-1 w-full" type="hidden" name="password"
                    required autocomplete="new-password" value="smkn8jakarta" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="hidden" value="smkn8jakarta"                   name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

        @if (Auth::user()->role == "pembina" or Auth::user()->role == "admin")
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pelatih Baru</h1>

            <div class="mb-4">
                <x-input-label for="identity" :value="__('NIP/Nomor Telp')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identitydua"
                    :value="old('NIP/Nomor Telp')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="namedua"
                    :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="emaildua"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="roledua" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="eskul" selected>Pembina</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-text-input id="password" class="block mt-1 w-full" type="hidden" name="passworddua"
                    required autocomplete="new-password" value="smkn8jakarta" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="hidden" value="smkn8jakarta"                   name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
        @endif
    </div>
</div>



<!-- Daftar Siswa -->
<div x-show="showForm === 'lihatSiswa'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-6">
  @if (Auth::user()->role == "admin" or Auth::user()->role == "guru")

<div class="siswa" style="width: 10cm;">

<div 
    x-data="{
        query: '',
        results: [],
        loading: false,

        searchSiswa() {
            if (this.query.trim().length < 2) { 
                this.results = []; 
                this.loading = false;
                return;
            }

            this.loading = true;

            // Panggil API Laravel
            fetch(`{{ route('api.siswa.search') }}?query=${encodeURIComponent(this.query)}`)
                .then(res => res.json())
                .then(data => {
                    // Penting: Pastikan data mencakup semua kolom yang dibutuhkan
                    this.results = data; 
                })
                .catch(err => {
                    console.error('Search error:', err);
                    this.results = [];
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }" 
    
    x-init="$watch('query', () => searchSiswa())"
    class="max-w-4xl mx-auto p-4 bg-gray-50 rounded-lg shadow-xl"
>

    <h3 class="text-xl font-semibold text-indigo-800 mb-3">Pencarian Siswa Aktif 🔎</h3>

    <input 
        type="text"
        x-model.debounce.300ms="query" 
        placeholder="Ketik nama, email, atau NISN siswa..."
        class="border border-gray-300 rounded-xl w-full p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
    >

    <p x-show="loading" class="text-indigo-500 text-sm mt-2 italic">Mencari...</p>

    <div class="mt-4 max-h-[70vh] overflow-y-auto">
        
        <template x-if="query.length >= 2 && !loading && results.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <template x-for="siswa in results" :key="siswa.id">
                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        
                        <div class="text-lg font-semibold text-gray-800" x-text="siswa.name"></div>
                        <div class="text-sm text-gray-600" x-text="`NISN: ${siswa.identity}`"></div>
                        <div class="text-sm text-gray-600" x-text="`Email: ${siswa.email}`"></div>
                        <div class="text-sm text-indigo-700" 
                             x-text="`Kelas/Jurusan: ${siswa.kelas ?? '-'} / ${siswa.jurusan ?? '-'}`">
                        </div>
                        
                        <template x-if="siswa.cabang_eskul">
                            <div class="text-sm text-purple-700" x-text="`Eskul: ${siswa.cabang_eskul}`"></div>
                        </template>

                        {{-- AKSI: TOMBOL EDIT (GET) --}}
                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" :value="siswa.id">
                            <input type="hidden" name="identity" :value="siswa.identity">
                            <input type="hidden" name="name" :value="siswa.name">
                            <input type="hidden" name="email" :value="siswa.email">
                            <input type="hidden" name="role" :value="siswa.role">
                            <input type="hidden" name="kelas" :value="siswa.kelas">
                            <input type="hidden" name="jurusan" :value="siswa.jurusan">
                            <input type="hidden" name="cabang_eskul" :value="siswa.cabang_eskul">
                            
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        {{-- AKSI: TOMBOL DELETE (POST) --}}
                        <form :action="`/siswa/${siswa.identity}`" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus siswa ' + siswa.name + '?');"
                            class="mt-2 inline-block">
                            @csrf 
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>

                    </div>
                </template>
                </div>
        </template>
        
        <template x-if="query.length >= 2 && !loading && results.length === 0">
            <p class="mt-4 text-red-500 italic">
                Tidak ada siswa ditemukan dengan kata kunci "<span x-text="query"></span>".
            </p>
        </template>
        
    </div>
</div>

<div class="top flex-1">
  <div class="card shadow-sm border-0" style="width: 15cm;">
    <div class="card-body">
        <h4 class="fw-bold mb-3 text-primary">📁 Kelola Data Excel</h4>
        <p class="text-muted mb-4">Unduh data .xlsx untuk mengetahui template data pada sistem.</p>

        {{-- Tombol Download --}}
        <div class="mb-3">
            <a href="{{ route('excel.download') }}" class="btn btn-success px-4">
                <i class="bi bi-download me-2"></i> Download Excel
            </a>
        </div>

        <hr>

        {{-- Form Upload --}}
        <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label fw-semibold">📤 Upload File Excel (.xlsx)</label>
                <input type="file" name="file" id="file" accept=".xlsx" class="form-control">
                <div class="form-text text-muted">Pastikan file berformat .xlsx dan sesuai template.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-upload me-2"></i> Upload
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-clockwise me-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="buttom flex justify-content-evenly mt-10" style="width: 20cm;">
    <div class="flex-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Siswa Baru</h1>

            <div class="mb-4">
                <x-input-label for="identity" :value="__('NISN')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                    :value="old('identity')" required autofocus autocomplete="identity" />
                <x-input-error :messages="$errors->get('identity')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="kelas" :value="__('Kelas')" />
                <small>menggunakan romawi seperti: X, XI, XII</small>
                <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas"
                    :value="old('kelas')" required autocomplete="kelas" />
                <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="jurusan" :value="__('Jurusan')" />
                <x-text-input id="jurusan" class="block mt-1 w-full" type="text" name="jurusan"
                    :value="old('jurusan')" required autocomplete="jurusan" />
                <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
            </div>

            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="siswa" selected>Siswa</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-text-input id="password" class="block mt-1 w-full" type="hidden" name="password"
                    required autocomplete="new-password" value="smkn8jakarta" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="hidden" value="smkn8jakarta"                   name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Siswa</h2>

        @php
            $siswaList = \App\Models\User::where('role', 'siswa')->get();
        @endphp

        @if ($siswaList->count())
            <div class="grid grid-cols-1 gap-6">
                @foreach ($siswaList as $siswa)
                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        <div class="text-lg font-semibold text-gray-800">{{ $siswa->name }}</div>
                        <div class="text-sm text-gray-600">NISN: {{ $siswa->identity }}</div>
                        <div class="text-sm text-gray-600">Email: {{ $siswa->email }}</div>
                        <div class="text-sm text-indigo-700">
                            Kelas/Jurusan: {{ $siswa->kelas ?? '-' }}/{{ $siswa->jurusan ?? '-' }}
                        </div>
                        {{-- Assuming cabang_eskul is optional for a student --}}
                        @if ($siswa->cabang_eskul)
                            <div class="text-sm text-purple-700">
                                Eskul: {{ $siswa->cabang_eskul }}
                            </div>
                        @endif

                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" value="{{ $siswa->id }}">
                            <input type="hidden" name="identity" value="{{ $siswa->identity }}">
                            <input type="hidden" name="name" value="{{ $siswa->name }}">
                            <input type="hidden" name="email" value="{{ $siswa->email }}">
                            <input type="hidden" name="role" value="{{ $siswa->role }}">
                            <input type="hidden" name="kelas" value="{{ $siswa->kelas }}">
                            <input type="hidden" name="jurusan" value="{{ $siswa->jurusan }}">
                            <input type="hidden" name="cabang_eskul" value="{{ $siswa->cabang_eskul }}">
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        <form action="{{ route('siswa.destroy', $siswa->identity) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus siswa ini?');"
                            class="mt-2 inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada siswa yang terdaftar.</p>
        @endif
    </div>
@endif
  </div>
</div>
</div>










            <!-- Daftar Guru dalam Bentuk Card -->
<div x-show="showForm === 'lihatGuru'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-6">
  @if (Auth::user()->role == "admin")

<div class="siswa" style="width: 10cm;">

<div 
    x-data="{
        query: '',
        results: [],
        loading: false,

        searchSiswa() {
            if (this.query.trim().length < 2) { 
                this.results = []; 
                this.loading = false;
                return;
            }

            this.loading = true;

            // Panggil API Laravel
            fetch(`{{ route('api.guru.search') }}?query=${encodeURIComponent(this.query)}`)
                .then(res => res.json())
                .then(data => {
                    // Penting: Pastikan data mencakup semua kolom yang dibutuhkan
                    this.results = data; 
                })
                .catch(err => {
                    console.error('Search error:', err);
                    this.results = [];
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }" 
    
    x-init="$watch('query', () => searchSiswa())"
    class="max-w-4xl mx-auto p-4 bg-gray-50 rounded-lg shadow-xl"
>

    <h3 class="text-xl font-semibold text-indigo-800 mb-3">Pencarian Guru Aktif 🔎</h3>

    <input 
        type="text"
        x-model.debounce.300ms="query" 
        placeholder="Ketik nama, email, atau NISN siswa..."
        class="border border-gray-300 rounded-xl w-full p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
    >

    <p x-show="loading" class="text-indigo-500 text-sm mt-2 italic">Mencari...</p>

    <div class="mt-4 max-h-[70vh] overflow-y-auto">
        
        <template x-if="query.length >= 2 && !loading && results.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <template x-for="guru in results" :key="siswa.id">
                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        
                        <div class="text-lg font-semibold text-gray-800" x-text="guru.name"></div>
                        <div class="text-sm text-gray-600" x-text="`NIP: ${guru.identity}`"></div>
                        <div class="text-sm text-gray-600" x-text="`Email: ${guru.email}`"></div>
                        <template x-if="guru.tanggal_tugas">
                            <div class="text-sm text-purple-700" x-text="`Eskul: ${guru.tanggal_tugas}`"></div>
                        </template>

                        {{-- AKSI: TOMBOL EDIT (GET) --}}
                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" :value="siswa.id">
                            <input type="hidden" name="identity" :value="siswa.identity">
                            <input type="hidden" name="name" :value="siswa.name">
                            <input type="hidden" name="email" :value="siswa.email">
                            <input type="hidden" name="role" :value="siswa.role">
                            <input type="hidden" name="kelas" :value="siswa.kelas">
                            <input type="hidden" name="jurusan" :value="siswa.jurusan">
                            <input type="hidden" name="cabang_eskul" :value="siswa.cabang_eskul">
                            
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        {{-- AKSI: TOMBOL DELETE (POST) --}}
                        <form :action="`/siswa/${siswa.identity}`" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus siswa ' + siswa.name + '?');"
                            class="mt-2 inline-block">
                            @csrf 
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>

                    </div>
                </template>
                </div>
        </template>
        
        <template x-if="query.length >= 2 && !loading && results.length === 0">
            <p class="mt-4 text-red-500 italic">
                Tidak ada siswa ditemukan dengan kata kunci "<span x-text="query"></span>".
            </p>
        </template>
        
    </div>
</div>


<div class="top flex-1">
  <div class="card shadow-sm border-0" style="width: 15cm;">
    <div class="card-body">
        <h4 class="fw-bold mb-3 text-primary">📁 Kelola Data Excel</h4>
        <p class="text-muted mb-4">Unduh data .xlsx untuk mengetahui template data pada sistem.</p>

        {{-- Tombol Download --}}
        <div class="mb-3">
            <a href="{{ route('excel.download') }}" class="btn btn-success px-4">
                <i class="bi bi-download me-2"></i> Download Excel
            </a>
        </div>

        <hr>

        {{-- Form Upload --}}
        <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label fw-semibold">📤 Upload File Excel (.xlsx)</label>
                <input type="file" name="file" id="file" accept=".xlsx" class="form-control">
                <div class="form-text text-muted">Pastikan file berformat .xlsx dan sesuai template.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-upload me-2"></i> Upload
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-clockwise me-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="buttom flex justify-content-evenly mt-10" style="width: 20cm;">
    <div class="flex-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Guru Baru</h1>

            <div class="mb-4">
                <x-input-label for="identity" :value="__('NIP')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                    :value="old('identity')" required autofocus autocomplete="identity" />
                <x-input-error :messages="$errors->get('identity')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

      @php $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat']; @endphp
      <div id="tanggal-tugas-guru-wrapper">
        <label for="tanggal_tugas" class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Tugas</label>
        <select id="tanggal_tugas" name="tanggal_tugas"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
          <option value="">Pilih Hari</option>
          @foreach ($days as $day)
            <option value="{{ $day }}">
              {{ ucfirst($day) }}
            </option>
          @endforeach
        </select>
      </div>

            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="siswa" selected>Siswa</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-text-input id="password" class="block mt-1 w-full" type="hidden" name="password"
                    required autocomplete="new-password" value="smkn8jakarta" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="hidden" value="smkn8jakarta"                   name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Guru</h2>

        @php
            $guruList = \App\Models\User::where('role', 'guru')->get();
        @endphp

        @if ($guruList->count())
            <div class="grid grid-cols-1 gap-6">
                @foreach ($guruList as $guru)
                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        <div class="text-lg font-semibold text-gray-800">{{ $guru->name }}</div>
                        <div class="text-sm text-gray-600">NIP: {{ $guru->identity }}</div>
                        <div class="text-sm text-gray-600">Email: {{ $guru->email }}</div>
                        <div class="text-sm text-indigo-700">
                            Tanggal tugas: {{ $guru->tanggal_tugas ?? '-' }} 
                        </div>

                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" value="{{ $guru->id }}">
                            <input type="hidden" name="identity" value="{{ $guru->identity }}">
                            <input type="hidden" name="name" value="{{ $guru->name }}">
                            <input type="hidden" name="email" value="{{ $guru->email }}">
                            <input type="hidden" name="role" value="{{ $guru->role }}">
                            <input type="hidden" name="tanggal_tugas" value="{{ $guru->tanggal_tugas }}">
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        <form action="{{ route('guru.destroy', $guru->identity) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus siswa ini?');"
                            class="mt-2 inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada siswa yang terdaftar.</p>
        @endif
    </div>
@endif
  </div>
</div>
</div>

            <!-- Daftar Pembina dalam Bentuk Card -->
@if (Auth::user()->role == "admin")
<div x-show="showForm === 'lihatPembina'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-6">

    <div class="flex-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pembina Baru</h1>

            <div class="mb-4">
                <x-input-label for="identity" :value="__('NIP/Nomor Telp')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                    :value="old('NIP/Nomor Telp')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
               <x-input-label for="role" :value="__('Cabang Eskul')" />
               <select id="role" name="cabang_eskul" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                  <option value="">-- Pilih Cabang Eskul --</option>
                     @foreach ($cabangList as $eskul)
                         <option value="{{ $eskul->cabang_eskul }}">{{ $eskul->cabang_eskul }}</option>
                     @endforeach
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="pembina" selected>Pembina</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-text-input id="password" class="block mt-1 w-full" type="hidden" name="password"
                    required autocomplete="new-password" value="smkn8jakarta" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="hidden" value="smkn8jakarta"                   name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Pembina</h2>

        @php
            $pembinas = \App\Models\User::where('role', 'pembina')->get();
        @endphp

        @if ($pembinas->count())
            <div class="grid grid-cols-1 gap-6">
                @foreach ($pembinas as $pembina)
                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        <div class="text-lg font-semibold text-gray-800">{{ $pembina->name }}</div>
                        <div class="text-sm text-gray-600">{{ $pembina->email }}</div>

                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" value="{{ $pembina->id }}">
                            <input type="hidden" name="identity" value="{{ $pembina->identity }}">
                            <input type="hidden" name="name" value="{{ $pembina->name }}">
                            <input type="hidden" name="identity" value="{{ $pembina->identity}}">
                            <input type="hidden" name="email" value="{{ $pembina->email }}">
                            <input type="hidden" name="role" value="{{ $pembina->role }}">
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        <form action="{{ route('pembina.destroy', $pembina->email) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus pembina ini?');"
                              class="mt-2 inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada pembina yang terdaftar.</p>
        @endif
    </div>
</div>
@endif


@if(session('notification'))
    @php
        $type = session('notification')['type'];
        $message = session('notification')['message'];
    @endphp

    <div id="notification-card" class="notification-card {{ $type }}">
        {{ $message }}
        <button id="close-notif" class="close-btn">&times;</button>
    </div>

    <style>
        .notification-card {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 250px;
            z-index: 9999;
            animation: slideIn 0.5s ease forwards;
        }

        .notification-card.success {
            background-color: #28a745; /* green */
        }

        .notification-card.error {
            background-color: #dc3545; /* red */
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            margin-left: 15px;
        }

        @keyframes slideIn {
            from {opacity: 0; transform: translateX(100%);}
            to {opacity: 1; transform: translateX(0);}
        }

        @keyframes slideOut {
            from {opacity: 1; transform: translateX(0);}
            to {opacity: 0; transform: translateX(100%);}
        }
    </style>
    <script>
        document.getElementById('close-notif').addEventListener('click', function() {
            const notif = document.getElementById('notification-card');
            notif.style.animation = 'slideOut 0.5s forwards';
            setTimeout(() => notif.remove(), 500);
        });

        // Auto-hide notification after 5 seconds
        setTimeout(() => {
            const notif = document.getElementById('notification-card');
            if(notif) {
                notif.style.animation = 'slideOut 0.5s forwards';
                setTimeout(() => notif.remove(), 500);
            }
        }, 5000);
    </script>
@endif


@if (Auth::user()->role == 'pembina')
<div x-show="showForm === 'lihatKetuaEskul'"
     x-data="{
        searchQueryketuaeskul: '',
        siswaList: @js($siswaList ?? []),
        filteredList: @js($siswaList ?? []),
        searchList() {
            const q = this.searchQueryketuaeskul.trim().toLowerCase();
            this.filteredList = q
                ? this.siswaList.filter(s => (s.name || '').toLowerCase().includes(q))
                : this.siswaList;
        }
     }"
     x-transition
     class="bg-white p-6 rounded-xl shadow max-w-6xl flex gap-6">

  <!-- Kolom kiri: Penunjukan -->
  <div class="flex-1">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Penunjukan Ketua Eskul</h1>

    <!-- Search Bar -->
    <div class="mb-6">
      <x-text-input
        x-model="searchQueryketuaeskul"
        x-on:input.debounce.300="searchList"
        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        type="text"
        placeholder="Cari siswa berdasarkan nama..."
      />
    </div>

    <!-- Daftar Siswa (client-side rendered oleh Alpine) -->
    <template x-if="filteredList.length > 0">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="siswa in filteredList" :key="siswa.id">
          <div class="bg-white rounded-xl shadow-md border p-5">
            <p class="font-semibold text-gray-800" x-text="siswa.name"></p>
            <p class="text-sm text-gray-600">NISN: <span x-text="siswa.identity"></span></p>
            <p class="text-sm text-gray-600">Kelas: <span x-text="siswa.kelas"></span></p>
            <p class="text-sm text-gray-600">Jurusan: <span x-text="siswa.jurusan"></span></p>

            <!-- Form (server route) — gunakan Alpine binding untuk value -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4 mt-3">
              @csrf

              <!-- Hidden fields di-bind dari objek siswa -->
              <input type="hidden" name="name" :value="siswa.name">
              <input type="hidden" name="identity" :value="siswa.identity">
              <input type="hidden" name="email" :value="siswa.email">
              <input type="hidden" name="kelas" :value="siswa.kelas">
              <input type="hidden" name="jurusan" :value="siswa.jurusan">
              <input type="hidden" name="role" value="ketua_eskul">

              <!-- Pilih Cabang Eskul (options di-render server-side) -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cabang Eskul</label>
                <select name="cabang_eskul" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                  <option value="{{ Auth::user()->cabang_eskul }}">{{ Auth::user()->cabang_eskul }}</option>
                </select>
              </div>

              <!-- Submit -->
              <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700">
                  Jadikan Ketua
                </button>
              </div>
            </form>
          </div>
        </template>
      </div>
    </template>

    <!-- Pesan tidak ada hasil -->
    <template x-if="filteredList.length === 0">
      <p class="text-gray-600 italic text-center">
        <span x-show="searchQueryketuaeskul.length > 0">Tidak ditemukan siswa dengan nama tersebut.</span>
        <span x-show="searchQueryketuaeskul.length === 0">Ketik nama siswa untuk mencari data.</span>
      </p>
    </template>
  </div>

<!-- Daftar Ketua Eskul -->
<div class="flex-1">
    <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Ketua Eskul</h2>
    @php
        $ketuaEskulList = \App\Models\User::where('role', 'ketua_eskul')->get();
    @endphp

    @if ($ketuaEskulList->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($ketuaEskulList as $ketua)
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5 hover:shadow-lg transition">
                    <div class="space-y-1 text-sm text-gray-700">
                        <p class="font-bold text-lg text-gray-800">{{ $ketua->name }}</p>
                        <p><span class="font-semibold">NISN:</span> {{ $ketua->identity }}</p>
                        <p><span class="font-semibold">Kelas:</span> {{ $ketua->kelas }} / {{ $ketua->jurusan }}</p>
                        <p><span class="font-semibold">Eskul:</span> {{ $ketua->cabang_eskul }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 flex gap-2">
                        <!-- Delete ke ketuaeskul.destroy -->
                        <form action="{{ route('ketuaeskul.destroy', $ketua->identity) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus Ketua Eskul ini?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Belum ada Ketua Eskul yang terdaftar.</p>
    @endif
</div>
    </div>
@endif
    <!-- Daftar Pelatih Eskul -->
<div x-show="showForm === 'lihatEskul'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-6">

    <!-- Form Tambah Pelatih -->
    <div class="flex-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            @php
              $pelatihs = \App\Models\User::where('role', 'eskul')->get();
            @endphp

            @if ($pelatihs->count())
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Pelatih</h1>

            @foreach ($pelatihs as $pelatih)
            <!-- Identity -->

            <div class="mb-4 hidden">
                <x-input-label for="identity" :value="__('NIP/Nomor Telp')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identityold"
                    value="{{ $pelatih->identity }}" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="identity" :value="__('NIP/Nomor Telp')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                    value="{{ $pelatih->identity }}" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Full Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    value="{{ $pelatih->name }}" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    value="{{ $pelatih->email }}" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="eskul" selected>Pelatih Eskul</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Cabang Eskul -->
            <div class="mb-4">
                <x-input-label for="cabang_eskul" :value="__('Cabang Eskul')" />
                <select id="cabang_eskul" name="cabang_eskul"
                    class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
                    <option value="{{ Auth::user()->cabang_eskul }}">{{ Auth::user()->cabang_eskul }}</option>
                </select>
                <x-input-error :messages="$errors->get('cabang_eskul')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-text-input id="password" class="block mt-1 w-full" type="hidden" name="password"
                    required autocomplete="new-password" value="smkn8jakarta" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="hidden" value="smkn8jakarta"                   name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="flex items-center" style="display: flex; justify-content: space-around;">
                <x-primary-button>
                    {{ __('Edit') }}
                </x-primary-button>
            </div>
        </form>
                <a href="/pelatih/{{ $pelatih->identity }}"><x-primary-button>
                    {{ __('Delete') }}
                </x-primary-button></a>
    </div>
  @endforeach
            @else

            @if (Auth::user()->role == "admin" or Auth::user()->role == "pembina")
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pelatih</h1>

            <!-- Identity -->
            <div class="mb-4">
                <x-input-label for="identity" :value="__('NIP/Nomor Telp')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                    :value="old('NIP/Nomor Telp')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Full Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="eskul" selected>Pelatih Eskul</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Cabang Eskul -->
            <div class="mb-4">
                <x-input-label for="cabang_eskul" :value="__('Cabang Eskul')" />
                <select id="cabang_eskul" name="cabang_eskul"
                    class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
                    <option value="{{ Auth::user()->cabang_eskul }}">{{ Auth::user()->cabang_eskul }}</option>
                </select>
                <x-input-error :messages="$errors->get('cabang_eskul')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-text-input id="password" class="block mt-1 w-full" type="hidden" name="password"
                    required autocomplete="new-password" value="smkn8jakarta" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="hidden" value="smkn8jakarta"                   name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
        @endif
    </div>
    
@endif



  <!-- Halaman untuk Pelatih Eskul -->

    {{-- Form Tambah Materi Eskul --}}
    <div x-show="showForm === 'TambahkanMateri'" class="mt-6">
        @if (Auth::user()->role == "eskul" or Auth::user()->role == "pembina")
        <form action="{{ route('events.store') }}" method="POST" class="space-y-4 bg-white shadow rounded-lg p-6">
            @csrf
            <div>
                <label class="block font-medium">Judul Materi</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
            </div>

            <input type="text" class="hidden" name="cabang_eskul" value="{{ Auth::user()->cabang_eskul }}"></input>

            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                <button type="button" @click="showForm = ''" class="px-4 py-2 border rounded">Batal</button>
            </div>
        </form>
    @endif
    </div>
</div>

</div>
        </main>
</div>
    
</body>
</html>