<?php

namespace App\Actions\Posts;

use App\DTOs\Post\PostStoreDTO;
use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePost
{
    use AsAction;

    /**
     * Створити новий пост.
     *
     * @param PostStoreDTO $dto
     * @return Post
     */
    public function handle(PostStoreDTO $dto): Post
    {
        $post = new Post();
        $post->user_id = $dto->userId;
        $post->book_id = $dto->bookId;
        $post->author_id = $dto->authorId;
        $post->title = $dto->title;
        $post->content = $dto->content;
        $post->cover_image = $dto->coverImage;
        $post->published_at = $dto->publishedAt;
        $post->type = $dto->type?->value;
        $post->status = $dto->status?->value;

        if ($dto->coverImage) {
            $post->cover_image = $post->handleFileUpload($dto->coverImage, 'covers');
        }

        $post->save();

        if ($dto->tagIds) {
            $post->tags()->sync($dto->tagIds);
        }

        return $post->load(['user', 'book', 'author', 'comments', 'likes', 'favorites', 'tags']);
    }
}
