<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;

class HomeController extends Controller
{
    use UserTrait;

    public function index()
    {
        return view('v1.admin.pages.home');
    }
}
