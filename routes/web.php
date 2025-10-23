<?php
use App\Http\Controllers\UploadsSiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\UpdateUserController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    // 1. Rute untuk MENAMPILKAN formulir pendaftaran (Ini yang hilang/diperlukan)
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    // 2. Rute untuk MEMPROSES pengiriman formulir pendaftaran
    Route::post('register', [RegisteredUserController::class, 'store']);

    // ... (Rute-rute autentikasi lainnya, seperti login, forgot password, dll.)
    
    // Login Routes
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Password Reset Routes
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/delete/picture', [ProfileController::class, 'delete_picture'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/myprofile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/myprofile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/myprofile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/edit-user', function(){
       return view('edit.edit');
    })->name('user.edit');
    Route::put('/edit-user/{identity}', [UpdateUserController::class, 'update'])->name('user.update');
    Route::post('/absensi', [AbsensiController::class, 'store']);


    // User policy by Admin
    Route::delete('/guru/{identity}', [UserController::class, 'gurudestroy'])->name('guru.destroy');
    Route::get('/pembina/{email}', [UserController::class, 'pembinadestroy'])->name('pembina.destroy');
    Route::get('/siswa/{identity}', [UserController::class, 'siswadestroy'])->name('siswa.destroy');
    Route::get('/ketuaeskul/{identity}', [UserController::class, 'ketuaeskuldestroy'])->name('ketuaeskul.destroy');
    Route::get('/pelatih/{identity}', [UserController::class, 'pelatihdestroy'])->name('pelatih.destroy');
    // Import data siswa
    Route::post('/siswa/upload/excel', [UploadsSiswaController::class, 'store'])->name('excel.upload');
    Route::get('/siswa/download/excel', [UploadsSiswaController::class, 'download'])->name('excel.download');
    Route::get('/api/siswa/search', [UploadsSiswaController::class, 'searchSiswa'])->name('api.siswa.search');
    Route::get('/api/guru/search', [UploadsSiswaController::class, 'searchGuru'])->name('api.guru.search');
 
    // User policy by Guru Piket
    Route::delete('/siswa/izin/destroy/{identity}', [UserController::class, 'siswaIzindestroy'])->name('siswa.izin.destroy');
    Route::post('/siswa/izin/store', [UserController::class, 'siswaIzinstore'])->name('siswa.izin.store');

    Route::delete('/guru/izin/destroy/{identity}', [UserController::class, 'guruIzindestroy'])->name('guru.izin.destroy');
    Route::post('/guru/izin/store', [UserController::class, 'guruIzinstore'])->name('guru.izin.store');

    // User policy by Siswa & Ketua Eskul
    Route::get('/eskul', [UserController::class, 'lihatEskul'])->name('lihateskul');
    Route::get('/eskul/more/{cabang_eskul}/{title}', [UserController::class, 'materieskul'])->name('events.more');
    Route::post('/eskul/daftar/{cabang}', [UserController::class, 'daftarEskul'])->name('eskul.daftar');
    Route::get('/eskul/hapus/{cabang}', [UserController::class, 'hapusEskul'])->name('eskul.hapus');

    // User policy by Kesiswaan
    Route::post('/addeskul', [UserController::class, 'addeskul'])->name('addeskul');
    Route::post('/updateeskul/{id}', [UserController::class, 'updateeskul'])->name('updateeskul');
    Route::get('/deleteeskul/{eskul}', [UserController::class, 'deleteeskul'])->name('deleteeskul');

    // User policy by Pelatih Eskul
    Route::post('/tambahkan/materi', [UserController::class, 'storemateri'])->name('events.store');

    // ajax jadwal absensi
    Route::get('/absensi/ajax', [UserController::class, 'ajax'])->name('absensi.ajax');
});


// Static Page 

Route::get('/about', function() {
    return view('about');
});


Route::fallback(function () {
    return redirect('/');
});


require __DIR__.'/auth.php';