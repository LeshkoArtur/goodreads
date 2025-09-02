<?php

namespace App\DTOs\EventRsvp;

use App\Enums\EventResponse;
use Illuminate\Http\Request;

class EventRsvpStoreDTO
{
    /**
     * @param string $groupEventId ID події групи
     * @param string $userId ID користувача
     * @param EventResponse $response Відповідь на подію
     */
    public function __construct(
        public readonly string $groupEventId,
        public readonly string $userId,
        public readonly EventResponse $response
    ) {}

    /**
     * Створити EventRsvpStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            groupEventId: $request->input('group_event_id'),
            userId: $request->input('user_id'),
            response: EventResponse::from($request->input('response'))
        );
    }
}
