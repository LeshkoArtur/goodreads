<?php

namespace App\DTOs\Note;

use Illuminate\Http\Request;

class NoteStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $bookId ID книги
     * @param string $text Текст нотатки
     * @param int|null $pageNumber Номер сторінки
     * @param bool $containsSpoilers Чи містить спойлери
     * @param bool $isPrivate Чи приватна нотатка
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $bookId,
        public readonly string $text,
        public readonly ?int $pageNumber = null,
        public readonly bool $containsSpoilers = false,
        public readonly bool $isPrivate = false
    ) {}

    /**
     * Створити NoteStoreDTO з HTTP-запиту
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
            isPrivate: $request->input('is_private', false)
        );
    }
}
