<?php

use App\Http\Controllers\Api\CorporateWalletController;
use App\Http\Controllers\Api\UserController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('fund-request', [UserController::class, 'fundRequestStore']);
    Route::get('user-info', [UserController::class, 'index']);
    Route::get('user-history', [UserController::class, 'history']);
    Route::post('volunteer-investigate-document/{seekerApplicationId}', [UserController::class, 'investigateDocument']);
    Route::post('update-profile', [UserController::class, 'updateProfile']);

    // Corporate Wallet & Tracking
    Route::get('corporate/wallet-history', [CorporateWalletController::class, 'getWalletHistory']);
    
    // (Mock/Admin Routes for manually building wallet & allocating funds)
    Route::post('admin/corporate/deposit', [CorporateWalletController::class, 'recordDeposit']);
    Route::post('admin/corporate/allocate', [CorporateWalletController::class, 'recordAllocation']);
});
