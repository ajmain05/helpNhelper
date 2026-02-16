<?php

use App\Http\Controllers\Admin\Transaction\TransactionController;

Route::group(['prefix' => 'admin'], function () {
    Route::get('/transaction', [TransactionController::class, 'index'])->name('admin.transaction-index');
});
