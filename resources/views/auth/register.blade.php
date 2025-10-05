<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKUL 8 - Registrasi Pengguna Baru</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Alpine.js for dynamic form handling -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.10/dist/cdn.min.js"></script>
    <!-- Load Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* Custom Font and Background from Login Style */
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            background-color: #f0f4f8; /* Light blue-grey background */
            background-image: radial-gradient(#d1d5db 1px, transparent 1px);
            background-size: 20px 20px;
        }

        /* Card Shadow & Border from Login Style */
        #register-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Custom input and select styles for the dark blue panel */
        .dark-form-input {
            /* Applied to input[type=text/email/password] and select */
            @apply w-full p-3 bg-blue-600 border border-blue-500 text-white rounded-lg placeholder-blue-300 focus:ring-white focus:border-white transition duration-150;
        }
        
        /* Required Label for light text on dark background */
        .required-label-dark:after {
            content: "*";
            color: #fca5a5; /* Red-300 for visibility */
            margin-left: 0.25rem;
        }

        /* Illustration styling (simplified) */
        .illustration-container {
            background-image: linear-gradient(180deg, #ffffff 0%, #f7f7f7 100%);
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-4">

    <!-- Main Registration Card Container -->
    <div id="register-card" 
         x-data="{ 
            selectedRole: 'admin', 
            isPasswordRequired: true,
            needsIdentity: false,
            needsClassMajor: false,
            needsTaskDate: false,
            needsEskul: false,
            
            updateFields(role) {
                // Logic based on controller validation
                this.isPasswordRequired = role !== 'ketua_eskul';
                this.needsIdentity = ['guru', 'siswa', 'ketua_eskul'].includes(role);
                this.needsClassMajor = ['siswa', 'ketua_eskul'].includes(role);
                this.needsTaskDate = role === 'guru';
                this.needsEskul = ['eskul', 'ketua_eskul'].includes(role);
            }
        }" 
        x-init="updateFields(selectedRole)" 
        class="w-full max-w-4xl bg-white rounded-3xl overflow-hidden shadow-2xl m-4 lg:m-8">
        
        <div class="md:grid md:grid-cols-2">

            <!-- Kiri (Left Panel - Branding & Illustration) -->
            <div class="illustration-container p-8 md:p-10 flex flex-col justify-center items-center text-center">
                
                <!-- Logo & School Name -->
                <div class="mb-6">
                    <!-- Placeholder Logo -->
                    <img src="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" 
                        alt="Logo SMK Negeri 8 Jakarta" 
                        class="w-20 h-20 mx-auto rounded-full object-cover border-4 border-white shadow-lg">
                    <h2 class="text-2xl font-extrabold text-gray-800 mt-4">
                        SISKUL 8 Jakarta
                    </h2>
                    <p class="text-gray-500 text-sm">Sistem Informasi Ekstrakurikuler Sekolah</p>
                </div>
                
                <!-- Illustration (Simplified SVG) -->
                <div class="w-2/3 h-auto mb-4">
                    <svg viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="userGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#4c85d8;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2a65ad;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <!-- Group of figures (Registration/Onboarding concept) -->
                        <g transform="translate(50, 50) scale(0.8)">
                            <!-- Main Figure (Admin/Registrar) -->
                            <rect x="250" y="250" width="60" height="70" rx="10" fill="#1f2937" />
                            <circle cx="280" cy="240" r="20" fill="#facc15" />
                            <!-- Desk/Table -->
                            <rect x="150" y="320" width="300" height="40" fill="#9ca3af" />
                            <!-- Computer Screen (Form) -->
                            <rect x="260" y="200" width="100" height="60" rx="5" fill="#e5e7eb" transform="rotate(-10 310 230)" />
                            <!-- User to be registered (Student/Teacher) -->
                            <rect x="150" y="260" width="50" height="60" rx="5" fill="#3b82f6" />
                            <circle cx="175" cy="250" r="15" fill="#facc15" />
                        </g>
                    </svg>
                </div>

                <p class="mt-4 text-gray-500 text-sm px-6">
                    Formulir ini digunakan oleh **Admin** atau **Pembina** untuk mendaftarkan pengguna baru (Guru, Siswa, Pelatih, dll.) ke dalam sistem.
                </p>
            </div>

            <!-- Kanan (Right Panel - Registration Form) -->
            <div class="bg-blue-700 p-8 md:p-12 text-white">
                <h1 class="text-3xl font-extrabold mb-2 text-center">
                    Daftar Pengguna
                </h1>
                <p class="text-white/80 text-center mb-8 text-sm">
                    Lengkapi data wajib (*) untuk peran yang dipilih.
                </p>

                <form method="POST" action="/register" class="space-y-4">
                    <!-- Simulating Laravel's CSRF protection -->
                    <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->

                    <!-- Role Selector (Wajib diisi) -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-white required-label-dark">Role Pengguna</label>
                        <select id="role" name="role" x-model="selectedRole" @change="updateFields(selectedRole)" required 
                                class="dark-form-input appearance-none cursor-pointer">
                            <option value="admin" class="bg-white text-gray-800">Admin (Tidak Wajib Identity)</option>
                            <option value="pembina" class="bg-white text-gray-800">Pembina (Tidak Wajib Identity)</option>
                            <option value="eskul" class="bg-white text-gray-800">Pelatih Ekstrakurikuler (Tidak Wajib Identity)</option>
                            <option value="guru" class="bg-white text-gray-800">Guru (Wajib NIP)</option>
                            <option value="siswa" class="bg-white text-gray-800">Siswa (Wajib NIS)</option>
                            <option value="ketua_eskul" class="bg-white text-gray-800">Ketua Eskul (Wajib NIS)</option>
                        </select>
                    </div>

                    <!-- Conditional Identity Field (NIS/NIP) -->
                    <div x-show="needsIdentity" x-transition.duration.300ms>
                        <label for="identity" class="block text-sm font-medium text-white required-label-dark" 
                               x-text="selectedRole === 'guru' ? 'NIP/NIK' : 'NIS/NISN'"></label>
                        <input id="identity" 
                               class="dark-form-input"
                               type="text" 
                               name="identity" 
                               :required="needsIdentity"
                               placeholder="Masukkan NIS atau NIP">
                    </div>
                    
                    <!-- Nama (Wajib diisi) -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-white required-label-dark">Nama Lengkap</label>
                        <input id="name" 
                               class="dark-form-input" 
                               type="text" 
                               name="name" 
                               required 
                               placeholder="Nama Lengkap Pengguna">
                    </div>

                    <!-- Email (Wajib diisi) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white required-label-dark">Email</label>
                        <input id="email" 
                               class="dark-form-input" 
                               type="email" 
                               name="email" 
                               required 
                               placeholder="contoh@sekolah.id">
                    </div>

                    <!-- Conditional Kelas & Jurusan (Hanya untuk Siswa/Ketua Eskul) -->
                    <div x-show="needsClassMajor" x-transition.duration.300ms class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="kelas" class="block text-sm font-medium text-white required-label-dark">Kelas</label>
                            <select id="kelas" name="kelas" :required="needsClassMajor" class="dark-form-input appearance-none cursor-pointer">
                                <option value="" class="bg-white text-gray-800">Pilih Kelas</option>
                                <option value="X" class="bg-white text-gray-800">X</option>
                                <option value="XI" class="bg-white text-gray-800">XI</option>
                                <option value="XII" class="bg-white text-gray-800">XII</option>
                            </select>
                        </div>
                        <div>
                            <label for="jurusan" class="block text-sm font-medium text-white required-label-dark">Jurusan</label>
                            <select id="jurusan" name="jurusan" :required="needsClassMajor" class="dark-form-input appearance-none cursor-pointer">
                                <option value="" class="bg-white text-gray-800">Pilih Jurusan</option>
                                <option value="MIPA" class="bg-white text-gray-800">MIPA</option>
                                <option value="IPS" class="bg-white text-gray-800">IPS</option>
                                <option value="Bahasa" class="bg-white text-gray-800">Bahasa</option>
                            </select>
                        </div>
                    </div>

                    <!-- Conditional Tanggal Tugas (Hanya untuk Guru) -->
                    <div x-show="needsTaskDate" x-transition.duration.300ms>
                        <label for="tanggal_tugas" class="block text-sm font-medium text-white required-label-dark">Tanggal Tugas</label>
                        <input id="tanggal_tugas" 
                               class="dark-form-input"
                               type="date" 
                               name="tanggal_tugas" 
                               :required="needsTaskDate">
                    </div>

                    <!-- Conditional Cabang Eskul (Hanya untuk Pelatih/Ketua Eskul) -->
                    <div x-show="needsEskul" x-transition.duration.300ms>
                        <label for="cabang_eskul" class="block text-sm font-medium text-white required-label-dark">Cabang Ekstrakurikuler</label>
                        <select id="cabang_eskul" name="cabang_eskul" :required="needsEskul" class="dark-form-input appearance-none cursor-pointer">
                            <option value="" class="bg-white text-gray-800">Pilih Cabang Eskul</option>
                            <option value="Pramuka" class="bg-white text-gray-800">Pramuka</option>
                            <option value="Basket" class="bg-white text-gray-800">Basket</option>
                            <option value="Futsal" class="bg-white text-gray-800">Futsal</option>
                            <option value="Paskibra" class="bg-white text-gray-800">Paskibra</option>
                            <option value="Sains" class="bg-white text-gray-800">Klub Sains</option>
                        </select>
                    </div>

                    <!-- Password Fields (Dikecualikan hanya untuk role 'ketua_eskul' jika field identity diisi) -->
                    <div x-show="isPasswordRequired" x-transition.duration.300ms class="space-y-4">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-white required-label-dark">Password</label>
                            <input id="password" 
                                   class="dark-form-input" 
                                   type="password" 
                                   name="password" 
                                   :required="isPasswordRequired" 
                                   autocomplete="new-password"
                                   placeholder="Minimal 8 karakter">
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-white required-label-dark">Konfirmasi Password</label>
                            <input id="password_confirmation" 
                                   class="dark-form-input" 
                                   type="password" 
                                   name="password_confirmation" 
                                   :required="isPasswordRequired" 
                                   autocomplete="new-password"
                                   placeholder="Ulangi Password">
                        </div>
                    </div>
                    
                    <!-- Password Exemption Notice -->
                    <div x-show="!isPasswordRequired" x-transition.duration.300ms class="p-3 bg-yellow-500/20 border-l-4 border-yellow-300 text-yellow-100 rounded-lg">
                        <p class="font-semibold text-sm">Catatan: Password tidak wajib untuk Ketua Eskul. Jika Ketua Eskul sudah terdaftar sebagai Siswa, datanya akan di-upgrade.</p>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-white/50 transition duration-200 shadow-xl flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> Daftarkan Pengguna
                        </button>
                    </div>

                </form>
                
                <div class="mt-6 text-center text-sm text-white/80">
                    <a href="#" class="hover:text-white hover:underline transition duration-150">
                        Kembali ke Halaman Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>