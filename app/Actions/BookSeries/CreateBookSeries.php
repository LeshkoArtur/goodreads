<?php

namespace App\Actions\BookSeries;

use App\Data\BookSeries\BookSeriesStoreData;
use App\Models\BookSeries;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBookSeries
{
    use AsAction;

    public function handle(BookSeriesStoreData $data): BookSeries
    {
        $bookSeries = new BookSeries;
        $bookSeries->title = $data->title;
        $bookSeries->description = $data->description;
        $bookSeries->total_books = $data->total_books;
        $bookSeries->is_completed = $data->is_completed;
        $bookSeries->save();

        return $bookSeries->fresh(['books']);
    }
}
