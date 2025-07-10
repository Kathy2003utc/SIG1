<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\RiesgoController;
use App\Http\Controllers\zonaSeguraController;
use App\Http\Controllers\PuntoEncuentroController;




Route::get('/', function () {
    return view('welcome');
});

// Rutas para admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', fn () => view('admin.dashboard'))->middleware('auth:admin')->name('dashboard');

    // Solo para pruebas
    Route::get('crear-admin', [AdminAuthController::class, 'createAdmin']);
});

// Rutas para usuarios
Route::get('register', [UserAuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [UserAuthController::class, 'register'])->name('register.post');

Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserAuthController::class, 'login'])->name('login.post');
Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', fn () => view('user.dashboard'))->middleware('auth:web')->name('user.dashboard');

// CRUDs protegidos para admin
Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {

    // Rutas existentes para ZonasRiesgo y ZonasSeguras
    Route::resource('ZonasRiesgo', RiesgoController::class)->names([
        'index'   => 'ZonasRiesgo.index',
        'create'  => 'ZonasRiesgo.create',
        'store'   => 'ZonasRiesgo.store',
        'show'    => 'ZonasRiesgo.show',
        'edit'    => 'ZonasRiesgo.edit',
        'update'  => 'ZonasRiesgo.update',
        'destroy' => 'ZonasRiesgo.destroy',
    ]);

    Route::resource('ZonasSeguras', zonaSeguraController::class)->names([
        'index'   => 'ZonasSeguras.index',
        'create'  => 'ZonasSeguras.create',
        'store'   => 'ZonasSeguras.store',
        'show'    => 'ZonasSeguras.show',
        'edit'    => 'ZonasSeguras.edit',
        'update'  => 'ZonasSeguras.update',
        'destroy' => 'ZonasSeguras.destroy',
    ]);

    // Aquí agregamos las rutas para Puntos de Encuentro
    Route::resource('puntos', PuntoEncuentroController::class)->names([
        'index'   => 'puntos.index',
        'create'  => 'puntos.create',
        'store'   => 'puntos.store',
        'show'    => 'puntos.show',
        'edit'    => 'puntos.edit',
        'update'  => 'puntos.update',
        'destroy' => 'puntos.destroy',
    ]);
});

