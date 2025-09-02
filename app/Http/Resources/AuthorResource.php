<?php

namespace App\Http\Resources;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Author
 */
class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'birth_date' => $this->birth_date?->format('Y-m-d'),
            'birth_place' => $this->birth_place,
            'nationality' => $this->nationality,
            'website' => $this->website,
            'profile_picture' => $this->profile_picture,
            'death_date' => $this->death_date?->format('Y-m-d'),
            'social_media_links' => $this->social_media_links ?? [],
            'media_images' => $this->media_images ?? [],
            'media_videos' => $this->media_videos ?? [],
            'fun_facts' => $this->fun_facts ?? [],
            'type_of_work' => $this->type_of_work?->value,
            'books' => $this->whenLoaded('books', function () {
                return $this->books->map(fn($book) => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'slug' => $book->slug ?? null,
                ]);
            }),
            'users' => $this->whenLoaded('users', function () {
                return $this->users->map(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                ]);
            }),
            'questions_count' => $this->whenLoaded('questions', fn() => $this->questions->count()),
            'answers_count' => $this->whenLoaded('answers', fn() => $this->answers->count()),
            'posts_count' => $this->whenLoaded('posts', fn() => $this->posts->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
