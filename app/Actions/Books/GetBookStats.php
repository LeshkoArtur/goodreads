<?php

namespace App\Actions\Books;

use App\Models\Book;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookStats
{
    use AsAction;

    public function handle(Book $book): array
    {
        return [
            'ratings_count' => $book->ratings()->count(),
            'reviews_count' => $book->ratings()->whereNotNull('review')->count(),
            'quotes_count' => $book->quotes()->count(),
            'characters_count' => $book->characters()->count(),
            'posts_count' => $book->posts()->count(),
            'questions_count' => $book->questions()->count(),
            'average_rating' => $book->average_rating,
            'ratings_breakdown' => [
                '5' => $book->ratings()->where('value', 5)->count(),
                '4' => $book->ratings()->where('value', 4)->count(),
                '3' => $book->ratings()->where('value', 3)->count(),
                '2' => $book->ratings()->where('value', 2)->count(),
                '1' => $book->ratings()->where('value', 1)->count(),
            ],
        ];
    }
}
