<?php

namespace App\Actions\Posts;

use App\DTOs\Post\PostUpdateDTO;
use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePost
{
    use AsAction;

    /**
     * Оновити існуючий пост.
     *
     * @param Post $post
     * @param PostUpdateDTO $dto
     * @return Post
     */
    public function handle(Post $post, PostUpdateDTO $dto): Post
    {
        $attributes = [
            'title' => $dto->title,
            'content' => $dto->body,
            'type' => $dto->type,
            'status' => $dto->status,
            'published_at' => $dto->publishedAt,
        ];

        $post->fill(array_filter($attributes, fn($value) => $value !== null));

        $post->save();

        if ($dto->tagIds !== null) {
            $post->tags()->sync($dto->tagIds);
        }

        return $post->load(['user', 'book', 'author', 'comments', 'likes', 'favorites', 'tags']);
    }
}
