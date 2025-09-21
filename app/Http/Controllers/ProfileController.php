<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('picture')) {
            if (Auth::user()->picture == "/storage/picture/picture.jpg")
            {
             $file = Str::uuid() . "." . $request->file('picture')->getClientOriginalExtension();
             $path = $request->file('picture')->storeAs('/profile', $file, 'public');
             Auth::user()->picture = $path;
            }
            else{
                Storage::disk('public')->delete(Auth::user()->picture);
                $file = Str::uuid() . "." . $request->file('picture')->getClientOriginalExtension();
                $path = $request->file('picture')->storeAs('/profile', $file, 'public');
                Auth::user()->picture = $path;
            }
            $request->session()->regenerateToken();
        }


        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete Photo Profile
     */

    public function delete_picture(Request $request)
    {
        if (Auth::user()->picture == '/storage/profile/profile.jpg')
        {
            return redirect()->to('/myprofile');
        }
        else{
            $user = Auth::user();  // Get the logged-in user directly
            Storage::disk('public')->delete($user->picture);
            $user->picture = '/storage/profile/profile.jpg';
            $user->save();
            return redirect()->to('/myprofile');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if (Auth::user()->picture != "/storage/picture/picture.jpg")
        {
             Storage::disk('public')->delete(Auth::user()->picture);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
