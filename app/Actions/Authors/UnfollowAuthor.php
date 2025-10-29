<?php

namespace App\Actions\Authors;

use App\Models\Author;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnfollowAuthor
{
    use AsAction;

    public function handle(Author $author, User $user): bool
    {
        if (! $author->users()->where('user_id', $user->id)->exists()) {
            return false;
        }

        $author->users()->detach($user->id);

        return true;
    }
}
