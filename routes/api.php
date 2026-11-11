<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

// RUTAS PUBLICAS DE AUTENTICACION

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

});

// RUTAS PROTEGIDAS CON JWT

Route::middleware('auth:api')->group(function () {

    // Autenticacion
    Route::prefix('auth')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/me', [AuthController::class, 'me']);

    });

    // CRUD DE LIBROS
    Route::prefix('books')->group(function () {

        Route::get('/', [BookController::class, 'index']);

        Route::get('/{id}', [BookController::class, 'show']);

        Route::post('/', [BookController::class, 'store']);

        Route::put('/{id}', [BookController::class, 'update']);

        Route::patch('/{id}', [BookController::class, 'update']);

        Route::delete('/{id}', [BookController::class, 'destroy']);

    });

});
