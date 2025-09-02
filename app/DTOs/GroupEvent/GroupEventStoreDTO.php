<?php

namespace App\DTOs\GroupEvent;

use App\Enums\EventStatus;
use Illuminate\Http\Request;

class GroupEventStoreDTO
{
    /**
     * @param string $groupId ID групи
     * @param string $creatorId ID творця
     * @param string $title Назва події
     * @param string|null $description Опис
     * @param string|null $eventDate Дата події у форматі Y-m-d H:i:s
     * @param string|null $location Місце проведення
     * @param EventStatus|null $status Статус події
     */
    public function __construct(
        public readonly string $groupId,
        public readonly string $creatorId,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?string $eventDate = null,
        public readonly ?string $location = null,
        public readonly ?EventStatus $status = null
    ) {}

    /**
     * Створити GroupEventStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            groupId: $request->input('group_id'),
            creatorId: $request->input('creator_id'),
            title: $request->input('title'),
            description: $request->input('description'),
            eventDate: $request->input('event_date'),
            location: $request->input('location'),
            status: $request->input('status') ? EventStatus::from($request->input('status')) : null
        );
    }
}
