<?php

namespace App\Http\Resources;

use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Award
 */
class AwardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'year' => $this->year,
            'organizer' => $this->organizer,
            'country' => $this->country,
            'ceremony_date' => $this->ceremony_date,
            'nominations' => NominationResource::collection($this->whenLoaded('nominations')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
