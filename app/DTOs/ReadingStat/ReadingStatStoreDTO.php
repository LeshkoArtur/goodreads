<?php

namespace App\DTOs\ReadingStat;

use Illuminate\Http\Request;

class ReadingStatStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param int $year Рік
     * @param int $booksRead Кількість прочитаних книг
     * @param int $pagesRead Кількість прочитаних сторінок
     * @param array|null $genresRead Прочитані жанри
     */
    public function __construct(
        public readonly string $userId,
        public readonly int $year,
        public readonly int $booksRead,
        public readonly int $pagesRead,
        public readonly ?array $genresRead = null
    ) {}

    /**
     * Створити ReadingStatStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            year: $request->input('year'),
            booksRead: $request->input('books_read'),
            pagesRead: $request->input('pages_read'),
            genresRead: $request->input('genres_read')
        );
    }
}
