<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - SISKUL 8</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #e5e7eb; }
        .input-style { transition: all 0.2s ease-in-out; border-color: #d1d5db; }
        .input-style:focus { outline: none; border-color: #4338ca; box-shadow: 0 0 0 3px rgba(67,56,202,0.25); }
    </style>
</head>
<body>
    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h2 class="font-extrabold text-2xl text-gray-900">Edit Profil</h2>
            <a href="{{ route('dashboard') }}"
               class="group inline-flex items-center px-4 py-2 bg-indigo-700 rounded-full text-white text-xs font-semibold hover:bg-indigo-800 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </header>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center text-center mb-10 border-t-4 border-indigo-600">
                <div class="relative w-36 h-36 mb-4">
                    <img id="previewFoto" 
                         src="{{ Auth::user()->picture == '/storage/profile/profile.jpg' ? Auth::user()->picture : '/storage/' . Auth::user()->picture }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="w-36 h-36 object-cover rounded-full border-4 border-white ring-4 ring-indigo-500 shadow-2xl">
                    <label for="foto" class="absolute bottom-0 right-0 w-10 h-10 bg-indigo-600 border-4 border-white rounded-full flex items-center justify-center cursor-pointer hover:bg-indigo-700 transition">
                        <i class="bi bi-camera-fill text-white text-md"></i>
                    </label>
                    <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('patch')
                    <input type="file" id="foto" name="picture" class="hidden" accept="image/*">
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2">{{ Auth::user()->name }}</h2>
                <p class="text-md text-indigo-600 font-medium mt-1 bg-indigo-50 px-3 py-1 rounded-full">{{ '@' . Str::slug(Auth::user()->name) }} • {{ Auth::user()->role ?? 'Pengguna' }}</p> 
            </div>

            <div class="bg-white shadow-xl rounded-2xl">
                <!-- Profile Section -->
                <div class="p-8 sm:p-10 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Perbarui Detail Akun</h3>
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                            <input id="name" name="name" type="text" value="{{ Auth::user()->name }}" required
                                   class="input-style block w-full rounded-lg border px-4 py-2.5 shadow-sm focus:shadow-md" />
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required
                                   class="input-style block w-full rounded-lg border px-4 py-2.5 shadow-sm focus:shadow-md">
                        </div>

                        <div class="pt-6 flex justify-end gap-3">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-6 py-2 border border-indigo-200 text-indigo-700 font-bold rounded-lg hover:bg-indigo-50">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-lg hover:bg-indigo-700 font-bold">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Password Update Section -->
                <div class="p-8 sm:p-10 mb-6 border-t">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Ubah Password</h3>
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1">Password Saat Ini</label>
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                                   class="input-style block w-full rounded-lg border px-4 py-2.5 shadow-sm focus:shadow-md" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password Baru</label>
                            <input id="password" name="password" type="password" autocomplete="new-password"
                                   class="input-style block w-full rounded-lg border px-4 py-2.5 shadow-sm focus:shadow-md" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                   class="input-style block w-full rounded-lg border px-4 py-2.5 shadow-sm focus:shadow-md" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="pt-6 flex justify-end gap-3">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-6 py-2 border border-indigo-200 text-indigo-700 font-bold rounded-lg hover:bg-indigo-50">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-lg hover:bg-indigo-700 font-bold">
                                Simpan Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Deletion Section -->
                <div class="p-8 sm:p-10">
                    <h3 class="text-xl font-bold text-red-700 mb-6 border-b pb-3">Hapus Akun</h3>
                    <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                        @csrf
                        @method('delete')

                        <div class="bg-red-50 p-4 rounded-xl border border-red-300">
                            <p class="text-base text-red-700 font-medium">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Setelah akun Anda dihapus, semua data akan hilang secara permanen.
                            </p>
                        </div>

                        <div>
                            <label for="delete_password" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                            <input id="delete_password" name="password" type="password"
                                   class="input-style block w-full rounded-lg border px-4 py-2.5 shadow-sm focus:shadow-md" />
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>

                        <div class="pt-6 flex justify-end gap-3">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-6 py-2 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg shadow-lg hover:bg-red-700 font-bold">
                                <i class="fas fa-gavel mr-2"></i> Hapus Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Foto Preview
        document.getElementById('foto').addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('previewFoto').src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
