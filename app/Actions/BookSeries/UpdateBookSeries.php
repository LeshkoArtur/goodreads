<?php

namespace App\Actions\BookSeries;

use App\DTOs\BookSeries\BookSeriesUpdateDTO;
use App\Models\BookSeries;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBookSeries
{
    use AsAction;

    /**
     * Оновити існуючу книжкову серію.
     *
     * @param BookSeries $bookSeries
     * @param BookSeriesUpdateDTO $dto
     * @return BookSeries
     */
    public function handle(BookSeries $bookSeries, BookSeriesUpdateDTO $dto): BookSeries
    {
        $attributes = [
            'title' => $dto->title,
            'description' => $dto->description,
            'is_completed' => $dto->isCompleted,
        ];

        $bookSeries->fill(array_filter($attributes, fn($value) => $value !== null));

        $bookSeries->save();

        return $bookSeries->load(['books']);
    }
}
