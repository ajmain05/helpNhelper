<?php

use App\Http\Controllers\Admin\Rating\RatingController;

Route::group(['prefix' => 'admin/rating-types'], function () {
    Route::get('/', [RatingController::class, 'index'])->name('admin.rating-types');
    Route::get('datatable-ajax', [RatingController::class, 'getSuccessDatatableAjax'])->name('admin.rating-types.ajax');

    Route::get('/create', [RatingController::class, 'create'])->name('admin.rating-types.create');
    Route::post('/create', [RatingController::class, 'store'])->name('admin.rating-types.store');
    Route::get('/edit/{id}', [RatingController::class, 'edit'])->name('admin.rating-types.edit');
    Route::post('/update/{id}', [RatingController::class, 'update'])->name('admin.rating-types.update');
    Route::post('/delete', [RatingController::class, 'destroy'])->name('admin.rating-types.delete');
});
