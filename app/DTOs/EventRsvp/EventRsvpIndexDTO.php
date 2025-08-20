<?php

namespace App\DTOs\EventRsvp;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку RSVP на події.
 */
class EventRsvpIndexDTO
{
    /**
     * Створює новий екземпляр EventRsvpIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $groupEventId Фільтр за ID події
     * @param string|null $userId Фільтр за ID користувача
     * @param string|null $response Фільтр за типом відповіді
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $groupEventId = null,
        public readonly ?string $userId = null,
        public readonly ?string $response = null,
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
            query: $request->input('q'),
            page: (int) $request->input('page', 1),
            perPage: (int) $request->input('per_page', 15),
            sort: $request->input('sort', 'created_at'),
            direction: $request->input('direction', 'desc'),
            groupEventId: $request->input('group_event_id'),
            userId: $request->input('user_id'),
            response: $request->input('response'),
        );
    }
}
