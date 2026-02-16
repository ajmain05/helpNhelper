<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    require_once __DIR__.'/api/v1/auth.php';
    require_once __DIR__.'/api/v1/bank.php';
    require_once __DIR__.'/api/v1/campaign.php';
    require_once __DIR__.'/api/v1/successStory.php';
    require_once __DIR__.'/api/v1/content.php';
    require_once __DIR__.'/api/v1/donation.php';
    require_once __DIR__.'/api/v1/transaction.php';
    require_once __DIR__.'/api/v1/user.php';
});
