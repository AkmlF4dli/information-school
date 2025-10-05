<!-- Main Content -->
    <main class="flex-1 p-10 space-y-6">

        <!-- Dashboard Welcome -->
        <div x-show="showForm === 'dashboard'" class="p-4">
            @if (Auth::user()->role != 'siswa' && Auth::user()->role != 'ketua_eskul')
                <!-- Non-Siswa -->
                <h1 class="text-2xl font-bold text-gray-800">
                    Selamat datang, {{ Auth::user()->name }}!
                </h1>
                <p class="mt-2 text-gray-600">Silakan pilih menu di sebelah kiri.</p>
            @endif

            {{-- Siswa --}}
            @if (Auth::user()->role == 'siswa')
            <form action="/logout" method="POST">
    <!-- biasanya di Laravel, Django, atau framework lain perlu CSRF token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <button type="submit">Logout</button>
</form>

                <div id="clock" class="text-4xl font-bold text-center"></div>
                <div id="date" class="text-lg text-center mt-2"></div>

                <div class="text-center mt-5">
                    <img src="{{ Auth::user()->picture == '/storage/profile/profile.jpg' ? Auth::user()->picture : '/storage/' . Auth::user()->picture }}"
                         alt="Profile Photo"
                         class="mb-5 w-32 h-32 rounded-full object-cover border border-gray-300 shadow">
                </div>

                @php
                    $user = Auth::user();
                    $eskuls = [$user->cabang_eskul, $user->cabang_eskul2, $user->cabang_eskul3];
                @endphp

                <div class="flex flex-wrap gap-6 justify-center mt-5">
                    <!-- Eskul diikuti -->
                    <div class="w-80">
                        <h3 class="font-bold mb-2">Eskul yang Kamu Ikuti:</h3>
                        <ul class="list-disc pl-5">
                            @foreach ($eskuls as $eskul)
                                @if ($eskul)
                                    <li class="flex justify-between items-center">
                                        {{ $eskul }}
                                        <form action="{{ route('eskul.hapus', $eskul) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Keluar</button>
                                        </form>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <!-- Semua daftar cabang -->
                    <div class="flex flex-wrap gap-4">
                        @foreach ($cabangList as $cabang)
                            <div onclick="window.location.href='{{ url('/eskul?cabang=' . urlencode($cabang)) }}'"
                                 class="px-4 py-2 rounded-lg shadow bg-white cursor-pointer hover:bg-blue-500 hover:text-white">
                                {{ $cabang }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

                @if (Auth::user()->role == "ketua_eskul" && $check_absent_siswa)
                <div class="flex-1">
                    <bold><h1 style="font-size: 1cm;">Hallo Ketua Eskul {{ Auth::user()->cabang_eskul }}</h1></bold>
                </div>
                @endif
        </div>

            <!-- Daftar Guru dalam Bentuk Card -->
<div x-show="showForm === 'lihatGuru'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-6">
    <div class="flex-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Guru Piket Baru</h1>

            <div class="mb-4">
                <x-input-label for="identity" :value="__('NIP')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                    :value="old('identity')" required autofocus autocomplete="off" />
                <x-input-error :messages="$errors->get('identity')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="guru" selected>guru</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="tanggal_tugas" :value="__('Tanggal Piket')" />
                <select id="tanggal_tugas" name="tanggal_tugas" required
                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    <option value="">Pilih Hari</option>
                    @php
                        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    @endphp
                    @foreach ($hariList as $hari)
                        <option value="{{ strtolower($hari) }}" {{ old('tanggal_tugas') === strtolower($hari) ? 'selected' : '' }}>
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('tanggal_tugas')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Guru Piket</h2>

        @php
            // Make sure the User model is correctly imported and available in your Blade context
            $gurus = \App\Models\User::where('role', 'guru')->get();
        @endphp

        @if ($gurus->count())
            <div class="grid grid-cols-1 gap-6">
                @foreach ($gurus as $guru)
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        <div class="text-lg font-semibold text-gray-800">NIP: {{ $guru->identity }}</div>
                        <div class="text-md font-semibold text-gray-800">NAMA: {{ $guru->name }}</div>
                        <div class="text-sm text-blue-700">
                            Hari Piket: {{ ucfirst($guru->tanggal_tugas) ?? '-' }}
                        </div>
                        <div class="text-sm text-gray-600">{{ $guru->email }}</div>

                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" value="{{ $guru->id }}">
                            <input type="hidden" name="identity" value="{{ $guru->identity }}">
                            <input type="hidden" name="name" value="{{ $guru->name }}">
                            <input type="hidden" name="email" value="{{ $guru->email }}">
                            <input type="hidden" name="role" value="{{ $guru->role }}">
                            <input type="hidden" name="tanggal_tugas" value="{{ $guru->tanggal_tugas }}">
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        <form action="{{ route('guru.destroy', $guru->identity) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus guru ini?');"
                            class="mt-2 inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada guru piket yang terdaftar.</p>
        @endif
    </div>
</div>
            <!-- Daftar Pembina dalam Bentuk Card -->
<div x-show="showForm === 'lihatPembina'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-6">

    <div class="flex-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pembina Baru</h1>

            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="pembina" selected>Pembina</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Pembina</h2>

        @php
            $pembinas = \App\Models\User::where('role', 'pembina')->get();
        @endphp

        @if ($pembinas->count())
            <div class="grid grid-cols-1 gap-6">
                @foreach ($pembinas as $pembina)
                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        <div class="text-lg font-semibold text-gray-800">{{ $pembina->name }}</div>
                        <div class="text-sm text-gray-600">{{ $pembina->email }}</div>

                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" value="{{ $pembina->id }}">
                            <input type="hidden" name="name" value="{{ $pembina->name }}">
                            <input type="hidden" name="email" value="{{ $pembina->email }}">
                            <input type="hidden" name="role" value="{{ $pembina->role }}">
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        <form action="{{ route('pembina.destroy', $pembina->email) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus pembina ini?');"
                              class="mt-2 inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada pembina yang terdaftar.</p>
        @endif
    </div>
</div>

<!-- Daftar Siswa -->
<div x-show="showForm === 'lihatSiswa'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-6">

    <div class="flex-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Siswa Baru</h1>

            <div class="mb-4">
                <x-input-label for="identity" :value="__('NISN')" />
                <x-text-input id="identity" class="block mt-1 w-full" type="number" name="identity"
                    :value="old('identity')" required autofocus autocomplete="identity" />
                <x-input-error :messages="$errors->get('identity')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="kelas" :value="__('Kelas')" />
                <small>menggunakan romawi seperti: X, XI, XII</small>
                <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas"
                    :value="old('kelas')" required autocomplete="kelas" />
                <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="jurusan" :value="__('Jurusan')" />
                <x-text-input id="jurusan" class="block mt-1 w-full" type="text" name="jurusan"
                    :value="old('jurusan')" required autocomplete="jurusan" />
                <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
            </div>

            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="siswa" selected>Siswa</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Siswa</h2>

        @php
            $siswaList = \App\Models\User::where('role', 'siswa')->get();
        @endphp

        @if ($siswaList->count())
            <div class="grid grid-cols-1 gap-6">
                @foreach ($siswaList as $siswa)
                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        <div class="text-lg font-semibold text-gray-800">{{ $siswa->name }}</div>
                        <div class="text-sm text-gray-600">NISN: {{ $siswa->identity }}</div>
                        <div class="text-sm text-gray-600">Email: {{ $siswa->email }}</div>
                        <div class="text-sm text-indigo-700">
                            Kelas/Jurusan: {{ $siswa->kelas ?? '-' }}/{{ $siswa->jurusan ?? '-' }}
                        </div>
                        {{-- Assuming cabang_eskul is optional for a student --}}
                        @if ($siswa->cabang_eskul)
                            <div class="text-sm text-purple-700">
                                Eskul: {{ $siswa->cabang_eskul }}
                            </div>
                        @endif

                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" value="{{ $siswa->id }}">
                            <input type="hidden" name="identity" value="{{ $siswa->identity }}">
                            <input type="hidden" name="name" value="{{ $siswa->name }}">
                            <input type="hidden" name="email" value="{{ $siswa->email }}">
                            <input type="hidden" name="role" value="{{ $siswa->role }}">
                            <input type="hidden" name="kelas" value="{{ $siswa->kelas }}">
                            <input type="hidden" name="jurusan" value="{{ $siswa->jurusan }}">
                            <input type="hidden" name="cabang_eskul" value="{{ $siswa->cabang_eskul }}">
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        <form action="{{ route('siswa.destroy', $siswa->identity) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus siswa ini?');"
                            class="mt-2 inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
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
<div x-show="showForm === 'lihatKetuaEskul'"
     x-data="{
        searchQueryketuaeskul: '',
        siswaList: @js($siswaList ?? []),
        filteredList: @js($siswaList ?? []),
        searchList() {
            const q = this.searchQueryketuaeskul.trim().toLowerCase();
            this.filteredList = q
                ? this.siswaList.filter(s => (s.name || '').toLowerCase().includes(q))
                : this.siswaList;
        }
     }"
     x-transition
     class="bg-white p-6 rounded-xl shadow max-w-6xl flex gap-6">

  <!-- Kolom kiri: Penunjukan -->
  <div class="flex-1">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Penunjukan Ketua Eskul</h1>

    <!-- Search Bar -->
    <div class="mb-6">
      <x-text-input
        x-model="searchQueryketuaeskul"
        x-on:input.debounce.300="searchList"
        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        type="text"
        placeholder="Cari siswa berdasarkan nama..."
      />
    </div>

    <!-- Daftar Siswa (client-side rendered oleh Alpine) -->
    <template x-if="filteredList.length > 0">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="siswa in filteredList" :key="siswa.id">
          <div class="bg-white rounded-xl shadow-md border p-5">
            <p class="font-semibold text-gray-800" x-text="siswa.name"></p>
            <p class="text-sm text-gray-600">NISN: <span x-text="siswa.identity"></span></p>
            <p class="text-sm text-gray-600">Kelas: <span x-text="siswa.kelas"></span></p>
            <p class="text-sm text-gray-600">Jurusan: <span x-text="siswa.jurusan"></span></p>

            <!-- Form (server route) — gunakan Alpine binding untuk value -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4 mt-3">
              @csrf

              <!-- Hidden fields di-bind dari objek siswa -->
              <input type="hidden" name="name" :value="siswa.name">
              <input type="hidden" name="identity" :value="siswa.identity">
              <input type="hidden" name="email" :value="siswa.email">
              <input type="hidden" name="kelas" :value="siswa.kelas">
              <input type="hidden" name="jurusan" :value="siswa.jurusan">
              <input type="hidden" name="role" value="ketua_eskul">

              <!-- Pilih Cabang Eskul (options di-render server-side) -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cabang Eskul</label>
                <select name="cabang_eskul" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                  <option value="">-- Pilih Cabang --</option>
                  @foreach ($cabangList as $cabang)
                    <option value="{{ $cabang }}">{{ $cabang }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Submit -->
              <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700">
                  Jadikan Ketua
                </button>
              </div>
            </form>
          </div>
        </template>
      </div>
    </template>

    <!-- Pesan tidak ada hasil -->
    <template x-if="filteredList.length === 0">
      <p class="text-gray-600 italic text-center">
        <span x-show="searchQueryketuaeskul.length > 0">Tidak ditemukan siswa dengan nama tersebut.</span>
        <span x-show="searchQueryketuaeskul.length === 0">Ketik nama siswa untuk mencari data.</span>
      </p>
    </template>
  </div>

<!-- Daftar Ketua Eskul -->
<div class="flex-1">
    <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Ketua Eskul</h2>
    @php
        $ketuaEskulList = \App\Models\User::where('role', 'ketua_eskul')->get();
    @endphp

    @if ($ketuaEskulList->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($ketuaEskulList as $ketua)
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5 hover:shadow-lg transition">
                    <div class="space-y-1 text-sm text-gray-700">
                        <p class="font-bold text-lg text-gray-800">{{ $ketua->name }}</p>
                        <p><span class="font-semibold">NISN:</span> {{ $ketua->identity }}</p>
                        <p><span class="font-semibold">Kelas:</span> {{ $ketua->kelas }} / {{ $ketua->jurusan }}</p>
                        <p><span class="font-semibold">Eskul:</span> {{ $ketua->cabang_eskul }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 flex gap-2">
                        <!-- Delete ke ketuaeskul.destroy -->
                        <form action="{{ route('ketuaeskul.destroy', $ketua->identity) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus Ketua Eskul ini?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Belum ada Ketua Eskul yang terdaftar.</p>
    @endif
</div>
    </div>
@endif
    <!-- Daftar Pelatih Eskul -->
<div x-show="showForm === 'lihatEskul'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-6">

    <!-- Form Tambah Pelatih -->
    <div class="flex-1">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pelatih Baru</h1>

            <!-- Full Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="mb-4 hidden">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="eskul" selected>Pelatih Eskul</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Cabang Eskul -->
            <div class="mb-4">
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

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Daftar Pelatih -->
    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Pelatih Ekstrakurikuler</h2>

        @php
            $pelatihs = \App\Models\User::where('role', 'eskul')->get();
        @endphp

        @if ($pelatihs->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($pelatihs as $pelatih)
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 shadow hover:shadow-lg transition relative">
                        <div class="text-lg font-semibold text-gray-800">{{ $pelatih->name }}</div>
                        <div class="text-sm text-gray-600">{{ $pelatih->email }}</div>
                        <div class="text-sm text-purple-700">
                            Cabang: {{ $pelatih->cabang_eskul ?? '-' }}
                        </div>

                        <!-- Edit -->
                        <form method="GET" action="{{ route('user.edit') }}" class="mt-4 inline-block">
                            <input type="hidden" name="id" value="{{ $pelatih->id }}">
                            <input type="hidden" name="name" value="{{ $pelatih->name }}">
                            <input type="hidden" name="email" value="{{ $pelatih->email }}">
                            <input type="hidden" name="role" value="{{ $pelatih->role }}">
                            <input type="hidden" name="cabang_eskul" value="{{ $pelatih->cabang_eskul }}">
                            <button type="submit"
                                class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Edit
                            </button>
                        </form>

                        <!-- Delete -->
                        <form action="{{ route('pelatih.destroy', $pelatih->email) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus pelatih ini?');"
                              class="mt-2 inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada pelatih ekstrakurikuler yang terdaftar.</p>
        @endif
    </div>
</div>


</div>
        </main>
</div>