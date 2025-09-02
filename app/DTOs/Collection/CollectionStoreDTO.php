<?php

namespace App\DTOs\Collection;

use Illuminate\Http\Request;

class CollectionStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $title Назва колекції
     * @param string|null $description Опис
     * @param string|null $coverImage Обкладинка
     * @param bool $isPublic Чи публічна колекція
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?string $coverImage = null,
        public readonly bool $isPublic = false
    ) {}

    /**
     * Створити CollectionStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            title: $request->input('title'),
            description: $request->input('description'),
            coverImage: $request->input('cover_image'),
            isPublic: $request->input('is_public', false)
        );
    }
}
