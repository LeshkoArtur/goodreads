<?php

namespace App\Http\Resources;

use App\Models\NominationEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin NominationEntry
 */
class NominationEntryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nomination_id' => $this->nomination_id,
            'book_id' => $this->book_id,
            'author_id' => $this->author_id,
            'status' => $this->status,
            'nomination' => new NominationResource($this->whenLoaded('nomination')),
            'book' => new BookResource($this->whenLoaded('book')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
