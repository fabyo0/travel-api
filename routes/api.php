<?php

use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Support\Facades\Route;

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

// Travel
Route::get('travels', [TravelController::class, 'index']);

//Tours
Route::get('travels/{travel}/tours', [TourController::class, 'index']);

// Admin Travel
Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::post('travels', [Admin\TravelController::class, 'store']);
        Route::post('travels/{travel:id}/tours', [Admin\TourController::class, 'store']);
    });

    Route::put('travels/{travel:id}', [Admin\TravelController::class, 'update']);
});

// Auth
Route::prefix('auth')->group(function () {
    // Login
    Route::post('login', LoginController::class);
});
