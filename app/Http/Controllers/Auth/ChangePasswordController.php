<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class ChangePasswordController extends Controller
{
    /**
     * Tampilkan form ubah password
     */
    public function edit()
    {
        return view('profile.change-password');
    }

    /**
     * Proses ubah password
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        // Simpan password baru
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password berhasil diubah.');
    }
}
