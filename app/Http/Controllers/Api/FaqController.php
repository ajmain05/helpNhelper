<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $faqs = Faq::where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'data' => $faqs
        ]);
    }
}
