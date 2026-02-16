<?php

use App\Http\Controllers\Api\TransactionController;

Route::middleware(['auth:sanctum'])->prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::patch('/update-receive-status/{transactionId}', [TransactionController::class, 'statusUpdate']);
});
