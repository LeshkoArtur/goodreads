<?php

namespace App\Actions\Collections;

use App\DTOs\Collection\CollectionIndexDTO;
use App\Models\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetCollections
{
    use AsAction;

    /**
     * Отримати список колекцій із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param CollectionIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(CollectionIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Collection::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['title', 'created_at'])) {
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
     * @param CollectionIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, CollectionIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = '{$dto->userId}'";
            }

            if ($dto->isPublic !== null) {
                $options['filter'][] = "is_public = " . ($dto->isPublic ? 'true' : 'false');
            }

            if ($dto->bookIds) {
                $options['filter'][] = "book_ids IN [" . implode(',', $dto->bookIds) . "]";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
