<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
      if (Auth::user()->role == 'siswa' || 'guru' || 'ketua_eskul'){
        if (Auth::user()->role == 'guru'){
        $now = Carbon::now()->format('Y-m-d H');
        $double_absent_check = Absensi::where('name', $request->name)->where('created_at', 'like', '%'. $now .'%')->Exists();
        }
        if (Auth::user()->role == 'siswa' || Auth::user()->role == 'ketua_eskul'){
        $now = Carbon::now()->format('Y-m-d H:i');
        $double_absent_check = Absensi::where('name', $request->name)->where('created_at', 'like', '%'. $now .'%')->Exists();
        }

        if (!$double_absent_check){
        $request->validate([
            'identity' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'kelas' => ['nullable', 'string' ,'required_if:role, siswa, ketua_eskul'],
            'jurusan' => ['nullable', 'string',  'required_if:role, siswa, ketua_eskul'],
            'role' => ['required', 'string', 'max:255'],
        ]);

        Absensi::create([
            'identity' => $request->identity,
            'name' => $request->name,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'role' => $request->role,
        ]);

        return redirect()->to('/dashboard')->with('notification', [
        'type' => 'success',
        'message' => 'Absensi berhasil',
        ]);
       }
       else{
         return redirect()->to('/dashboard')->with('notification', [
           'type' => 'error',
           'message' => 'Kamu sudah absensi',
         ]);
       }
      }
      else{
        return redirect()->to('/dashboard');
      }
    }
}
