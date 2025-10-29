<?php

namespace App\Http\Resources;

use App\Models\ReadingStat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ReadingStat
 */
class ReadingStatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'year' => $this->year,
            'books_read' => $this->books_read,
            'pages_read' => $this->pages_read,
            'genres_read' => $this->genres_read ?? [],
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'username' => $this->user->username ?? null,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
