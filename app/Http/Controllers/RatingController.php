<?php

namespace App\Http\Controllers;

use App\Actions\Ratings\CreateRating;
use App\Actions\Ratings\GetRatingComments;
use App\Actions\Ratings\GetRatingLikes;
use App\Actions\Ratings\GetRatings;
use App\Actions\Ratings\LikeRating;
use App\Actions\Ratings\UnlikeRating;
use App\Actions\Ratings\UpdateRating;
use App\Data\Rating\RatingIndexData;
use App\Data\Rating\RatingRelationIndexData;
use App\Data\Rating\RatingStoreData;
use App\Data\Rating\RatingUpdateData;
use App\Http\Requests\Rating\RatingDeleteRequest;
use App\Http\Requests\Rating\RatingIndexRequest;
use App\Http\Requests\Rating\RatingRelationRequest;
use App\Http\Requests\Rating\RatingStoreRequest;
use App\Http\Requests\Rating\RatingUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LikeResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\UserResource;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RatingController extends Controller
{
    public function index(RatingIndexRequest $request): AnonymousResourceCollection
    {
        $ratings = GetRatings::run(RatingIndexData::fromRequest($request));

        return RatingResource::collection($ratings);
    }

    public function show(Rating $rating): RatingResource
    {
        return new RatingResource($rating->load(['user', 'book']));
    }

    public function store(RatingStoreRequest $request): RatingResource
    {
        $rating = CreateRating::run(RatingStoreData::fromRequest($request));

        return new RatingResource($rating);
    }

    public function update(RatingUpdateRequest $request, Rating $rating): RatingResource
    {
        $rating = UpdateRating::run($rating, RatingUpdateData::fromRequest($request));

        return new RatingResource($rating);
    }

    public function destroy(RatingDeleteRequest $request, Rating $rating): JsonResponse
    {
        $rating->delete();

        return response()->json([
            'message' => 'Рейтинг успішно видалено.',
        ], 200);
    }

    public function user(Rating $rating): UserResource
    {
        return new UserResource($rating->user);
    }

    public function book(Rating $rating): BookResource
    {
        return new BookResource($rating->book);
    }

    public function comments(RatingRelationRequest $request, Rating $rating): AnonymousResourceCollection
    {
        $comments = GetRatingComments::run($rating, RatingRelationIndexData::fromRequest($request));

        return CommentResource::collection($comments);
    }

    public function likes(RatingRelationRequest $request, Rating $rating): AnonymousResourceCollection
    {
        $likes = GetRatingLikes::run($rating, RatingRelationIndexData::fromRequest($request));

        return LikeResource::collection($likes);
    }

    public function like(Request $request, Rating $rating): JsonResponse
    {
        $success = LikeRating::run($rating, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже вподобали цей рейтинг.',
            ], 409);
        }

        return response()->json([
            'message' => 'Рейтинг успішно вподобано.',
        ], 201);
    }

    public function unlike(Request $request, Rating $rating): JsonResponse
    {
        $success = UnlikeRating::run($rating, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не вподобали цей рейтинг.',
            ], 404);
        }

        return response()->json([
            'message' => 'Вподобання успішно видалено.',
        ], 200);
    }
}
