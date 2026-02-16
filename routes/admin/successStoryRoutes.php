<?php

use App\Http\Controllers\Admin\Success\SuccessStoryController;

Route::group(['prefix' => 'admin/success'], function () {
    Route::get('/', [SuccessStoryController::class, 'index'])->name('admin.success');
    Route::get('datatable-ajax', [SuccessStoryController::class, 'getSuccessDatatableAjax'])->name('admin.success.ajax');

    Route::get('/create', [SuccessStoryController::class, 'create'])->name('admin.success.create');
    Route::post('/create', [SuccessStoryController::class, 'store'])->name('admin.success.store');
    Route::get('/edit/{id}', [SuccessStoryController::class, 'edit'])->name('admin.success.edit');
    Route::post('/update', [SuccessStoryController::class, 'update'])->name('admin.success.update');
    Route::post('/delete', [SuccessStoryController::class, 'destroy'])->name('admin.success.delete');
});
