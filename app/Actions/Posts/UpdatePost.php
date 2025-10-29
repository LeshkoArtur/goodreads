<?php

namespace App\Actions\Posts;

use App\Data\Post\PostUpdateData;
use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePost
{
    use AsAction;

    public function handle(Post $post, PostUpdateData $data): Post
    {
        $post->update(array_filter([
            'user_id' => $data->user_id,
            'title' => $data->title,
            'content' => $data->content,
            'book_id' => $data->book_id,
            'author_id' => $data->author_id,
            'cover_image' => $data->cover_image,
            'published_at' => $data->published_at,
            'type' => $data->type,
            'status' => $data->status,
        ], fn ($value) => $value !== null));

        when($data->tag_ids !== null, fn () => $post->tags()->sync($data->tag_ids));

        return $post->fresh(['user', 'book', 'author', 'tags']);
    }
}
