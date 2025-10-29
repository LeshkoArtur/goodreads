<?php

namespace App\Http\Resources;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Favorite
 */
class FavoriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'favoriteable_type' => $this->favoriteable_type,
            'favoriteable_id' => $this->favoriteable_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'favoriteable' => $this->when($this->relationLoaded('favoriteable'), function () {
                return match (get_class($this->favoriteable)) {
                    'App\Models\Book' => new BookResource($this->favoriteable),
                    'App\Models\Author' => new AuthorResource($this->favoriteable),
                    'App\Models\Quote' => new QuoteResource($this->favoriteable),
                    'App\Models\Post' => new PostResource($this->favoriteable),
                    default => null,
                };
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
