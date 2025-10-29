<?php

namespace App\Actions\BookSeries;

use App\Data\BookSeries\BookSeriesUpdateData;
use App\Models\BookSeries;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBookSeries
{
    use AsAction;

    public function handle(BookSeries $bookSeries, BookSeriesUpdateData $data): BookSeries
    {
        $bookSeries->update(array_filter([
            'title' => $data->title,
            'description' => $data->description,
            'total_books' => $data->total_books,
            'is_completed' => $data->is_completed,
        ], fn ($value) => $value !== null));

        return $bookSeries->fresh(['books']);
    }
}
