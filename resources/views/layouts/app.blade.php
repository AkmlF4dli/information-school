<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKUL 8 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="public/favicon.ico" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ86dGNB8Co/8Gtr89M0v+3wGoJ4DNYo3/dJ8S/D3n/6F6T/5+FqVl288gG/8Lw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html, body {
        max-width: 100%;
        /* overflow-x: hidden; */
        }
        
        body { font-family: 'Roboto', sans-serif; }
        
        .navtop-color { background-color: #1d4ed8; }
        .mainav-color { background-color: #ffffff }
        .hero-overlay { background-color: rgba(0, 0, 0, 0.4); }

        /* Hero Parallax Placeholder Styles */
        .parallax-hero {
            position: relative;
            height: 70vh;
            background-image: url('https://placehold.co/1920x800/2563eb/ffffff?text=SMKN+8+Jakarta+Building+Image');
            background-size: cover;
            background-position: center;
        }

        /* Mobile Menu Toggle Animation */
        #mobile-menu .bar {
            display: block;
            height: 3px;
            width: 100%;
            background-color: #1d4ed8;
            margin-bottom: 5px;
            border-radius: 9999px;
            transition: all 0.3s ease-in-out;
        }
        #mobile-menu.open .bar:nth-child(1) { transform: translateY(8px) rotate(45deg); }
        #mobile-menu.open .bar:nth-child(2) { opacity: 0; }
        #mobile-menu.open .bar:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }

        /* Pencarian */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999;
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-white text-gray-800">
    <!-- Navtop -->
    <div class="navtop-color hidden lg:block">
        <nav class="max-w-7xl mx-auto px-4 py-2">
            <ul class="flex justify-end space-x-6 text-sm text-white">
                <li>
                    <a href="#" class="hover:text-gray-200 transition flex items-center">
                        <i class="fa-solid fa-map-marker-alt mr-2"></i>
                        Jl. Pejaten Raya, Kompleks Depdikbud, Pejaten Barat, Jakarta Selatan 12510
                    </a>
                </li>
                <li>
                    <a href="tel:(021) 7996493" class="hover:text-gray-200 transition flex items-center">
                        <i class="fa-solid fa-phone mr-2"></i>
                        (021) 7996493
                    </a>
                </li>
                <li>
                    <a href="mailto:info@smkn8jakarta.sch.id" class="hover:text-gray-200 transition flex items-center">
                        <i class="fa-solid fa-envelope mr-2"></i>
                        info@smkn8jakarta.sch.id
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    
    <!-- Navbar Utama -->
    <nav class="mainav-color text-blue-700 shadow-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <a class="flex items-center space-x-3 transition duration-300">
                    <img src="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" 
                            alt="Logo SMKN 8 Jakarta" class="h-12 w-auto rounded-full shadow-lg">
                    <span class="text-xl md:text-2xl font-bold text-blue-800">Siskul 8 Jakarta</span>
                </a>
                
                <!-- Menu Desktop -->
                <div class="hidden lg:flex items-center space-x-6">
                    <ul class="flex items-center space-x-6">
                        <li><a class="text-blue-700 hover:text-blue-600 transition font-medium" href="/"><i class="fa-solid fa-home mr-1"></i>Beranda</a></li>
                        <li><a class="text-blue-700 hover:text-blue-600 transition font-medium" href="/about/#visi"><i class="fa-solid fa-star mr-1"></i>Visi dan Misi</a></li>
                        <li><a class="text-blue-700 hover:text-blue-600 transition font-medium" href="/about"><i class="fa-solid fa-user-group mr-1"></i>Tentang</a></li>
                    </ul>
                    <div class="flex items-center space-x-3">
                        <a href="/login" class="bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg hover:bg-blue-600 transition duration-150 shadow-md">
                            Login
                        </a>
                    </div>
                </div>

                <!-- Menu Mobile -->
                <div class="lg:hidden flex items-center">
                    <button class="menu-toggle flex flex-col justify-center items-center w-6 h-6" id="mobile-menu">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </button>
                </div>

            </div>
        </div>
        
        <!-- Isi Menu Mobile -->
        <div class="lg:hidden hidden bg-white shadow-lg pb-4" id="mobile-menu-content">
            <a class="block px-6 py-2 text-blue-700 hover:bg-gray-100 transition" href="/"><i class="fa-solid fa-home mr-2"></i>Beranda</a>
            <a class="block px-6 py-2 text-blue-700 hover:bg-gray-100 transition" href="/about/#visi"><i class="fa-solid fa-star mr-2"></i>Visi dan Misi</a>
            <a class="block px-6 py-2 text-blue-700 hover:bg-gray-100 transition" href="/about"><i class="fa-solid fa-user-group mr-2"></i>Tentang</a>
            <a id="openSearchBtnMobile" class="block bg-blue-700 text-white font-semibold mx-4 mt-2 py-2 text-center rounded-lg hover:bg-blue-600 transition duration-150">
                <i class="fa-solid fa-search"></i> Cari
            </a>
            <a href="/login" class="block bg-blue-700 text-white font-semibold mx-4 mt-2 py-2 text-center rounded-lg hover:bg-blue-600 transition duration-150">
                Login
            </a>
        </div>
    </nav>

    <!-- Isi Halaman -->
    <main>
        @yield('content')
    </main>

<!-- Footer -->
<footer class="bg-white text-blue-700 shadow-xl mt-12">
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-10">
        
        <div class="space-y-2">
            <h3 class="font-bold text-xl mb-3 text-blue-800">SMKN 8 Jakarta</h3>
            <p class="text-sm text-blue-700">Jl. Pejaten Raya, Kompleks Depdikbud, RT.07/RW.06, Pejaten Barat, Jakarta Selatan 12510</p>
            <p class="text-sm text-blue-700">Telp: (021) 7996493</p>
            <p class="text-sm text-blue-700">Email: smkn8jakarta@gmail.com</p>
        </div>

        <div class="space-y-2">
            <h3 class="font-bold text-xl mb-3 text-blue-800">Website Lainnya</h3>
            <ul>
                <li><a href="https://smkdki.id/" class="hover:underline text-blue-700 hover:text-blue-800 transition">SMK DKI Jakarta</a></li>
                <li><a href="https://smkn8jakarta.sch.id/" class="hover:underline text-blue-700 hover:text-blue-800 transition">SMK Negeri 8 Jakarta</a></li>
                <li><a href="https://perpusdepan.online/" class="hover:underline text-blue-700 hover:text-blue-800 transition">Perpus Depan</a></li>
                <li><a href="https://belajar.kemdikbud.go.id/" class="hover:underline text-blue-700 hover:text-blue-800 transition">Rumah Belajar</a></li>
            </ul>
        </div>
        
        <div class="space-y-2">
            <h3 class="font-bold text-xl mb-3 text-blue-800">Sosial Media</h3>
            <div class="flex space-x-6">
                <a href="https://www.facebook.com/smkn8jktofficial" target="_blank" title="Facebook">
                    <i class="fa-brands fa-facebook-f text-3xl hover:text-blue-600 transition"></i>
                </a>
                <a href="https://www.instagram.com/delapanjkt" target="_blank" title="Instagram">
                    <i class="fa-brands fa-instagram text-3xl hover:text-pink-500 transition"></i>
                </a>
                <a href="https://x.com/smkn8jkt" target="_blank" title="X (Formerly Twitter)">
                    <i class="fa-brands fa-x-twitter text-3xl hover:text-gray-800 transition"></i>
                </a>
                <a href="https://www.youtube.com/@Smkn8jkt" target="_blank" title="Youtube">
                    <i class="fa-brands fa-youtube text-3xl hover:text-red-600 transition"></i>
                </a>
                <a href="https://wa.me/6285717281174" target="_blank" title="WhatsApp">
                    <i class="fa-brands fa-whatsapp text-3xl hover:text-green-500 transition"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-700 text-center py-3 text-sm text-white">
        © 2025 SISKUL 8 JAKARTA - All rights reserved.
    </div>
</footer>

<!-- Bagian Pencarian -->
<div id="search_popup" class="modal-overlay hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-8 shadow-2xl w-full max-w-lg relative transform transition-all duration-300 ease-in-out scale-100">
        
        <button id="closeSearchBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-900 transition focus:outline-none">
            <i class="fa-solid fa-times text-2xl"></i>
        </button>
        
        <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Cari Sesuatu</h2>
        
        <form class="flex space-x-2" action="/search" method="GET">
            
            <input 
                type="text" 
                placeholder="Search" 
                aria-label="search" 
                name="query" 
                class="w-full px-5 py-3 border-2 border-gray-300 rounded-full focus:ring-2 focus:outline-none focus:ring-blue-700 focus:border-blue-700 transition duration-150 text-gray-700 placeholder-gray-400" 
                required>
            
            <button 
                class="flex items-center justify-center bg-blue-700 text-white py-2 px-4 rounded-full hover:bg-blue-600 transition duration-150 shadow-md flex-shrink-0" 
                type="submit"
                title="Cari">
                <i class="fa-solid fa-search text-xl"></i>
            </button>
        </form>
    </div>
</div>

<script>
    // 1. Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu');
    const mobileMenuContent = document.getElementById('mobile-menu-content');
    
    if (mobileMenuButton && mobileMenuContent) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenuButton.classList.toggle('open');
            mobileMenuContent.classList.toggle('hidden');
        });
    }

    // 2. Search Modal Logic
    const searchPopup = document.getElementById('search_popup');
    // Ambil SEMUA tombol yang membuka modal
    const openButtons = [
        document.getElementById('openSearchBtnDesktop'),
        document.getElementById('openSearchBtnMobile')
    ].filter(btn => btn !== null);

    const closeButton = document.getElementById('closeSearchBtn');

    // Fungsi untuk menampilkan modal
    function openModal() {
        searchPopup.classList.remove('hidden');
        document.addEventListener('keydown', handleEscKey);
    }

    // Fungsi untuk menyembunyikan modal
    function closeModal() {
        searchPopup.classList.add('hidden');
        document.removeEventListener('keydown', handleEscKey);
    }

    // Handler untuk tombol ESC
    function handleEscKey(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    }

    // Terapkan event listener pada SEMUA tombol pembuka
    openButtons.forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    // Event listener pada tombol tutup (X)
    closeButton.addEventListener('click', closeModal);

    // Event listener untuk menutup modal jika mengklik di luar area modal
    searchPopup.addEventListener('click', (event) => {
        if (event.target === searchPopup) {
            closeModal();
        }
    });
</script>

</body>
</html>