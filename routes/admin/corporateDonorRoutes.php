<?php

use App\Http\Controllers\Admin\CorporateDonorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::group(['prefix' => 'corporate-donors'], function () {
        Route::get('/', [CorporateDonorController::class, 'index'])->name('corporate-donors.index');
        Route::get('/datatable', [CorporateDonorController::class, 'getDatatableAjax'])->name('corporate-donors.datatable');
        Route::post('/allocate', [CorporateDonorController::class, 'allocate'])->name('corporate-donors.allocate');
    });
});
