<?php

namespace App\Http\Resources;

use App\Models\AuthorAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AuthorAnswer
 */
class AuthorAnswerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question_id' => $this->question_id,
            'author_id' => $this->author_id,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'status' => $this->status?->value,
            'author' => $this->whenLoaded('author', function () {
                return [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                    'profile_picture' => $this->author->profile_picture ?? null,
                ];
            }),
            'question' => $this->whenLoaded('question', function () {
                return [
                    'id' => $this->question->id,
                    'content' => $this->question->content,
                    'user_id' => $this->question->user_id,
                ];
            }),
            'likes' => $this->whenLoaded('likes', function () {
                return $this->likes->map(fn ($like) => [
                    'id' => $like->id,
                    'user_id' => $like->user_id,
                    'created_at' => $like->created_at,
                ]);
            }),
            'likes_count' => $this->whenCounted('likes'),
            'is_liked_by_user' => $this->when($request->user(), function () use ($request) {
                return $this->likes()->where('user_id', $request->user()->id)->exists();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
