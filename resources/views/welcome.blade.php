@extends('layouts.app')

@section('title', 'Beranda - SISKUL 8')

@section('content')

<style>
    /* ---------------------------------------------------- */
    /* Kustomisasi SVG Devider */
    /* ---------------------------------------------------- */
    .devider svg {
        display: block;
    }
    .devider.atas svg path {
        /* Warna untuk mengisi gelombang (di bawah garis) - Dari bawah ke atas */
        fill: #ffffff; /* Berasal dari section Kejuaraan atau Ekstra */
    }
    .devider.bawah svg path {
        /* Warna untuk mengisi gelombang (di bawah garis) - Dari atas ke bawah */
        fill: #f3f4f6; /* Sama dengan bg-gray-100 */
    }
    .devider.bawah.reverse svg path {
        /* Warna untuk mengisi gelombang saat dibalik */
        fill: #ffffff; /* Berasal dari section Berita */
        transform: rotate(180deg);
        transform-origin: 50% 50%;
    }

    /* Kustomisasi untuk devider Ekstra ke Berita */
    .devider.atas .berita-bg path {
        fill: #f3f4f6; /* bg-gray-100 */
    }

    /* Kustomisasi Ilustrasi Berita */
    .berita .image img {
        max-width: 100%;
        height: auto;
    }
    
    /* Tambahan untuk ikon pada Info 4 Panel */
    .fa-soccer-ball:before {
        content: "\f1e3"; /* Mengganti ikon fa-regular fa-soccer-ball jika tidak tersedia */
    }
    .fa-pencil-square:before {
        content: "\f044"; /* Mengganti ikon fas fa-pencil-square jika tidak tersedia */
    }

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f7f9fc;
    }
    /* Custom style untuk menangani transisi display: none/block */
    .post-card.hidden-post {
        display: none !important;
    }
</style>

<section class="relative w-full h-screen overflow-hidden">
    <div class="relative w-full h-full">
        <img 
            id="carouselImage" 
            src="/storage/slide/slide1.png" 
            class="absolute inset-0 w-full h-full object-cover" 
            alt="Carousel Image">
        <div class="absolute inset-0 flex flex-col justify-center items-center bg-black/40 text-center text-white px-4">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow">Selamat Datang di Website Siskul Delapan</h2>
            <p class="text-lg md:text-xl max-w-2xl mx-auto drop-shadow">Temukan informasi terbaru seputar kegiatan eskul, absensi guru maupun absensi siswa SMKN 8 Jakarta.</p>
        </div>
        {{-- Tombol navigasi tetap di-comment, menggunakan JS di bawah --}}
        {{-- <button onclick="changeSlide(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-3 py-2 rounded-full shadow hover:bg-blue-800 z-10">←</button>
        <button onclick="changeSlide(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-3 py-2 rounded-full shadow hover:bg-blue-800 z-10">→</button> --}}
    </div>
</section>

<section class="py-10 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
            
            <a href="/juara" class="p-4 sm:p-6 text-center bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 mx-auto mb-2 flex items-center justify-center text-blue-500 text-2xl">
                    <i class="fas fa-trophy text-3xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Kejuaraan</span>
            </a>
            
            <a href="/eskul" class="p-4 sm:p-6 text-center bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 mx-auto mb-2 flex items-center justify-center text-blue-500 text-2xl">
                    {{-- Menggunakan class standar jika font-awesome di-load --}}
                    <i class="fas fa-futbol text-3xl"></i> 
                    {{-- <i class="fa-regular fa-soccer-ball text-3xl"></i> --}}
                </div>
                <span class="text-sm font-semibold text-gray-700">Ekstrakurikuler</span>
            </a>
            
            <a href="/berita" class="p-4 sm:p-6 text-center bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 mx-auto mb-2 flex items-center justify-center text-blue-500 text-2xl">
                    <i class="fa-solid fa-newspaper text-3xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Berita</span>
            </a>
            
            <a href="/agenda" class="p-4 sm:p-6 text-center bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="w-12 h-12 mx-auto mb-2 flex items-center justify-center text-blue-500 text-2xl">
                    <i class="fas fa-calendar-alt text-3xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Agenda</span>
            </a>
        </div>
    </div>
