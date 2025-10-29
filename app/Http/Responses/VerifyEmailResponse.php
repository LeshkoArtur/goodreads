<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;

class VerifyEmailResponse implements VerifyEmailResponseContract
{
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'message' => 'Email verified successfully.',
            'email_verified' => true,
        ]);
    }
}
