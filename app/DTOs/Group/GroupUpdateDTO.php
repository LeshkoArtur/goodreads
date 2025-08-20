<?php

namespace App\DTOs\Group;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних групи.
 */
class GroupUpdateDTO
{
    /**
     * Створює новий екземпляр GroupUpdateDTO.
     *
     * @param string|null $name Назва групи
     * @param bool|null $isPublic Видимість групи
     * @param bool|null $isActive Активність групи
     * @param string|null $joinPolicy Політика приєднання
     * @param string|null $postPolicy Політика публікацій
     * @param string|null $description Опис групи
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?bool $isPublic = null,
        public readonly ?bool $isActive = null,
        public readonly ?string $joinPolicy = null,
        public readonly ?string $postPolicy = null,
        public readonly ?string $description = null,
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
            name: $request->input('name'),
            isPublic: $request->has('is_public') ? $request->boolean('is_public') : null,
            isActive: $request->has('is_active') ? $request->boolean('is_active') : null,
            joinPolicy: $request->input('join_policy'),
            postPolicy: $request->input('post_policy'),
            description: $request->input('description'),
        );
    }
}
