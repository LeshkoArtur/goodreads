<?php

namespace App\Http\Controllers;

use App\Actions\Likes\CreateLike;
use App\Actions\Likes\GetLikeLikeable;
use App\Actions\Likes\GetLikes;
use App\Actions\Likes\GetLikeUser;
use App\Actions\Likes\ToggleLike;
use App\Data\Like\LikeIndexData;
use App\Data\Like\LikeStoreData;
use App\Data\Like\LikeToggleData;
use App\Http\Requests\Like\LikeDeleteRequest;
use App\Http\Requests\Like\LikeIndexRequest;
use App\Http\Requests\Like\LikeStoreRequest;
use App\Http\Requests\Like\LikeToggleRequest;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeController extends Controller
{
    public function index(LikeIndexRequest $request): AnonymousResourceCollection
    {
        $likes = GetLikes::run(LikeIndexData::fromRequest($request));

        return LikeResource::collection($likes);
    }

    public function show(Like $like): LikeResource
    {
        return new LikeResource($like->load(['user', 'likeable']));
    }

    public function store(LikeStoreRequest $request): LikeResource
    {
        $like = CreateLike::run(LikeStoreData::fromRequest($request), $request->user());

        return new LikeResource($like);
    }

    public function destroy(LikeDeleteRequest $request, Like $like): JsonResponse
    {
        $like->delete();

        return response()->json([
            'message' => 'Лайк успішно видалено.',
        ], 200);
    }

    public function user(Like $like): UserResource
    {
        $user = GetLikeUser::run($like);

        return new UserResource($user);
    }

    public function likeable(Like $like): JsonResource
    {
        $likeable = GetLikeLikeable::run($like);

        if (! $likeable) {
            return response()->json([
                'message' => 'Об\'єкт лайка не знайдено.',
            ], 404);
        }

        return new JsonResource($likeable);
    }

    public function toggle(LikeToggleRequest $request): JsonResponse
    {
        $result = ToggleLike::run(LikeToggleData::fromRequest($request), $request->user());

        $statusCode = $result['action'] === 'liked' ? 201 : 200;

        return response()->json($result, $statusCode);
    }
}
