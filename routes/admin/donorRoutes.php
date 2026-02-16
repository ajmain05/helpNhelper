<?php

use App\Http\Controllers\Admin\Donor\DonorController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'donors/'], function () {
        Route::group(['middleware' => ['permission:all-donor']], function () {
            Route::get('/', [DonorController::class, 'index'])->name('admin.donors.index');
            Route::get('datatable-ajax', [DonorController::class, 'getDonorsDatatableAjax'])->name('admin.donors.ajax');
        });
        Route::group(['middleware' => ['permission:edit-donor']], function () {
            Route::get('edit/{id}', [DonorController::class, 'edit'])->name('admin.donor.edit');
            Route::post('update', [DonorController::class, 'update'])->name('admin.donor.update');
        });
        Route::group(['middleware' => ['permission:delete-donor']], function () {
            Route::post('delete', [DonorController::class, 'destroy'])->name('admin.donor.delete');
        });
    });

});
