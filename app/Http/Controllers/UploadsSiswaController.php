<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UploadsSiswaController extends Controller
{
    
    public function searchSiswa(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $siswa = User::where('role', 'siswa')
            ->where(function ($q) use ($query) {
                // Mencari berdasarkan nama, email, atau identity (NISN)
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('identity', 'like', "%{$query}%");
            })
            // Batasi hasil untuk performa
            ->limit(10) 
            // Pilih kolom yang dibutuhkan
            ->get([
                'id', 
                'name', 
                'email', 
                'identity', 
                'kelas', 
                'jurusan' // Sesuaikan dengan kolom Anda
            ]);

        return response()->json($siswa);
    }

    public function searchGuru(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $siswa = User::where('role', 'guru')
            ->where(function ($q) use ($query) {
                // Mencari berdasarkan nama, email, atau identity (NISN)
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('identity', 'like', "%{$query}%");
            })
            // Batasi hasil untuk performa
            ->limit(10) 
            // Pilih kolom yang dibutuhkan
            ->get([
                'id', 
                'name', 
                'email', 
                'identity',
                'role',
                'tanggal_tugas',
            ]);

        return response()->json($siswa);
    }


    public function store(Request $request){

    }
}
