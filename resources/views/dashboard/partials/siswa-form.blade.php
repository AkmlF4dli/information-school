@php
    // Fetch all student ABSENCES (leave requests) to pass to Alpine.js
    // Corrected to fetch Absensi records, not general User records.
    $siswaIzin = \App\Models\User::where('role', 'siswa')->orWhere('role', 'ketua_eskul')->get();
@endphp

<div 
    x-data="{
        izinData: @js($siswaIzin), // Data dari controller (siswa + ketua_eskul)
        searchQuery: '',
        filteredList: [],
        init() {
            // Tampilkan semua data dengan role siswa atau ketua_eskul saat awal
            this.filteredList = this.izinData.filter(item => 
                item.role === 'siswa' || item.role === 'ketua_eskul'
            );
        },
        searchList() {
            const query = this.searchQuery.toLowerCase();
            
            // Filter by name + role siswa/ketua_eskul
            this.filteredList = this.izinData.filter(item => {
                const nameMatch = item.name && item.name.toLowerCase().includes(query);
                const roleMatch = (item.role === 'siswa' || item.role === 'ketua_eskul');
                
                return roleMatch && nameMatch;
            });
        }
    }" 
    x-show="showForm === 'izinSiswa'" 
    x-transition 
    class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-12"
>
    <!-- LEFT COLUMN: Search Bar and Form Pengajuan Izin Siswa -->
    <div class="flex-1">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Pengajuan Izin Siswa</h1>

        <!-- Search Bar (ON THE LEFT) -->
        <div class="mb-6">
            <x-text-input 
                x-model="searchQuery" 
                x-on:input.debounce.300="searchList" 
                class="block w-full" 
                type="text" 
                placeholder="Cari Siswa berdasarkan Nama..." 
            />
        </div>
        
        <template x-if="filteredList.length > 0">
        @if (count($siswaIzin) > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach ($siswaIzin as $izin)
<!-- Card Form Izin Siswa -->
<div class="max-w-md bg-white rounded-xl shadow p-5 border border-gray-100">
    <form action="{{ route('siswa.izin.store') }}" method="POST" class="space-y-3">
        @csrf

        <!-- Hidden Fields -->
        <input type="hidden" name="name" value="{{ old('name', $izin->name ?? '') }}">
        <input type="hidden" name="identity" value="{{ old('identity', $izin->identity ?? '') }}">
        <input type="hidden" name="email" value="{{ old('email', $izin->email ?? '') }}">
        <input type="hidden" name="kelas" value="{{ old('kelas', $izin->kelas ?? '') }}">
        <input type="hidden" name="jurusan" value="{{ old('jurusan', $izin->jurusan ?? '') }}">
        <input type="hidden" name="role" value="{{ old('role', $izin->role ?? '') }}">
        <input type="hidden" name="tanggal_tugas" value="{{ old('tanggal_tugas', $izin->tanggal_tugas ?? '')}}">

        <!-- Info Ringkas -->
        <div class="text-sm text-gray-700 space-y-0.5">
            <p><span class="font-medium"><b>Nama:</b></span> {{ $izin->name ?? '-' }}</p>
            <p><span class="font-medium"><b>NISN:</b></span> {{ $izin->identity ?? '-' }}</p>
            <p><span class="font-medium"><b>Kelas:</b></span> {{ $izin->kelas ?? '-' }}</p>
            <p><span class="font-medium"><b>Jurusan:</b></span> {{ $izin->jurusan ?? '-' }}</p>
        </div>

        <!-- Mata Pelajaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <textarea name="mata_pelajaran" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none"
                      placeholder="Tuliskan Mata pelajaran saat  izin...">{{ old('alasan', $izin->mata_pelajaran ?? '') }}</textarea>
        </div>
        
        <!-- Jam Pelajaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Pelajaran</label>
            <input type="text" name="jam_pelajaran"
                   value="{{ old('jam_pelajaran', $izin->jam_pelajaran ?? '') }}"
                   min="1" max="10"
                   class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none"
                   placeholder="Contoh: 1-2, 3-4">
        </div>

        <!-- Alasan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
            <textarea name="alasan" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none"
                      placeholder="Tuliskan alasan izin...">{{ old('alasan', $izin->alasan ?? '') }}</textarea>
        </div>

        <!-- Tombol -->
        <div class="flex gap-2">
            <a href="{{ url()->previous() }}"
               class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg border text-sm hover:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm shadow hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endforeach
        @else
            <p class="text-gray-600">Belum ada pengajuan izin siswa yang tercatat hari ini.</p>
        @endif
    </template>

                <!-- No data message -->
        <template x-if="filteredList.length === 0">
            <p class="text-gray-600">
                <span x-show="searchQuery.length > 0">Tidak ditemukan pengajuan izin siswa dengan nama tersebut.</span>
                <span x-show="searchQuery.length === 0">Belum ada pengajuan izin siswa yang tercatat hari ini.</span>
            </p>
        </template>
    </div>
        <!-- End Search Bar -->
         
    <!-- Daftar Izin Siswa -->
    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Izin Siswa Hari Ini</h2>

        @php
            $siswaIzinList = \App\Models\Absensi::where('role', 'siswa')->orWhere('role', 'ketua_eskul')->get();
        @endphp

        @if (count($siswaIzinList) > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach ($siswaIzinList as $izin)
                   @if (isset($izin->role) != NULL)
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow hover:shadow-lg transition">
                        <div class="font-bold text-gray-800">{{ $izin->name }} (NISN: {{ $izin->identity }})</div>
                        <div class="text-sm text-green-700">Kelas: {{ $izin->kelas ?? '-' }} / Jurusan: {{ $izin->jurusan ?? '-' }}</div>
                        <div class="text-sm text-gray-600 mt-1">
                            <span class="font-semibold">Tanggal:</span> {{ $izin->created_at }}
                        </div>
                        <div class="text-sm text-gray-600 italic truncate" title="{{ $izin->alasan_izin }}">
                            Alasan: "{{ $izin->alasan_izin }}"
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex gap-2">

                            <!-- Delete -->
                            <form action="{{ route('siswa.izin.destroy', $izin->identity) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data izin ini?');"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada pengajuan izin siswa yang tercatat hari ini.</p>
        @endif
     </div>
  </div>
</div>