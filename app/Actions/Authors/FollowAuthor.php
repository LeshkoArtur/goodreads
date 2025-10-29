<?php

namespace App\Actions\Authors;

use App\Models\Author;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class FollowAuthor
{
    use AsAction;

    public function handle(Author $author, User $user): bool
    {
        if ($author->users()->where('user_id', $user->id)->exists()) {
            return false;
        }

        $author->users()->attach($user->id, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return true;
    }
}
