<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function destroy($id)
    {
        if (Auth::user()->role == 'admin'){
        $guru = User::where('identity', $id);
        $guru->delete();
        
        return redirect()->back()->with('notification', [
        'type' => 'success',
        'message' => 'Guru successfully Deleted'
        ]);
        }
        else{
        return redirect()->back()->with('notification', [
         'type' => 'success',
         'message' => 'Who are You??'
        ]); 
        }
    }

}
