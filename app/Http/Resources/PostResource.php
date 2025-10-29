<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Post
 */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'cover_image' => $this->cover_image,
            'published_at' => $this->published_at,
            'type' => $this->type,
            'status' => $this->status,
            'likes_count' => $this->whenCounted('likes'),
            'comments_count' => $this->whenCounted('comments'),
            'user' => new UserResource($this->whenLoaded('user')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'book' => new BookResource($this->whenLoaded('book')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
