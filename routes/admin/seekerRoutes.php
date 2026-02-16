<?php

use App\Http\Controllers\Admin\Seeker\SeekerApplicationController;
use App\Http\Controllers\Admin\Seeker\SeekerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'seekers/'], function () {
        Route::group(['middleware' => ['permission:all-seeker']], function () {
            Route::get('/', [SeekerController::class, 'index'])->name('admin.seekers.index');
            Route::get('datatable-ajax', [SeekerController::class, 'getSeekersDatatableAjax'])->name('admin.seekers.ajax');
        });
        Route::group(['middleware' => ['permission:edit-seeker']], function () {
            Route::get('edit/{id}', [SeekerController::class, 'edit'])->name('admin.seeker.edit');
            Route::post('update', [SeekerController::class, 'update'])->name('admin.seeker.update');
        });
        Route::group(['middleware' => ['permission:delete-seeker']], function () {
            Route::post('delete', [SeekerController::class, 'destroy'])->name('admin.seeker.delete');
        });

    });
    Route::group(['prefix' => 'seeker-application'], function () {
        Route::group(['middleware' => ['permission:all-seeker-application']], function () {
            Route::get('/', [SeekerApplicationController::class, 'index'])->name('admin.seeker-applications.index');
            Route::get('datatable-ajax', [SeekerApplicationController::class, 'getSeekerApplicationsDatatableAjax'])->name('admin.seeker-applications.ajax');
            Route::get('show/{id}', [SeekerApplicationController::class, 'show'])->name('admin.seeker-application.show');

        });
        Route::group(['middleware' => ['permission:create-seeker-application']], function () {
            Route::get('create', [SeekerApplicationController::class, 'create'])->name('admin.seeker-application.create');
            Route::post('store', [SeekerApplicationController::class, 'store'])->name('admin.seeker-application.store');
        });
        Route::group(['middleware' => ['permission:edit-seeker-application']], function () {
            Route::get('edit/{id}', [SeekerApplicationController::class, 'edit'])->name('admin.seeker-application.edit');
            Route::post('update', [SeekerApplicationController::class, 'update'])->name('admin.seeker-application.update');
            Route::get('update-status/{status}/{id}', [SeekerApplicationController::class, 'updateStatus'])->name('admin.seeker-application.update.status');
            Route::post('update-volunteer-document-status', [SeekerApplicationController::class, 'updateVolunteerDocumentStatus'])->name('admin.seeker-application.update.volunteer-document-status');
        });
        Route::group(['middleware' => ['permission:delete-seeker-application']], function () {
            Route::post('delete', [SeekerApplicationController::class, 'destroy'])->name('admin.seeker-application.delete');
        });
    });

});