</section>
<section id="contact" class="min-h-screen bg-gray-50 flex items-center justify-center p-8" 
    style="background-image: url('URL_BACKGROUND_SKETCH'); background-size: cover;">
    <div class="max-w-6xl w-full bg-white shadow-xl rounded-lg p-12 lg:p-16 border border-gray-200">
        <div class="lg:flex lg:space-x-12">

            {{-- Kiri: Form Kontak --}}
            <div class="lg:w-1/2 mb-10 lg:mb-0">
                <h3 class="text-3xl font-semibold mb-8 text-blue-600">Contact</h3>
                
                <form id='kritiksaran' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    
                    <div class="flex flex-col sm:flex-row space-y-6 sm:space-y-0 sm:space-x-4 mb-6">
                        <div class="relative w-full sm:w-1/2">
                            <input class="w-full border-b-2 focus:border-blue-500 outline-none p-2 pt-6 peer transition-colors" 
                                id="name_form" name="nama_kritiksaran" required="" type="text" placeholder=" " />
                            <label for="name_form" class="absolute left-2 top-0 text-sm text-gray-600 transition-all peer-placeholder-shown:text-lg peer-placeholder-shown:top-3 peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-500">Name</label>
                        </div>
                        <div class="relative w-full sm:w-1/2">
                            <input class="w-full border-b-2 focus:border-blue-500 outline-none p-2 pt-6 peer transition-colors" 
                                id="email_form" name="email_kritiksaran" required="" type="email" placeholder=" " />
                            <label for="email_form" class="absolute left-2 top-0 text-sm text-gray-600 transition-all peer-placeholder-shown:text-lg peer-placeholder-shown:top-3 peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-500">E-mail</label>
                        </div>
                    </div>
                    
                    <div class="relative mb-6">
                        <textarea class="w-full border-b-2 focus:border-blue-500 outline-none p-2 pt-6 peer resize-none transition-colors" 
                                name="pesan_kritiksaran" id="pesan_form" rows="4" required="" type="text" placeholder=" "></textarea>
                        <label for="pesan_form" class="absolute left-2 top-0 text-sm text-gray-600 transition-all peer-placeholder-shown:text-lg peer-placeholder-shown:top-3 peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-500">Pesan</label>
                        <span class="absolute bottom-2 right-2 text-gray-400"></span> 
                    </div>

                    <span class="text-sm text-gray-500 italic mb-6 block">
                        *Anda tidak perlu login untuk mengisi kritik dan saran
                    </span>

                    <div class="flex items-center">
                        <button class="bg-white border-2 border-blue-500 text-blue-500 font-bold py-2 px-8 rounded-full hover:bg-blue-500 hover:text-white transition duration-300 shadow-md" 
                                type="submit" id="submit">Kirim</button>
                    </div>
                </form>
            </div>

            {{-- Kanan: Info Sekolah dan Map --}}
            <div class="lg:w-1/2">
                <h3 class="text-3xl font-semibold mb-4 text-blue-600">SMK Negeri 8 Jakarta</h3>
                
                <div class="space-y-3 mb-6 text-gray-700">
                    <p class="flex items-start">
                        <i class="fa-solid fa-location-dot text-blue-500 mr-3 mt-1"></i>
                        <span>Jl. Pejaten Raya, Kompleks Depdikbud, RT.07/RW.06, Pejaten Barat, Jakarta Selatan</span>
                    </p>
                    <p class="flex items-center">
                        <i class="fa fa-phone text-blue-500 mr-3"></i>
                        (021) 7996493
                    </p>
                    <p class="flex items-center">
                        <i class="fa fa-envelope text-blue-500 mr-3"></i>
                        info@smkn8jakarta.sch.id 
                    </p>
                </div>
                
                <div class="w-full h-80 rounded-lg overflow-hidden shadow-lg border border-gray-300">
                    <iframe loading="lazy" title="SMK Negeri 8 Jakarta Map" 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8915139996384!2d106.83406321419409!3d-6.277991363200373!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f23e0287b8e1%3A0x2a98e9f790322749!2sSekolah%20Menengah%20Kejuruan%20Negeri%208%20Jakarta!5e0!3m2!1sid!2sid!4v1576403584132!5m2!1sid!2sid" 
                        width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const images = [
        "/storage/slide/slide1.png",
        "/storage/slide/slide2.png",
        "/storage/slide/slide3.png"
    ];
    let currentIndex = 0;
    const carouselImage = document.getElementById('carouselImage');

    function changeSlide(direction) {
      currentIndex = (currentIndex + direction + images.length) % images.length;
      carouselImage.src = images[currentIndex];
    }

    // Auto-play setiap 5 detik
    setInterval(() => {
      changeSlide(1);
    }, 5000);

    // Fungsi toggleMenu yang mungkin digunakan untuk navigasi mobile
    function toggleMenu() {
      const mobileMenu = document.getElementById('mobileMenu');
      mobileMenu.classList.toggle('hidden');
    }


            // --- DATA POSTINGAN DUMMY ---
        const allPosts = [
            { id: 1, title: "Pembukaan Pendaftaran Beasiswa Akademik 2024", category: "akademik", tag: "Akademik", tagColor: "blue", image: "https://placehold.co/400x300/60a5fa/ffffff?text=Beasiswa" },
            { id: 2, title: "Laporan Kegiatan Ekstrakurikuler Pramuka", category: "ekstrakurikuler", tag: "Ekstrakurikuler", tagColor: "yellow", image: "https://placehold.co/400x300/fcd34d/4a4a4a?text=Pramuka" },
            { id: 3, title: "Wawancara Eksklusif dengan Guru Terbaik Tahun Ini", category: "jurnalistik", tag: "Jurnalistik", tagColor: "green", image: "https://placehold.co/400x300/34d399/ffffff?text=Wawancara" },
            { id: 4, title: "Siswa Kami Meraih Medali Emas Olimpiade Sains Nasional", category: "prestasi", tag: "Prestasi", tagColor: "red", image: "https://placehold.co/400x300/f87171/ffffff?text=Olimpiade" },
            { id: 5, title: "PENGUMUMAN: Libur Hari Raya Idul Adha 1446 H", category: "pengumuman", tag: "Pengumuman", tagColor: "indigo", image: "https://placehold.co/400x300/818cf8/ffffff?text=Libur" },
            { id: 6, title: "Seminar Kurikulum Merdeka untuk Orang Tua Murid", category: "akademik", tag: "Akademik", tagColor: "blue", image: "https://placehold.co/400x300/60a5fa/ffffff?text=Kurikulum" },
            { id: 7, title: "Galeri Foto: Lomba Basket Antar Kelas", category: "ekstrakurikuler", tag: "Ekstrakurikuler", tagColor: "yellow", image: "https://placehold.co/400x300/fcd34d/4a4a4a?text=Basket" },
            { id: 8, title: "Mengulas Pentingnya Bahasa Inggris di Era Digital", category: "jurnalistik", tag: "Jurnalistik", tagColor: "green", image: "https://placehold.co/400x300/34d399/ffffff?text=Artikel" },
            { id: 9, title: "Tim Debat Sekolah Juara 1 Tingkat Provinsi!", category: "prestasi", tag: "Prestasi", tagColor: "red", image: "https://placehold.co/400x300/f87171/ffffff?text=Debat" },
            { id: 10, title: "Revisi Jadwal Ujian Tengah Semester Ganjil", category: "pengumuman", tag: "Pengumuman", tagColor: "indigo", image: "https://placehold.co/400x300/818cf8/ffffff?text=Jadwal+Ujian" },
            // Menambahkan lebih banyak postingan Jurnalistik agar lebih sesuai dengan hitungan 30
            { id: 11, title: "Liputan Hari Guru Nasional 2024", category: "jurnalistik", tag: "Jurnalistik", tagColor: "green", image: "https://placehold.co/400x300/34d399/ffffff?text=Hari+Guru" },
            { id: 12, title: "Persiapan Lomba Karya Ilmiah Remaja", category: "akademik", tag: "Akademik", tagColor: "blue", image: "https://placehold.co/400x300/60a5fa/ffffff?text=Karya+Ilmiah" },
            { id: 13, title: "Latihan Rutin Tim Voli Putri", category: "ekstrakurikuler", tag: "Ekstrakurikuler", tagColor: "yellow", image: "https://placehold.co/400x300/fcd34d/4a4a4a?text=Voli" },
            { id: 14, title: "Berita Terbaru Dari Redaksi Majalah Dinding", category: "jurnalistik", tag: "Jurnalistik", tagColor: "green", image: "https://placehold.co/400x300/34d399/ffffff?text=Majalah+Dinding" },
            { id: 15, title: "Pemenang Lomba Desain Grafis Sekolah", category: "prestasi", tag: "Prestasi", tagColor: "red", image: "https://placehold.co/400x300/f87171/ffffff?text=Desain+Grafis" },
        ];
        
        // Konstanta untuk manajemen pagination
        const POSTS_PER_PAGE = 6;
        let currentPage = 1;
        let currentCategory = 'semua';
        let filteredPosts = [];

        // --- REFERENSI DOM ---
        const postContainer = document.getElementById('post-container');
        const categoryLinks = document.querySelectorAll('.category-link');
        const loadMoreBtn = document.getElementById('load-more-btn');
        const errorAlert = document.getElementById('error-alert');
        const noMorePostsText = document.getElementById('no-more-posts');

        // --- FUNGSI UTAMA ---

        /**
         * Mengubah data postingan menjadi string HTML (kartu postingan).
         * @param {Object} post - Objek postingan.
         * @returns {string} String HTML kartu postingan.
         */
        function createPostCardHTML(post) {
            // Mapping warna untuk tag
            const colorClasses = {
                'blue': 'bg-blue-100 text-blue-700',
                'yellow': 'bg-yellow-100 text-yellow-700',
                'green': 'bg-green-100 text-green-700',
                'red': 'bg-red-100 text-red-700',
                'indigo': 'bg-indigo-100 text-indigo-700',
            };
            
            const tagClass = colorClasses[post.tagColor] || 'bg-gray-100 text-gray-700';

            return `
                <div class="post-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1" data-category="${post.category}">
                    <img src="${post.image}" alt="${post.title}" onerror="this.onerror=null; this.src='https://placehold.co/400x300/cccccc/4a4a4a?text=Image+Error'" class="w-full h-48 object-cover">
                    <div class="p-5">
                        <span class="inline-block ${tagClass} text-xs font-semibold px-3 py-1 rounded-full mb-3">
                            <i class="fas fa-tag mr-1"></i> ${post.tag}
                        </span>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">${post.title}</h3>
                        <a href="#" class="text-blue-500 hover:text-blue-700 text-sm font-medium transition duration-150">Baca Selengkapnya &rarr;</a>
                    </div>
                </div>
            `;
        }

        /**
         * Menggambar atau menambahkan postingan ke kontainer.
         * @param {boolean} append - Jika true, postingan ditambahkan (untuk 'Lebih Banyak'). Jika false, kontainer di-reset.
         */
        function renderPosts(append = false) {
            const startIndex = append ? currentPage * POSTS_PER_PAGE : 0;
            const endIndex = Math.min(filteredPosts.length, (currentPage + 1) * POSTS_PER_PAGE);
            
            const postsToRender = filteredPosts.slice(startIndex, endIndex);
            const newPostHTML = postsToRender.map(createPostCardHTML).join('');

            if (append) {
                postContainer.insertAdjacentHTML('beforeend', newPostHTML);
            } else {
                postContainer.innerHTML = newPostHTML;
                // Jika tidak ada postingan, tampilkan pesan
                if (filteredPosts.length === 0) {
                     postContainer.innerHTML = `
                        <div class="md:col-span-3 text-center p-8 bg-gray-100 rounded-xl shadow-inner">
                            <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
                            <p class="text-lg text-gray-600">Mohon maaf, belum ada postingan di kategori **${currentCategory.charAt(0).toUpperCase() + currentCategory.slice(1)}** saat ini.</p>
                        </div>
                    `;
                }
            }
            
            // Perbarui status tombol "Lebih Banyak"
            updateLoadMoreButton(endIndex < filteredPosts.length);
        }

        /**
         * Mengatur logika pemfilteran, pagination, dan rendering.
         * @param {string} category - Kategori yang dipilih.
         */
        function filterAndRender(category) {
            currentCategory = category;
            currentPage = 0; // Reset ke halaman pertama

            if (category === 'semua') {
                filteredPosts = allPosts;
            } else {
                filteredPosts = allPosts.filter(post => post.category === category);
            }

            renderPosts(false); // Render ulang kontainer (bukan append)
            updateCategoryLinkCounts(category); // Opsional: Perbarui hitungan jika data dinamis
        }

        /**
         * Memperbarui tampilan tombol 'Lebih Banyak' (hidden/visible).
         * @param {boolean} hasMore - True jika masih ada postingan yang belum ditampilkan.
         */
        function updateLoadMoreButton(hasMore) {
            if (hasMore) {
                loadMoreBtn.classList.remove('hidden');
                noMorePostsText.classList.add('hidden');
            } else {
                loadMoreBtn.classList.add('hidden');
                // Tampilkan pesan "Semua postingan sudah ditampilkan" hanya jika ada postingan
                if (filteredPosts.length > 0) {
                    noMorePostsText.classList.remove('hidden');
                } else {
                    noMorePostsText.classList.add('hidden');
                }
            }
        }

        /**
         * Mengatur gaya tombol yang aktif.
         * @param {HTMLElement} clickedLink - Elemen tautan yang baru saja diklik.
         */
        function setActiveButton(clickedLink) {
            categoryLinks.forEach(link => {
                // Non-aktifkan semua
                link.classList.remove('bg-blue-500', 'text-white', 'shadow-md');
                link.classList.add('bg-gray-200', 'text-gray-700');
            });

            // Aktifkan yang diklik
            clickedLink.classList.remove('bg-gray-200', 'text-gray-700');
            clickedLink.classList.add('bg-blue-500', 'text-white', 'shadow-md');
        }

        // --- EVENT LISTENERS ---

        // 1. Listener untuk Tombol Kategori
        categoryLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); 
                
                const category = link.getAttribute('data-category');
                
                // 1. Atur gaya visual
                setActiveButton(link);
                
                // 2. Filter data dan render ulang
                filterAndRender(category);
            });
        });

        // 2. Listener untuk Tombol 'Lebih Banyak'
        loadMoreBtn.addEventListener('click', () => {
            // Simulasikan penundaan loading (misalnya, dari API)
            loadMoreBtn.innerHTML = '<span class="text-lg"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat...</span>';
            loadMoreBtn.disabled = true;

            setTimeout(() => {
                currentPage++;
                renderPosts(true); // Tambahkan postingan (append)
                loadMoreBtn.innerHTML = '<span class="text-lg">Lebih Banyak</span>';
                loadMoreBtn.disabled = false;
                
                // Gulirkan ke postingan baru (opsional)
                const newPosts = postContainer.querySelectorAll('.post-card');
                if (newPosts.length > POSTS_PER_PAGE) {
                    newPosts[newPosts.length - postsToRender.length].scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

            }, 800); // Penundaan 800ms
        });

        // 3. Fungsi untuk menjaga hitungan di tombol tetap akurat (jika data dinamis)
        function updateCategoryLinkCounts(activeCategory) {
            // Ini bersifat opsional karena hitungan di HTML Anda sudah statis (Semua (89), Akademik (15), dll.)
            // Namun, jika Anda menggunakan data dinamis (allPosts), Anda dapat mengaktifkan ini:
            /*
            const counts = allPosts.reduce((acc, post) => {
                acc[post.category] = (acc[post.category] || 0) + 1;
                acc['semua'] = (acc['semua'] || 0) + 1;
                return acc;
            }, {});

            categoryLinks.forEach(link => {
                const category = link.getAttribute('data-category');
                const count = counts[category] || 0;
                const originalText = link.textContent.replace(/\s\(\d+\)$/, ''); // Hapus hitungan lama
                link.textContent = `${originalText} (${count})`;
            });
            */
        }


        // --- INISIALISASI ---
        document.addEventListener('DOMContentLoaded', () => {
            // Atur kategori 'semua' sebagai default aktif
            const defaultLink = document.querySelector('[data-category="semua"]');
            if (defaultLink) {
                setActiveButton(defaultLink);
                filterAndRender('semua');
            }
        });
</script>

@endsection