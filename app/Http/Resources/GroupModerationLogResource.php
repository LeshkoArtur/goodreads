<?php

namespace App\Http\Resources;

use App\Models\GroupModerationLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin GroupModerationLog
 */
class GroupModerationLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'moderator_id' => $this->moderator_id,
            'action' => $this->action,
            'targetable_type' => $this->targetable_type,
            'targetable_id' => $this->targetable_id,
            'description' => $this->description,
            'group' => new GroupResource($this->whenLoaded('group')),
            'moderator' => new UserResource($this->whenLoaded('moderator')),
            'targetable' => $this->whenLoaded('targetable', function () {
                return match (get_class($this->targetable)) {
                    'App\Models\GroupPost' => new GroupPostResource($this->targetable),
                    'App\Models\Comment' => new CommentResource($this->targetable),
                    default => null,
                };
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
