<?php

namespace App\Actions\ReadingStats;

use App\Data\ReadingStat\ReadingStatUpdateData;
use App\Models\ReadingStat;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateReadingStat
{
    use AsAction;

    public function handle(ReadingStat $readingStat, ReadingStatUpdateData $data): ReadingStat
    {
        $readingStat->update(array_filter([
            'user_id' => $data->user_id,
            'year' => $data->year,
            'books_read' => $data->books_read,
            'pages_read' => $data->pages_read,
            'genres_read' => $data->genres_read,
        ], fn ($value) => $value !== null));

        return $readingStat->fresh(['user']);
    }
}
