<?php

namespace App\Actions\BookSeries;

use App\Models\BookSeries;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookSeriesAuthor
{
    use AsAction;

    public function handle(BookSeries $bookSeries)
    {
        $firstBook = $bookSeries->books()->with('authors')->first();

        if (! $firstBook || $firstBook->authors->isEmpty()) {
            return null;
        }

        return $firstBook->authors->first();
    }
}
