<?php

namespace App\Http\Controllers;

use App\Actions\EventRsvps\CreateEventRsvp;
use App\Actions\EventRsvps\GetEventRsvpEvent;
use App\Actions\EventRsvps\GetEventRsvps;
use App\Actions\EventRsvps\GetEventRsvpUser;
use App\Actions\EventRsvps\MarkEventRsvpGoing;
use App\Actions\EventRsvps\MarkEventRsvpMaybe;
use App\Actions\EventRsvps\MarkEventRsvpNotGoing;
use App\Actions\EventRsvps\UpdateEventRsvp;
use App\Data\EventRsvp\EventRsvpIndexData;
use App\Data\EventRsvp\EventRsvpStoreData;
use App\Data\EventRsvp\EventRsvpUpdateData;
use App\Http\Requests\EventRsvp\EventRsvpDeleteRequest;
use App\Http\Requests\EventRsvp\EventRsvpIndexRequest;
use App\Http\Requests\EventRsvp\EventRsvpStoreRequest;
use App\Http\Requests\EventRsvp\EventRsvpUpdateRequest;
use App\Http\Resources\EventRsvpResource;
use App\Http\Resources\GroupEventResource;
use App\Http\Resources\UserResource;
use App\Models\EventRsvp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventRsvpController extends Controller
{
    public function index(EventRsvpIndexRequest $request): AnonymousResourceCollection
    {
        $eventRsvps = GetEventRsvps::run(EventRsvpIndexData::fromRequest($request));

        return EventRsvpResource::collection($eventRsvps);
    }

    public function show(EventRsvp $eventRsvp): EventRsvpResource
    {
        return new EventRsvpResource($eventRsvp->load(['event', 'user']));
    }

    public function store(EventRsvpStoreRequest $request): EventRsvpResource
    {
        $eventRsvp = CreateEventRsvp::run(EventRsvpStoreData::fromRequest($request), $request->user());

        return new EventRsvpResource($eventRsvp);
    }

    public function update(EventRsvpUpdateRequest $request, EventRsvp $eventRsvp): EventRsvpResource
    {
        $eventRsvp = UpdateEventRsvp::run($eventRsvp, EventRsvpUpdateData::fromRequest($request));

        return new EventRsvpResource($eventRsvp);
    }

    public function destroy(EventRsvpDeleteRequest $request, EventRsvp $eventRsvp): JsonResponse
    {
        $eventRsvp->delete();

        return response()->json([
            'message' => 'RSVP успішно видалено.',
        ], 200);
    }

    public function event(EventRsvp $eventRsvp): GroupEventResource
    {
        $event = GetEventRsvpEvent::run($eventRsvp);

        return new GroupEventResource($event);
    }

    public function user(EventRsvp $eventRsvp): UserResource
    {
        $user = GetEventRsvpUser::run($eventRsvp);

        return new UserResource($user);
    }

    public function markGoing(Request $request, EventRsvp $eventRsvp): EventRsvpResource
    {
        $eventRsvp = MarkEventRsvpGoing::run($eventRsvp);

        return new EventRsvpResource($eventRsvp);
    }

    public function markNotGoing(Request $request, EventRsvp $eventRsvp): EventRsvpResource
    {
        $eventRsvp = MarkEventRsvpNotGoing::run($eventRsvp);

        return new EventRsvpResource($eventRsvp);
    }

    public function markMaybe(Request $request, EventRsvp $eventRsvp): EventRsvpResource
    {
        $eventRsvp = MarkEventRsvpMaybe::run($eventRsvp);

        return new EventRsvpResource($eventRsvp);
    }
}
