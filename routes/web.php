<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Lector\Dashboard as LectorDashboard;

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
});

require __DIR__.'/settings.php';
