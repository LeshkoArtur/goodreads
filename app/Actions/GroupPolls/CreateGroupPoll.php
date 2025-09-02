<?php

namespace App\Actions\GroupPolls;

use App\DTOs\GroupPoll\GroupPollStoreDTO;
use App\Models\GroupPoll;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupPoll
{
    use AsAction;

    /**
     * Створити нове опитування групи.
     *
     * @param GroupPollStoreDTO $dto
     * @return GroupPoll
     */
    public function handle(GroupPollStoreDTO $dto): GroupPoll
    {
        $groupPoll = new GroupPoll();
        $groupPoll->group_id = $dto->groupId;
        $groupPoll->creator_id = $dto->creatorId;
        $groupPoll->question = $dto->question;
        $groupPoll->is_active = $dto->isActive;

        $groupPoll->save();

        return $groupPoll->load(['group', 'creator', 'options', 'votes']);
    }
}
