<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Eskul;
use App\Models\Events;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        // ✅ Validate the input (optional but recommended)
        $validated = $request->validate([
            'tanggal' => ['nullable', 'date'],
        ]);

        // Ambil tanggal dari input atau default hari ini
        $tanggal = $validated['tanggal'] ?? now()->toDateString();

        // Total siswa & guru
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru  = User::where('role', 'guru')->count();

        // Data izin berdasarkan tanggal
        $siswaIzin = Absensi::where('role', 'siswa')
            ->whereNotNull('alasan_izin')
            ->whereDate('created_at', $tanggal)
            ->get();

        $guruIzin = Absensi::where('role', 'guru')
            ->whereNotNull('alasan_izin')
            ->whereDate('created_at', $tanggal)
            ->get();

        // Kirim ke view
        return view('dashboard', compact(
            'tanggal',
            'totalSiswa',
            'totalGuru',
            'siswaIzin',
            'guruIzin'
        ));
    }

    // Authorize by Admin
    public function gurudestroy($id)
    {
        if (Auth::user()->role == 'admin'){
        $guru = User::where('identity', $id);
        $guru->delete();
        
        return redirect()->back()->with('notification', [
        'type' => 'success',
        'message' => 'Guru berhasil dihapus'
        ]);
        }
        else{
        return redirect()->back()->with('notification', [
         'type' => 'success',
         'message' => 'Who are You??'
        ]); 
        }
    }

    public function pembinadestroy($email)
    {
        if (Auth::user()->role == 'admin'){
        $pembina = User::where('email', $email);
        $pembina->delete();
        
        return redirect()->back()->with('notification', [
        'type' => 'success',
        'message' => 'Pembina berhasil dihapus'
        ]);
        }
        else{
        return redirect()->back()->with('notification', [
         'type' => 'success',
         'message' => 'Who are You??'
        ]); 
        }
    }

    public function siswadestroy($id)
    {
        if (Auth::user()->role == 'admin'){
        $siswa = User::where('identity', $id);
        $siswa->delete();
        
        return redirect()->back()->with('notification', [
        'type' => 'success',
        'message' => 'Guru berhasil dihapus'
        ]);
        }
        else{
        return redirect()->back()->with('notification', [
         'type' => 'success',
         'message' => 'Who are You??'
        ]); 
        }
    }
    // Authorize by Pembina

