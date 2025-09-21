<x-app-layout>
    <div x-data="{ showForm: 'dashboard' }" class="flex min-h-screen bg-gradient-to-br from-white to-blue-100" id="main">
    @if (Auth::user()->role != 'siswa')
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-6 space-y-4" style="background-color: blue;">
            @if (Auth::user()->role == 'admin')
            <center><h2 class="text-xl font-semibold text-gray-800 mb-4" style="color: white;">Menu Admin</h2></center>
            @elseif (Auth::user()->role == 'guru')
            <center><h2 class="text-xl font-semibold text-gray-800 mb-4" style="color: white;">Menu Piket</h2></center>
            @elseif (Auth::user()->role == 'pembina')
            <center><h2 class="text-xl font-semibold text-gray-800 mb-4" style="color: white;">Menu Pembina</h2></center>
            @elseif (Auth::user()->role == 'eskul')
            <center><h2 class="text-xl font-semibold text-gray-800 mb-4" style="color: white;">Menu Pelatih Eskul {{ Auth::user()->cabang_eskul }}</h2></center>
            @elseif (Auth::user()->role == 'ketua_eskul')
            <center><h2 class="text-xl font-semibold text-gray-800 mb-4" style="color: white;">Menu Ketua Eskul {{ Auth::user()->cabang_eskul }}</h2></center>
            @endif
            <nav class="flex flex-col space-y-2">
                @if (Auth::user()->picture == '/storage/profile/profile.jpg')
                <center><img src="{{ Auth::user()->picture }}" alt="Profile Photo" width="100" height="100" class="mb-5 w-32 h-32 rounded-full object-cover border border-gray-300 shadow"></center>
                @else
                <center><img src="/storage/{{ Auth::user()->picture }}" alt="Profile Photo" width="100" height="100" class="mb-5 w-32 h-32 rounded-full object-cover border border-gray-300 shadow"></center>
                @endif
                <button 
                   onclick="window.location.href = '/myprofile'"
                   class="px-4 py-2 rounded-md bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold"
                >
                   My Profile
                </button>
                <button
                    @click="showForm = 'dashboard'"
                    class="px-4 py-2 rounded-md bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold"
                >
                    Dashboard
                </button>

                @if (Auth::user()->role == 'admin')
                <button
                    @click="showForm = 'lihatPembina'"
                    class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold"
                >
                    Lihat Pembina
                </button>

                <button
                    @click="showForm = 'lihatGuru'"
                    class="px-4 py-2 rounded-md bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-semibold"
                >
                    Lihat Guru Piket
                </button>
                @endif
                @if (Auth::user()->role == 'pembina')
                <button
                    @click="showForm = 'lihatEskul'"
                    class="px-4 py-2 rounded-md bg-purple-100 hover:bg-purple-200 text-purple-800 font-semibold"
                >
                    Lihat Pelatih Eskul
                </button>
                
                <button
                    @click="showForm = 'lihatKetuaEskul'"
                    class="px-4 py-2 rounded-md bg-pink-100 hover:bg-pink-200 text-pink-800 font-semibold"
                >
                    Lihat Ketua Eskul
                </button>
                @endif
                @if (Auth::user()->role == 'admin')
                <button
                    @click="showForm = 'lihatSiswa'"
                    class="px-4 py-2 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold"
                >
                    Lihat Siswa
                </button>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-800 font-semibold rounded-md">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>
    @endif
        <!-- Main Content -->
        <main class="flex-1 p-10 space-y-6">

            <!-- Dashboard Welcome -->
            <div x-show="showForm === 'dashboard'" class="p-4">
                <h1 class="text-2xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }}!</h1>
                <p class="mt-2 text-gray-600">Silakan pilih menu di sebelah kiri.</p>
                @if (Auth::user()->role == "siswa")
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-800 font-semibold rounded-md">
                        Logout
                    </button>
                </form>
                @endif
            </div>

            <!-- Daftar Guru dalam Bentuk Card -->
            <div x-show="showForm === 'lihatGuru'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl" style="display: flex; juistify-content: space-between;">
                <div>
                    <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Guru Piket Baru</h1>

                    <!-- Nisn -->
                    <div class="mb-4"> 
                        <x-input-label for="identity" :value="__('NIP')" />
                        <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                            :value="old('identity')" autofocus autocomplete="identity" />
                        <x-input-error :messages="$errors->get('identity')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

               <!-- Role -->
