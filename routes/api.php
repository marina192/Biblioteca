<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',            [ApiController::class, 'logout']);
    Route::get('/libros',             [ApiController::class, 'indexLibros']);
    Route::get('/libros/{id}',        [ApiController::class, 'showLibro']);
    Route::post('/prestamos',         [ApiController::class, 'storePrestamo']);
});