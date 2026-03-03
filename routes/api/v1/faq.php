<?php

use App\Http\Controllers\Api\FaqController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FaqController::class, 'index']);