<div class="mt-4" x-data="{ role: '{{ old('role') }}' }" style="display: none;">
    <x-input-label for="role" :value="__('Role')" />
    <select id="role" name="role" x-model="role" required
        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="guru">guru</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>
    <!-- Tanggal Tugas -->
<div class="mt-4 mb-2">
<x-input-label for="tanggal_tugas" :value="__('Tanggal Piket')" />
    <select id="tanggal_tugas" name="tanggal_tugas" x-model="tanggal_tugas" required
        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="minggu">Senin</option>
        <option value="selasa">Selasa</option>
        <option value="rabu">Rabu</option>
        <option value="kamis">Kamis</option>
        <option value="jumat">Jumat</option>
    </select>
</div>
                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                            required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
                </div>
                <div>
                <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Guru</h2>

                @php
                    $gurus = \App\Models\User::where('role', 'guru')->get();
                @endphp

                @if ($gurus->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($gurus as $guru)
                             <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                                <p>NIP: {{ $guru->identity }}</p>
                                <div class="text-lg font-semibold text-gray-800"><p>Name: {{ $guru->name }}</p></div>
                                <div class="text-lg font-semibold text-gray-800"><p>Picket: {{ $guru->tanggal_tugas }}</p></div>
                                <div class="text-sm text-gray-600"><p>Email: {{ $guru->email }}</p></div>
                                    <form action="{{ route('guru.destroy', $guru->identity) }}" method="POST"
        onsubmit="return confirm('Yakin ingin menghapus guru ini?');"
        class="absolute top-2 right-2"
    >
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-500 hover:text-red-700 text-lg font-bold" title="Hapus guru">
            Delete
        </button>
    </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">Belum ada guru yang terdaftar.</p>
                @endif
            </div>
        </div>

            <!-- Daftar Pembina dalam Bentuk Card -->
<div x-show="showForm === 'lihatPembina'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl">
    <div>
                    <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pembina Baru</h1>

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

               <!-- Role dan Cabang Eskul -->
<div class="mt-4" x-data="{ role: '{{ old('role') }}' }" style="display: none;">
    <x-input-label for="role" :value="__('Role')" />
    <select id="role" name="role" x-model="role" required
        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="pembina">Pilih Role</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />

    <!-- Tanggal Tugas -->
<div x-show="role === 'guru'" x-transition class="mt-4">
<div class="mt-4">
    <x-input-label for="tanggal_tugas" :value="__('Tanggal Tugas')" />
    <x-text-input
        id="tanggal_tugas"
        class="block mt-1 w-full"
        type="date"
        name="tanggal_tugas"
        :value="old('tanggal_tugas')"
        autocomplete="tanggal_tugas"
    />
    <x-input-error :messages="$errors->get('tanggal_tugas')" class="mt-2" />
</div>
</div>

    <!-- Dropdown Cabang Eskul -->
    <div x-show="role === 'eskul' || role === 'ketua_eskul'" x-transition class="mt-4">
        <x-input-label for="cabang_eskul" :value="__('Cabang Eskul')" />
        <select id="cabang_eskul" name="cabang_eskul"
            class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
            <option value="">Pilih Cabang</option>
            @php
                $cabangList = ['Futsal', 'Basket', 'Pramuka', 'Paskibra'];
            @endphp
            @foreach ($cabangList as $cabang)
                <option value="{{ $cabang }}" {{ old('cabang_eskul') === $cabang ? 'selected' : '' }}>
                    {{ $cabang }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('cabang_eskul')" class="mt-2" />
    </div>
</div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                            required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
    </div>
    <div>
    <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Pembina</h2>

    @php
        $pembinas = \App\Models\User::where('role', 'pembina')->get();
    @endphp

    @if ($pembinas->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pembinas as $pembina)
                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition">
                    <div class="text-lg font-semibold text-gray-800">{{ $pembina->name }}</div>
                    <div class="text-sm text-gray-600">{{ $pembina->email }}</div>
                    @if ($pembina->cabang_eskul)
                        <div class="text-sm text-indigo-700">Cabang: {{ $pembina->cabang_eskul }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Belum ada pembina yang terdaftar.</p>
    @endif
    </div>
</div>

<!-- Daftar Siswa -->
<div x-show="showForm === 'lihatSiswa'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl" style="display: flex; justify-content: space-between">
<div>
                <!-- Tambah User Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Siswa Baru</h1>

                    <!-- Nisn -->
                    <div class="mb-4"> 
                        <x-input-label for="identity" :value="__('NISN')" />
                        <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                            :value="old('identity')" autofocus autocomplete="identity" />
                        <x-input-error :messages="$errors->get('identity')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Kelas -->
                    <div class="mt-4">
                        <x-input-label for="kelas" :value="__('Kelas')" />
                        <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas"
                            :value="old('kelas')" required autofocus autocomplete="kelas" />
                        <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
                    </div>

                    <!-- Jurusan -->
                    <div class="mt-4">
                        <x-input-label for="jurusan" :value="__('Jurusan')" />
                        <x-text-input id="jurusan" class="block mt-1 w-full" type="text" name="jurusan"
                            :value="old('jurusan')" required autofocus autocomplete="jurusan" />
                        <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
                    </div>

               <!-- Role dan Cabang Eskul -->
<div class="mt-4" x-data="{ role: '{{ old('role') }}' }" style="display: none;">
    <x-input-label for="role" :value="__('Role')" />
    <select id="role" name="role" x-model="role" required
        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="siswa">Siswa</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />

    <!-- Dropdown Cabang Eskul -->
    <div x-show="role === 'eskul' || role === 'ketua_eskul'" x-transition class="mt-4">
        <x-input-label for="cabang_eskul" :value="__('Cabang Eskul')" />
        <select id="cabang_eskul" name="cabang_eskul"
            class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
            <option value="">Pilih Cabang</option>
            @php
                $cabangList = ['Futsal', 'Basket', 'Pramuka', 'Paskibra'];
            @endphp
            @foreach ($cabangList as $cabang)
                <option value="{{ $cabang }}" {{ old('cabang_eskul') === $cabang ? 'selected' : '' }}>
                    {{ $cabang }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('cabang_eskul')" class="mt-2" />
    </div>
</div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                            required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>

</div>
<div>
   <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Siswa</h2>

    @php
        $siswaList = \App\Models\User::where('role', 'siswa')->get();
    @endphp

    @if ($siswaList->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($siswaList as $siswa)
                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition">
                    <div class="text-lg font-semibold text-gray-800">{{ $siswa->name }}</div>
                    <div class="text-sm text-gray-600">{{ $siswa->email }}</div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Belum ada siswa yang terdaftar.</p>
    @endif
</div>
</div>

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
    <!-- Daftar Ketua Eskul -->
    <div x-show="showForm === 'lihatKetuaEskul'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Ketua Ekstrakurikuler</h2>

        @php
            $ketuaList = \App\Models\User::where('role', 'ketua_eskul')->get();
        @endphp

        @if ($ketuaList->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($ketuaList as $ketua)
                    <div class="bg-pink-50 border border-pink-200 rounded-xl p-4 shadow hover:shadow-lg transition">
                        <div class="text-lg font-semibold text-gray-800">{{ $ketua->name }}</div>
                        <div class="text-sm text-gray-600">{{ $ketua->email }}</div>
                        <div class="text-sm text-pink-700">
                            Cabang: {{ $ketua->cabang_eskul ?? '-' }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada ketua ekstrakurikuler yang terdaftar.</p>
        @endif
    </div>

    <!-- Daftar Pelatih Eskul -->
    <div x-show="showForm === 'lihatEskul'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Pelatih Ekstrakurikuler</h2>

        @php
            $pelatihs = \App\Models\User::where('role', 'eskul')->get();
        @endphp

        @if ($pelatihs->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($pelatihs as $pelatih)
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 shadow hover:shadow-lg transition">
                        <div class="text-lg font-semibold text-gray-800">{{ $pelatih->name }}</div>
                        <div class="text-sm text-gray-600">{{ $pelatih->email }}</div>
                        <div class="text-sm text-purple-700">
                            Cabang: {{ $pelatih->cabang_eskul ?? '-' }}
                        </div>

                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4">
                            <input type="hidden" name="id" value="{{ $pelatih->id }}">
                            <input type="hidden" name="name" value="{{ $pelatih->name }}">
                            <input type="hidden" name="email" value="{{ $pelatih->email }}">
                            <input type="hidden" name="role" value="{{ $pelatih->role }}">
                            <input type="hidden" name="cabang_eskul" value="{{ $pelatih->cabang_eskul }}">
                            <button type="submit" class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada pelatih ekstrakurikuler yang terdaftar.</p>
        @endif
    </div>
@endif
        </main>
    </div>
    
    @php
        $check_absent_guru = \App\Models\Absensi::where('name', Auth::user()->name)->where('created_at', 'like', '%' . \Carbon\Carbon::now()->format('Y-m-d') . '%')->Exists();
        $check_absent_siswa = \App\Models\Absensi::where('name', Auth::user()->name)->where('created_at', 'like', '%' . \Carbon\Carbon::now()->format('Y-m-d') . '%')->Exists();
    @endphp

@if (!$check_absent_guru && Auth::user()->role == 'guru' && Auth::user()->tanggal_tugas == strtolower(\Carbon\Carbon::now()->translatedFormat('l')))
    {{-- Hide main section directly --}}
    <style>
        #main { display: none; }
    </style>

    <center><p>Silakan isi absensi terlebih dahulu</p></center>

    {{-- Absensi form --}}
    <form action="/absensi" method="POST" class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 border border-blue-300">
        @csrf

        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Form Absensi</h2>

        <div class="mb-4">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="identity">Identity</label>
            <input type="number" name="identity" id="identity" value="{{ Auth::user()->identity }}" class="shadow border rounded w-full py-2 px-3" required readonly>
        </div>

        <div class="mb-4">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="shadow border rounded w-full py-2 px-3" required readonly>
        </div>

        <div class="mb-4">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="role">Role</label>
            <input type="text" name="role" id="role" value="{{ Auth::user()->role }}" class="shadow border rounded w-full py-2 px-3" required readonly>
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
        <button type="submit" class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-800 font-semibold rounded-md">
            Logout
        </button>
    </form>

@elseif (!$check_absent_siswa && Auth::user()->role == 'siswa' || Auth::user()->role == 'ketua_eskul')
    @if (Auth::user()->role == 'siswa')
        <style>
            #main { display: none; }
        </style>
    @endif

    <center><p>Silakan isi absensi terlebih dahulu</p></center>

    <form action="/absensi" method="POST" 
          class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 border border-blue-300">
        @csrf

        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Form Absensi</h2>

        {{-- Identity --}}
        <div class="mb-4">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="identity">
                Identity
            </label>
            <input type="number" 
                   name="identity" 
                   id="identity" 
                   value="{{ Auth::user()->identity }}"
                   readonly
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Name --}}
        <div class="mb-4">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="name">
                Name
            </label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   value="{{ Auth::user()->name }}"
                   readonly
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Role --}}
        <div class="mb-4">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="role">
                Role
            </label>
            <input type="text" 
                   name="role" 
                   id="role" 
                   value="{{ Auth::user()->role }}"
                   readonly
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Kelas --}}
        <div class="mb-4">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="kelas">
                Kelas
            </label>
            <input type="text" 
                   name="kelas" 
                   id="kelas" 
                   value="{{ Auth::user()->kelas }}"
                   readonly
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- Jurusan --}}
        <div class="mb-4">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="jurusan">
                Jurusan
            </label>
            <input type="text" 
                   name="jurusan" 
                   id="jurusan" 
                   value="{{ Auth::user()->jurusan }}"
                   readonly
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 cursor-not-allowed">
        </div>

        {{-- MAC Address (editable) --}}
        <div class="mb-6">
            <label class="block text-blue-700 text-sm font-bold mb-2" for="mac_address">
                MAC Address
            </label>
            <input type="text" 
                   name="mac_address" 
                   id="mac_address"
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline focus:border-blue-500" 
                   required>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Submit Absensi
            </button>
        </div>
    </form>
@endif
</x-app-layout>
