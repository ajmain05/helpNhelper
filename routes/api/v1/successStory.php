<?php

use App\Http\Controllers\Api\SuccessStoryController;

Route::group(['prefix' => 'success-story'], function () {
    Route::get('/', [SuccessStoryController::class, 'index']);
    Route::get('{id}', [SuccessStoryController::class, 'show'])->where('id', '[0-9]+');
});
