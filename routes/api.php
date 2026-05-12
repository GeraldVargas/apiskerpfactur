<?php

use App\Http\Controllers\Api\CodigoIrregularController;
use App\Http\Controllers\Api\LecturaController;
use App\Http\Controllers\Api\RutaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('facturacion')->group(function () {
    Route::get('/codigos-irregulares', [CodigoIrregularController::class, 'index']);
    Route::post('/codigos-irregulares', [CodigoIrregularController::class, 'store']);
    Route::get('/codigos-irregulares/{id}', [CodigoIrregularController::class, 'show']);
    Route::put('/codigos-irregulares/{id}', [CodigoIrregularController::class, 'update']);
    Route::delete('/codigos-irregulares/{id}', [CodigoIrregularController::class, 'destroy']);

    Route::get('/rutas', [RutaController::class, 'index']);
    Route::post('/rutas', [RutaController::class, 'store']);
    Route::get('/rutas/{id}', [RutaController::class, 'show']);
    Route::put('/rutas/{id}', [RutaController::class, 'update']);
    Route::delete('/rutas/{id}', [RutaController::class, 'destroy']);

    Route::get('/lecturas', [LecturaController::class, 'index']);
    Route::post('/lecturas', [LecturaController::class, 'store']);
    Route::get('/lecturas/{id}', [LecturaController::class, 'show']);
    Route::put('/lecturas/{id}', [LecturaController::class, 'update']);
    Route::delete('/lecturas/{id}', [LecturaController::class, 'destroy']);

    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::post('/clientes', [ClienteController::class, 'store']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show']);
    Route::put('/clientes/{id}', [ClienteController::class, 'update']);
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);
});
