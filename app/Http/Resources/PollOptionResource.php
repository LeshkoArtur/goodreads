<?php

namespace App\Http\Resources;

use App\Models\PollOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PollOption
 */
class PollOptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_poll_id' => $this->group_poll_id,
            'text' => $this->text,
            'vote_count' => $this->vote_count,
            'group_poll' => new GroupPollResource($this->whenLoaded('poll')),
            'votes' => PollVoteResource::collection($this->whenLoaded('votes')),
            'votes_count' => $this->whenCounted('votes'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
