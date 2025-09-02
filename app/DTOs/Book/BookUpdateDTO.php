<?php

namespace App\DTOs\Book;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних книги.
 */
class BookUpdateDTO
{
    use HandlesJsonArrays;

    /**
     * Створює новий екземпляр BookUpdateDTO.
     *
     * @param string|null $title Назва книги
     * @param string|null $seriesId ID серії
     * @param int|null $pageCount Кількість сторінок
     * @param array|null $languages Мови книги
     * @param bool|null $isBestseller Статус бестселера
     * @param string|null $ageRestriction Вікове обмеження
     * @param string|null $description Опис книги
     * @param string|null $coverImage Обкладинка
     * @param array|null $authorIds Масив ID авторів
     * @param array|null $genreIds Масив ID жанрів
     * @param array|null $publisherIds Масив даних видавців із проміжною таблицею
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $seriesId = null,
        public readonly ?int $pageCount = null,
        public readonly ?array $languages = null,
        public readonly ?bool $isBestseller = null,
        public readonly ?string $ageRestriction = null,
        public readonly ?string $description = null,
        public readonly ?string $coverImage = null,
        public readonly ?array $authorIds = null,
        public readonly ?array $genreIds = null,
        public readonly ?array $publisherIds = null
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
            title: $request->input('title'),
            seriesId: $request->input('series_id'),
            pageCount: $request->input('page_count') ? (int) $request->input('page_count') : null,
            languages: self::processJsonArray($request->input('languages')),
            isBestseller: $request->has('is_bestseller') ? $request->boolean('is_bestseller') : null,
            ageRestriction: $request->input('age_restriction'),
            description: $request->input('description'),
            coverImage: $request->input('cover_image'),
            authorIds: self::processJsonArray($request->input('author_ids')),
            genreIds: self::processJsonArray($request->input('genre_ids')),
            publisherIds: self::processJsonArray($request->input('publisher_ids'))
        );
    }
}
