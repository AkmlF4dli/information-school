<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SMKN 8 Jakarta</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">
  <!-- Navbar -->
  <nav class="bg-blue-700 text-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <a href="/">
        <img src="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" alt="Logo SMKN 8 Jakarta" class="w-10 h-10">
        </a>
        <div class="text-2xl font-bold">SMKN 8 Jakarta</div>
      </div>
      <div class="md:hidden">
        <button onclick="toggleMenu()" class="text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
      <ul id="navMenu" class="hidden md:flex space-x-6 text-sm font-medium">
        <li><a href="/about" class="hover:text-blue-200">About</a></li>
        <li><a href="/profile" class="hover:text-blue-200">Profil Sekolah</a></li>
        <li><a href="/prestasi" class="hover:text-blue-200">Prestasi</a></li>
        <li><a href="#eskul" class="hover:text-blue-200">Eskul</a></li>
        <li><a href="#absensi" class="hover:text-blue-200">Absensi</a></li>
      </ul>
    </div>
    <div id="mobileMenu" class="md:hidden hidden px-4 pb-4 absolute bg-blue-700 w-full left-0 top-full">
      <ul class="space-y-2 text-sm font-medium">
        <li><a href="/about" class="block py-1 text-white hover:text-blue-200">About</a></li>
        <li><a href="/profile" class="block py-1 text-white hover:text-blue-200">Profil Sekolah</a></li>
        <li><a href="/prestasi" class="block py-1 text-white hover:text-blue-200">Prestasi</a></li>
        <li><a href="#eskul" class="block py-1 text-white hover:text-blue-200">Eskul</a></li>
        <li><a href="#absensi" class="block py-1 text-white hover:text-blue-200">Absensi</a></li>
      </ul>
    </div>
  </nav>

  <!-- Image Carousel Section with Hero Text -->
  <section class="relative overflow-hidden">
    <div class="relative w-full h-64 md:h-[450px]">
      <img id="carouselImage" src="https://source.unsplash.com/1200x400/?school,classroom" class="w-full h-full object-cover rounded-b-2xl shadow-md" alt="Carousel Image">
      <div class="absolute inset-0 flex flex-col justify-center items-center bg-black/40 text-center text-white px-4">
        <h2 class="text-4xl font-extrabold mb-4 drop-shadow">Selamat Datang di Website Resmi Sekolah</h2>
        <p class="text-lg max-w-2xl mx-auto drop-shadow">Temukan informasi terbaru seputar kegiatan, fasilitas, dan prestasi siswa SMKN 8 Jakarta.</p>
        <button class="mt-6 px-6 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition shadow">Daftar Sekarang</button>
      </div>
      <button onclick="changeSlide(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-3 py-2 rounded-full shadow hover:bg-blue-800 z-10">&#8592;</button>
      <button onclick="changeSlide(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-3 py-2 rounded-full shadow hover:bg-blue-800 z-10">&#8594;</button>
    </div>
  </section>

  <!-- News Section -->
  <section id="events" class="py-16 bg-white">
    <div class="container mx-auto px-4">
      <h3 class="text-3xl font-bold text-center text-blue-800 mb-10">Berita Sekolah</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-pink-50 border border-pink-200 rounded-2xl shadow-md p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
          <div class="text-pink-500 text-4xl mb-2">🎭</div>
          <h4 class="text-xl font-semibold text-pink-700">Pentas Seni Tahunan</h4>
          <p class="text-sm text-gray-600">10 Agustus 2025</p>
          <p class="mt-2 text-gray-700">Ajang unjuk bakat siswa di bidang seni musik, tari, dan teater.</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-2xl shadow-md p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
          <div class="text-green-500 text-4xl mb-2">🧠</div>
          <h4 class="text-xl font-semibold text-green-700">Lomba Cerdas Cermat</h4>
          <p class="text-sm text-gray-600">17 Agustus 2025</p>
          <p class="mt-2 text-gray-700">Kompetisi antar kelas dalam bidang akademik untuk memperingati Hari Kemerdekaan.</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl shadow-md p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
          <div class="text-yellow-500 text-4xl mb-2">🎓</div>
          <h4 class="text-xl font-semibold text-yellow-700">Seminar Karier</h4>
          <p class="text-sm text-gray-600">25 Agustus 2025</p>
          <p class="mt-2 text-gray-700">Pembekalan siswa tentang pilihan karier dan pendidikan lanjutan.</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-2xl shadow-md p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
          <div class="text-blue-500 text-4xl mb-2">📚</div>
          <h4 class="text-xl font-semibold text-blue-700">Pelatihan Literasi Digital</h4>
          <p class="text-sm text-gray-600">30 Agustus 2025</p>
          <p class="mt-2 text-gray-700">Siswa dilatih menggunakan teknologi untuk mendukung pembelajaran.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Map Section -->
<section id="lokasi" class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <h3 class="text-3xl font-bold text-center text-blue-800 mb-8">Lokasi SMKN 8 Jakarta</h3>
    <div class="w-full h-96 rounded-2xl overflow-hidden shadow-lg">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8915139996384!2d106.83406321419409!3d-6.277991363200373!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f23e0287b8e1%3A0x2a98e9f790322749!2sSekolah%20Menengah%20Kejuruan%20Negeri%208%20Jakarta!5e0!3m2!1sid!2sid!4v1576403584132!5m2!1sid!2sid"
        width="100%"
        height="100%"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

  <!-- Footer -->
  <footer class="bg-blue-700 py-6 mt-12">
    <div class="container mx-auto px-4 text-center text-white">
      &copy; 2025 SMKN8. All rights reserved.
    </div>
  </footer>

  <!-- Script -->
  <script>
    const images = [
      "/storage/slide/slide1.jpg",
      "/storage/slide/slide2.jpg",
      "/storage/slide/slide3.jpg"
    ];
    let currentIndex = 0;
    const carouselImage = document.getElementById('carouselImage');

    function changeSlide(direction) {
      currentIndex = (currentIndex + direction + images.length) % images.length;
      carouselImage.src = images[currentIndex];
    }

    function toggleMenu() {
      const mobileMenu = document.getElementById('mobileMenu');
      mobileMenu.classList.toggle('hidden');
    }
  </script>
</body>
</html>
