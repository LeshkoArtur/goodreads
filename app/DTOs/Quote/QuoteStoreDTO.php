<?php

namespace App\DTOs\Quote;

use Illuminate\Http\Request;

class QuoteStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $bookId ID книги
     * @param string $text Текст цитати
     * @param int|null $pageNumber Номер сторінки
     * @param bool $containsSpoilers Чи містить спойлери
     * @param bool $isPublic Чи публічна цитата
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $bookId,
        public readonly string $text,
        public readonly ?int $pageNumber = null,
        public readonly bool $containsSpoilers = false,
        public readonly bool $isPublic = true
    ) {}

    /**
     * Створити QuoteStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            bookId: $request->input('book_id'),
            text: $request->input('text'),
            pageNumber: $request->input('page_number'),
            containsSpoilers: $request->input('contains_spoilers', false),
            isPublic: $request->input('is_public', true)
        );
    }
}
