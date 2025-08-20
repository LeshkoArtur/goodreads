<?php

namespace App\DTOs\NominationEntry;

use App\Enums\NominationStatus;
use Illuminate\Http\Request;

class NominationEntryStoreDTO
{
    /**
     * @param string $nominationId ID номінації
     * @param string $bookId ID книги
     * @param string $authorId ID автора
     * @param NominationStatus|null $status Статус номінації
     */
    public function __construct(
        public readonly string $nominationId,
        public readonly string $bookId,
        public readonly string $authorId,
        public readonly ?NominationStatus $status = null
    ) {}

    /**
     * Створити NominationEntryStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            nominationId: $request->input('nomination_id'),
            bookId: $request->input('book_id'),
            authorId: $request->input('author_id'),
            status: $request->input('status') ? NominationStatus::from($request->input('status')) : null
        );
    }
}
