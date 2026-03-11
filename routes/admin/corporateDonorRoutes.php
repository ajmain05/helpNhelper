<?php

use App\Http\Controllers\Admin\CorporateDonorController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'corporate-donors'], function () {
        Route::group(['middleware' => ['permission:all-donor']], function () {
            Route::get('/', [CorporateDonorController::class, 'index'])->name('admin.corporate-donors.index');
            Route::get('/datatable', [CorporateDonorController::class, 'getDatatableAjax'])->name('admin.corporate-donors.datatable');
            Route::post('/allocate', [CorporateDonorController::class, 'allocate'])->name('admin.corporate-donors.allocate');
            Route::get('/allocations/{id}', [CorporateDonorController::class, 'allocations'])->name('admin.corporate-donors.allocations');
            Route::post('/allocation/{id}/refund', [CorporateDonorController::class, 'refundAllocation'])->name('admin.corporate-donors.refund');
            Route::post('/{id}/approve', [CorporateDonorController::class, 'approveDonor'])->name('admin.corporate-donors.approve');
            Route::post('/{id}/reject', [CorporateDonorController::class, 'rejectDonor'])->name('admin.corporate-donors.reject');
            Route::delete('/delete/{id}', [CorporateDonorController::class, 'delete'])->name('admin.corporate-donors.delete');
        });
    });
});

