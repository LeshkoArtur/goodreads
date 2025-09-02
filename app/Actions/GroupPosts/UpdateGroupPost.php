<?php

namespace App\Actions\GroupPosts;

use App\DTOs\GroupPost\GroupPostUpdateDTO;
use App\Models\GroupPost;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupPost
{
    use AsAction;

    /**
     * Оновити існуючий пост групи.
     *
     * @param GroupPost $post
     * @param GroupPostUpdateDTO $dto
     * @return GroupPost
     */
    public function handle(GroupPost $post, GroupPostUpdateDTO $dto): GroupPost
    {
        $attributes = [
            'content' => $dto->body,
            'is_pinned' => $dto->isPinned,
            'category' => $dto->category,
            'post_status' => $dto->status,
        ];

        $post->fill(array_filter($attributes, fn($value) => $value !== null));

        $post->save();

        return $post->load(['group', 'user', 'comments', 'likes', 'favorites', 'moderationLogs']);
    }
}
