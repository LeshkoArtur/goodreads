<?php

namespace App\DTOs\Note;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних нотатки.
 */
class NoteUpdateDTO
{
    /**
     * Створює новий екземпляр NoteUpdateDTO.
     *
     * @param string|null $body Текст нотатки
     * @param bool|null $containsSpoilers Чи містить спойлери
     * @param bool|null $isPrivate Приватність нотатки
     * @param int|null $pageNumber Номер сторінки
     */
    public function __construct(
        public readonly ?string $body = null,
        public readonly ?bool $containsSpoilers = null,
        public readonly ?bool $isPrivate = null,
        public readonly ?int $pageNumber = null,
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
            body: $request->input('body'),
            containsSpoilers: $request->has('contains_spoilers') ? $request->boolean('contains_spoilers') : null,
            isPrivate: $request->has('is_private') ? $request->boolean('is_private') : null,
            pageNumber: $request->input('page_number') ? (int) $request->input('page_number') : null,
        );
    }
}
