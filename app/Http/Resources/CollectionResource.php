<?php

namespace App\Http\Resources;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Collection
 */
class CollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'is_public' => $this->is_public,
            'books_count' => $this->whenCounted('books'),
            'user' => new UserResource($this->whenLoaded('user')),
            'books' => BookResource::collection($this->whenLoaded('books')),
            'pivot' => $this->whenPivotLoaded('book_collection', function () {
                return [
                    'order_index' => $this->pivot->order_index,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
