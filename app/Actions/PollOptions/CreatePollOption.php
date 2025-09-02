<?php

namespace App\Actions\PollOptions;

use App\DTOs\PollOption\PollOptionStoreDTO;
use App\Models\PollOption;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePollOption
{
    use AsAction;

    /**
     * Створити новий варіант опитування.
     *
     * @param PollOptionStoreDTO $dto
     * @return PollOption
     */
    public function handle(PollOptionStoreDTO $dto): PollOption
    {
        $pollOption = new PollOption();
        $pollOption->group_poll_id = $dto->groupPollId;
        $pollOption->text = $dto->text;
        $pollOption->vote_count = $dto->voteCount;

        $pollOption->save();

        return $pollOption->load(['poll']);
    }
}
