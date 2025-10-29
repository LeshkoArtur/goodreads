<?php

namespace App\Actions\AuthorAnswers;

use App\Models\AuthorAnswer;
use App\Models\Like;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LikeAuthorAnswer
{
    use AsAction;

    public function handle(AuthorAnswer $authorAnswer, User $user): bool
    {
        if ($authorAnswer->likes()->where('user_id', $user->id)->exists()) {
            return false;
        }

        $like = new Like;
        $like->user_id = $user->id;
        $like->likeable_id = $authorAnswer->id;
        $like->likeable_type = AuthorAnswer::class;
        $like->save();

        return true;
    }
}
