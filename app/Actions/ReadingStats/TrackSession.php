<?php

namespace App\Actions\ReadingStats;

use App\Models\ReadingStat;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class TrackSession
{
    use AsAction;

    public function handle(User $user, int $pagesRead, ?array $genresRead = null): ReadingStat
    {
        $year = now()->year;

        $readingStat = ReadingStat::firstOrNew([
            'user_id' => $user->id,
            'year' => $year,
        ]);

        $readingStat->books_read = ($readingStat->books_read ?? 0) + 1;
        $readingStat->pages_read = ($readingStat->pages_read ?? 0) + $pagesRead;

        if ($genresRead) {
            $existingGenres = $readingStat->genres_read ?? [];
            $readingStat->genres_read = array_values(array_unique(array_merge($existingGenres, $genresRead)));
        }

        $readingStat->save();

        return $readingStat->fresh(['user']);
    }
}
