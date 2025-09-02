<?php

namespace App\Actions\Reports;

use App\DTOs\Report\ReportIndexDTO;
use App\Models\Report;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetReports
{
    use AsAction;

    /**
     * Отримати список звітів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param ReportIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(ReportIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Report::search($dto->query ?? '');

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
     * @param ReportIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, ReportIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->reportableType) {
                $options['filter'][] = "reportable_type = '{$dto->reportableType}'";
            }

            if ($dto->reportableId) {
                $options['filter'][] = "reportable_id = {$dto->reportableId}";
            }

            if ($dto->reason) {
                $options['filter'][] = "type = '{$dto->reason}'";
            }

            if ($dto->status) {
                $options['filter'][] = "status = '{$dto->status}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
