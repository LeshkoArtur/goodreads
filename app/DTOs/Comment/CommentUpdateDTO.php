<?php

namespace App\DTOs\Comment;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних коментаря.
 */
class CommentUpdateDTO
{
    /**
     * Створює новий екземпляр CommentUpdateDTO.
     *
     * @param string|null $body Текст коментаря
     * @param bool|null $isSpoiler Чи містить коментар спойлери
     */
    public function __construct(
        public readonly ?string $body = null,
        public readonly ?bool $isSpoiler = null,
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
            isSpoiler: $request->has('is_spoiler') ? $request->boolean('is_spoiler') : null,
        );
    }
}
