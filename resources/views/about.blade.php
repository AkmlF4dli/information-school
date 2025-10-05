@extends('layouts.app')

@section('title', 'Tentang - SISKUL 8')

@section('content')
<!-- Team -->
  <section id="team" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
      <h3 class="text-3xl font-bold text-blue-600 mb-10">Team</h3>
      <div class="grid grid-cols-2 md:grid-cols-6 gap-8">
        <div class="flex flex-col items-center">
          <img src="/storage/team/akmal.jpg" class="mb-5 w-40 h-40 rounded-full object-cover border border-gray-300 shadow" alt="Team Member 1">
          <p class="font-semibold">Muhammad Akmal Fadli</p>
          <small>Backend Programmer</small>
        </div>
        <div class="flex flex-col items-center">
          <img src="/storage/team/azra.jpg" class="mb-5 w-40 h-40 rounded-full object-cover border border-gray-300 shadow" alt="Team Member 2">
          <p class="font-semibold">Azmar Syifa Azra</p>
          <small>UI/UX</small>
        </div>
        <div class="flex flex-col items-center">
          <img src="/storage/team/azzam.jpg" class="mb-5 w-40 h-40 rounded-full object-cover border border-gray-300 shadow" alt="Team Member 3">
          <p class="font-semibold">Rizki Khoirul Azzam</p>
          <small>UI/UX</small>
        </div>
        <div class="flex flex-col items-center">
          <img src="/storage/team/omar.jpg" class="mb-5 w-40 h-40 rounded-full object-cover border border-gray-300 shadow" alt="Team Member 4">
          <p class="font-semibold">Moeamar Hamzah Omar Ollie</p>
          <small>UI/UX</small>
        </div>
        <div class="flex flex-col items-center">
          <img src="/storage/team/gagah.jpg" class="mb-5 w-40 h-40 rounded-full object-cover border border-gray-300 shadow" alt="Team Member 5">
          <p class="font-semibold">Wisanggeni Gagah Ramadhan</p>
          <small>Frontend Programmer</small>
        </div>
        <div class="flex flex-col items-center">
          <img src="/storage/team/yazid.jpg" class="mb-5 w-40 h-40 rounded-full object-cover border border-gray-300 shadow" alt="Team Member 6">
          <p class="font-semibold">Yazid Alfa</p>
          <small>Data Analis</small>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Informasi App -->
  <section id="informasi" class="py-16 bg-white">
    <div class="container mx-auto px-4 text-center">
      <h3 class="text-3xl font-bold text-blue-600 mb-6">Informasi App</h3>
      <p class="max-w-2xl mx-auto text-gray-700">
        Aplikasi ini dibangun menggunakan <span class="font-semibold">Laravel</span> sebagai backend utama 
        dan menerapkan metode <span class="font-semibold">Waterfall</span> dalam pengembangannya. 
        Metode ini memastikan setiap tahap dari perencanaan, desain, implementasi, hingga pengujian dilakukan secara runtut dan sistematis.
      </p>
    </div>
  </section>

    <!-- Visi & Misi -->
  <section id="visi" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
      <h3 class="text-3xl font-bold text-blue-600 mb-6">Visi & Misi</h3>
      <p class="max-w-2xl mx-auto text-gray-700">
        Visi aplikasi ini adalah menghadirkan sistem absensi yang efisien, transparan, dan mudah digunakan.  
        Misi kami adalah mendigitalisasi proses absensi agar lebih cepat, akurat, dan dapat diakses kapan saja.  
        Dengan demikian, guru, siswa, dan sekolah dapat lebih fokus pada kegiatan belajar mengajar tanpa terbebani urusan administrasi manual.
      </p>
    </div>
  </section>

  <!-- Moto -->
  <section id="moto" class="py-16 bg-white">
    <div class="container mx-auto px-4 text-center">
      <h3 class="text-3xl font-bold text-blue-600 mb-6">Moto</h3>
      <p class="max-w-xl mx-auto text-gray-700 italic">"Menyajikan aplikasi absensi yang tersentralisasi pada digital."</p>
    </div>
  </section>

@endsection