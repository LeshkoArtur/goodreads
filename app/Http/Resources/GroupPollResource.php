<?php

namespace App\Http\Resources;

use App\Models\GroupPoll;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin GroupPoll
 */
class GroupPollResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'creator_id' => $this->creator_id,
            'question' => $this->question,
            'is_active' => $this->is_active,
            'group' => new GroupResource($this->whenLoaded('group')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'options' => PollOptionResource::collection($this->whenLoaded('options')),
            'votes' => PollVoteResource::collection($this->whenLoaded('votes')),
            'options_count' => $this->whenLoaded('options', fn () => $this->options->count()),
            'votes_count' => $this->whenLoaded('votes', fn () => $this->votes->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
