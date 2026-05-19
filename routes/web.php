<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Lector\Dashboard as LectorDashboard;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\categoriasController;
use App\Http\Controllers\librosController;
use App\Http\Controllers\ejemplaresController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

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

Route::middleware(['auth', 'role:lector'])->group(function () {
    Route::get('/lector/dashboard', LectorDashboard::class)->name('lector.dashboard');
});

/*
|--------------------------------------------------------------------------
| Rutas para ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::resource('usuarios', usuarioController::class);
    Route::resource('categorias', categoriasController::class);
    Route::resource('libros', librosController::class);
    Route::resource('ejemplares', ejemplaresController::class);
});

require __DIR__.'/settings.php';
