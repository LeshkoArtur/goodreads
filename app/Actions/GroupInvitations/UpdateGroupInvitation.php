<?php

namespace App\Actions\GroupInvitations;

use App\DTOs\GroupInvitation\GroupInvitationUpdateDTO;
use App\Models\GroupInvitation;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupInvitation
{
    use AsAction;

    /**
     * Оновити існуюче запрошення до групи.
     *
     * @param GroupInvitation $groupInvitation
     * @param GroupInvitationUpdateDTO $dto
     * @return GroupInvitation
     */
    public function handle(GroupInvitation $groupInvitation, GroupInvitationUpdateDTO $dto): GroupInvitation
    {
        $attributes = [
            'status' => $dto->status,
        ];

        $groupInvitation->fill(array_filter($attributes, fn($value) => $value !== null));

        $groupInvitation->save();

        return $groupInvitation->load(['group', 'inviter', 'invitee']);
    }
}
