<?php

namespace App\Actions\Favorites;

use App\DTOs\Favorite\FavoriteIndexDTO;
use App\Models\Favorite;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetFavorites
{
    use AsAction;

    /**
     * Отримати список улюблених із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param FavoriteIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(FavoriteIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Favorite::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at'])) {
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
     * @param FavoriteIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, FavoriteIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = '{$dto->userId}'";
            }

            if ($dto->favoriteableType) {
                $options['filter'][] = "favoriteable_type = '{$dto->favoriteableType}'";
            }

            if ($dto->favoriteableId) {
                $options['filter'][] = "favoriteable_id = '{$dto->favoriteableId}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
