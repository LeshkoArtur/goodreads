<?php

namespace App\Http\Controllers;

use App\Actions\GroupEvents\CancelRsvpToGroupEvent;
use App\Actions\GroupEvents\CreateGroupEvent;
use App\Actions\GroupEvents\GetGroupEventAttendees;
use App\Actions\GroupEvents\GetGroupEventGroup;
use App\Actions\GroupEvents\GetGroupEventRsvps;
use App\Actions\GroupEvents\GetGroupEvents;
use App\Actions\GroupEvents\RsvpToGroupEvent;
use App\Actions\GroupEvents\UpdateGroupEvent;
use App\Data\GroupEvent\GroupEventIndexData;
use App\Data\GroupEvent\GroupEventRelationIndexData;
use App\Data\GroupEvent\GroupEventRsvpData;
use App\Data\GroupEvent\GroupEventStoreData;
use App\Data\GroupEvent\GroupEventUpdateData;
use App\Http\Requests\GroupEvent\GroupEventDeleteRequest;
use App\Http\Requests\GroupEvent\GroupEventIndexRequest;
use App\Http\Requests\GroupEvent\GroupEventRelationRequest;
use App\Http\Requests\GroupEvent\GroupEventRsvpRequest;
use App\Http\Requests\GroupEvent\GroupEventStoreRequest;
use App\Http\Requests\GroupEvent\GroupEventUpdateRequest;
use App\Http\Resources\EventRsvpResource;
use App\Http\Resources\GroupEventResource;
use App\Http\Resources\GroupResource;
use App\Models\GroupEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupEventController extends Controller
{
    public function index(GroupEventIndexRequest $request): AnonymousResourceCollection
    {
        $groupEvents = GetGroupEvents::run(GroupEventIndexData::fromRequest($request));

        return GroupEventResource::collection($groupEvents);
    }

    public function show(GroupEvent $groupEvent): GroupEventResource
    {
        return new GroupEventResource($groupEvent->load(['group', 'creator']));
    }

    public function store(GroupEventStoreRequest $request): GroupEventResource
    {
        $groupEvent = CreateGroupEvent::run(GroupEventStoreData::fromRequest($request), $request->user());

        return new GroupEventResource($groupEvent);
    }

    public function update(GroupEventUpdateRequest $request, GroupEvent $groupEvent): GroupEventResource
    {
        $groupEvent = UpdateGroupEvent::run($groupEvent, GroupEventUpdateData::fromRequest($request));

        return new GroupEventResource($groupEvent);
    }

    public function destroy(GroupEventDeleteRequest $request, GroupEvent $groupEvent): JsonResponse
    {
        $groupEvent->delete();

        return response()->json([
            'message' => 'Подію групи успішно видалено.',
        ], 200);
    }

    public function group(GroupEvent $groupEvent): GroupResource
    {
        $group = GetGroupEventGroup::run($groupEvent);

        return new GroupResource($group);
    }

    public function rsvps(GroupEventRelationRequest $request, GroupEvent $groupEvent): AnonymousResourceCollection
    {
        $rsvps = GetGroupEventRsvps::run($groupEvent, GroupEventRelationIndexData::fromRequest($request));

        return EventRsvpResource::collection($rsvps);
    }

    public function attendees(GroupEventRelationRequest $request, GroupEvent $groupEvent): AnonymousResourceCollection
    {
        $attendees = GetGroupEventAttendees::run($groupEvent, GroupEventRelationIndexData::fromRequest($request));

        return EventRsvpResource::collection($attendees);
    }

    public function rsvp(GroupEventRsvpRequest $request, GroupEvent $groupEvent): EventRsvpResource
    {
        $rsvp = RsvpToGroupEvent::run($groupEvent, GroupEventRsvpData::fromRequest($request), $request->user());

        return new EventRsvpResource($rsvp);
    }

    public function cancelRsvp(Request $request, GroupEvent $groupEvent): JsonResponse
    {
        $success = CancelRsvpToGroupEvent::run($groupEvent, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не зареєстровані на цю подію.',
            ], 404);
        }

        return response()->json([
            'message' => 'RSVP успішно скасовано.',
        ], 200);
    }
}
