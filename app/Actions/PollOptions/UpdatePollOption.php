<?php

namespace App\Actions\PollOptions;

use App\DTOs\PollOption\PollOptionUpdateDTO;
use App\Models\PollOption;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePollOption
{
    use AsAction;

    /**
     * Оновити існуючий варіант опитування.
     *
     * @param PollOption $pollOption
     * @param PollOptionUpdateDTO $dto
     * @return PollOption
     */
    public function handle(PollOption $pollOption, PollOptionUpdateDTO $dto): PollOption
    {
        $attributes = [
            'text' => $dto->title,
        ];

        $pollOption->fill(array_filter($attributes, fn($value) => $value !== null));

        $pollOption->save();

        return $pollOption->load(['poll']);
    }
}
