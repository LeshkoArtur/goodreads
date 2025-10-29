<?php

namespace App\Actions\Users;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserStats
{
    use AsAction;

    public function handle(User $user): array
    {
        return [
            'total_books' => $user->books()->count(),
            'total_ratings' => $user->ratings()->count(),
            'average_rating' => round($user->ratings()->avg('rating') ?? 0, 2),
            'total_quotes' => $user->quotes()->count(),
            'total_comments' => $user->comments()->count(),
            'total_shelves' => $user->shelves()->count(),
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
            'groups_count' => $user->groups()->count(),
            'books_read' => $user->books()->whereNotNull('read_date')->count(),
            'books_reading' => $user->books()
                ->whereNotNull('start_date')
                ->whereNull('read_date')
                ->count(),
        ];
    }
}
