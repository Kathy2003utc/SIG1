<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->middleware('auth:admin')->name('dashboard');

    // Solo para pruebas (crear admin desde URL)
    Route::get('crear-admin', [AdminAuthController::class, 'createAdmin']);
});

// Rutas para usuarios normales
Route::get('register', [UserAuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [UserAuthController::class, 'register'])->name('register.post');

Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserAuthController::class, 'login'])->name('login.post');

Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth:web')->name('user.dashboard');
