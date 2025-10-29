<?php

namespace App\Actions\ViewHistories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMostViewed
{
    use AsAction;

    public function handle(User $user, int $limit = 10): Collection
    {
        return DB::table('view_histories')
            ->select('viewable_id', 'viewable_type', DB::raw('COUNT(*) as views_count'))
            ->where('user_id', $user->id)
            ->groupBy('viewable_id', 'viewable_type')
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();
    }
}
