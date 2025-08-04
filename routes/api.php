<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TrackingController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PekerjaanController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/users', [UserController::class,'index']);
Route::get('/user/{id}/customers', [PelangganController::class, 'show']);
Route::get('/user/{id}/foto', [UserController::class, 'getFotoProfil']);

Route::put('/customers/{id}/status', [PelangganController::class, 'updateStatus']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::post('/update-location', [LocationController::class, 'updateLocation']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
