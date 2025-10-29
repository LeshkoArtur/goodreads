<?php

namespace App\Actions\ReadingStats;

use App\Models\ReadingStat;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetYearlyStats
{
    use AsAction;

    public function handle(User $user, ?int $year = null): ?ReadingStat
    {
        $targetYear = $year ?? now()->year;

        return ReadingStat::where('user_id', $user->id)
            ->where('year', $targetYear)
            ->first();
    }
}
