 <!-- Halaman untuk Pelatih Eskul -->

    {{-- Form Tambah Materi Eskul --}}
    <div x-show="showForm === 'TambahkanMateri'" class="mt-6">
        <form action="{{ route('events.store') }}" method="POST" class="space-y-4 bg-white shadow rounded-lg p-6">
            @csrf

            <div>
                <label class="block font-medium">Judul Materi</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
            </div>

            <input type="text" class="hidden" name="cabang_eskul" value="{{ Auth::user()->cabang_eskul }}"></input>

            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                <button type="button" @click="showForm = ''" class="px-4 py-2 border rounded">Batal</button>
            </div>
        </form>
    </div>