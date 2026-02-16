<?php

use App\Http\Controllers\Api\Bank\BankController;

Route::middleware(['auth:sanctum'])->prefix('banks')->group(function () {
    Route::get('/', [BankController::class, 'index']);
    Route::post('/', [BankController::class, 'store']);
    Route::put('/{id}', [BankController::class, 'update'])
        ->where('id', '[0-9]+');
    Route::delete('/{id}', [BankController::class, 'destroy'])
        ->where('id', '[0-9]+');
});
