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
        if (Auth::user()->role == 'admin'){
        $request->validate([
            'identity' => ['nullable', 'required_if:role, guru, siswa, ketua_eskul', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
            'tanggal_tugas' => ['nullable', 'required_if:role,guru', 'string'],
            'cabang_eskul' => ['nullable', 'required_if:role,eskul, ketua_eskul', 'string'],
        ]);

        $user = User::where('identity', $request->identity)->exist();
        $name = User::where('name', $request->name)->exist();

        $pelatih = User::where('cabang_eskul', $request->cabang_eskul)->where('role', 'eskul')->count();
        $ketua = User::where('cabang_eskul', $request->cabang_eskul)->where('role', 'ketua_eskul')->count();
 
if ($request->role === 'eskul') {
    $pelatihExists = User::where('cabang_eskul', $request->cabang_eskul)
                         ->where('role', 'eskul')->exists();

    if ($pelatihExists) {
        return redirect()->to('/dashboard')->with('notification', [
            'type' => 'error',
            'message' => 'That Extracurricular Already has a Trainer.',
        ]);
    }
}

if ($request->role === 'ketua_eskul') {
    $ketuaExists = User::where('cabang_eskul', $request->cabang_eskul)
                       ->where('role', 'ketua_eskul')->exists();

    if ($ketuaExists) {
        return redirect()->to('/dashboard')->with('notification', [
            'type' => 'error',
            'message' => 'That Extracurricular Already has a Leader.',
        ]);
    }
}


        if (!isset($request->identity))
        {
            if($request->role == "admin" || $request->role == "pembina" || $request->role == "eskul"){
                if ($user == 0 && $name == 0){
        $user = User::create([
           'picture' => '/storage/profile/profile.jpg',
           'identity' => $request->identity,
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'role' => $request->role,
           'tanggal_tugas' => $request->tanggal_tugas ?? null,
           'cabang_eskul' => in_array($request->role, ['eskul', 'ketua_eskul']) ? $request->cabang_eskul : null,
        ]);
        }
        else{
            return redirect()->to('/dashboard')->with('notification', [
                'type' => 'error',  // atau 'error'
                'message' => 'Data Already Used'
            ]);
        }
            }
            if ($request->role == "murid" || $request->role == "ketua_eskul" || $request->role == "guru")
            {
                return redirect()->to('/dashboard')->with('notification', [
                'type' => 'error',  // atau 'error'
                'message' => 'For Student, Leader Extracurricular and Teacher need NIS/NIP'
            ]);
            }
        }


        if (!isset($user) && !isset($name)){
        $user = User::create([
           'picture' => '/storage/profile/profile.jpg',
           'identity' => $request->identity,
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'role' => $request->role,
           'tanggal_tugas' => $request->tanggal_tugas ?? null,
           'cabang_eskul' => in_array($request->role, ['eskul', 'ketua_eskul']) ? $request->cabang_eskul : null,
        ]);
        }
        else{
            return redirect()->to('/dashboard')->with('notification', [
                'type' => 'error',  // atau 'error'
                'message' => 'Data Already Used'
            ]);
        }


        event(new Registered($user));

        return redirect()->to('/dashboard')->with('notification', [
           'type' => 'success',  // atau 'error'
           'message' => 'Data Successfully Entry'
        ]);
        }
        else{
            return redirect()->to('/dashboard');
        }
    }
}