public function ketuaeskuldestroy($id)
{
    if (Auth::user()->role === 'pembina') {
        $ketuaeskul = User::where('identity', $id)->where('role', 'ketua_eskul')->first();

        if ($ketuaeskul) {
            // Ubah role kembali ke siswa
            $ketuaeskul->update([
                'role' => 'siswa',
                'cabang_eskul' => null, // optional: hapus cabang supaya clear
            ]);

            return redirect()->back()->with('notification', [
                'type'    => 'success',
                'message' => 'Ketua Eskul berhasil diturunkan menjadi Siswa.',
            ]);
        }

        return redirect()->back()->with('notification', [
            'type'    => 'error',
            'message' => 'Data Ketua Eskul tidak ditemukan.',
        ]);
    }

    return redirect()->back()->with('notification', [
        'type'    => 'error',
        'message' => 'Who are You??',
    ]);
}

    public function pelatihdestroy($identity)
    {
        if (Auth::user()->role == 'pembina'){
        $guru = User::where('identity', $identity)->delete();
        
        return redirect()->back()->with('notification', [
        'type' => 'success',
        'message' => 'Pelatih berhasil dihapus'
        ]);
        }
        else{
        return redirect()->back()->with('notification', [
         'type' => 'success',
         'message' => 'Who are You??'
        ]); 
        }
    }
    
    // Authorize by Guru Piket

    public function siswaIzindestroy($id)
    {
        if (Auth::user()->role == 'guru'){
        $ketuaeskul = Absensi::where('identity', $id);
        $ketuaeskul->delete();
        
        return redirect()->back()->with('notification', [
        'type' => 'success',
        'message' => 'Siswa berhasil dihapus'
        ]);
        }
        else{
        return redirect()->back()->with('notification', [
         'type' => 'success',
         'message' => 'Who are You??'
        ]); 
        }
    }

    public function siswaIzinstore(Request $request)
    {
        if (Auth::user()->role == 'guru')
        {
        $now = Carbon::now()->format('Y-m-d');
        $double_absent_check = Absensi::where('name', $request->name)->where('created_at', 'like', '%'. $now .'%')->where("input_by", Auth::user()->name)->Exists();

        if ($double_absent_check)
        {
            if ($double_absent_check)
            return $this->errorRedirect();
        }

        $request->validate([
            'identity'      => ['nullable', 'required_if:role,guru,siswa,ketua_eskul', 'integer'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'kelas'         => ['nullable', 'required_if:role,siswa,ketua_eskul', 'string', 'max:255'],
            'jurusan'       => ['nullable', 'required_if:role,siswa,ketua_eskul', 'string', 'max:255'],
            'role'          => ['required', 'string'],
            'mata_pelajaran'=> ['nullable', 'required_if:alasan_izin,sakit, Sakit, SAKIT, alpa, Alpa, ALPA', 'string'],
            'jam_pelajaran' => ['nullable', 'required_if:alasan_izin,sakit, Sakit, SAKIT, alpa, Alpa, ALPA', 'string', 'max:255'],
            'alasan_izin'   => ['nullable', 'string'],
            'tanggal_tugas' => ['nullable', 'required_if:role,guru', 'string'],
        ]);

        $user = $this->createUser($request);
        return $this->successRedirect();
        
        }
        else{
          return redirect()->back()->with('notification', [
           'type' => 'success',
           'message' => 'Who are You??'
          ]); 
        }
    }

    private function createUser(Request $request) : Absensi
    {
        return Absensi::create([
            'identity'        => $request->identity,
            'name'            => $request->name,
            'email'           => $request->email,
            'kelas'           => $request->kelas ?? null,
            'jurusan'         => $request->jurusan ?? null,
            'alasan'          => $request->alasan,
            'role'            => $request->role,
            'mata_pelajaran'  => $request->mata_pelajaran ?? null,
            'jam_pelajaran'   => $request->jam_pelajaran ?? null,
            'alasan_izin'     => $request->alasan,
            'tanggal_tugas'   => $request->tanggal_tugas,
        ]);
    }


    public function guruIzindestroy($id)
    {
        if (Auth::user()->role == 'guru'){
        $ketuaeskul = Absensi::where('identity', $id);
        $ketuaeskul->delete();
        
        return redirect()->back()->with('notification', [
        'type' => 'success',
        'message' => 'Guru berhasil dihapus'    
        ]);
        }
        else{
        return redirect()->back()->with('notification', [
         'type' => 'success',
         'message' => 'Who are You??'
        ]); 
        }
    }

    public function guruIzinstore(Request $request)
    {
        if (Auth::user()->role == 'guru')
        {
            if (Auth::user()->identity == $request->identity)
            {
                return redirect()->back()->with('notification', [
                  'type' => 'error',
                  'message' => 'Anda sudah absen'
               ]); 
            }
        $now = Carbon::now()->format('Y-m-d');
        $double_absent_check = Absensi::where('name', $request->name)->where('created_at', 'like', '%'. $now .'%')->Exists();

        if ($double_absent_check)
        {
            return $this->errorRedirect();
        }

        $request->validate([
            'identity'      => ['nullable', 'required_if:role,guru,siswa,ketua_eskul', 'integer'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'kelas'         => ['nullable', 'required_if:role,siswa,ketua_eskul', 'string', 'max:255'],
            'jurusan'       => ['nullable', 'required_if:role,siswa,ketua_eskul', 'string', 'max:255'],
            'role'          => ['required', 'string'],
            'mata_pelajaran'=> ['nullable', 'required_if:alasan_izin,sakit, Sakit, SAKIT, alpa, Alpa, ALPA', 'string'],
            'jam_pelajaran' => ['nullable', 'required_if:alasan_izin,sakit, Sakit, SAKIT, alpa, Alpa, ALPA', 'string', 'max:255'],
            'alasan_izin'   => ['nullable', 'string'],
            'tanggal_tugas' => ['nullable', 'required_if:role,guru', 'string'],
        ]);

        $user = $this->createUser($request);
        return $this->successRedirect();
        
        }
        else{
          return redirect()->back()->with('notification', [
           'type' => 'error',
           'message' => 'Who are You??'
          ]); 
        }
    }

    // Authorize by Siswa

public function lihatEskul(Request $request)
{
    $cabangList = ['Futsal', 'Basket', 'Pramuka', 'Paskibra'];

    // ambil parameter ?cabang=... dari URL
    $cabang = $request->query('cabang');

    // cek apakah cabang ada di daftar
    if (in_array($cabang, $cabangList)) {
        // ambil event sesuai cabang
        $events = \App\Models\Events::where('cabang_eskul', $cabang)->get();
    } else {
        // kalau tidak ada, ambil semua event
        $events = \App\Models\Events::all();
    }

    // kirim ke view
    return view('eskul.index', compact('events', 'cabangList', 'cabang'));
}

public function daftarEskul(Request $request, $cabang)
{
    $user = Auth::user(); // ambil user yang login

    // Cek apakah cabang sudah pernah dipilih
    if (
        $user->cabang_eskul === $cabang ||
        $user->cabang_eskul2 === $cabang ||
        $user->cabang_eskul3 === $cabang
    ) {
        return redirect()->back()->with('error', "Kamu sudah terdaftar di Eskul $cabang.");
    }

    // Hitung slot yang sudah terisi
    $eskulCount = 0;
    if ($user->cabang_eskul)  $eskulCount++;
    if ($user->cabang_eskul2) $eskulCount++;
    if ($user->cabang_eskul3) $eskulCount++;

    // Batas maksimal
    if ($eskulCount >= 3) {
        return redirect()->back()->with('error', 'Kamu sudah mencapai batas maksimal 3 eskul.');
    }

    // Masukkan cabang ke slot kosong
    if (!$user->cabang_eskul) {
        $user->cabang_eskul = $cabang;
    } elseif (!$user->cabang_eskul2) {
        $user->cabang_eskul2 = $cabang;
    } elseif (!$user->cabang_eskul3) {
        $user->cabang_eskul3 = $cabang;
    }

    // Simpan ke database
    $user->save();

    return redirect()->back()->with('success', "Kamu berhasil mendaftar Eskul $cabang!");
}

public function hapusEskul($cabang)
{
    $user = Auth::user();

    // Cek dan hapus jika cabang cocok
    if ($user->cabang_eskul === $cabang) {
        $user->cabang_eskul = null;
    } elseif ($user->cabang_eskul2 === $cabang) {
        $user->cabang_eskul2 = null;
    } elseif ($user->cabang_eskul3 === $cabang) {
        $user->cabang_eskul3 = null;
    } else {
        return redirect()->back()->with('error', "Kamu tidak terdaftar di Eskul $cabang.");
    }

    $user->save();

    return redirect()->back()->with('success', "Kamu berhasil keluar dari Eskul $cabang.");
}


    // Authorize by Pelatih

     public function storemateri(Request $request)
    {
        if (Auth::user()->role == "eskul")
        {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'cabang_eskul' => 'required|string',
        ]);

        // Simpan ke database
        Events::create([
            'title' => $request->title,
            'deskripsi' => $request->deskripsi,
            'cabang_eskul' => $request->cabang_eskul,
            'upload_by' => Auth::user()->name, // otomatis dari user login
        ]);

        return $this->successRedirect();
        }
    }



    public function materieskul($cabang, $title)
    {
        $data = Events::where('cabang_eskul', $cabang)->where('title', $title)->get();
        return view('eskul.materi', compact('data'));
    }
    

