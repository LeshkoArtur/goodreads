<?php

namespace App\Http\Resources;

use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserBook
 */
class UserBookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'shelf_id' => $this->shelf_id,
            'start_date' => $this->start_date,
            'read_date' => $this->read_date,
            'progress_pages' => $this->progress_pages,
            'is_private' => $this->is_private,
            'rating' => $this->rating,
            'notes' => $this->notes,
            'reading_format' => $this->reading_format,
            'user' => new UserResource($this->whenLoaded('user')),
            'book' => new BookResource($this->whenLoaded('book')),
            'shelf' => new ShelfResource($this->whenLoaded('shelf')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
