<!-- Halaman Untuk Guru Piket -->

@php
    // Fetch all Guru (teachers) data
    $guruIzin = \App\Models\User::where('role', 'guru')->get();
@endphp

<div x-data="{
    izinData: @js($guruIzin), 
    searchQuery: '',
    filteredList: [],
    init() {
        this.filteredList = this.izinData.filter(item => item.role === 'guru');
    },
    searchList() {
        const query = this.searchQuery.toLowerCase();
        this.filteredList = this.izinData.filter(item => {
            const nameMatch = item.name && item.name.toLowerCase().includes(query);
            const roleMatch = item.role === 'guru';
            return roleMatch && nameMatch;
        });
    }
}" x-show="showForm === 'izinGuru'" x-transition class="bg-white p-6 rounded-xl shadow max-w-6xl mt-6 flex gap-12">

    <!-- LEFT COLUMN -->
    <div class="flex-1">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Pengajuan Izin Guru</h1>

        <!-- Search Bar -->
        <div class="mb-6">
            <x-text-input 
                x-model="searchQuery" 
                x-on:input.debounce.300="searchList" 
                class="block w-full" 
                type="text" 
                placeholder="Cari Guru berdasarkan Nama..." 
            />
        </div>
        
        <template x-if="filteredList.length > 0">
        @if (count($guruIzin) > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach ($guruIzin as $izin)
<!-- Card Form Izin Guru -->
<div class="max-w-md bg-white rounded-xl shadow p-5 border border-gray-100">
    <form action="{{ route('guru.izin.store') }}" method="POST" class="space-y-3">
        @csrf

        <!-- Hidden Fields -->
        <input type="hidden" name="name" value="{{ old('name', $izin->name ?? '') }}">
        <input type="hidden" name="identity" value="{{ old('identity', $izin->identity ?? '') }}">
        <input type="hidden" name="email" value="{{ old('email', $izin->email ?? '') }}">
        <input type="hidden" name="role" value="{{ old('role', $izin->role ?? '') }}">
        <input type="hidden" name="tanggal_tugas" value="{{ old('tanggal_tugas', $izin->tanggal_tugas ?? now()->translatedFormat('l')) }}">

        <!-- Info Ringkas -->
        <div class="text-sm text-gray-700 space-y-0.5">
            <p><span class="font-medium"><b>Nama:</b></span> {{ $izin->name ?? '-' }}</p>
            <p><span class="font-medium"><b>NIP:</b></span> {{ $izin->identity ?? '-' }}</p>
            <p><span class="font-medium"><b>Email:</b></span> {{ $izin->email ?? '-' }}</p>
        </div>

        <!-- Mata Pelajaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <textarea name="mata_pelajaran" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none"
                      placeholder="Tuliskan Mata pelajaran saat  izin..." require>{{ old('alasan', $izin->mata_pelajaran ?? '') }}</textarea>
        </div>

        <!-- Jam Pelajaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Pelajaran</label>
            <input type="number" name="jam_pelajaran"
                   value="{{ old('jam_pelajaran', $izin->jam_pelajaran ?? '') }}"
                   min="1" max="10"
                   class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none"
                   placeholder="Contoh: 1-2, 3-4" require>
        </div>

        <!-- Alasan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
            <textarea name="alasan" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none"
                      placeholder="Tuliskan alasan izin..." require>{{ old('alasan', $izin->alasan ?? '') }}</textarea>
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
            <p class="text-gray-600">Belum ada pengajuan izin guru yang tercatat hari ini.</p>
        @endif
    </template>

        <!-- No data message -->
        <template x-if="filteredList.length === 0">
            <p class="text-gray-600">
                <span x-show="searchQuery.length > 0">Tidak ditemukan pengajuan izin guru dengan nama tersebut.</span>
                <span x-show="searchQuery.length === 0">Belum ada pengajuan izin guru yang tercatat hari ini.</span>
            </p>
        </template>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="flex-1">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Daftar Izin Guru Hari Ini</h2>

        @php
            $guruIzinList = \App\Models\Absensi::where('role', 'guru')->get();
        @endphp

        @if (count($guruIzinList) > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach ($guruIzinList as $izin)
                   @if (isset($izin->role) != NULL && isset($izin->alasan_izin) != NULL)
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow hover:shadow-lg transition">
                        <div class="font-bold text-gray-800">{{ $izin->name }} (NIP: {{ $izin->identity }})</div>
                        <div class="text-sm text-green-700">Mapel: {{ $izin->mapel ?? '-' }}</div>
                        <div class="text-sm text-gray-600 mt-1">
                            <span class="font-semibold">Tanggal:</span> {{ $izin->created_at }}
                        </div>
                        <div class="text-sm text-gray-600"><span class="font-semibold">Jam Pelajaran:</span> {{ $izin->jam_pelajaran ?? '-' }}</div>
                        <div class="text-sm text-gray-600 italic truncate" title="{{ $izin->alasan_izin }}">
                            Alasan: "{{ $izin->alasan_izin }}"
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex gap-2">
                            <form action="{{ route('guru.izin.destroy', $izin->identity) }}" method="POST"
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
            <p class="text-gray-600">Belum ada pengajuan izin guru yang tercatat hari ini.</p>
        @endif
     </div>
</div>