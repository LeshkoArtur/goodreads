<?php

namespace App\Actions\Books;

use App\Data\Book\BookStoreData;
use App\Models\Book;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBook
{
    use AsAction;

    public function handle(BookStoreData $data): Book
    {
        $book = new Book;
        $book->title = $data->title;
        $book->description = $data->description;
        $book->plot = $data->plot;
        $book->history = $data->history;
        $book->series_id = $data->series_id;
        $book->number_in_series = $data->number_in_series;
        $book->page_count = $data->page_count;
        $book->languages = $data->languages;
        $book->cover_image = $data->cover_image;
        $book->fun_facts = $data->fun_facts;
        $book->adaptations = $data->adaptations;
        $book->is_bestseller = $data->is_bestseller;
        $book->average_rating = $data->average_rating;
        $book->age_restriction = $data->age_restriction;
        $book->save();

        if ($data->author_ids) {
            $book->authors()->sync($data->author_ids);
        }

        if ($data->genre_ids) {
            $book->genres()->sync($data->genre_ids);
        }

        if ($data->publisher_ids) {
            $book->publishers()->sync($data->publisher_ids);
        }

        return $book->fresh(['authors', 'genres', 'publishers', 'series']);
    }
}
