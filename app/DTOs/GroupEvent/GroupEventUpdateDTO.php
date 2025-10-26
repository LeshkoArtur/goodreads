<?php

namespace App\DTOs\GroupEvent;

use App\Enums\EventStatus;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних події групи.
 */
class GroupEventUpdateDTO
{
    /**
     * Створює новий екземпляр GroupEventUpdateDTO.
     *
     * @param string|null $title Назва події
     * @param string|null $description Опис події
     * @param string|null $eventDate Дата події
     * @param string|null $location Місце проведення
     * @param string|null $status Статус події
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?string $eventDate = null,
        public readonly ?string $location = null,
        public readonly ?string $status = null,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return self::makeDTO($request->all());
    }

    public static function fromArray(array $data): static
    {
        return self::makeDTO($data);
    }
    private static function makeDTO(array $data): static
    {
        return new static(
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            eventDate: $data['eventDate'] ?? null,
            location: $data['location'] ?? null,
            status: $data['status'] ?? null,
        );
    }
}
