<?php

namespace App\Actions\Reports;

use App\Data\Report\ReportIndexData;
use App\Models\Report;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetReports
{
    use AsAction;

    public function handle(ReportIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Report::search('');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/reports');

        return $paginator;
    }

    private function applyFilters(Builder $query, ReportIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
            ->when($data->type, fn ($collection) => $collection->push("type = '{$data->type->value}'"))
            ->when($data->reportable_type, fn ($collection) => $collection->push("reportable_type = '{$data->reportable_type}'"))
            ->when($data->reportable_id, fn ($collection) => $collection->push("reportable_id = '{$data->reportable_id}'"))
            ->when($data->status, fn ($collection) => $collection->push("status = '{$data->status->value}'"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
