<?php

use App\Http\Controllers\Admin\User\Download\UserListDownloadController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\User\UserRequestController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::group(['middleware' => ['permission:all-user']], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
            Route::get('/download', UserListDownloadController::class)->name('admin.users.download');
            Route::get('dropdown', [UserController::class, 'dropdown']);
            Route::get('datatable-ajax', [UserController::class, 'getUsersDatatableAjax'])->name('admin.users.ajax');
        });
        Route::group(['middleware' => ['permission:create-user']], function () {
            Route::get('create', [UserController::class, 'create'])->name('admin.user.create');
            Route::post('store', [UserController::class, 'store'])->name('admin.user.store');
        });
        Route::group(['middleware' => ['permission:edit-user']], function () {
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::get('show/{id}', [UserController::class, 'show'])->name('admin.user.show');
            Route::post('ratings/{userId}', [UserController::class, 'ratingStore'])->name('admin.user.rating.store');
            Route::delete('ratings/{ratingId}', [UserController::class, 'ratingDelete'])->name('admin.user.rating.delete');
            Route::post('update', [UserController::class, 'update'])->name('admin.user.update');
        });
        Route::group(['middleware' => ['permission:delete-user']], function () {
            Route::post('delete', [UserController::class, 'destroy'])->name('admin.user.delete');
        });
    });
    Route::group(['prefix' => 'user-requests'], function () {
        Route::group(['middleware' => ['permission:all-user-request']], function () {
            Route::get('/{type}', [UserRequestController::class, 'index'])->name('admin.user-requests.index');
            Route::get('datatable-ajax/{type}', [UserRequestController::class, 'getUserRequestsDatatableAjax'])->name('admin.user-requests.ajax');
        });
        Route::group(['middleware' => ['permission:edit-user-request']], function () {
            Route::get('edit/{type}/{id}', [UserRequestController::class, 'edit'])->name('admin.user-request.edit');
            Route::get('update-status/{id}', [UserRequestController::class, 'updateStatus'])->name('admin.user-request.update-status');
            Route::post('update', [UserRequestController::class, 'update'])->name('admin.user-request.update');
        });
        Route::group(['middleware' => ['permission:delete-user-request']], function () {
            Route::post('delete', [UserRequestController::class, 'destroy'])->name('admin.user-request.delete');
        });
    });
    Route::group(['prefix' => 'user-roles'], function () {
        Route::group(['middleware' => ['permission:all-role']], function () {
            Route::get('/', [RoleController::class, 'index'])->name('admin.roles.index');
            Route::get('datatable-ajax', [RoleController::class, 'getRolesDatatableAjax'])->name('admin.roles.ajax');
        });
        Route::group(['middleware' => ['permission:create-role']], function () {
            Route::get('create', [RoleController::class, 'create'])->name('admin.role.create');
            Route::post('store', [RoleController::class, 'store'])->name('admin.role.store');
        });
        Route::group(['middleware' => ['permission:edit-role']], function () {
            Route::get('edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
            Route::post('update', [RoleController::class, 'update'])->name('admin.role.update');
        });
        Route::group(['middleware' => ['permission:delete-role']], function () {
            Route::post('delete', [RoleController::class, 'destroy'])->name('admin.role.delete');
        });
    });

});
