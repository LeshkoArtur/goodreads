<?php

namespace App\Actions\GroupPolls;

use App\DTOs\GroupPoll\GroupPollUpdateDTO;
use App\Models\GroupPoll;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupPoll
{
    use AsAction;

    /**
     * Оновити існуюче опитування групи.
     *
     * @param GroupPoll $groupPoll
     * @param GroupPollUpdateDTO $dto
     * @return GroupPoll
     */
    public function handle(GroupPoll $groupPoll, GroupPollUpdateDTO $dto): GroupPoll
    {
        $attributes = [
            'question' => $dto->title,
            'is_active' => $dto->isActive,
        ];

        $groupPoll->fill(array_filter($attributes, fn($value) => $value !== null));

        $groupPoll->save();

        return $groupPoll->load(['group', 'creator', 'options', 'votes']);
    }
}
