<?php

namespace App\Actions\Awards;

use App\DTOs\Award\AwardIndexDTO;
use App\Models\Award;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetAwards
{
    use AsAction;

    /**
     * Отримати список нагород із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param AwardIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(AwardIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Award::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['name', 'year', 'ceremony_date', 'created_at'])) {
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
     * @param AwardIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, AwardIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->year !== null) {
                $options['filter'][] = "year = {$dto->year}";
            }

            if ($dto->organizer) {
                $options['filter'][] = "organizer = '{$dto->organizer}'";
            }

            if ($dto->country) {
                $options['filter'][] = "country = '{$dto->country}'";
            }

            if ($dto->minCeremonyDate !== null) {
                $options['filter'][] = "ceremony_date >= '{$dto->minCeremonyDate}'";
            }

            if ($dto->maxCeremonyDate !== null) {
                $options['filter'][] = "ceremony_date <= '{$dto->maxCeremonyDate}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
