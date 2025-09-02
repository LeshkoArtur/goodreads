<?php

namespace App\DTOs\Book;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\AgeRestriction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookStoreDTO
{
    use HandlesJsonArrays;

    /**
     * @param string $title Назва книги
     * @param string|null $description Опис
     * @param string|null $plot Сюжет
     * @param string|null $history Історія створення
     * @param string|null $seriesId ID серії
     * @param int|null $numberInSeries Номер у серії
     * @param int|null $pageCount Кількість сторінок
     * @param array|Collection|null $languages Мови
     * @param string|null $coverImage Обкладинка
     * @param array|Collection|null $funFacts Цікаві факти
     * @param array|Collection|null $adaptations Екранізації / адаптації
     * @param bool $isBestseller Чи є бестселером
     * @param float|null $averageRating Середній рейтинг
     * @param AgeRestriction|null $ageRestriction Вікові обмеження
     * @param array|null $authorIds Масив ID авторів
     * @param array|null $genreIds Масив ID жанрів
     * @param array|null $publisherIds Масив даних видавців із проміжною таблицею
     */
    public function __construct(
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?string $plot = null,
        public readonly ?string $history = null,
        public readonly ?string $seriesId = null,
        public readonly ?int $numberInSeries = null,
        public readonly ?int $pageCount = null,
        public readonly array|Collection|null $languages = null,
        public readonly ?string $coverImage = null,
        public readonly array|Collection|null $funFacts = null,
        public readonly array|Collection|null $adaptations = null,
        public readonly bool $isBestseller = false,
        public readonly ?float $averageRating = null,
        public readonly ?AgeRestriction $ageRestriction = null,
        public readonly ?array $authorIds = null,
        public readonly ?array $genreIds = null,
        public readonly ?array $publisherIds = null
    ) {
    }

    /**
     * Створити BookStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public
    static function fromRequest(
        Request $request
    ): static {
        return new static(
            title: $request->input('title'),
            description: $request->input('description'),
            plot: $request->input('plot'),
            history: $request->input('history'),
            seriesId: $request->input('series_id'),
            numberInSeries: $request->input('number_in_series') !== null ? (int)$request->input(
                'number_in_series'
            ) : null,
            pageCount: $request->input('page_count') !== null ? (int)$request->input('page_count') : null,
            languages: self::processJsonArray($request->input('languages')),
            coverImage: $request->input('cover_image'),
            funFacts: self::processJsonArray($request->input('fun_facts')),
            adaptations: self::processJsonArray($request->input('adaptations')),
            isBestseller: $request->boolean('is_bestseller', false),
            averageRating: $request->input('average_rating') !== null ? (float)$request->input('average_rating') : null,
            ageRestriction: $request->input('age_restriction')
                ? AgeRestriction::from($request->input('age_restriction'))
                : null,
            authorIds: self::processJsonArray($request->input('author_ids')),
            genreIds: self::processJsonArray($request->input('genre_ids')),
            publisherIds: self::processJsonArray($request->input('publisher_ids'))
        );
    }
}
