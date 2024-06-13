<?php

use App\Http\Controllers\AccommodationObjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('accommodation-objects', AccommodationObjectController::class);
    Route::get('accommodation-objects/{accommodationObject}/rooms', [RoomController::class, 'index']);
    Route::post('accommodation-objects/{accommodationObject}/rooms', [RoomController::class, 'store']);
    Route::get('rooms/{room}', [RoomController::class, 'show']);
    Route::put('rooms/{room}', [RoomController::class, 'update']);
    Route::delete('rooms/{room}', [RoomController::class, 'destroy']);

    Route::post('availabilities/update-price-in-range', [AvailabilityController::class, 'updatePriceInRange']);
    Route::post('availabilities/update-price-on-weekdays', [AvailabilityController::class, 'updatePriceOnWeekdays']);

    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::get('/user/reservations', [ReservationController::class, 'userReservations']);
});
