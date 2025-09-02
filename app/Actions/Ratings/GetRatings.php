<?php

namespace App\Actions\Ratings;

use App\DTOs\Rating\RatingIndexDTO;
use App\Models\Rating;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetRatings
{
    use AsAction;

    /**
     * Отримати список рейтингів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param RatingIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(RatingIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Rating::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'rating'])) {
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
     * @param RatingIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, RatingIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->bookId) {
                $options['filter'][] = "book_id = {$dto->bookId}";
            }

            if ($dto->minScore !== null) {
                $options['filter'][] = "rating >= {$dto->minScore}";
            }

            if ($dto->maxScore !== null) {
                $options['filter'][] = "rating <= {$dto->maxScore}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
