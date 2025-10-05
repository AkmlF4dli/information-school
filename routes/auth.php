<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('prcs', [AuthenticatedSessionController::class, 'store'])->name('adminprcs');

    Route::get('password-reset', [ResetPasswordController::class, 'create'])->name('password-reset');
    
    Route::post('password-reset', [ResetPasswordController::class, 'store'])->name('password-reset-post');

    Route::get('password-sending', function () {
        return "berhasil di kirim";
    });

    Route::get('password-reset/{data}', [ResetPasswordController::class, 'resetpass'])->where('data', '.*'); // Ini agar semua karakter diterima

    Route::get('feedback', [ResetPasswordController::class, 'resetpassfeedback'])->name('resetpassfeedback')->where('data', '.*');
});

Route::middleware('auth')->group(function () {
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [ChangePasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
        
});
