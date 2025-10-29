<?php

namespace App\Http\Resources;

use App\Models\BookSeries;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin BookSeries
 */
class BookSeriesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'total_books' => $this->total_books,
            'is_completed' => $this->is_completed,
            'books_count' => $this->whenCounted('books'),
            'books' => BookResource::collection($this->whenLoaded('books')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
