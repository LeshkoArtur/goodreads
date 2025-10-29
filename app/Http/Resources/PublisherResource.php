<?php

namespace App\Http\Resources;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Publisher
 */
class PublisherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'website' => $this->website,
            'country' => $this->country,
            'founded_year' => $this->founded_year,
            'logo' => $this->logo,
            'contact_email' => $this->contact_email,
            'phone' => $this->phone,
            'pivot' => $this->whenPivotLoaded('book_publisher', function () {
                return [
                    'published_date' => $this->pivot->published_date,
                    'isbn' => $this->pivot->isbn,
                    'circulation' => $this->pivot->circulation,
                    'format' => $this->pivot->format,
                    'cover_type' => $this->pivot->cover_type,
                    'translator' => $this->pivot->translator,
                    'edition' => $this->pivot->edition,
                    'price' => $this->pivot->price,
                    'binding' => $this->pivot->binding,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
