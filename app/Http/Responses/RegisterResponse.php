<?php

namespace App\Http\Responses;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): JsonResponse
    {
        $user = $request->user();
        
        // Update last_login timestamp on first registration
        $user->update(['last_login' => now()]);
        
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user->fresh()),
            'token' => $token,
        ], 201);
    }
}
