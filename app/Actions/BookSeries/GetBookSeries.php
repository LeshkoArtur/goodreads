<?php

namespace App\Actions\BookSeries;

use App\DTOs\BookSeries\BookSeriesIndexDTO;
use App\Models\BookSeries;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetBookSeries
{
    use AsAction;

    /**
     * Отримати список книжкових серій із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param BookSeriesIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(BookSeriesIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = BookSeries::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['title', 'total_books', 'created_at'])) {
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
     * @param BookSeriesIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, BookSeriesIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->minTotalBooks !== null) {
                $options['filter'][] = "total_books >= {$dto->minTotalBooks}";
            }

            if ($dto->maxTotalBooks !== null) {
                $options['filter'][] = "total_books <= {$dto->maxTotalBooks}";
            }

            if ($dto->isCompleted !== null) {
                $options['filter'][] = "is_completed = " . ($dto->isCompleted ? 'true' : 'false');
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
