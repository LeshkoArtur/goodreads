<?php

namespace App\Http\Resources;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Quote
 */
class QuoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'text' => $this->text,
            'page_number' => $this->page_number,
            'contains_spoilers' => $this->contains_spoilers,
            'is_public' => $this->is_public,
            'likes_count' => $this->whenCounted('likes'),
            'user' => new UserResource($this->whenLoaded('user')),
            'book' => new BookResource($this->whenLoaded('book')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
