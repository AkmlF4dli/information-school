<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserController extends Controller
{
    public function update(Request $request, $id): RedirectResponse
    {
        // Cari user berdasarkan identity
        $user = User::where('identity', $id)->first();
        
        if (!$user) {
            return redirect()->to('/dashboard')->with('notification', [
                'type' => 'error',
                'message' => 'User tidak ditemukan',
            ]);
        }

        // Validasi sesuai role
        if (Auth::user()->role == "admin") {
            $validated = $request->validate([
                'identity'      => ['required', 'integer'],
                'name'          => ['required', 'string', 'max:255'],
                'email'         => ['required', 'email', 'max:255'],
                'role'          => ['required', 'string'],
                'cabang_eskul'  => ['nullable', 'string', 'max:255'],
                'tanggal_tugas' => ['nullable', 'string'],
            ]);
        } elseif (Auth::user()->role == "pembina") {
            $rules = [
                'name'         => ['required', 'string', 'max:255'],
                'email'        => ['required', 'email', 'max:255'],
                'role'         => ['required', 'string'],
                'cabang_eskul' => ['nullable', 'string', 'max:255'],
            ];

            if ($request->input('role') == "ketua_eskul") {
                $rules['identity'] = ['required', 'integer'];
            }

            $validated = $request->validate($rules);
        } else {
            return redirect()->to('/dashboard')->with('notification', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengupdate data',
            ]);
        }

        try {
            $user->update($validated);

            return redirect()->to('/dashboard')->with('notification', [
                'type' => 'success',
                'message' => 'Berhasil mengganti data',
            ]);
        } catch (\Exception $e) {
            return redirect()->to('/dashboard')->with('notification', [
                'type' => 'error',
                'message' => 'Gagal mengganti data: ' . $e->getMessage(),
            ]);
        }
    }
}
