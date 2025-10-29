<?php

namespace App\Http\Controllers;

use App\Actions\Users\CreateUser;
use App\Actions\Users\FollowUser;
use App\Actions\Users\GetUserBooks;
use App\Actions\Users\GetUserComments;
use App\Actions\Users\GetUserFollowers;
use App\Actions\Users\GetUserFollowing;
use App\Actions\Users\GetUserGroups;
use App\Actions\Users\GetUserQuotes;
use App\Actions\Users\GetUserRatings;
use App\Actions\Users\GetUsers;
use App\Actions\Users\GetUserShelves;
use App\Actions\Users\GetUserStats;
use App\Actions\Users\UnfollowUser;
use App\Actions\Users\UpdateUser;
use App\Data\User\UserIndexData;
use App\Data\User\UserRelationIndexData;
use App\Data\User\UserStoreData;
use App\Data\User\UserUpdateData;
use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserRelationRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\ShelfResource;
use App\Http\Resources\UserBookResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function index(UserIndexRequest $request): AnonymousResourceCollection
    {
        $users = GetUsers::run(UserIndexData::fromRequest($request));

        return UserResource::collection($users);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user->load(['authors', 'shelves']));
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $user = CreateUser::run(UserStoreData::fromRequest($request));

        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user = UpdateUser::run($user, UserUpdateData::fromRequest($request));

        return new UserResource($user);
    }

    public function destroy(UserDeleteRequest $request, User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'Користувача успішно видалено.',
        ], 200);
    }

    public function books(UserRelationRequest $request, User $user): AnonymousResourceCollection
    {
        $books = GetUserBooks::run($user, UserRelationIndexData::fromRequest($request));

        return UserBookResource::collection($books);
    }

    public function shelves(UserRelationRequest $request, User $user): AnonymousResourceCollection
    {
        $shelves = GetUserShelves::run($user, UserRelationIndexData::fromRequest($request));

        return ShelfResource::collection($shelves);
    }

    public function ratings(UserRelationRequest $request, User $user): AnonymousResourceCollection
    {
        $ratings = GetUserRatings::run($user, UserRelationIndexData::fromRequest($request));

        return RatingResource::collection($ratings);
    }

    public function quotes(UserRelationRequest $request, User $user): AnonymousResourceCollection
    {
        $quotes = GetUserQuotes::run($user, UserRelationIndexData::fromRequest($request));

        return QuoteResource::collection($quotes);
    }

    public function comments(UserRelationRequest $request, User $user): AnonymousResourceCollection
    {
        $comments = GetUserComments::run($user, UserRelationIndexData::fromRequest($request));

        return CommentResource::collection($comments);
    }

    public function following(UserRelationRequest $request, User $user): AnonymousResourceCollection
    {
        $following = GetUserFollowing::run($user, UserRelationIndexData::fromRequest($request));

        return UserResource::collection($following);
    }

    public function followers(UserRelationRequest $request, User $user): AnonymousResourceCollection
    {
        $followers = GetUserFollowers::run($user, UserRelationIndexData::fromRequest($request));

        return UserResource::collection($followers);
    }

    public function groups(UserRelationRequest $request, User $user): AnonymousResourceCollection
    {
        $groups = GetUserGroups::run($user, UserRelationIndexData::fromRequest($request));

        return GroupResource::collection($groups);
    }

    public function stats(User $user): JsonResponse
    {
        $stats = GetUserStats::run($user);

        return response()->json($stats);
    }

    public function follow(Request $request, User $user): JsonResponse
    {
        $success = FollowUser::run($user, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже підписані на цього користувача.',
            ], 409);
        }

        return response()->json([
            'message' => 'Успішно підписано на користувача.',
        ], 201);
    }

    public function unfollow(Request $request, User $user): JsonResponse
    {
        $success = UnfollowUser::run($user, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не підписані на цього користувача.',
            ], 404);
        }

        return response()->json([
            'message' => 'Успішно відписано від користувача.',
        ], 200);
    }
}
