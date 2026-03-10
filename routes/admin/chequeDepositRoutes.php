<?php

use App\Http\Controllers\Admin\ChequeDepositController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'cheque-deposits'], function () {
        Route::group(['middleware' => ['permission:all-donor']], function () {
            Route::get('/', [ChequeDepositController::class, 'index'])->name('admin.cheque-deposits.index');
            Route::post('/', [ChequeDepositController::class, 'store'])->name('admin.cheque-deposits.store');
            Route::post('/{id}/approve', [ChequeDepositController::class, 'approve'])->name('admin.cheque-deposits.approve');
            Route::post('/{id}/reject', [ChequeDepositController::class, 'reject'])->name('admin.cheque-deposits.reject');
        });
    });
});
