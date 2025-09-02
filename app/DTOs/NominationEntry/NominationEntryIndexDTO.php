<?php

<<<<<<< HEAD
namespace App\DTOs\NominationEntry;
=======
namespace App\DTOs\NominationEntrie;
>>>>>>> ddf399eaeb167a63c56b43963d810c2306a971c3

use App\Enums\NominationStatus;
use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку записів номінацій.
 */
class NominationEntryIndexDTO
{
    /**
     * Створює новий екземпляр NominationEntryIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $nominationId Фільтр за ID номінації
     * @param string|null $bookId Фільтр за ID книги
     * @param string|null $authorId Фільтр за ID автора
     * @param string|null $status Фільтр за статусом
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $nominationId = null,
        public readonly ?string $bookId = null,
        public readonly ?string $authorId = null,
        public readonly ?string $status = null,
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
            nominationId: $request->input('nomination_id'),
            bookId: $request->input('book_id'),
            authorId: $request->input('author_id'),
            status: $request->input('status'),
        );
    }
}
