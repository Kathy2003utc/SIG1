<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\RiesgoController;
use App\Http\Controllers\zonaSeguraController;
use App\Http\Controllers\PuntoEncuentroController;
use App\Http\Controllers\ReportesController;
use App\Models\Riesgo;
use App\Http\Controllers\UserController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/usuarioPuntos', [UserController::class, 'userPuntos']);
Route::get('/user/usuarioSeguros', [UserController::class, 'userZonas']);
Route::get('/user/usuarioRiesgos', [UserController::class, 'userRiesgos']);

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

    Route::get('reportes/zonas', [ReportesController::class, 'generarPDF'])
      ->name('reportes.zonas')
      ->middleware('auth:admin');

    Route::get('mapa-zonas', function () {
        $zonas = Riesgo::all();
        return view('mapas.publico', compact('zonas'));
    })->name('mapa.zonas.publico');

    // routes/web.php  (dentro del prefix('admin')->name('admin.') …)
    Route::get('ZonasRiesgo/mapa', [RiesgoController::class, 'mapa'])
        ->name('ZonasRiesgo.mapa');
    Route::get('zonas-seguras/mapa', [zonaSeguraController::class, 'mapa'])->name('ZonasSeguras.mapa');

    Route::get('zonas-seguras/reporte', [zonaSeguraController::class, 'reporte'])->name('ZonasSeguras.reporte');

    Route::get('/admin/puntos/reporte', [PuntoEncuentroController::class, 'reporte'])->name('puntos.reporte');

    Route::get('/admin/puntos/mapa', [PuntoEncuentroController::class, 'mapa'])->name('puntos.mapa');

    Route::get('/admin/puntos/reporte-pdf', [PuntoEncuentroController::class, 'reportePdf'])->name('puntos.reportePdf');

    Route::get('/mapa-zonas-riesgo', [RiesgoController::class, 'mapaPublico'])->name('publico.mapa_zonas_riesgo');



});




