<?php

namespace App\Http\Resources;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Like
 */
class LikeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'likeable_type' => $this->likeable_type,
            'likeable_id' => $this->likeable_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'likeable' => $this->when($this->relationLoaded('likeable'), function () {
                return match (get_class($this->likeable)) {
                    'App\Models\Rating' => new RatingResource($this->likeable),
                    'App\Models\Quote' => new QuoteResource($this->likeable),
                    'App\Models\Comment' => new CommentResource($this->likeable),
                    'App\Models\Post' => new PostResource($this->likeable),
                    'App\Models\AuthorAnswer' => new AuthorAnswerResource($this->likeable),
                    default => null,
                };
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
