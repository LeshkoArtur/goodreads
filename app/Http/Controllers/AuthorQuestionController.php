<?php

namespace App\Http\Controllers;

use App\Actions\AuthorQuestions\CreateAuthorQuestion;
use App\Actions\AuthorQuestions\GetAuthorQuestionAnswers;
use App\Actions\AuthorQuestions\GetAuthorQuestions;
use App\Actions\AuthorQuestions\UpdateAuthorQuestion;
use App\Data\AuthorQuestion\AuthorQuestionIndexData;
use App\Data\AuthorQuestion\AuthorQuestionRelationIndexData;
use App\Data\AuthorQuestion\AuthorQuestionStoreData;
use App\Data\AuthorQuestion\AuthorQuestionUpdateData;
use App\Http\Requests\AuthorQuestion\AuthorQuestionDeleteRequest;
use App\Http\Requests\AuthorQuestion\AuthorQuestionIndexRequest;
use App\Http\Requests\AuthorQuestion\AuthorQuestionRelationRequest;
use App\Http\Requests\AuthorQuestion\AuthorQuestionStoreRequest;
use App\Http\Requests\AuthorQuestion\AuthorQuestionUpdateRequest;
use App\Http\Resources\AuthorAnswerResource;
use App\Http\Resources\AuthorQuestionResource;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\UserResource;
use App\Models\AuthorQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorQuestionController extends Controller
{
    public function index(AuthorQuestionIndexRequest $request): AnonymousResourceCollection
    {
        $authorQuestions = GetAuthorQuestions::run(AuthorQuestionIndexData::fromRequest($request));

        return AuthorQuestionResource::collection($authorQuestions);
    }

    public function show(AuthorQuestion $authorQuestion): AuthorQuestionResource
    {
        return new AuthorQuestionResource($authorQuestion->load(['user', 'author', 'book', 'answers']));
    }

    public function store(AuthorQuestionStoreRequest $request): AuthorQuestionResource
    {
        $authorQuestion = CreateAuthorQuestion::run(AuthorQuestionStoreData::fromRequest($request));

        return new AuthorQuestionResource($authorQuestion);
    }

    public function update(AuthorQuestionUpdateRequest $request, AuthorQuestion $authorQuestion): AuthorQuestionResource
    {
        $authorQuestion = UpdateAuthorQuestion::run($authorQuestion, AuthorQuestionUpdateData::fromRequest($request));

        return new AuthorQuestionResource($authorQuestion);
    }

    public function destroy(AuthorQuestionDeleteRequest $request, AuthorQuestion $authorQuestion): JsonResponse
    {
        $authorQuestion->delete();

        return response()->json([
            'message' => 'Питання до автора успішно видалено.',
        ], 200);
    }

    public function author(AuthorQuestion $authorQuestion): AuthorResource
    {
        return new AuthorResource($authorQuestion->author);
    }

    public function asker(AuthorQuestion $authorQuestion): UserResource
    {
        return new UserResource($authorQuestion->user);
    }

    public function book(AuthorQuestion $authorQuestion): JsonResponse|BookResource
    {
        if (! $authorQuestion->book_id) {
            return response()->json([
                'message' => 'Це питання не пов\'язане з книгою.',
            ], 404);
        }

        return new BookResource($authorQuestion->book);
    }

    public function answers(AuthorQuestionRelationRequest $request, AuthorQuestion $authorQuestion): AnonymousResourceCollection
    {
        $answers = GetAuthorQuestionAnswers::run($authorQuestion, AuthorQuestionRelationIndexData::fromRequest($request));

        return AuthorAnswerResource::collection($answers);
    }
}
