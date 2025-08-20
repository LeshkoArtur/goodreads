<?php

namespace App\DTOs\Character;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку персонажів.
 */
class CharacterIndexDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр CharacterIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $bookId Фільтр за ID книги
     * @param string|null $race Фільтр за расою
     * @param string|null $nationality Фільтр за національністю
     * @param string|null $residence Фільтр за місцем проживання
     * @param array|null $otherNames Фільтр за іншими іменами
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $bookId = null,
        public readonly ?string $race = null,
        public readonly ?string $nationality = null,
        public readonly ?string $residence = null,
        public readonly ?array $otherNames = null,
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
            bookId: $request->input('book_id'),
            race: $request->input('race'),
            nationality: $request->input('nationality'),
            residence: $request->input('residence'),
            otherNames: self::processArrayInput($request, 'other_names'),
        );
    }
}
