<?php

namespace App\Actions\Awards;

use App\Models\Award;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAwardStats
{
    use AsAction;

    public function handle(Award $award): array
    {
        $nominations = $award->nominations();

        return [
            'total_nominations' => $nominations->count(),
            'total_winners' => $nominations->where('is_winner', true)->count(),
            'categories_count' => $nominations->distinct('category_id')->count('category_id'),
        ];
    }
}
