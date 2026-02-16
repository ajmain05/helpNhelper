<?php

use App\Http\Controllers\Admin\Faq\FaqController;

Route::group(['prefix' => 'admin/faq'], function () {
    Route::get('/', [FaqController::class, 'index'])->name('admin.faq');
    Route::post('/', [FaqController::class, 'store'])->name('admin.faq.store');
    Route::post('/update', [FaqController::class, 'update'])->name('admin.faq.update');
    Route::post('/delete', [FaqController::class, 'destroy'])->name('admin.faq.delete');
});
