<?php

namespace App\DTOs\Post;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних поста.
 */
class PostUpdateDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр PostUpdateDTO.
     *
     * @param string|null $title Назва поста
     * @param string|null $body Текст поста
     * @param string|null $type Тип поста
     * @param string|null $status Статус поста
     * @param string|null $publishedAt Дата публікації
     * @param array|null $tagIds ID тегів
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $body = null,
        public readonly ?string $type = null,
        public readonly ?string $status = null,
        public readonly ?string $publishedAt = null,
        public readonly ?array $tagIds = null,
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
            type: $request->input('type'),
            status: $request->input('status'),
            publishedAt: $request->input('published_at'),
            tagIds: self::processArrayInput($request, 'tag_ids'),
        );
    }
}
