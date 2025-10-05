<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Only pembina & admin can register users
        if (!in_array(Auth::user()->role, ['pembina', 'admin'])) {
            return redirect()->to('/dashboard');
        }

        // Validate input
$request->validate([
    'identity'      => ['nullable', 'required_if:role,guru,siswa,ketua_eskul', 'integer'],
    'name'          => ['required', 'string', 'max:255'],
    'email'         => ['required', 'string', 'lowercase', 'email', 'max:255'],
    'kelas'         => ['nullable', 'required_if:role,siswa,ketua_eskul', 'string', 'max:255'],
    'jurusan'       => ['nullable', 'required_if:role,siswa,ketua_eskul', 'string', 'max:255'],
    
    // password hanya wajib kalau role-nya bukan "ketua_eskul"
    'password'      => [
        'nullable', // boleh kosong
        'required_unless:role,ketua_eskul', 
        'confirmed',
        Rules\Password::defaults()
    ],

    'role'          => ['required', 'string'],
    'tanggal_tugas' => ['nullable', 'required_if:role,guru', 'string'],
    'cabang_eskul'  => ['nullable', 'required_if:role,eskul,ketua_eskul', 'string'],
]);



if ($request->role == 'ketua_eskul' && $request->filled('identity')) {
            $siswa = User::where('identity', $request->identity)
                        ->where('role', 'siswa')
                        ->first();
            if ($siswa) {
                // Pastikan cabang eskul belum ada ketuanya
                $ketuaExists = User::where('cabang_eskul', $request->cabang_eskul)
                                    ->where('role', 'ketua_eskul')
                                    ->exists();
                if ($ketuaExists) {
                    return $this->errorRedirect('Ketua Eskul untuk cabang ini sudah ada.');
                }

                // Upgrade siswa → ketua_eskul
                $siswa->update([
                    'role'         => 'ketua_eskul',
                    'cabang_eskul' => $request->cabang_eskul,
                ]);

                return $this->successRedirect();
            }
        }


        // Role groups
        $noIdentityRoles    = ['admin', 'pembina', 'eskul'];
        $needsIdentityRoles = ['guru', 'siswa', 'ketua_eskul'];

        // Uniqueness checks
        $identityExists = User::where('identity', $request->identity)->exists();
        $nameExists     = User::where('name', $request->name)->exists();
        $emailExists    = User::where('email', $request->email)->exists();
        $ketuaeskulExists = User::where('cabang_eskul', $request->cabang_eskul)->where('role', 'ketua_eskul')->exists();

        if ($nameExists) {
            return $this->errorRedirect('Name tidak tersedia.');
        }

        if ($emailExists) {
            return $this->errorRedirect('Email tidak tersedia.');
        }

        if ($ketuaeskulExists) {
            return $this->errorRedirect('Ketua Eskul sudah ada sebelumnya');
        }

        // Case 1: Roles that don't require identity
        if (in_array($request->role, $noIdentityRoles)) {
            $user = $this->createUser($request);
            return $this->successRedirect();
        }

        // Case 2: Roles that DO require identity
        if (in_array($request->role, $needsIdentityRoles)) {
            if ($identityExists) {
                return $this->errorRedirect('NIS/NIP sudah ada sebelumnya');
            }

            if (!$request->filled('identity')) {
                return $this->errorRedirect('Untuk siswa, ketua eskul dan guru harus menggunakan identitas (NIS/NIP)');
            }

            $user = $this->createUser($request);
            event(new Registered($user));
            return $this->successRedirect();
        }

        // Fallback
        return $this->errorRedirect('Data Register tidak lengkap (corrupt)');
    }

    /**
     * Create a new user instance.
     */
    private function createUser(Request $request): User
    {
        return User::create([
            'picture'       => '/storage/profile/profile.jpg',
            'identity'      => $request->identity,
            'name'          => $request->name,
            'email'         => $request->email,
            'kelas'         => $request->kelas,
            'jurusan'       => $request->jurusan,
            'password'      => Hash::make($request->password),
            'role'          => $request->role,
            'tanggal_tugas' => $request->tanggal_tugas,
            'cabang_eskul'  => in_array($request->role, ['eskul', 'ketua_eskul']) ? $request->cabang_eskul : null,
        ]);
    }

    /**
     * Redirect success with notification.
     */
    private function successRedirect(): RedirectResponse
    {
        return redirect()->to('/dashboard')->with('notification', [
            'type'    => 'success',
            'message' => 'Data berhasil di masukan',
        ]);
    }

    /**
     * Redirect error with notification.
     */
    private function errorRedirect(string $message): RedirectResponse
    {
        return redirect()->to('/dashboard')->with('notification', [
            'type'    => 'error',
            'message' => $message,
        ]);
    }
}
