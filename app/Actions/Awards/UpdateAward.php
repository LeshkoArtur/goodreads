<?php

namespace App\Actions\Awards;

use App\DTOs\Award\AwardUpdateDTO;
use App\Models\Award;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAward
{
    use AsAction;

    /**
     * Оновити існуючу нагороду.
     *
     * @param Award $award
     * @param AwardUpdateDTO $dto
     * @return Award
     */
    public function handle(Award $award, AwardUpdateDTO $dto): Award
    {
        $attributes = [
            'name' => $dto->name,
            'year' => $dto->year,
            'description' => $dto->description,
            'organizer' => $dto->organizer,
            'country' => $dto->country,
            'ceremony_date' => $dto->ceremonyDate,
        ];

        $award->fill(array_filter($attributes, fn($value) => $value !== null));

        $award->save();

        return $award->load(['nominations']);
    }
}
