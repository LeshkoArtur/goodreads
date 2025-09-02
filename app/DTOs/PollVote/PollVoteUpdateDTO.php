<?php

namespace App\DTOs\PollVote;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних голосу в опитуванні.
 */
class PollVoteUpdateDTO
{
    /**
     * Створює новий екземпляр PollVoteUpdateDTO.
     *
     * @param string|null $pollOptionId ID варіанту опитування
     */
    public function __construct(
        public readonly ?string $pollOptionId = null,
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
            pollOptionId: $request->input('poll_option_id'),
        );
    }
}
