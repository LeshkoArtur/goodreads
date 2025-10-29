<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->when($request->user()?->id === $this->id, $this->email),
            'profile_picture' => $this->profile_picture,
            'bio' => $this->bio,
            'location' => $this->location,
            'is_public' => $this->is_public,
            'birthday' => $this->birthday?->format('Y-m-d'),
            'gender' => $this->gender?->value,
            'role' => $this->role?->value,
            'social_media_links' => $this->social_media_links ?? [],
            'last_login' => $this->last_login,
            'authors' => $this->whenLoaded('authors', function () {
                return $this->authors->map(fn ($author) => [
                    'id' => $author->id,
                    'name' => $author->name,
                ]);
            }),
            'shelves' => $this->whenLoaded('shelves', function () {
                return $this->shelves->map(fn ($shelf) => [
                    'id' => $shelf->id,
                    'name' => $shelf->name,
                ]);
            }),
            'followers_count' => $this->whenLoaded('followers', fn () => $this->followers->count()),
            'following_count' => $this->whenLoaded('following', fn () => $this->following->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'pivot' => $this->whenPivotLoaded('author_user', function () {
                return [
                    'created_at' => $this->pivot->created_at,
                ];
            }),
        ];
    }
}
