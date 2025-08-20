<?php

namespace App\DTOs\EventRsvp;

use App\Enums\EventResponse;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних RSVP на подію.
 */
class EventRsvpUpdateDTO
{
    /**
     * Створює новий екземпляр EventRsvpUpdateDTO.
     *
     * @param string|null $response Відповідь на подію
     */
    public function __construct(
        public readonly ?string $response = null,
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
            response: $request->input('response'),
        );
    }
}
