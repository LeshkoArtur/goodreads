<?php

namespace App\Http\Controllers;

use App\Actions\Authors\ClaimAuthor;
use App\Actions\Authors\CreateAuthor;
use App\Actions\Authors\FollowAuthor;
use App\Actions\Authors\GetAuthorAnswers;
use App\Actions\Authors\GetAuthorAwards;
use App\Actions\Authors\GetAuthorBooks;
use App\Actions\Authors\GetAuthorNominations;
use App\Actions\Authors\GetAuthorPopularBooks;
use App\Actions\Authors\GetAuthorPosts;
use App\Actions\Authors\GetAuthorQuestions;
use App\Actions\Authors\GetAuthors;
use App\Actions\Authors\GetAuthorSeries;
use App\Actions\Authors\GetAuthorStats;
use App\Actions\Authors\GetAuthorUsers;
use App\Actions\Authors\GetSimilarAuthors;
use App\Actions\Authors\UnfollowAuthor;
use App\Actions\Authors\UpdateAuthor;
use App\Data\Author\AuthorIndexData;
use App\Data\Author\AuthorRelationIndexData;
use App\Data\Author\AuthorStoreData;
use App\Data\Author\AuthorUpdateData;
use App\Http\Requests\Author\AuthorDeleteRequest;
use App\Http\Requests\Author\AuthorIndexRequest;
use App\Http\Requests\Author\AuthorRelationRequest;
use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Http\Resources\AuthorAnswerResource;
use App\Http\Resources\AuthorQuestionResource;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookSeriesResource;
use App\Http\Resources\NominationEntryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function index(AuthorIndexRequest $request): AnonymousResourceCollection
    {
        $authors = GetAuthors::run(AuthorIndexData::fromRequest($request));

        return AuthorResource::collection($authors);
    }

    public function show(Author $author): AuthorResource
    {
        return new AuthorResource($author->load(['users', 'books']));
    }

    public function store(AuthorStoreRequest $request): AuthorResource
    {
        $author = CreateAuthor::run(AuthorStoreData::fromRequest($request));

        return new AuthorResource($author);
    }

    public function update(AuthorUpdateRequest $request, Author $author): AuthorResource
    {
        $author = UpdateAuthor::run($author, AuthorUpdateData::fromRequest($request));

        return new AuthorResource($author);
    }

    public function destroy(AuthorDeleteRequest $request, Author $author): JsonResponse
    {
        $author->delete();

        return response()->json([
            'message' => 'Автора успішно видалено.',
        ], 200);
    }

    public function books(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $books = GetAuthorBooks::run($author, AuthorRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function series(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $series = GetAuthorSeries::run($author, AuthorRelationIndexData::fromRequest($request));

        return BookSeriesResource::collection($series);
    }

    public function users(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $users = GetAuthorUsers::run($author, AuthorRelationIndexData::fromRequest($request));

        return UserResource::collection($users);
    }

    public function questions(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $questions = GetAuthorQuestions::run($author, AuthorRelationIndexData::fromRequest($request));

        return AuthorQuestionResource::collection($questions);
    }

    public function answers(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $answers = GetAuthorAnswers::run($author, AuthorRelationIndexData::fromRequest($request));

        return AuthorAnswerResource::collection($answers);
    }

    public function posts(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $posts = GetAuthorPosts::run($author, AuthorRelationIndexData::fromRequest($request));

        return PostResource::collection($posts);
    }

    public function nominations(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $nominations = GetAuthorNominations::run($author, AuthorRelationIndexData::fromRequest($request));

        return NominationEntryResource::collection($nominations);
    }

    public function awards(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $awards = GetAuthorAwards::run($author, AuthorRelationIndexData::fromRequest($request));

        return NominationEntryResource::collection($awards);
    }

    public function stats(Author $author): JsonResponse
    {
        $stats = GetAuthorStats::run($author);

        return response()->json($stats);
    }

    public function popularBooks(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $books = GetAuthorPopularBooks::run($author, AuthorRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function similar(AuthorRelationRequest $request, Author $author): AnonymousResourceCollection
    {
        $similarAuthors = GetSimilarAuthors::run($author, AuthorRelationIndexData::fromRequest($request));

        return AuthorResource::collection($similarAuthors);
    }

    public function claim(Request $request, Author $author): JsonResponse
    {
        $success = ClaimAuthor::run($author, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже заявляли претензію на цього автора.',
            ], 409);
        }

        return response()->json([
            'message' => 'Претензію на автора успішно заявлено.',
        ], 201);
    }

    public function follow(Request $request, Author $author): JsonResponse
    {
        $success = FollowAuthor::run($author, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже підписані на цього автора.',
            ], 409);
        }

        return response()->json([
            'message' => 'Успішно підписано на автора.',
        ], 201);
    }

    public function unfollow(Request $request, Author $author): JsonResponse
    {
        $success = UnfollowAuthor::run($author, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не підписані на цього автора.',
            ], 404);
        }

        return response()->json([
            'message' => 'Успішно відписано від автора.',
        ], 200);
    }
}
