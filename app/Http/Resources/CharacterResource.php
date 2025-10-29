<?php

namespace App\Http\Resources;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Character
 */
class CharacterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'book_id' => $this->book_id,
            'name' => $this->name,
            'other_names' => $this->other_names,
            'race' => $this->race,
            'nationality' => $this->nationality,
            'residence' => $this->residence,
            'biography' => $this->biography,
            'fun_facts' => $this->fun_facts,
            'links' => $this->links,
            'media_images' => $this->media_images,
            'book' => new BookResource($this->whenLoaded('book')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
