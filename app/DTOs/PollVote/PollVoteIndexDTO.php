<?php

namespace App\DTOs\PollVote;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку голосів в опитуваннях.
 */
class PollVoteIndexDTO
{
    /**
     * Створює новий екземпляр PollVoteIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $groupPollId Фільтр за ID опитування
     * @param string|null $pollOptionId Фільтр за ID варіанту
     * @param string|null $userId Фільтр за ID користувача
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $groupPollId = null,
        public readonly ?string $pollOptionId = null,
        public readonly ?string $userId = null,
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
            groupPollId: $request->input('group_poll_id'),
            pollOptionId: $request->input('poll_option_id'),
            userId: $request->input('user_id'),
        );
    }
}
