<?php

namespace App\Actions\GroupPolls;

use App\Data\GroupPoll\GroupPollStoreData;
use App\Models\GroupPoll;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupPoll
{
    use AsAction;

    public function handle(GroupPollStoreData $data, User $user): GroupPoll
    {
        $groupPoll = new GroupPoll;
        $groupPoll->group_id = $data->group_id;
        $groupPoll->creator_id = $user->id;
        $groupPoll->question = $data->question;
        $groupPoll->is_active = $data->is_active ?? true;
        $groupPoll->save();

        // Create poll options
        foreach ($data->options as $optionText) {
            $groupPoll->options()->create([
                'text' => $optionText,
            ]);
        }

        return $groupPoll->fresh(['group', 'creator', 'options']);
    }
}
