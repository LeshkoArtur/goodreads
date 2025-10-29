<?php

namespace App\Http\Controllers;

use App\Actions\Groups\BanMember;
use App\Actions\Groups\CreateGroup;
use App\Actions\Groups\GetGroupActivity;
use App\Actions\Groups\GetGroupAdmins;
use App\Actions\Groups\GetGroupEvents;
use App\Actions\Groups\GetGroupInvitations;
use App\Actions\Groups\GetGroupMembers;
use App\Actions\Groups\GetGroupModerators;
use App\Actions\Groups\GetGroupPolls;
use App\Actions\Groups\GetGroupPosts;
use App\Actions\Groups\GetGroups;
use App\Actions\Groups\GetGroupStats;
use App\Actions\Groups\InviteUserToGroup;
use App\Actions\Groups\JoinGroup;
use App\Actions\Groups\LeaveGroup;
use App\Actions\Groups\RemoveMemberFromGroup;
use App\Actions\Groups\UnbanMember;
use App\Actions\Groups\UpdateGroup;
use App\Actions\Groups\UpdateMemberRole;
use App\Data\Group\GroupIndexData;
use App\Data\Group\GroupRelationIndexData;
use App\Data\Group\GroupStoreData;
use App\Data\Group\GroupUpdateData;
use App\Http\Requests\Group\GroupDeleteRequest;
use App\Http\Requests\Group\GroupIndexRequest;
use App\Http\Requests\Group\GroupRelationRequest;
use App\Http\Requests\Group\GroupStoreRequest;
use App\Http\Requests\Group\GroupUpdateRequest;
use App\Http\Resources\GroupEventResource;
use App\Http\Resources\GroupInvitationResource;
use App\Http\Resources\GroupPollResource;
use App\Http\Resources\GroupPostResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupController extends Controller
{
    public function index(GroupIndexRequest $request): AnonymousResourceCollection
    {
        $groups = GetGroups::run(GroupIndexData::fromRequest($request));

        return GroupResource::collection($groups);
    }

    public function show(Group $group): GroupResource
    {
        return new GroupResource($group->load(['creator', 'members']));
    }

    public function store(GroupStoreRequest $request): GroupResource
    {
        $group = CreateGroup::run(GroupStoreData::fromRequest($request));

        return new GroupResource($group);
    }

    public function update(GroupUpdateRequest $request, Group $group): GroupResource
    {
        $group = UpdateGroup::run($group, GroupUpdateData::fromRequest($request));

        return new GroupResource($group);
    }

    public function destroy(GroupDeleteRequest $request, Group $group): JsonResponse
    {
        $group->delete();

        return response()->json([
            'message' => 'Групу успішно видалено.',
        ], 200);
    }

    public function members(GroupRelationRequest $request, Group $group): AnonymousResourceCollection
    {
        $members = GetGroupMembers::run($group, GroupRelationIndexData::fromRequest($request));

        return UserResource::collection($members);
    }

    public function moderators(GroupRelationRequest $request, Group $group): AnonymousResourceCollection
    {
        $moderators = GetGroupModerators::run($group, GroupRelationIndexData::fromRequest($request));

        return UserResource::collection($moderators);
    }

    public function admins(GroupRelationRequest $request, Group $group): AnonymousResourceCollection
    {
        $admins = GetGroupAdmins::run($group, GroupRelationIndexData::fromRequest($request));

        return UserResource::collection($admins);
    }

    public function posts(GroupRelationRequest $request, Group $group): AnonymousResourceCollection
    {
        $posts = GetGroupPosts::run($group, GroupRelationIndexData::fromRequest($request));

        return GroupPostResource::collection($posts);
    }

    public function events(GroupRelationRequest $request, Group $group): AnonymousResourceCollection
    {
        $events = GetGroupEvents::run($group, GroupRelationIndexData::fromRequest($request));

        return GroupEventResource::collection($events);
    }

    public function polls(GroupRelationRequest $request, Group $group): AnonymousResourceCollection
    {
        $polls = GetGroupPolls::run($group, GroupRelationIndexData::fromRequest($request));

        return GroupPollResource::collection($polls);
    }

    public function invitations(GroupRelationRequest $request, Group $group): AnonymousResourceCollection
    {
        $invitations = GetGroupInvitations::run($group, GroupRelationIndexData::fromRequest($request));

        return GroupInvitationResource::collection($invitations);
    }

    public function stats(Group $group): JsonResponse
    {
        $stats = GetGroupStats::run($group);

        return response()->json($stats);
    }

    public function activity(Group $group): JsonResponse
    {
        $activity = GetGroupActivity::run($group);

        return response()->json($activity);
    }

    public function join(Request $request, Group $group): JsonResponse
    {
        $success = JoinGroup::run($group, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже є учасником цієї групи.',
            ], 409);
        }

        $message = match ($group->join_policy->value) {
            'open' => 'Ви успішно приєдналися до групи.',
            'request' => 'Запит на приєднання надіслано. Очікуйте схвалення.',
            'invite_only' => 'Ця група доступна лише за запрошеннями.',
            default => 'Запит надіслано.',
        };

        return response()->json(['message' => $message], 201);
    }

    public function leave(Request $request, Group $group): JsonResponse
    {
        $success = LeaveGroup::run($group, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не є учасником цієї групи.',
            ], 404);
        }

        return response()->json([
            'message' => 'Ви успішно покинули групу.',
        ], 200);
    }

    public function inviteUser(Request $request, Group $group, User $user): JsonResponse
    {
        $success = InviteUserToGroup::run($group, $request->user(), $user);

        if (! $success) {
            return response()->json([
                'message' => 'Користувач вже запрошений або є учасником групи.',
            ], 409);
        }

        return response()->json([
            'message' => 'Запрошення успішно надіслано.',
        ], 201);
    }

    public function removeMember(Request $request, Group $group, User $user): JsonResponse
    {
        $success = RemoveMemberFromGroup::run($group, $user);

        if (! $success) {
            return response()->json([
                'message' => 'Користувач не є учасником групи.',
            ], 404);
        }

        return response()->json([
            'message' => 'Учасника успішно видалено з групи.',
        ], 200);
    }

    public function updateMemberRole(Request $request, Group $group, User $user): JsonResponse
    {
        $roleValues = array_map(fn ($case) => $case->value, \App\Enums\MemberRole::cases());

        $request->validate([
            'role' => ['required', 'string', Rule::in($roleValues)],
        ]);

        $success = UpdateMemberRole::run($group, $user, $request->input('role'));

        if (! $success) {
            return response()->json([
                'message' => 'Не вдалося оновити роль користувача.',
            ], 400);
        }

        return response()->json([
            'message' => 'Роль користувача успішно оновлено.',
        ], 200);
    }

    public function banMember(Request $request, Group $group, User $user): JsonResponse
    {
        $success = BanMember::run($group, $user);

        if (! $success) {
            return response()->json([
                'message' => 'Користувач не є учасником групи.',
            ], 404);
        }

        return response()->json([
            'message' => 'Користувача успішно заблоковано.',
        ], 200);
    }

    public function unbanMember(Request $request, Group $group, User $user): JsonResponse
    {
        $success = UnbanMember::run($group, $user);

        if (! $success) {
            return response()->json([
                'message' => 'Користувач не заблокований у цій групі.',
            ], 404);
        }

        return response()->json([
            'message' => 'Користувача успішно розблоковано.',
        ], 200);
    }
}
