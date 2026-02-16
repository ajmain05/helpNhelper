<?php

use App\Http\Controllers\Admin\Volunteer\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'volunteers/'], function () {
        Route::group(['middleware' => ['permission:all-volunteer']], function () {
            Route::get('/', [VolunteerController::class, 'index'])->name('admin.volunteers.index');
            Route::get('datatable-ajax', [VolunteerController::class, 'getVolunteersDatatableAjax'])->name('admin.volunteers.ajax');
        });
        Route::group(['middleware' => ['permission:edit-volunteer']], function () {
            Route::get('show/{id}', [VolunteerController::class, 'show'])->name('admin.volunteer.show');
            Route::get('edit/{id}', [VolunteerController::class, 'edit'])->name('admin.volunteer.edit');
            Route::post('update', [VolunteerController::class, 'update'])->name('admin.volunteer.update');
        });
        Route::group(['middleware' => ['permission:delete-volunteer']], function () {
            Route::post('delete', [VolunteerController::class, 'destroy'])->name('admin.volunteer.delete');
        });
    });

});
