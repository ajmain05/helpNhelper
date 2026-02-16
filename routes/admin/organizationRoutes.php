<?php

use App\Http\Controllers\Admin\Organization\OrganizationApplicationController;
use App\Http\Controllers\Admin\Organization\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'organizations/'], function () {
        Route::group(['middleware' => ['permission:all-organization']], function () {
            Route::get('/', [OrganizationController::class, 'index'])->name('admin.organizations.index');
            Route::get('datatable-ajax', [OrganizationController::class, 'getOrganizationsDatatableAjax'])->name('admin.organizations.ajax');
        });
        Route::group(['middleware' => ['permission:edit-organization']], function () {
            Route::get('edit/{id}', [OrganizationController::class, 'edit'])->name('admin.organization.edit');
            Route::post('update', [OrganizationController::class, 'update'])->name('admin.organization.update');
        });
        Route::group(['middleware' => ['permission:delete-organization']], function () {
            Route::post('delete', [OrganizationController::class, 'destroy'])->name('admin.organization.delete');
        });

    });
    Route::group(['prefix' => 'organization-application'], function () {
        Route::group(['middleware' => ['permission:all-organization-application']], function () {
            Route::get('/', [OrganizationApplicationController::class, 'index'])->name('admin.organization-applications.index');
            Route::get('datatable-ajax', [OrganizationApplicationController::class, 'getOrganizationApplicationsDatatableAjax'])->name('admin.organization-applications.ajax');
            Route::get('show/{id}', [OrganizationApplicationController::class, 'show'])->name('admin.organization-application.show');

        });
        Route::group(['middleware' => ['permission:create-organization-application']], function () {
            Route::get('create', [OrganizationApplicationController::class, 'create'])->name('admin.organization-application.create');
            Route::post('store', [OrganizationApplicationController::class, 'store'])->name('admin.organization-application.store');
        });
        Route::group(['middleware' => ['permission:edit-organization-application']], function () {
            Route::get('edit/{id}', [OrganizationApplicationController::class, 'edit'])->name('admin.organization-application.edit');
            Route::post('update', [OrganizationApplicationController::class, 'update'])->name('admin.organization-application.update');
            Route::get('update-status/{status}/{id}', [OrganizationApplicationController::class, 'updateStatus'])->name('admin.organization-application.update.status');
        });
        Route::group(['middleware' => ['permission:delete-organization-application']], function () {
            Route::post('delete', [OrganizationApplicationController::class, 'destroy'])->name('admin.organization-application.delete');
        });
    });

});
