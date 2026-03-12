<?php

use App\Http\Controllers\Admin\GeneralSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/general-settings', [GeneralSettingController::class, 'index'])->name('admin.general-settings.index');
Route::post('/admin/general-settings', [GeneralSettingController::class, 'update'])->name('admin.general-settings.update');
