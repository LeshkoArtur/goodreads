<?php

namespace App\Actions\ViewHistories;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ClearHistoryByType
{
    use AsAction;

    public function handle(User $user, string $type): int
    {
        return $user->viewHistories()
            ->where('viewable_type', $type)
            ->delete();
    }
}
