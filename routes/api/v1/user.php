<?php

use App\Http\Controllers\Api\UserController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('fund-request', [UserController::class, 'fundRequestStore']);
    Route::get('user-info', [UserController::class, 'index']);
    Route::get('user-history', [UserController::class, 'history']);
    Route::post('volunteer-investigate-document/{seekerApplicationId}', [UserController::class, 'investigateDocument']);
    Route::post('update-profile', [UserController::class, 'updateProfile']);
});
