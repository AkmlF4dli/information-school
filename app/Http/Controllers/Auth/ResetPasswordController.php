<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function create()
    {
        return view('auth.resetpassword');
    }

    public function store(Request $request)
    {
        $email = $request->request->get('email');
        $user = User::where('email', $email)->first();

        if (isset($user->password) != ""){
$response = Http::withHeaders([
            'api-key' => env('API_SENDINBLUE'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Educated',
                'email' => 'majormr64@gmail.com',
            ],
            'to' => [
                ['email' => $email , 'name' => 'Educated']
            ],
            'subject' => 'Test Email via API',
            'htmlContent' => '<h1>Hello from Laravel</h1><a href="http://localhost:8000/password-reset/'. $user->password . '">Reset Password</a>',
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'Email sent!']);
        } else {
            return response()->json(['error' => 'Failed to send email', 'details' => $response->json()], 500);
        }
        }
        else{
            return view('auth.failed');
        }

    }

public function resetpass($data)
{

    $password = User::where('password', $data)->first();

    if (isset($password->password) != "") {
        return view('auth.resetform', ['email' => $password->email]);
    } else {
        return view('auth.failed'); // atau redirect ke halaman error
    }
}

public function resetpassfeedback(Request $request)
{
    $oldPassword = $request->query('oldpassword'); 
    $newPassword = $request->query('newpassword');   

    $password = User::where('password', $oldPassword)->first();

    if (isset($password->password) != "")
    {

    $password->password = Hash::make($newPassword);
    $password->save();
    return redirect()->to('/');

    }
    else{
        return view('auth.failed');
    }
}

}
