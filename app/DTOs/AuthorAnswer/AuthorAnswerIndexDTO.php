<?php

namespace App\DTOs\AuthorAnswer;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку відповідей авторів.
 */
class AuthorAnswerIndexDTO
{
    use HandlesArrayInput;
    /**
     * Створює новий екземпляр AuthorAnswerIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $questionId Фільтр за ID питання
     * @param string|null $authorId Фільтр за ID автора
     * @param string|null $status Фільтр за статусом
     * @param string|null $minPublishedAt Мінімальна дата публікації
     * @param string|null $maxPublishedAt Максимальна дата публікації
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $questionId = null,
        public readonly ?string $authorId = null,
        public readonly ?string $status = null,
        public readonly ?string $minPublishedAt = null,
        public readonly ?string $maxPublishedAt = null,
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
            questionId: $request->input('question_id'),
            authorId: $request->input('author_id'),
            status: $request->input('status'),
            minPublishedAt: $request->input('min_published_at'),
            maxPublishedAt: $request->input('max_published_at'),
        );
    }
}
