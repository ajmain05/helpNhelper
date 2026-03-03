<?php

use App\Http\Controllers\Api\TeamMemberController;

Route::get('team-member', [TeamMemberController::class, 'index']);
