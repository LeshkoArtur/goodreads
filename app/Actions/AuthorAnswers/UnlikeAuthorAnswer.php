<?php

namespace App\Actions\AuthorAnswers;

use App\Models\AuthorAnswer;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnlikeAuthorAnswer
{
    use AsAction;

    public function handle(AuthorAnswer $authorAnswer, User $user): bool
    {
        $like = $authorAnswer->likes()->where('user_id', $user->id)->first();

        if (! $like) {
            return false;
        }

        $like->delete();

        return true;
    }
}
