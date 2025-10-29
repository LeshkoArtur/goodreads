<?php

namespace App\Http\Controllers;

use App\Actions\GroupPosts\CreateGroupPost;
use App\Actions\GroupPosts\GetGroupPostComments;
use App\Actions\GroupPosts\GetGroupPostGroup;
use App\Actions\GroupPosts\GetGroupPostLikes;
use App\Actions\GroupPosts\GetGroupPosts;
use App\Actions\GroupPosts\GetGroupPostUser;
use App\Actions\GroupPosts\LikeGroupPost;
use App\Actions\GroupPosts\PinGroupPost;
use App\Actions\GroupPosts\UnlikeGroupPost;
use App\Actions\GroupPosts\UnpinGroupPost;
use App\Actions\GroupPosts\UpdateGroupPost;
use App\Data\GroupPost\GroupPostIndexData;
use App\Data\GroupPost\GroupPostRelationIndexData;
use App\Data\GroupPost\GroupPostStoreData;
use App\Data\GroupPost\GroupPostUpdateData;
use App\Http\Requests\GroupPost\GroupPostDeleteRequest;
use App\Http\Requests\GroupPost\GroupPostIndexRequest;
use App\Http\Requests\GroupPost\GroupPostRelationRequest;
use App\Http\Requests\GroupPost\GroupPostStoreRequest;
use App\Http\Requests\GroupPost\GroupPostUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\GroupPostResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
use App\Models\GroupPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupPostController extends Controller
{
    public function index(GroupPostIndexRequest $request): AnonymousResourceCollection
    {
        $groupPosts = GetGroupPosts::run(GroupPostIndexData::fromRequest($request));

        return GroupPostResource::collection($groupPosts);
    }

    public function show(GroupPost $groupPost): GroupPostResource
    {
        return new GroupPostResource($groupPost->load(['group', 'user']));
    }

    public function store(GroupPostStoreRequest $request): GroupPostResource
    {
        $groupPost = CreateGroupPost::run(GroupPostStoreData::fromRequest($request), $request->user());

        return new GroupPostResource($groupPost);
    }

    public function update(GroupPostUpdateRequest $request, GroupPost $groupPost): GroupPostResource
    {
        $groupPost = UpdateGroupPost::run($groupPost, GroupPostUpdateData::fromRequest($request));

        return new GroupPostResource($groupPost);
    }

    public function destroy(GroupPostDeleteRequest $request, GroupPost $groupPost): JsonResponse
    {
        $groupPost->delete();

        return response()->json([
            'message' => 'Пост групи успішно видалено.',
        ], 200);
    }

    public function group(GroupPost $groupPost): GroupResource
    {
        $group = GetGroupPostGroup::run($groupPost);

        return new GroupResource($group);
    }

    public function user(GroupPost $groupPost): UserResource
    {
        $user = GetGroupPostUser::run($groupPost);

        return new UserResource($user);
    }

    public function comments(GroupPostRelationRequest $request, GroupPost $groupPost): AnonymousResourceCollection
    {
        $comments = GetGroupPostComments::run($groupPost, GroupPostRelationIndexData::fromRequest($request));

        return CommentResource::collection($comments);
    }

    public function likes(GroupPostRelationRequest $request, GroupPost $groupPost): AnonymousResourceCollection
    {
        $likes = GetGroupPostLikes::run($groupPost, GroupPostRelationIndexData::fromRequest($request));

        return LikeResource::collection($likes);
    }

    public function like(Request $request, GroupPost $groupPost): JsonResponse
    {
        $success = LikeGroupPost::run($groupPost, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже вподобали цей пост.',
            ], 409);
        }

        return response()->json([
            'message' => 'Пост успішно вподобано.',
        ], 201);
    }

    public function unlike(Request $request, GroupPost $groupPost): JsonResponse
    {
        $success = UnlikeGroupPost::run($groupPost, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не вподобали цей пост.',
            ], 404);
        }

        return response()->json([
            'message' => 'Вподобання посту успішно видалено.',
        ], 200);
    }

    public function pin(Request $request, GroupPost $groupPost): JsonResponse
    {
        $success = PinGroupPost::run($groupPost);

        if (! $success) {
            return response()->json([
                'message' => 'Пост вже закріплено.',
            ], 409);
        }

        return response()->json([
            'message' => 'Пост успішно закріплено.',
        ], 200);
    }

    public function unpin(Request $request, GroupPost $groupPost): JsonResponse
    {
        $success = UnpinGroupPost::run($groupPost);

        if (! $success) {
            return response()->json([
                'message' => 'Пост не закріплено.',
            ], 404);
        }

        return response()->json([
            'message' => 'Пост успішно відкріплено.',
        ], 200);
    }
}
