<?php

namespace App\Actions\BookSeries;

use App\DTOs\BookSeries\BookSeriesStoreDTO;
use App\Models\BookSeries;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBookSeries
{
    use AsAction;

    /**
     * Створити нову книжкову серію.
     *
     * @param BookSeriesStoreDTO $dto
     * @return BookSeries
     */
    public function handle(BookSeriesStoreDTO $dto): BookSeries
    {
        $bookSeries = new BookSeries();
        $bookSeries->title = $dto->title;
        $bookSeries->description = $dto->description;
        $bookSeries->total_books = $dto->totalBooks;
        $bookSeries->is_completed = $dto->isCompleted;

        $bookSeries->save();

        return $bookSeries->load(['books']);
    }
}
