<?php

namespace App\Actions\Stores;

use App\DTOs\Store\StoreIndexDTO;
use App\Models\Store;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetStores
{
    use AsAction;

    /**
     * Отримати список магазинів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param StoreIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(StoreIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Store::search($dto->query ?? '');

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
     * @param StoreIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, StoreIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->country) {
                $options['filter'][] = "region = '{$dto->country}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
