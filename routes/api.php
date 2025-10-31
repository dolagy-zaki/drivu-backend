<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    VehicleController,
    TripController,
    DrivingEventController,
    MaintenanceJobController,
    MaintenancePredictionController,
    MaintenanceTypeController,
    TipController,
    FuelFillUpController,
    UserController
};

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --- API Resource Routes ---

// Core Business Resources
Route::apiResource('users', UserController::class);
Route::apiResource('vehicles', VehicleController::class);
Route::apiResource('trips', TripController::class);

// Related Data Resources (Using kebab-case for URL slugs)
Route::apiResource('driving-events', DrivingEventController::class); 
Route::apiResource('fuel-fill-ups', FuelFillUpController::class);

// Maintenance Resources
Route::apiResource('maintenance-types', MaintenanceTypeController::class);
Route::apiResource('maintenance-jobs', MaintenanceJobController::class);
Route::apiResource('maintenance-predictions', MaintenancePredictionController::class);

// Tips/Recommendations
Route::apiResource('tips', TipController::class);