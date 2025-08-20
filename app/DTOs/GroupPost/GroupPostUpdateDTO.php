<?php

namespace App\DTOs\GroupPost;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних поста групи.
 */
class GroupPostUpdateDTO
{
    /**
     * Створює новий екземпляр GroupPostUpdateDTO.
     *
     * @param string|null $title Назва поста
     * @param string|null $body Текст поста
     * @param bool|null $isPinned Статус закріплення
     * @param string|null $category Категорія поста
     * @param string|null $status Статус поста
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $body = null,
        public readonly ?bool $isPinned = null,
        public readonly ?string $category = null,
        public readonly ?string $status = null,
    ) {
    }

    /**
     * Створює новий екземпляр DTO з запиту.
     *
     * @param Request $request HTTP-запит
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            title: $request->input('title'),
            body: $request->input('body'),
            isPinned: $request->has('is_pinned') ? $request->boolean('is_pinned') : null,
            category: $request->input('category'),
            status: $request->input('status'),
        );
    }
}
