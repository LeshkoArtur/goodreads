<?php

namespace App\DTOs\Group;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Http\Request;

class GroupStoreDTO
{
    /**
     * @param string $name Назва групи
     * @param string|null $description Опис
     * @param string $creatorId ID творця
     * @param bool $isPublic Чи публічна група
     * @param string|null $coverImage Обкладинка
     * @param string|null $rules Правила
     * @param int|null $memberCount Кількість учасників
     * @param bool $isActive Чи активна група
     * @param JoinPolicy|null $joinPolicy Політика приєднання
     * @param PostPolicy|null $postPolicy Політика публікацій
     */
    public function __construct(
        public readonly string $name,
        public readonly string $creatorId,
        public readonly bool $isPublic = false,
        public readonly ?string $description = null,
        public readonly ?string $coverImage = null,
        public readonly ?string $rules = null,
        public readonly ?int $memberCount = null,
        public readonly bool $isActive = true,
        public readonly ?JoinPolicy $joinPolicy = null,
        public readonly ?PostPolicy $postPolicy = null
    ) {}

    /**
     * Створити GroupStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            name: $request->input('name'),
            description: $request->input('description'),
            creatorId: $request->input('creator_id'),
            isPublic: $request->input('is_public', false),
            coverImage: $request->input('cover_image'),
            rules: $request->input('rules'),
            memberCount: $request->input('member_count'),
            isActive: $request->input('is_active', true),
            joinPolicy: $request->input('join_policy') ? JoinPolicy::from($request->input('join_policy')) : null,
            postPolicy: $request->input('post_policy') ? PostPolicy::from($request->input('post_policy')) : null
        );
    }
}
