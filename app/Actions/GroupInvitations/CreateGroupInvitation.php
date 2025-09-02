<?php

namespace App\Actions\GroupInvitations;

use App\DTOs\GroupInvitation\GroupInvitationStoreDTO;
use App\Models\GroupInvitation;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupInvitation
{
    use AsAction;

    /**
     * Створити нове запрошення до групи.
     *
     * @param GroupInvitationStoreDTO $dto
     * @return GroupInvitation
     */
    public function handle(GroupInvitationStoreDTO $dto): GroupInvitation
    {
        $groupInvitation = new GroupInvitation();
        $groupInvitation->group_id = $dto->groupId;
        $groupInvitation->inviter_id = $dto->inviterId;
        $groupInvitation->invitee_id = $dto->inviteeId;
        $groupInvitation->status = $dto->status;

        $groupInvitation->save();

        return $groupInvitation->load(['group', 'inviter', 'invitee']);
    }
}
