<?php

namespace App\Http\Controllers;

use App\Actions\GroupModerationLogs\CreateGroupModerationLog;
use App\Actions\GroupModerationLogs\GetGroupModerationLogGroup;
use App\Actions\GroupModerationLogs\GetGroupModerationLogModerator;
use App\Actions\GroupModerationLogs\GetGroupModerationLogs;
use App\Actions\GroupModerationLogs\GetGroupModerationLogsByGroup;
use App\Actions\GroupModerationLogs\GetGroupModerationLogsByModerator;
use App\Actions\GroupModerationLogs\GetGroupModerationLogsBySubject;
use App\Actions\GroupModerationLogs\GetGroupModerationLogTargetable;
use App\Data\GroupModerationLog\GroupModerationLogFilterData;
use App\Data\GroupModerationLog\GroupModerationLogIndexData;
use App\Data\GroupModerationLog\GroupModerationLogStoreData;
use App\Http\Requests\GroupModerationLog\GroupModerationLogFilterRequest;
use App\Http\Requests\GroupModerationLog\GroupModerationLogIndexRequest;
use App\Http\Requests\GroupModerationLog\GroupModerationLogStoreRequest;
use App\Http\Resources\GroupModerationLogResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\GroupModerationLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupModerationLogController extends Controller
{
    public function index(GroupModerationLogIndexRequest $request): AnonymousResourceCollection
    {
        $logs = GetGroupModerationLogs::run(GroupModerationLogIndexData::fromRequest($request));

        return GroupModerationLogResource::collection($logs);
    }

    public function show(GroupModerationLog $groupModerationLog): GroupModerationLogResource
    {
        return new GroupModerationLogResource($groupModerationLog->load(['group', 'moderator', 'targetable']));
    }

    public function store(GroupModerationLogStoreRequest $request): GroupModerationLogResource
    {
        $log = CreateGroupModerationLog::run(GroupModerationLogStoreData::fromRequest($request), $request->user());

        return new GroupModerationLogResource($log);
    }

    public function group(GroupModerationLog $groupModerationLog): GroupResource
    {
        $group = GetGroupModerationLogGroup::run($groupModerationLog);

        return new GroupResource($group);
    }

    public function moderator(GroupModerationLog $groupModerationLog): UserResource
    {
        $moderator = GetGroupModerationLogModerator::run($groupModerationLog);

        return new UserResource($moderator);
    }

    public function subject(GroupModerationLog $groupModerationLog): JsonResponse
    {
        $targetable = GetGroupModerationLogTargetable::run($groupModerationLog);

        if (! $targetable) {
            return response()->json([
                'message' => 'Об\'єкт модерації не знайдено.',
            ], 404);
        }

        $resource = match (get_class($targetable)) {
            'App\Models\GroupPost' => new \App\Http\Resources\GroupPostResource($targetable),
            'App\Models\Comment' => new \App\Http\Resources\CommentResource($targetable),
            default => null,
        };

        return response()->json($resource);
    }

    public function byGroup(GroupModerationLogFilterRequest $request, Group $group): AnonymousResourceCollection
    {
        $logs = GetGroupModerationLogsByGroup::run($group, GroupModerationLogFilterData::fromRequest($request));

        return GroupModerationLogResource::collection($logs);
    }

    public function byModerator(GroupModerationLogFilterRequest $request, User $user): AnonymousResourceCollection
    {
        $logs = GetGroupModerationLogsByModerator::run($user, GroupModerationLogFilterData::fromRequest($request));

        return GroupModerationLogResource::collection($logs);
    }

    public function bySubject(GroupModerationLogFilterRequest $request, User $user): AnonymousResourceCollection
    {
        $logs = GetGroupModerationLogsBySubject::run($user, GroupModerationLogFilterData::fromRequest($request));

        return GroupModerationLogResource::collection($logs);
    }
}
