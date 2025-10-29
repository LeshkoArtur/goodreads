<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Book
 */
class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'plot' => $this->plot,
            'history' => $this->history,
            'number_in_series' => $this->number_in_series,
            'page_count' => $this->page_count,
            'languages' => $this->languages ?? [],
            'cover_image' => $this->cover_image,
            'fun_facts' => $this->fun_facts ?? [],
            'adaptations' => $this->adaptations ?? [],
            'is_bestseller' => $this->is_bestseller,
            'average_rating' => $this->average_rating,
            'age_restriction' => $this->age_restriction?->value,

            'series' => $this->whenLoaded('series', function () {
                return [
                    'id' => $this->series->id,
                    'title' => $this->series->title,
                ];
            }),

            'authors' => $this->whenLoaded('authors', function () {
                return $this->authors->map(fn ($author) => [
                    'id' => $author->id,
                    'name' => $author->name,
                ]);
            }),

            'genres' => $this->whenLoaded('genres', function () {
                return $this->genres->map(fn ($genre) => [
                    'id' => $genre->id,
                    'name' => $genre->name,
                ]);
            }),

            'publishers' => $this->whenLoaded('publishers', function () {
                return $this->publishers->map(fn ($publisher) => [
                    'id' => $publisher->id,
                    'name' => $publisher->name,
                    'pivot' => [
                        'published_date' => $publisher->pivot->published_date,
                        'isbn' => $publisher->pivot->isbn,
                        'circulation' => $publisher->pivot->circulation,
                        'format' => $publisher->pivot->format,
                        'cover_type' => $publisher->pivot->cover_type,
                        'translator' => $publisher->pivot->translator,
                        'edition' => $publisher->pivot->edition,
                        'price' => $publisher->pivot->price,
                        'binding' => $publisher->pivot->binding,
                    ],
                ]);
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
