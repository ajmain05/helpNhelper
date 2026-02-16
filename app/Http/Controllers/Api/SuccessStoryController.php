<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Response;

class SuccessStoryController extends Controller
{
    public function index()
    {
        try {
            $successStories = SuccessStory::latest()->get();

            return response()->json([
                'data' => $successStories,
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function show($id)
    {
        try {
            $successStory = SuccessStory::findOrFail($id);

            return response()->json([
                'data' => $successStory,
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