public function addeskul(Request $request)
{
    if (Auth::user()->role == "admin") {
        $request->validate([
            'cabang_eskul' => 'required|string|max:255',
            'hari' => 'required|string|max:255',
            'waktu' => 'required|date_format:H:i',
            'tempat' => 'required|string|max:255',
            'identity' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'identitydua' => 'required|integer',
            'namedua' => 'required|string|max:255',
            'emaildua' => 'required|string|max:255',
            'passworddua' => 'required|string|max:255',
            'roledua' => 'required|string|max:255',
        ]);


        if ($request->identity == $request->identitydua)
        {
            if ($request->name == $request->namedua)
            {
                if ($request->email == $request->emaildua)
                {
                   return $this->errorRedirect();
                }
            }
        }

        $check = User::where('identity', $request->identity)->where('name', $request->name)->where('email', $request->email)->exists();

        $check2 = User::where('identity', $request->identity2)->where('name', $request->name2)->where('email', $request->email2)->exists();

        if ($check && $check2){
            return $this->errorRedirect();
        }

        Eskul::create([
            'cabang_eskul' => $request->cabang_eskul,
            'hari' => $request->hari,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
        ]);

        User::create([
            'picture' => '/storage/profile/profile.jpg',
            'identity' => $request->identity,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'cabang_eskul' => $request->cabang_eskul,
        ]);

        User::create([
            'picture' => '/storage/profile/profile.jpg',
            'identity' => $request->identitydua,
            'name' => $request->namedua,
            'email' => $request->emaildua,
            'password' => Hash::make($request->passworddua),
            'role' => $request->roledua,
            'cabang_eskul' => $request->cabang_eskul,
        ]);

        return $this->successRedirect();
    }
}

