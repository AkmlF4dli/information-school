<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpdateUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/myprofile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/myprofile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/myprofile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/edit-user', function(){
       return view('edit.edit');
    })->name('user.edit');
    Route::post('/edit-user', [UpdateUserController::class, 'store'])->name('user.update');
});

Route::get('/about', function() {
    return "About";
});

Route::get('/profile', function() {
    return "Profile Sekolah";
});

Route::get('/prestasi', function() {
    return "Prestasi Sekolah";
});

Route::fallback(function () {
    return redirect('/');
});


require __DIR__.'/auth.php';
