<?php

namespace App\DTOs\Book;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку книг.
 */
class BookIndexDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр BookIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $seriesId Фільтр за ID серії
     * @param int|null $minPageCount Мінімальна кількість сторінок
     * @param int|null $maxPageCount Максимальна кількість сторінок
     * @param array|null $languages Фільтр за мовами
     * @param bool|null $isBestseller Фільтр за статусом бестселера
     * @param float|null $minAverageRating Мінімальний середній рейтинг
     * @param float|null $maxAverageRating Максимальний середній рейтинг
     * @param string|null $ageRestriction Фільтр за віковими обмеженнями
     * @param array|null $authorIds Фільтр за ID авторів
     * @param array|null $genreIds Фільтр за ID жанрів
     * @param array|null $publisherIds Фільтр за ID видавців
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $seriesId = null,
        public readonly ?int $minPageCount = null,
        public readonly ?int $maxPageCount = null,
        public readonly ?array $languages = null,
        public readonly ?bool $isBestseller = null,
        public readonly ?float $minAverageRating = null,
        public readonly ?float $maxAverageRating = null,
        public readonly ?string $ageRestriction = null,
        public readonly ?array $authorIds = null,
        public readonly ?array $genreIds = null,
        public readonly ?array $publisherIds = null,
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
            seriesId: $request->input('series_id'),
            minPageCount: $request->input('min_page_count') ? (int) $request->input('min_page_count') : null,
            maxPageCount: $request->input('max_page_count') ? (int) $request->input('max_page_count') : null,
            languages: self::processArrayInput($request, 'languages'),
            isBestseller: $request->has('is_bestseller') ? (bool) $request->input('is_bestseller') : null,
            minAverageRating: $request->input('min_average_rating') ? (float) $request->input('min_average_rating') : null,
            maxAverageRating: $request->input('max_average_rating') ? (float) $request->input('max_average_rating') : null,
            ageRestriction: $request->input('age_restriction'),
            authorIds: self::processArrayInput($request, 'author_ids'),
            genreIds: self::processArrayInput($request, 'genre_ids'),
            publisherIds: self::processArrayInput($request, 'publisher_ids'),
        );
    }
}
