<?php

namespace App\DTOs\GroupInvitation;

use App\Enums\InvitationStatus;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних запрошення до групи.
 */
class GroupInvitationUpdateDTO
{
    /**
     * Створює новий екземпляр GroupInvitationUpdateDTO.
     *
     * @param string|null $status Статус запрошення
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
