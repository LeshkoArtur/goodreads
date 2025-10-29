<?php

namespace App\Actions\Awards;

use App\Data\Award\AwardUpdateData;
use App\Models\Award;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAward
{
    use AsAction;

    public function handle(Award $award, AwardUpdateData $data): Award
    {
        $award->name = $data->name;
        $award->year = $data->year;
        $award->description = $data->description;
        $award->organizer = $data->organizer;
        $award->country = $data->country;
        $award->ceremony_date = $data->ceremony_date;
        $award->save();

        return $award->fresh();
    }
}
