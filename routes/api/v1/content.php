<?php

use App\Http\Controllers\Api\ContentController;

Route::get('contents', [ContentController::class, 'contents']);
Route::get('meet-our-team', [ContentController::class, 'meetOurTeam']);
Route::get('faq', [ContentController::class, 'faq']);
Route::get('country', [ContentController::class, 'country']);
Route::get('division', [ContentController::class, 'division']);
Route::get('district', [ContentController::class, 'district']);
Route::get('upazila', [ContentController::class, 'upazila']);
Route::get('settings', [ContentController::class, 'settings']);
