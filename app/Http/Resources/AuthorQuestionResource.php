<?php

namespace App\Http\Resources;

use App\Models\AuthorQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AuthorQuestion
 */
class AuthorQuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'author_id' => $this->author_id,
            'book_id' => $this->book_id,
            'content' => $this->content,
            'status' => $this->status?->value,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'avatar_url' => $this->user->avatar_url ?? null,
                ];
            }),
            'author' => $this->whenLoaded('author', function () {
                return [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                    'profile_picture' => $this->author->profile_picture ?? null,
                ];
            }),
            'book' => $this->whenLoaded('book', function () {
                return [
                    'id' => $this->book->id,
                    'title' => $this->book->title,
                    'slug' => $this->book->slug ?? null,
                ];
            }),
            'answers' => $this->whenLoaded('answers', function () {
                return $this->answers->map(fn ($answer) => [
                    'id' => $answer->id,
                    'content' => $answer->content,
                    'created_at' => $answer->created_at,
                ]);
            }),
            'answers_count' => $this->whenCounted('answers'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
