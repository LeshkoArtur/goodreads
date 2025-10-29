<?php

namespace App\Actions\ViewHistories;

use App\Models\User;
use App\Models\ViewHistory;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRecentViews
{
    use AsAction;

    public function handle(User $user, int $limit = 20): Collection
    {
        return ViewHistory::where('user_id', $user->id)
            ->with(['viewable'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
