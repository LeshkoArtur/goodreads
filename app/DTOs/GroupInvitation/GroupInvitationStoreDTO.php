<?php

namespace App\DTOs\GroupInvitation;

use App\Enums\InvitationStatus;
use Illuminate\Http\Request;

class GroupInvitationStoreDTO
{
    /**
     * @param string $groupId ID групи
     * @param string $inviterId ID запрошувача
     * @param string $inviteeId ID запрошеного
     * @param InvitationStatus|null $status Статус запрошення
     */
    public function __construct(
        public readonly string $groupId,
        public readonly string $inviterId,
        public readonly string $inviteeId,
        public readonly ?InvitationStatus $status = null
    ) {}

    /**
     * Створити GroupInvitationStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            groupId: $request->input('group_id'),
            inviterId: $request->input('inviter_id'),
            inviteeId: $request->input('invitee_id'),
            status: $request->input('status') ? InvitationStatus::from($request->input('status')) : null
        );
    }
}
