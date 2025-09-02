<?php

namespace App\Actions\Genres;

use App\DTOs\Genre\GenreIndexDTO;
use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetGenres
{
    use AsAction;

    /**
     * Отримати список жанрів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param GenreIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(GenreIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Genre::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['name', 'book_count', 'created_at'])) {
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
     * @param GenreIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, GenreIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->parentId) {
                $options['filter'][] = "parent_id = '{$dto->parentId}'";
            }

            if ($dto->minBookCount !== null) {
                $options['filter'][] = "book_count >= {$dto->minBookCount}";
            }

            if ($dto->maxBookCount !== null) {
                $options['filter'][] = "book_count <= {$dto->maxBookCount}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
