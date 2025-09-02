<?php

namespace App\Actions\Books;

use App\DTOs\Book\BookIndexDTO;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetBooks
{
    use AsAction;

    /**
     * Отримати список книг із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param BookIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(BookIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Book::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['average_rating', 'page_count', 'created_at'])) {
            $searchQuery->orderBy($dto->sort, $dto->direction ?? 'desc');
        }

        return $searchQuery->paginate(
            perPage: $dto->perPage,
            page: $dto->page
        );
    }

    /**
     * Застосувати фільтри до пошукового запиту Meilisearch.
     *
     * @param Builder $query
     * @param BookIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, BookIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->seriesId) {
                $options['filter'][] = "series_id = {$dto->seriesId}";
            }

            if ($dto->minPageCount !== null) {
                $options['filter'][] = "page_count >= {$dto->minPageCount}";
            }
            if ($dto->maxPageCount !== null) {
                $options['filter'][] = "page_count <= {$dto->maxPageCount}";
            }

            if ($dto->languages) {
                foreach ($dto->languages as $language) {
                    $options['filter'][] = "languages = '{$language}'";
                }
            }

            if ($dto->isBestseller !== null) {
                $options['filter'][] = "is_bestseller = " . ($dto->isBestseller ? 'true' : 'false');
            }

            if ($dto->minAverageRating !== null) {
                $options['filter'][] = "average_rating >= {$dto->minAverageRating}";
            }
            if ($dto->maxAverageRating !== null) {
                $options['filter'][] = "average_rating <= {$dto->maxAverageRating}";
            }

            if ($dto->ageRestriction) {
                $options['filter'][] = "age_restriction = '{$dto->ageRestriction}'";
            }

            if ($dto->authorIds) {
                $options['filter'][] = 'author_ids IN [' . implode(',', $dto->authorIds) . ']';
            }

            if ($dto->genreIds) {
                $options['filter'][] = 'genre_ids IN [' . implode(',', $dto->genreIds) . ']';
            }

            if ($dto->publisherIds) {
                $options['filter'][] = 'publisher_ids IN [' . implode(',', $dto->publisherIds) . ']';
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
