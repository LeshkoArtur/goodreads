<?php

namespace App\Http\Resources;

use App\Models\PollVote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PollVote
 */
class PollVoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_poll_id' => $this->group_poll_id,
            'poll_option_id' => $this->poll_option_id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'poll_option' => new PollOptionResource($this->whenLoaded('option')),
            'group_poll' => new GroupPollResource($this->whenLoaded('poll')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
