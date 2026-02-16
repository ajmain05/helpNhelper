<?php

use App\Http\Controllers\Api\CampaignController;

Route::group(['prefix' => 'campaign'], function () {
    Route::get('/', [CampaignController::class, 'index']);
    Route::get('category', [CampaignController::class, 'category']);
    Route::get('{id}', [CampaignController::class, 'show'])->where('id', '[0-9]+');
});
