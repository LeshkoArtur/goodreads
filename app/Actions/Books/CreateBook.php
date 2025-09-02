<?php

namespace App\Actions\Books;

use App\DTOs\Book\BookStoreDTO;
use App\Models\Book;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBook
{
    use AsAction;

    /**
     * Створити нову книгу.
     *
     * @param BookStoreDTO $dto
     * @return Book
     */
    public function handle(BookStoreDTO $dto): Book
    {
        $book = new Book();
        $book->title = $dto->title;
        $book->description = $dto->description;
        $book->plot = $dto->plot;
        $book->history = $dto->history;
        $book->series_id = $dto->seriesId;
        $book->number_in_series = $dto->numberInSeries;
        $book->page_count = $dto->pageCount;
        $book->languages = $dto->languages ?? [];
        $book->cover_image = $dto->coverImage;
        $book->fun_facts = $dto->funFacts ?? [];
        $book->adaptations = $dto->adaptations ?? [];
        $book->is_bestseller = $dto->isBestseller;
        $book->average_rating = $dto->averageRating;
        $book->age_restriction = $dto->ageRestriction?->value;

        if ($dto->coverImage) {
            $book->cover_image = $book->handleFileUpload($dto->coverImage, 'covers');
        }

        $book->save();

        if ($dto->authorIds) {
            $book->authors()->sync($dto->authorIds);
        }

        if ($dto->genreIds) {
            $book->genres()->sync($dto->genreIds);
        }

        if ($dto->publisherIds) {
            $syncData = [];
            foreach ($dto->publisherIds as $publisherId) {
                $syncData[$publisherId] = ['published_at' => now()];
            }
            $book->publishers()->sync($syncData);
        }

        return $book->load(['series', 'authors', 'genres', 'publishers']);
    }
}
