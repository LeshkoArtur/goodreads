<?php

namespace App\DTOs\PollOption;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку варіантів опитувань.
 */
class PollOptionIndexDTO
{
    /**
     * Створює новий екземпляр PollOptionIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $groupPollId Фільтр за ID опитування
     * @param int|null $minVoteCount Мінімальна кількість голосів
     * @param int|null $maxVoteCount Максимальна кількість голосів
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $groupPollId = null,
        public readonly ?int $minVoteCount = null,
        public readonly ?int $maxVoteCount = null,
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
            minVoteCount: $request->input('min_vote_count') ? (int) $request->input('min_vote_count') : null,
            maxVoteCount: $request->input('max_vote_count') ? (int) $request->input('max_vote_count') : null,
        );
    }
}