public function deleteeskul(Request $request, $eskul)
{
    if (Auth::user()->role == "admin")
    {
      if (isset($eskul))
      {
        Eskul::where('cabang_eskul', $eskul)->delete();
        User::where('cabang_eskul', $eskul)->delete();
        User::where('cabang_eskul2', $eskul)->delete();
        User::where('cabang_eskul3', $eskul)->delete();

        return $this->successRedirect();

      }
    }
}

public function updateeskul(Request $request, $id)
{
    if (Auth::user()->role == "admin") {

        $request->validate([
            'cabang_eskul' => 'required|string|max:255',
            'hari' => 'required|string|max:255',
            'waktu' => 'required|date_format:H:i',
            'tempat' => 'required|string|max:255',
        ]);
        
        $eskul = Eskul::findOrFail($id);

        $eskul->update([
            'cabang_eskul' => $request->cabang_eskul,
            'hari' => $request->hari,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
        ]);

        return redirect()->back()->with('notification', [
            'type' => 'success',
            'message' => 'Jadwal eskul berhasil diperbarui!',
        ]);
    }

    return redirect()->back()->with('notification', [
        'type' => 'error',
        'message' => 'Anda tidak memiliki izin untuk mengupdate jadwal.',
    ]);
}


public function ajax(Request $request)
{
    $tanggal = $request->input('tanggal', now()->toDateString());

    $siswaIzin = Absensi::where('role', 'siswa')
        ->whereNotNull('alasan_izin')
        ->whereDate('created_at', $tanggal)
        ->get(['name', 'alasan_izin']);

    $guruIzin = Absensi::where('role', 'guru')
        ->whereNotNull('alasan_izin')
        ->whereDate('created_at', $tanggal)
        ->get(['name', 'alasan_izin']);

    return response()->json([
        'siswaIzin' => $siswaIzin,
        'guruIzin' => $guruIzin,
    ]);
}


    private function successRedirect()
    {
        return redirect()->to('/dashboard')->with('notification', [
            'type'    => 'success',
            'message' => 'Data berhasil di masukan.',
        ]);
    }

    private function errorRedirect()
    {
        return redirect()->to('/dashboard')->with('notification', [
            'type'    => 'error',
            'message' => 'Data sudah terdaftar',
        ]);
    }
}
