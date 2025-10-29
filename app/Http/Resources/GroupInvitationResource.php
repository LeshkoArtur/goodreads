<?php

namespace App\Http\Resources;

use App\Models\GroupInvitation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin GroupInvitation
 */
class GroupInvitationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'inviter_id' => $this->inviter_id,
            'invitee_id' => $this->invitee_id,
            'status' => $this->status,
            'group' => new GroupResource($this->whenLoaded('group')),
            'inviter' => new UserResource($this->whenLoaded('inviter')),
            'invitee' => new UserResource($this->whenLoaded('invitee')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
