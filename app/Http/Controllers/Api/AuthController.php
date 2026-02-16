<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function store(LoginRequest $request)
    {
        try {

            $user = $request->authenticate();
            $remember = $request->validated('remember') ?? false;

            // $user->tokens()->delete(); // TODO: Uncomment this in production

            $token = $user->createToken(
                name: $request->validated('email') ?? $request->validated('mobile'),
                expiresAt: $remember ? null : now()->addHour()
            )->plainTextToken;

            return response()->json(
                [
                    'message' => 'Login successful.',
                    'token' => $token,
                    'user' => $user,
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {

            return response()->json(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(Request $request)
    {
        try {

            $request->user()->currentAccessToken()->delete();
            // $request->user()->tokens()->delete();

            return response()->json(
                [
                    'message' => 'Logout successful.',
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {

            return response()->json(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
