<?php

namespace App\Http\Resources;

use App\Models\GroupPost;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin GroupPost
 */
class GroupPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'is_pinned' => $this->is_pinned,
            'category' => $this->category,
            'post_status' => $this->post_status,
            'group' => new GroupResource($this->whenLoaded('group')),
            'user' => new UserResource($this->whenLoaded('user')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'comments_count' => $this->whenLoaded('comments', fn () => $this->comments->count()),
            'likes_count' => $this->whenLoaded('likes', fn () => $this->likes->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
