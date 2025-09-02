<?php

namespace App\Actions\Nominations;

use App\DTOs\Nomination\NominationIndexDTO;
use App\Models\Nomination;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetNominations
{
    use AsAction;

    /**
     * Отримати список номінацій із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param NominationIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(NominationIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Nomination::search($dto->query ?? '');

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
     * @param NominationIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, NominationIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->awardId) {
                $options['filter'][] = "award_id = {$dto->awardId}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
