<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Lector\Dashboard as LectorDashboard;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\categoriasController;
use App\Http\Controllers\librosController;
use App\Http\Controllers\ejemplaresController;
use App\Http\Controllers\prestamosController;
use App\Http\Controllers\reportesController;
use App\Http\Controllers\pdfController;
use App\Models\User;
use App\Mail\BienvenidaLector;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->hasRole('lector')) {
            return redirect()->route('lector.dashboard');
        }
    }
    return view('welcome');
})->name('home');

Route::get('/preview-correo', function () {

    $user = new User();

    $user->name = 'Ana García';
    $user->email = 'correo@gmail.com';
    $user->created_at = now();

    return new BienvenidaLector($user);
});

/*
|--------------------------------------------------------------------------
| Redirección automática según rol
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if(auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if(auth()->user()->hasRole('lector')) {
        return redirect()->route('lector.dashboard');
    }
})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| Rutas para LECTOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:lector'])->prefix('lector')->name('lector.')->group(function () {
    Route::get('dashboard', LectorDashboard::class)->name('dashboard');
    Route::resource('categorias', categoriasController::class)->only(['index']);
    Route::resource('libros', librosController::class)->only(['index', 'show']);
    Route::resource('prestamos', prestamosController::class)->only(['index', 'create', 'update']);
});

/*
|--------------------------------------------------------------------------
| Rutas para ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', AdminDashboard::class)->name('dashboard');
    Route::resource('usuarios', usuarioController::class);
    Route::resource('categorias', categoriasController::class);
    Route::resource('libros', librosController::class);
    Route::resource('ejemplares', ejemplaresController::class);
    Route::resource('prestamos', prestamosController::class);
    Route::resource('reportes', reportesController::class);
    Route::get('/pdf/descargar', [pdfController::class, 'descargar'])->name('pdf.descargar');
    Route::get('/pdf/ver', [pdfController::class, 'ver'])->name('pdf.ver');
    Route::get('/pdf/guardar', [pdfController::class, 'guardar'])->name('pdf.guardar');
});

require __DIR__.'/settings.php';
