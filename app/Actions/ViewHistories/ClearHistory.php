<?php

namespace App\Actions\ViewHistories;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ClearHistory
{
    use AsAction;

    public function handle(User $user): int
    {
        return $user->viewHistories()->delete();
    }
}
