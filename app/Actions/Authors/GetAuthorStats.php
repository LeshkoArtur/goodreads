<?php

namespace App\Actions\Authors;

use App\Models\Author;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorStats
{
    use AsAction;

    public function handle(Author $author): array
    {
        return [
            'books_count' => $author->books()->count(),
            'followers_count' => $author->users()->count(),
            'questions_count' => $author->questions()->count(),
            'answers_count' => $author->answers()->count(),
            'posts_count' => $author->posts()->count(),
            'nominations_count' => $author->nominations()->count(),
            'awards_count' => $author->nominations()->where('is_winner', true)->count(),
            'average_book_rating' => round($author->books()->withAvg('ratings', 'value')->get()->avg('ratings_avg_value'), 2),
            'total_ratings_count' => $author->books()->withCount('ratings')->get()->sum('ratings_count'),
            'total_reviews_count' => $author->books()->withCount('reviews')->get()->sum('reviews_count'),
        ];
    }
}
