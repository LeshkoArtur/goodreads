<?php

namespace App\Actions\GroupPosts;

use App\DTOs\GroupPost\GroupPostStoreDTO;
use App\Models\GroupPost;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupPost
{
    use AsAction;

    /**
     * Створити новий пост групи.
     *
     * @param GroupPostStoreDTO $dto
     * @return GroupPost
     */
    public function handle(GroupPostStoreDTO $dto): GroupPost
    {
        $post = new GroupPost();
        $post->group_id = $dto->groupId;
        $post->user_id = $dto->userId;
        $post->content = $dto->content;
        $post->is_pinned = $dto->isPinned;
        $post->category = $dto->category?->value;
        $post->post_status = $dto->postStatus?->value;

        $post->save();

        return $post->load(['group', 'user', 'comments', 'likes', 'favorites', 'moderationLogs']);
    }
}
