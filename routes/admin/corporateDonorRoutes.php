<?php

use App\Http\Controllers\Admin\CorporateDonorController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'corporate-donors'], function () {
        Route::group(['middleware' => ['permission:all-donor']], function () {
            Route::get('/', [CorporateDonorController::class, 'index'])->name('admin.corporate-donors.index');
            Route::get('/datatable', [CorporateDonorController::class, 'getDatatableAjax'])->name('admin.corporate-donors.datatable');
            Route::post('/allocate', [CorporateDonorController::class, 'allocate'])->name('admin.corporate-donors.allocate');
        });
    });
});
