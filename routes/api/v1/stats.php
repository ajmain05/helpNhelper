<?php

use App\Http\Controllers\Api\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('stats', [StatsController::class, 'index']);
