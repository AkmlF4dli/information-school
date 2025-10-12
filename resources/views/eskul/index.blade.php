<link rel="icon" href="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" type="image/png"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<title>Eskul {{ $cabang }}</title>
<div class="container mt-4">
<?php
use \App\Models\Eskul;
use \App\Models\User;
?>

    <!-- Tombol ke menu utama -->
    <div class="mb-3">
        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
            ← Kembali ke Menu Utama
        </a>
    </div>

@if(Auth::user()->role != "kesiswaan" and Auth::user()->role != "admin")
@php
$user = Auth::user();
$eskuls = [
    $user->cabang_eskul,
    $user->cabang_eskul2,
    $user->cabang_eskul3,
];
@endphp

@if(in_array($cabang, $eskuls))
    <center><h1>Eskul {{ $cabang }}</h1></center>

    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        @foreach ($events as $event)
           @if ($cabang == $event->cabang_eskul)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text text-muted">
                            {{ Str::limit($event->deskripsi, 100) }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <div>Cabang: {{ $event->cabang_eskul }}</div>
                            <div>Upload by: {{ $event->upload_by }}</div>
                            <div>Upload at: {{ $event->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <!-- Tombol View More -->
                        <a href="{{ route('events.more', ['cabang_eskul' => $event->cabang_eskul, 'title' => $event->title]) }}" class="btn btn-sm btn-outline-primary">
                            View More
                        </a>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@else
<form action="{{ route('eskul.daftar', $cabang) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success">
        Daftar Eskul {{ $cabang }}
    </button>
</form>
@endif
@else
<?php
$currentCabang = request('cabang');

// Ambil jadwal dari tabel Eskul
$jadwalList = Eskul::where('cabang_eskul', $currentCabang)->get();

// Ambil pelatih dan ketua dari tabel User
$pelatihList = User::where('role', 'eskul')
                    ->where('cabang_eskul', $currentCabang)
                    ->get();

$ketuaList = User::where('role', 'ketua_eskul')
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
    <div class="dashboard-title">Dashboard {{ request("cabang") }}</div>

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
      
      <!-- Pelatih -->
      <div class="section-container">
        <div class="section-title">Pelatih Eskul</div>
        <div class="grid">
          @forelse ($pelatihList as $pelatih)
            <div class="card" @click="showForm = 'pelatih{{ $pelatih->id }}'">
              <div class="name">{{ $pelatih->name }}</div>
              <div class="role">Pelatih</div>
              <div class="cabang">Cabang: {{ $pelatih->cabang_eskul }}</div>
            </div>
          @empty
            <div class="empty">Belum ada pelatih di cabang ini.</div>
          @endforelse
        </div>
      </div>

      <!-- Ketua -->
      <div class="section-container">
        <div class="section-title">Ketua Eskul</div>
        <div class="grid">
          @forelse ($ketuaList as $ketua)
            <div class="card" @click="showForm = 'ketua{{ $ketua->id }}'">
              <div class="name">{{ $ketua->name }}</div>
              <div class="role">Ketua Eskul</div>
              <div class="cabang">Cabang: {{ $ketua->cabang_eskul }}</div>
            </div>
          @empty
            <div class="empty">Belum ada ketua di cabang ini.</div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>
@endif