<?php

use App\Http\Controllers\Api\CorporateDepositController;
use Illuminate\Support\Facades\Route;

// SSLCommerz callbacks (no auth needed — called by SSLCommerz server)
Route::prefix('corporate/deposit')->group(function () {
    Route::post('success', [CorporateDepositController::class, 'success']);
    Route::post('cancel',  [CorporateDepositController::class, 'cancel']);
    Route::post('failed',  [CorporateDepositController::class, 'failed']);
});

// Authenticated corporate donor routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('corporate')->group(function () {
        // SSLCommerz deposit (existing)
        Route::post('/deposit/initiate',         [CorporateDepositController::class, 'initiateDeposit']);

        // NEW: Cheque deposit submission by the donor
        Route::post('/deposit/cheque',           [CorporateDepositController::class, 'submitChequeDeposit']);

        // NEW: Deposit history (all methods – SSLCommerz + cheque)
        Route::get('/deposit/history',           [CorporateDepositController::class, 'depositHistory']);
    });
});
