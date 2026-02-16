<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Web\User\UserRequestController;

Route::post('user-request', UserRequestController::class);
Route::post('sign-in', [AuthController::class, 'store']);
Route::post('get-signin-otp', OtpController::class);
Route::middleware('auth:sanctum')->post('sign-out', [AuthController::class, 'destroy']);
