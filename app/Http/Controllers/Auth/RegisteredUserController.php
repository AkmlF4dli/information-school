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
    if (Auth::user()->role != 'admin') {
        return redirect()->to('/dashboard');
    }

    // Validate input
    $request->validate([
        'identity' => ['nullable', 'required_if:role,guru,siswa,ketua_eskul', 'integer'],
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        'kelas' => ['nullable', 'required_if:role,siswa,ketua_eskul', 'string', 'max:255'],
        'jurusan' => ['nullable', 'required_if:role,siswa,ketua_eskul', 'string', 'max:255'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'string'],
        'tanggal_tugas' => ['nullable', 'required_if:role,guru', 'string'],
        'cabang_eskul' => ['nullable', 'required_if:role,eskul,ketua_eskul', 'string'],
    ]);

    // Uniqueness checks
    $identityExists = User::where('identity', $request->identity)->exists();
    $nameExists = User::where('name', $request->name)->exists();
    $emailExists = User::where('email', $request->email)->exists();

    if ($emailExists) {
        return redirect()->to('/dashboard')->with('notification', [
            'type' => 'error',
            'message' => 'Email is already used.',
        ]);
    }

    // Eskul-specific: only one trainer per extracurricular
    if ($request->role === 'eskul') {
        $trainerExists = User::where('cabang_eskul', $request->cabang_eskul)
                             ->where('role', 'eskul')->exists();
        if ($trainerExists) {
            return redirect()->to('/dashboard')->with('notification', [
                'type' => 'error',
                'message' => 'That extracurricular already has a trainer.',
            ]);
        }
    }

    // Ketua Eskul-specific: only one leader per extracurricular
    if ($request->role === 'ketua_eskul') {
        $leaderExists = User::where('cabang_eskul', $request->cabang_eskul)
                            ->where('role', 'ketua_eskul')->exists();
        if ($leaderExists) {
            return redirect()->to('/dashboard')->with('notification', [
                'type' => 'error',
                'message' => 'That extracurricular already has a leader.',
            ]);
        }
    }

    // Roles that do NOT require identity (NIS/NIP)
    $noIdentityRoles = ['admin', 'pembina', 'eskul'];
    $needsIdentityRoles = ['guru', 'siswa', 'ketua_eskul'];

    // Case 1: Roles that don't require identity
    if (in_array($request->role, $noIdentityRoles)) {
        if (!$nameExists && !$identityExists) {
            $user = $this->createUser($request);
            return $this->successRedirect();
        } else {
            return $this->errorRedirect('Data already used.');
        }
    }

    // Case 2: Roles that DO require identity (NIS/NIP)
    if (in_array($request->role, $needsIdentityRoles)) {
        if ($identityExists || $nameExists) {
            return $this->errorRedirect('Data already used.');
        }

        if (!$request->filled('identity')) {
            return $this->errorRedirect('For students, leaders, and teachers, identity (NIS/NIP) is required.');
        }

        $user = $this->createUser($request);
        event(new Registered($user));
        return $this->successRedirect();
    }

    // Fallback
    return $this->errorRedirect('Invalid registration data.');
}


private function createUser(Request $request): User
{
    return User::create([
        'picture' => '/storage/profile/profile.jpg',
        'identity' => $request->identity,
        'name' => $request->name,
        'email' => $request->email,
        'kelas' => $request->kelas,
        'jurusan' => $request->jurusan,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'tanggal_tugas' => $request->tanggal_tugas,
        'cabang_eskul' => in_array($request->role, ['eskul', 'ketua_eskul']) ? $request->cabang_eskul : null,
    ]);
}

private function successRedirect(): RedirectResponse
{
    return redirect()->to('/dashboard')->with('notification', [
        'type' => 'success',
        'message' => 'Data successfully entered.',
    ]);
}

private function errorRedirect(string $message): RedirectResponse
{
    return redirect()->to('/dashboard')->with('notification', [
        'type' => 'error',
        'message' => $message,
    ]);
}

}
