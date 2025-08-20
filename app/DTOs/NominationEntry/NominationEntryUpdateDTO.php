<?php

namespace App\DTOs\NominationEntry;

use App\Enums\NominationStatus;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних запису номінації.
 */
class NominationEntryUpdateDTO
{
    /**
     * Створює новий екземпляр NominationEntryUpdateDTO.
     *
     * @param string|null $status Статус номінації
     */
    public function __construct(
        public readonly ?string $status = null,
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
            status: $request->input('status'),
        );
    }
}
