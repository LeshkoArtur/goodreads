<?php

namespace App\Actions\GroupInvitations;

use App\Data\GroupInvitation\GroupInvitationFilterData;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSentGroupInvitations
{
    use AsAction;

    public function handle(User $user, GroupInvitationFilterData $data): LengthAwarePaginator
    {
        return $user->sentInvitations()
            ->with(['group', 'invitee'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
