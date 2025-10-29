<?php

namespace App\Actions\ReadingStats;

use App\Data\ReadingStat\ReadingStatStoreData;
use App\Models\ReadingStat;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateReadingStat
{
    use AsAction;

    public function handle(ReadingStatStoreData $data): ReadingStat
    {
        $readingStat = new ReadingStat;
        $readingStat->user_id = $data->user_id;
        $readingStat->year = $data->year;
        $readingStat->books_read = $data->books_read;
        $readingStat->pages_read = $data->pages_read;
        $readingStat->genres_read = $data->genres_read;
        $readingStat->save();

        return $readingStat->fresh(['user']);
    }
}
