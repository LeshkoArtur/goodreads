<?php

namespace App\Actions\Books;

use App\Data\Book\BookUpdateData;
use App\Models\Book;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBook
{
    use AsAction;

    public function handle(Book $book, BookUpdateData $data): Book
    {
        $book->update(array_filter([
            'title' => $data->title,
            'description' => $data->description,
            'plot' => $data->plot,
            'history' => $data->history,
            'series_id' => $data->series_id,
            'number_in_series' => $data->number_in_series,
            'page_count' => $data->page_count,
            'languages' => $data->languages,
            'cover_image' => $data->cover_image,
            'fun_facts' => $data->fun_facts,
            'adaptations' => $data->adaptations,
            'is_bestseller' => $data->is_bestseller,
            'average_rating' => $data->average_rating,
            'age_restriction' => $data->age_restriction,
        ], fn ($value) => $value !== null));

        collect([
            'authors' => $data->author_ids,
            'genres' => $data->genre_ids,
            'publishers' => $data->publisher_ids,
        ])->each(fn ($ids, $relation) => when($ids !== null, fn () => $book->$relation()->sync($ids)));

        return $book->fresh(['authors', 'genres', 'publishers', 'series']);
    }
}
