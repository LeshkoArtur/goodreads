<?php

namespace App\Actions\Posts;

use App\Data\Post\PostStoreData;
use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePost
{
    use AsAction;

    public function handle(PostStoreData $data): Post
    {
        $post = new Post;
        $post->user_id = $data->user_id;
        $post->title = $data->title;
        $post->content = $data->content;
        $post->book_id = $data->book_id;
        $post->author_id = $data->author_id;
        $post->cover_image = $data->cover_image;
        $post->published_at = $data->published_at;
        $post->type = $data->type;
        $post->status = $data->status;
        $post->save();

        when($data->tag_ids, fn () => $post->tags()->sync($data->tag_ids));

        return $post->fresh(['user', 'book', 'author', 'tags']);
    }
}
