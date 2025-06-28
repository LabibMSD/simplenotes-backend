<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiJsonResponseMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiJsonResponseMiddleware::class])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/user/notes', [UserController::class, 'notes']);

        // Route::get('/notes', [NoteController::class, 'index']);
        Route::get('/notes/{note}', [NoteController::class, 'show']);
        Route::post('/notes', [NoteController::class, 'store']);
        Route::delete('/notes/{note}', [NoteController::class, 'destroy']);
        Route::put('/notes/{note}', [NoteController::class, 'update']);
    });
});
