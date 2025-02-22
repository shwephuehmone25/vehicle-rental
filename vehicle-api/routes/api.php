<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/vehicles', [VehicleController::class, 'store']);
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show']);
Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update']);
Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy']);
