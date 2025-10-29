<?php

namespace App\Http\Resources;

use App\Models\Nomination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Nomination
 */
class NominationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'award_id' => $this->award_id,
            'name' => $this->name,
            'description' => $this->description,
            'award' => new AwardResource($this->whenLoaded('award')),
            'entries' => NominationEntryResource::collection($this->whenLoaded('entries')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
