<?php

namespace App\DTOs\GroupPoll;

use Illuminate\Http\Request;

class GroupPollStoreDTO
{
    /**
     * @param string $groupId ID групи
     * @param string $creatorId ID творця
     * @param string $question Питання
     * @param bool $isActive Чи активне опитування
     */
    public function __construct(
        public readonly string $groupId,
        public readonly string $creatorId,
        public readonly string $question,
        public readonly bool $isActive = true
    ) {}

    /**
     * Створити GroupPollStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            groupId: $request->input('group_id'),
            creatorId: $request->input('creator_id'),
            question: $request->input('question'),
            isActive: $request->input('is_active', true)
        );
    }
}
