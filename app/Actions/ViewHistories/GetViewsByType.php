<?php

namespace App\Actions\ViewHistories;

use App\Models\User;
use App\Models\ViewHistory;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetViewsByType
{
    use AsAction;

    public function handle(User $user, string $type): Collection
    {
        return ViewHistory::where('user_id', $user->id)
            ->where('viewable_type', $type)
            ->with(['viewable'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
