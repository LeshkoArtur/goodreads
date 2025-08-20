<?php

namespace App\DTOs\GroupModerationLog;

use Illuminate\Http\Request;

class GroupModerationLogStoreDTO
{
    /**
     * @param string $groupId ID групи
     * @param string $moderatorId ID модератора
     * @param string $action Дія
     * @param string $targetableId ID цільового об'єкта
     * @param string $targetableType Тип цільового об'єкта
     * @param string|null $description Опис
     */
    public function __construct(
        public readonly string $groupId,
        public readonly string $moderatorId,
        public readonly string $action,
        public readonly string $targetableId,
        public readonly string $targetableType,
        public readonly ?string $description = null
    ) {}

    /**
     * Створити GroupModerationLogStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            groupId: $request->input('group_id'),
            moderatorId: $request->input('moderator_id'),
            action: $request->input('action'),
            targetableId: $request->input('targetable_id'),
            targetableType: $request->input('targetable_type'),
            description: $request->input('description')
        );
    }
}
