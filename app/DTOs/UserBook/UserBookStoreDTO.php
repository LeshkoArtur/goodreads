<?php

namespace App\DTOs\UserBook;

use App\Enums\ReadingFormat;
use Illuminate\Http\Request;

class UserBookStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $bookId ID книги
     * @param string|null $shelfId ID полиці
     * @param string|null $startDate Дата початку читання у форматі Y-m-d
     * @param string|null $readDate Дата завершення читання у форматі Y-m-d
     * @param int|null $progressPages Прогрес у сторінках
     * @param bool $isPrivate Чи приватна
     * @param int|null $rating Оцінка
     * @param string|null $notes Нотатки
     * @param ReadingFormat|null $readingFormat Формат читання
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $bookId,
        public readonly ?string $shelfId = null,
        public readonly ?string $startDate = null,
        public readonly ?string $readDate = null,
        public readonly ?int $progressPages = null,
        public readonly bool $isPrivate = false,
        public readonly ?int $rating = null,
        public readonly ?string $notes = null,
        public readonly ?ReadingFormat $readingFormat = null
    ) {}

    /**
     * Створити UserBookStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            bookId: $request->input('book_id'),
            shelfId: $request->input('shelf_id'),
            startDate: $request->input('start_date'),
            readDate: $request->input('read_date'),
            progressPages: $request->input('progress_pages'),
            isPrivate: $request->input('is_private', false),
            rating: $request->input('rating'),
            notes: $request->input('notes'),
            readingFormat: $request->input('reading_format') ? ReadingFormat::from($request->input('reading_format')) : null
        );
    }
}
