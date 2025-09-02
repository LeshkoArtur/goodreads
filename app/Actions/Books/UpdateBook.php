<?php

namespace App\Actions\Books;

use App\DTOs\Book\BookUpdateDTO;
use App\Models\Book;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBook
{
    use AsAction;

    /**
     * Оновити існуючу книгу.
     *
     * @param Book $book
     * @param BookUpdateDTO $dto
     * @return Book
     */
    public function handle(Book $book, BookUpdateDTO $dto): Book
    {
        $attributes = [
            'title' => $dto->title,
            'description' => $dto->description,
            'series_id' => $dto->seriesId,
            'page_count' => $dto->pageCount,
            'languages' => $dto->languages,
            'is_bestseller' => $dto->isBestseller,
            'age_restriction' => $dto->ageRestriction,
        ];

        $book->fill(array_filter($attributes, fn($value) => $value !== null));

        if ($dto->coverImage !== null) {
            $book->cover_image = $book->handleFileUpload($dto->coverImage, 'covers', $book->cover_image);
        }

        $book->save();

        $this->syncRelations($book, $dto);

        return $book->load(['series', 'authors', 'genres', 'publishers']);
    }

    /**
     * Синхронізувати зв’язки книги (автори, жанри, видавці).
     *
     * @param Book $book
     * @param BookUpdateDTO $dto
     * @return void
     */
    private function syncRelations(Book $book, BookUpdateDTO $dto): void
    {
        if ($dto->authorIds !== null) {
            $book->authors()->sync($dto->authorIds);
        }

        if ($dto->genreIds !== null) {
            $book->genres()->sync($dto->genreIds);
        }

        if ($dto->publisherIds !== null) {
            $syncData = [];
            foreach ($dto->publisherIds as $publisherId) {
                $syncData[$publisherId] = ['published_at' => now()];
            }
            $book->publishers()->sync($syncData);
        }
    }
}
