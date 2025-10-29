<?php

namespace App\Http\Controllers;

use App\Actions\AuthorAnswers\ApproveAuthorAnswer;
use App\Actions\AuthorAnswers\CreateAuthorAnswer;
use App\Actions\AuthorAnswers\GetAuthorAnswerLikes;
use App\Actions\AuthorAnswers\GetAuthorAnswers;
use App\Actions\AuthorAnswers\LikeAuthorAnswer;
use App\Actions\AuthorAnswers\RejectAuthorAnswer;
use App\Actions\AuthorAnswers\UnlikeAuthorAnswer;
use App\Actions\AuthorAnswers\UpdateAuthorAnswer;
use App\Data\AuthorAnswer\AuthorAnswerIndexData;
use App\Data\AuthorAnswer\AuthorAnswerRelationIndexData;
use App\Data\AuthorAnswer\AuthorAnswerStoreData;
use App\Data\AuthorAnswer\AuthorAnswerUpdateData;
use App\Http\Requests\AuthorAnswer\AuthorAnswerDeleteRequest;
use App\Http\Requests\AuthorAnswer\AuthorAnswerIndexRequest;
use App\Http\Requests\AuthorAnswer\AuthorAnswerRelationRequest;
use App\Http\Requests\AuthorAnswer\AuthorAnswerStoreRequest;
use App\Http\Requests\AuthorAnswer\AuthorAnswerUpdateRequest;
use App\Http\Resources\AuthorAnswerResource;
use App\Http\Resources\AuthorQuestionResource;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
use App\Models\AuthorAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorAnswerController extends Controller
{
    public function index(AuthorAnswerIndexRequest $request): AnonymousResourceCollection
    {
        $authorAnswers = GetAuthorAnswers::run(AuthorAnswerIndexData::fromRequest($request));

        return AuthorAnswerResource::collection($authorAnswers);
    }

    public function show(AuthorAnswer $authorAnswer): AuthorAnswerResource
    {
        return new AuthorAnswerResource($authorAnswer->load(['author', 'question']));
    }

    public function store(AuthorAnswerStoreRequest $request): AuthorAnswerResource
    {
        $authorAnswer = CreateAuthorAnswer::run(AuthorAnswerStoreData::fromRequest($request));

        return new AuthorAnswerResource($authorAnswer);
    }

    public function update(AuthorAnswerUpdateRequest $request, AuthorAnswer $authorAnswer): AuthorAnswerResource
    {
        $authorAnswer = UpdateAuthorAnswer::run($authorAnswer, AuthorAnswerUpdateData::fromRequest($request));

        return new AuthorAnswerResource($authorAnswer);
    }

    public function destroy(AuthorAnswerDeleteRequest $request, AuthorAnswer $authorAnswer): JsonResponse
    {
        $authorAnswer->delete();

        return response()->json([
            'message' => 'Відповідь автора успішно видалено.',
        ], 200);
    }

    public function author(AuthorAnswer $authorAnswer): AuthorResource
    {
        return new AuthorResource($authorAnswer->author);
    }

    public function question(AuthorAnswer $authorAnswer): AuthorQuestionResource
    {
        return new AuthorQuestionResource($authorAnswer->question);
    }

    public function answerer(AuthorAnswer $authorAnswer): AuthorResource
    {
        return new AuthorResource($authorAnswer->author);
    }

    public function likes(AuthorAnswerRelationRequest $request, AuthorAnswer $authorAnswer): AnonymousResourceCollection
    {
        $likes = GetAuthorAnswerLikes::run($authorAnswer, AuthorAnswerRelationIndexData::fromRequest($request));

        return LikeResource::collection($likes);
    }

    public function like(Request $request, AuthorAnswer $authorAnswer): JsonResponse
    {
        $success = LikeAuthorAnswer::run($authorAnswer, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже вподобали цю відповідь.',
            ], 409);
        }

        return response()->json([
            'message' => 'Відповідь успішно вподобано.',
        ], 201);
    }

    public function unlike(Request $request, AuthorAnswer $authorAnswer): JsonResponse
    {
        $success = UnlikeAuthorAnswer::run($authorAnswer, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не вподобали цю відповідь.',
            ], 404);
        }

        return response()->json([
            'message' => 'Вподобання відповіді успішно знято.',
        ], 200);
    }

    public function approve(Request $request, AuthorAnswer $authorAnswer): AuthorAnswerResource
    {
        $authorAnswer = ApproveAuthorAnswer::run($authorAnswer);

        return new AuthorAnswerResource($authorAnswer);
    }

    public function reject(Request $request, AuthorAnswer $authorAnswer): AuthorAnswerResource
    {
        $authorAnswer = RejectAuthorAnswer::run($authorAnswer);

        return new AuthorAnswerResource($authorAnswer);
    }
}
