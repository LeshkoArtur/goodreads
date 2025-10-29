<?php

namespace App\Http\Resources;

use App\Models\GroupEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin GroupEvent
 */
class GroupEventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'creator_id' => $this->creator_id,
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'location' => $this->location,
            'status' => $this->status,
            'group' => new GroupResource($this->whenLoaded('group')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'rsvps' => EventRsvpResource::collection($this->whenLoaded('rsvps')),
            'rsvps_count' => $this->whenLoaded('rsvps', fn () => $this->rsvps->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
