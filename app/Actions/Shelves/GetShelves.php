<?php

namespace App\Actions\Shelves;

use App\DTOs\Shelf\ShelfIndexDTO;
use App\Models\Shelf;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetShelves
{
    use AsAction;

    /**
     * Отримати список полиць із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param ShelfIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(ShelfIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Shelf::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'name'])) {
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
     * @param ShelfIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, ShelfIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
