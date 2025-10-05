<!DOCTYPE html>
<html lang="id">
<head>
  <link rel="icon" href="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" type="image/png"/>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-100 via-white to-sky-200 flex items-center justify-center px-4">

  <div class="bg-white shadow-2xl rounded-2xl w-full max-w-2xl p-8 space-y-6">
    <h1 class="text-3xl font-semibold text-gray-800 text-center">Edit Pengguna: 
      <span class="text-blue-600">{{ request()->query('name') }}</span>
    </h1>

    <!-- Notifikasi Error -->
    @if ($errors->any())
      <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg border border-red-300">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Form Edit -->
    <form method="POST" action="{{ route('user.update', request()->query('identity')) }}" class="space-y-4">
      @csrf
      @method('PUT')

     <!-- Identity -->
      <div>
        <label for="name" class="block text-sm font-semibold text-gray-600 mb-1">NIS/NIP</label>
        <small>Diperlukan untuk Guru dan Siswa</small>
        <input type="text" id="name" name="identity"
          value="{{ old('identity', request()->query('identity')) }}"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
          required autofocus>
      </div>

      <!-- Nama -->
      <div>
        <label for="name" class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
        <input type="text" id="name" name="name"
          value="{{ old('name', request()->query('name')) }}"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
          required autofocus>
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
        <input type="email" id="email" name="email"
          value="{{ old('email', request()->query('email')) }}"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
          required>
      </div>

      <!-- Role -->
      @php $role = old('role', request()->query('role')); @endphp
      <div>
        <label for="role" class="block text-sm font-semibold text-gray-600 mb-1">Role</label>
        <select id="role" name="role"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
          onchange="toggleFields(this.value)" required>
          <option value="">Pilih Role</option>
          @if (Auth::user()->role == "admin")
            <option value="guru" {{ $role == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="pembina" {{ $role == 'pembina' ? 'selected' : '' }}>Pembina</option>
            <option value="siswa" {{ $role == 'siswa' ? 'selected' : '' }}>Siswa</option>
          @elseif (Auth::user()->role == "pembina")
            <option value="ketua_eskul" {{ $role == 'ketua_eskul' ? 'selected' : '' }}>Ketua Eskul</option>
            <option value="eskul" {{ $role == 'eskul' ? 'selected' : '' }}>Pelatih Ekstrakurikuler</option>
          @endif
        </select>
      </div>

      <!-- Cabang Eskul -->
      @php
        $cabangList = ['Futsal', 'Basket', 'Pramuka', 'Paskibra', 'IT', 'Paskibraka', 'Jepang', 'Korea'];
        $selectedCabang = old('cabang_eskul', request()->query('cabang_eskul'));
      @endphp
      <div id="cabang-eskul-wrapper" style="display: {{ $role === 'eskul' ? 'block' : 'none' }}">
        <label for="cabang_eskul" class="block text-sm font-semibold text-gray-600 mb-1">Cabang Eskul</label>
        <select id="cabang_eskul" name="cabang_eskul"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-400">
          <option value="">Pilih Cabang</option>
          @foreach ($cabangList as $cabang)
            <option value="{{ $cabang }}" {{ $selectedCabang === $cabang ? 'selected' : '' }}>
              {{ $cabang }}
            </option>
          @endforeach
        </select>
      </div>

<!-- Tanggal Tugas (khusus Guru) -->
@php
  $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
  $selectedDay = old('tanggal_tugas', request()->query('tanggal_tugas'));
@endphp
<div id="tanggal-tugas-wrapper" style="display: {{ $role === 'guru' ? 'block' : 'none' }}">
  <label for="tanggal_tugas" class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Tugas</label>
  <select id="tanggal_tugas" name="tanggal_tugas"
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
    <option value="">Pilih Hari</option>
    @foreach ($days as $day)
      <option value="{{ $day }}" {{ $selectedDay === $day ? 'selected' : '' }}>
        {{ ucfirst($day) }}
      </option>
    @endforeach
  </select>
</div>


      <!-- Tombol -->
      <div class="flex justify-between items-center pt-4">
        <a href="/dashboard"
          class="text-sm px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-700">
          ← Kembali
        </a>
        <button type="submit"
          class="text-sm px-5 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>

  <script>
    function toggleFields(role) {
      document.getElementById('cabang-eskul-wrapper').style.display = role === 'eskul' ? 'block' : 'none';
      document.getElementById('tanggal-tugas-wrapper').style.display = role === 'guru' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', () => {
      toggleFields(document.getElementById('role').value);
    });
  </script>
</body>
</html>
