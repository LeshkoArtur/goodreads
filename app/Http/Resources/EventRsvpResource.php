<?php

namespace App\Http\Resources;

use App\Models\EventRsvp;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin EventRsvp
 */
class EventRsvpResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_event_id' => $this->group_event_id,
            'user_id' => $this->user_id,
            'response' => $this->response,
            'user' => new UserResource($this->whenLoaded('user')),
            'group_event' => new GroupEventResource($this->whenLoaded('event')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
