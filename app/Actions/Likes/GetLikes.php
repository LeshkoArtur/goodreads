<?php

namespace App\Actions\Likes;

use App\DTOs\Like\LikeIndexDTO;
use App\Models\Like;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetLikes
{
    use AsAction;

    /**
     * Отримати список лайків із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param LikeIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(LikeIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Like::search($dto->query ?? '');

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
     * @param LikeIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, LikeIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->likeableType) {
                $options['filter'][] = "likeable_type = '{$dto->likeableType}'";
            }

            if ($dto->likeableId) {
                $options['filter'][] = "likeable_id = {$dto->likeableId}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
