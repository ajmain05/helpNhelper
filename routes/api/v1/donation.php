<?php

use App\Http\Controllers\Web\DonationController;

Route::prefix('payment')->group(function () {
    Route::post('success', [DonationController::class, 'success']);
    Route::post('cancel', [DonationController::class, 'cancel']);
    Route::post('failed', [DonationController::class, 'failed']);
});
Route::post('donation-store', [DonationController::class, 'makePayment']);
