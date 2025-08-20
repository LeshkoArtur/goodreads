<?php

namespace App\DTOs\Quote;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних цитати.
 */
class QuoteUpdateDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр QuoteUpdateDTO.
     *
     * @param string|null $body Текст цитати
     * @param string|null $status Статус цитати
     * @param array|null $tagIds ID тегів
     */
    public function __construct(
        public readonly ?string $body = null,
        public readonly ?string $status = null,
        public readonly ?array $tagIds = null,
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
            status: $request->input('status'),
            tagIds: self::processArrayInput($request, 'tag_ids'),
        );
    }
}
