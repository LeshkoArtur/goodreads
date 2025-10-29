<?php

namespace App\Http\Controllers;

use App\Actions\GroupInvitations\AcceptGroupInvitation;
use App\Actions\GroupInvitations\BulkAcceptGroupInvitations;
use App\Actions\GroupInvitations\BulkRejectGroupInvitations;
use App\Actions\GroupInvitations\CreateGroupInvitation;
use App\Actions\GroupInvitations\GetGroupInvitationGroup;
use App\Actions\GroupInvitations\GetGroupInvitationInvitee;
use App\Actions\GroupInvitations\GetGroupInvitationInviter;
use App\Actions\GroupInvitations\GetGroupInvitations;
use App\Actions\GroupInvitations\GetPendingGroupInvitations;
use App\Actions\GroupInvitations\GetReceivedGroupInvitations;
use App\Actions\GroupInvitations\GetSentGroupInvitations;
use App\Actions\GroupInvitations\RejectGroupInvitation;
use App\Data\GroupInvitation\GroupInvitationBulkData;
use App\Data\GroupInvitation\GroupInvitationFilterData;
use App\Data\GroupInvitation\GroupInvitationIndexData;
use App\Data\GroupInvitation\GroupInvitationStoreData;
use App\Http\Requests\GroupInvitation\GroupInvitationBulkRequest;
use App\Http\Requests\GroupInvitation\GroupInvitationDeleteRequest;
use App\Http\Requests\GroupInvitation\GroupInvitationFilterRequest;
use App\Http\Requests\GroupInvitation\GroupInvitationIndexRequest;
use App\Http\Requests\GroupInvitation\GroupInvitationStoreRequest;
use App\Http\Resources\GroupInvitationResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\GroupInvitation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupInvitationController extends Controller
{
    public function index(GroupInvitationIndexRequest $request): AnonymousResourceCollection
    {
        $groupInvitations = GetGroupInvitations::run(GroupInvitationIndexData::fromRequest($request));

        return GroupInvitationResource::collection($groupInvitations);
    }

    public function show(GroupInvitation $groupInvitation): GroupInvitationResource
    {
        return new GroupInvitationResource($groupInvitation->load(['group', 'inviter', 'invitee']));
    }

    public function store(GroupInvitationStoreRequest $request): GroupInvitationResource
    {
        $groupInvitation = CreateGroupInvitation::run(GroupInvitationStoreData::fromRequest($request), $request->user());

        return new GroupInvitationResource($groupInvitation);
    }

    public function destroy(GroupInvitationDeleteRequest $request, GroupInvitation $groupInvitation): JsonResponse
    {
        $groupInvitation->delete();

        return response()->json([
            'message' => 'Запрошення групи успішно видалено.',
        ], 200);
    }

    public function group(GroupInvitation $groupInvitation): GroupResource
    {
        $group = GetGroupInvitationGroup::run($groupInvitation);

        return new GroupResource($group);
    }

    public function inviter(GroupInvitation $groupInvitation): UserResource
    {
        $inviter = GetGroupInvitationInviter::run($groupInvitation);

        return new UserResource($inviter);
    }

    public function invitee(GroupInvitation $groupInvitation): UserResource
    {
        $invitee = GetGroupInvitationInvitee::run($groupInvitation);

        return new UserResource($invitee);
    }

    public function pending(GroupInvitationFilterRequest $request): AnonymousResourceCollection
    {
        $invitations = GetPendingGroupInvitations::run($request->user(), GroupInvitationFilterData::fromRequest($request));

        return GroupInvitationResource::collection($invitations);
    }

    public function sent(GroupInvitationFilterRequest $request): AnonymousResourceCollection
    {
        $invitations = GetSentGroupInvitations::run($request->user(), GroupInvitationFilterData::fromRequest($request));

        return GroupInvitationResource::collection($invitations);
    }

    public function received(GroupInvitationFilterRequest $request): AnonymousResourceCollection
    {
        $invitations = GetReceivedGroupInvitations::run($request->user(), GroupInvitationFilterData::fromRequest($request));

        return GroupInvitationResource::collection($invitations);
    }

    public function accept(Request $request, GroupInvitation $groupInvitation): GroupInvitationResource
    {
        $groupInvitation = AcceptGroupInvitation::run($groupInvitation);

        return new GroupInvitationResource($groupInvitation);
    }

    public function reject(Request $request, GroupInvitation $groupInvitation): GroupInvitationResource
    {
        $groupInvitation = RejectGroupInvitation::run($groupInvitation);

        return new GroupInvitationResource($groupInvitation);
    }

    public function bulkAccept(GroupInvitationBulkRequest $request): JsonResponse
    {
        $count = BulkAcceptGroupInvitations::run(GroupInvitationBulkData::fromRequest($request), $request->user());

        return response()->json([
            'message' => "Успішно прийнято {$count} запрошень.",
            'count' => $count,
        ], 200);
    }

    public function bulkReject(GroupInvitationBulkRequest $request): JsonResponse
    {
        $count = BulkRejectGroupInvitations::run(GroupInvitationBulkData::fromRequest($request), $request->user());

        return response()->json([
            'message' => "Успішно відхилено {$count} запрошень.",
            'count' => $count,
        ], 200);
    }
}
