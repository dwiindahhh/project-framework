<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/jabatans', App\Http\Controllers\Api\JabatanController::class);
Route::apiResource('/departemens', App\Http\Controllers\Api\DepartemenController::class);
Route::apiResource('/karyawans', App\Http\Controllers\Api\KaryawanController::class);
Route::apiResource('/absensis', App\Http\Controllers\Api\AbsensiController::class);
Route::apiResource('/gajis', App\Http\Controllers\Api\GajiController::class);

Route::post('/absensi', [App\Http\Controllers\Api\AbsensiController::class, 'store']); // Absen masuk
Route::put('/absensi/{id}', [App\Http\Controllers\Api\AbsensiController::class, 'update']); // Absen keluar