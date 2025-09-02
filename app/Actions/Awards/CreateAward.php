<?php

namespace App\Actions\Awards;

use App\DTOs\Award\AwardStoreDTO;
use App\Models\Award;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAward
{
    use AsAction;

    /**
     * Створити нову нагороду.
     *
     * @param AwardStoreDTO $dto
     * @return Award
     */
    public function handle(AwardStoreDTO $dto): Award
    {
        $award = new Award();
        $award->name = $dto->name;
        $award->year = $dto->year;
        $award->description = $dto->description;
        $award->organizer = $dto->organizer;
        $award->country = $dto->country;
        $award->ceremony_date = $dto->ceremonyDate;

        $award->save();

        return $award->load(['nominations']);
    }
}
