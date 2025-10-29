<?php

namespace App\Http\Resources;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Group
 */
class GroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'creator_id' => $this->creator_id,
            'is_public' => $this->is_public,
            'cover_image' => $this->cover_image,
            'rules' => $this->rules,
            'member_count' => $this->member_count,
            'is_active' => $this->is_active,
            'join_policy' => $this->join_policy?->value,
            'post_policy' => $this->post_policy?->value,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'members' => UserResource::collection($this->whenLoaded('members')),
            'posts_count' => $this->whenLoaded('posts', fn () => $this->posts->count()),
            'events_count' => $this->whenLoaded('events', fn () => $this->events->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
