<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Comment
 */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'commentable_type' => $this->commentable_type,
            'commentable_id' => $this->commentable_id,
            'content' => $this->content,
            'parent_id' => $this->parent_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'commentable' => $this->when($this->relationLoaded('commentable'), function () {
                return match (get_class($this->commentable)) {
                    'App\Models\Book' => new BookResource($this->commentable),
                    'App\Models\Review' => new ReviewResource($this->commentable),
                    'App\Models\Post' => new PostResource($this->commentable),
                    default => null,
                };
            }),
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
            'replies_count' => $this->whenLoaded('replies', fn () => $this->replies->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
