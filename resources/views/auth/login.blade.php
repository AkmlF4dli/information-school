<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKUL 8 - Login</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* Custom font and background styles */
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            background-color: #f0f4f8; /* Light blue-grey background */
            background-image: radial-gradient(#d1d5db 1px, transparent 1px);
            background-size: 20px 20px;
        }

        /* Input field styling */
        .custom-input {
            border: none !important; /* Remove default border */
            border-bottom: 2px solid rgba(255, 255, 255, 0.5) !important; /* Subtle bottom border */
            background-color: transparent !important;
            color: white;
            padding-left: 2.5rem !important;
            transition: border-bottom-color 0.3s;
        }

        .custom-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .custom-input:focus {
            outline: none !important;
            box-shadow: none !important;
            border-bottom: 2px solid white !important;
        }

        /* Hide Alpine transition flashes */
        [x-cloak] { display: none !important; }

        /* Custom shape for the card background glow */
        #login-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Illustration styling (simplified) */
        .illustration-container {
            background-image: linear-gradient(180deg, #ffffff 0%, #f7f7f7 100%);
        }
    </style>

    <script>
        // Placeholder for authentication logic - The actual API calls would go here.
        // The __initial_auth_token and __firebase_config are placeholders for the environment.

        const login = (event) => {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const statusDiv = document.getElementById('auth-status');
            const submitButton = document.getElementById('submit-button');

            // Simple validation simulation
            if (!email || !password) {
                statusDiv.className = 'block mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-sm w-full max-w-md';
                statusDiv.textContent = 'Email dan Password wajib diisi.';
                return;
            }

            // Show loading state
            submitButton.disabled = true;
            submitButton.classList.add('opacity-70');
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            statusDiv.classList.add('hidden');

            // Simulate API call delay
            setTimeout(() => {
                // Simulate successful login
                if (email === "user@smanda.id" && password === "password") {
                    statusDiv.className = 'block mb-4 p-3 bg-emerald-100 border border-emerald-400 text-emerald-700 rounded-lg shadow-sm w-full max-w-md';
                    statusDiv.textContent = 'Login berhasil! Mengalihkan ke dashboard...';
                    // In a real app, you would redirect here
                } else {
                    // Simulate error
                    statusDiv.className = 'block mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-sm w-full max-w-md';
                    statusDiv.textContent = 'Email atau Password salah. Silakan coba lagi.';
                }
                
                // Reset button state
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-70');
                submitButton.innerHTML = 'Login';

            }, 2000);
        };
    </script>
</head>
<body class="antialiased flex items-center justify-center min-h-screen">

    <div id="auth-status" class="fixed top-4 z-50 hidden" role="alert"></div>

    <!-- Main Login Card Container -->
    <div id="login-card" class="w-full max-w-4xl bg-white rounded-3xl overflow-hidden shadow-2xl m-4 lg:m-8">
        <div class="md:grid md:grid-cols-2">

            <!-- Kiri (Left Panel - Branding & Illustration) -->
            <div class="illustration-container p-10 flex flex-col justify-center items-center text-center">
                
                <!-- Logo & School Name -->
                <div class="mb-8">
                    <img src="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" 
                         alt="Logo SMK Negeri 8 Jakarta" 
                         class="w-20 h-20 mx-auto rounded-full object-cover border-4 border-white shadow-lg">
                    <h2 class="text-2xl font-extrabold text-gray-800 mt-4">
                        SISKUL 8 Jakarta
                    </h2>
                    <p class="text-gray-500 text-sm">Masuk ke Sistem Informasi Sekolah</p>
                </div>
                
                <!-- Illustration (Simulated with SVG for a self-contained file) -->
                <div class="w-2/3 h-auto mb-4">
                    <svg viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="lockGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#4c85d8;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2a65ad;stop-opacity:1" />
                            </linearGradient>
                            <mask id="padlock-mask">
                                <rect width="500" height="400" fill="white" />
                                <text x="250" y="250" font-size="200" text-anchor="middle" fill="black">🔒</text>
                            </mask>
                        </defs>
                        <!-- Lock body (simplified based on the image's aesthetic) -->
                        <rect x="180" y="150" width="140" height="150" rx="15" fill="url(#lockGradient)" />
                        <!-- Lock shackle -->
                        <path d="M220 150 A50 50 0 0 1 280 150 V80 H220 Z" fill="url(#lockGradient)" />
                        <!-- Keyhole / Button -->
                        <circle cx="250" cy="220" r="15" fill="#f7d04f" />
                        <rect x="245" y="235" width="10" height="20" fill="#f7d04f" />

                        <!-- Simplified illustration figure (man with tablet) -->
                        <g transform="translate(-100, 100)">
                             <!-- Body -->
                            <rect x="180" y="250" width="40" height="60" rx="5" fill="#1f2937" />
                            <!-- Head -->
                            <circle cx="200" cy="240" r="15" fill="#facc15" />
                            <!-- Tablet -->
                            <rect x="210" y="260" width="45" height="55" rx="5" fill="#9ca3af" transform="rotate(15 232.5 287.5)" />
                            <!-- Legs -->
                            <rect x="180" y="310" width="15" height="40" rx="5" fill="#1d4ed8" />
                            <rect x="200" y="310" width="15" height="40" rx="5" fill="#1d4ed8" />
                        </g>
                    </svg>
                </div>

                <p class="mt-4 text-gray-500 text-sm px-6">
                    Akses data sekolah, nilai siswa, dan informasi guru dengan aman.
                </p>
            </div>

            <!-- Kanan (Right Panel - Login Form) -->
            <div class="bg-blue-700 p-10 md:p-12 text-white">
                <h1 class="text-4xl font-extrabold mb-8 text-center">Login</h1>

                <form id="login-form" action="{{ route('adminprcs') }}" method="POST">
                    @csrf
                    
                    <!-- Email Input -->
                    <div class="relative mb-6">
                        <i class="fas fa-user absolute left-0 top-1/2 -translate-y-1/2 text-white/80"></i>
                        <input id="email" 
                               class="custom-input w-full text-lg pb-1"
                               type="email" 
                               name="email" 
                               required 
                               autocomplete="username" 
                               placeholder="Email">
                    </div>

                    <!-- Password Input -->
                    <div class="relative mb-6">
                        <i class="fas fa-lock absolute left-0 top-1/2 -translate-y-1/2 text-white/80"></i>
                        <input id="password" 
                               class="custom-input w-full text-lg pb-1"
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Password">
                    </div>

                    <!-- Options & Forgot Password -->
                    <div class="flex items-center justify-between mt-4 text-sm">
                        <div class="flex items-center">
                            <input type="checkbox" id="rememberme" name="rememberme" class="w-4 h-4 text-blue-700 bg-gray-100 border-gray-300 rounded focus:ring-blue-800">
                            <label for="rememberme" class="ml-2">Remember Me</label>
                        </div>
                        <a href="#" class="text-white/80 hover:text-white hover:underline transition duration-150">
                            Forgot Password
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" id="submit-button" class="block w-full text-center py-3 mt-6 bg-white text-blue-600 font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-200">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>