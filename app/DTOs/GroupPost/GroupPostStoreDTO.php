<?php

namespace App\DTOs\GroupPost;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use Illuminate\Http\Request;

class GroupPostStoreDTO
{
    /**
     * @param string $groupId ID групи
     * @param string $userId ID користувача
     * @param string $content Текст посту
     * @param bool $isPinned Чи закріплено пост
     * @param PostCategory|null $category Категорія посту
     * @param PostStatus|null $postStatus Статус посту
     */
    public function __construct(
        public readonly string $groupId,
        public readonly string $userId,
        public readonly string $content,
        public readonly bool $isPinned = false,
        public readonly ?PostCategory $category = null,
        public readonly ?PostStatus $postStatus = null
    ) {}

    /**
     * Створити GroupPostStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            groupId: $request->input('group_id'),
            userId: $request->input('user_id'),
            content: $request->input('content'),
            isPinned: $request->input('is_pinned', false),
            category: $request->input('category') ? PostCategory::from($request->input('category')) : null,
            postStatus: $request->input('post_status') ? PostStatus::from($request->input('post_status')) : null
        );
    }
}
