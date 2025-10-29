<?php

namespace App\Actions\BookSeries;

use App\Data\BookSeries\BookSeriesIndexData;
use App\Models\BookSeries;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookSeries
{
    use AsAction;

    public function handle(BookSeriesIndexData $data): LengthAwarePaginator
    {
        $searchQuery = BookSeries::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['title', 'total_books', 'created_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/book-series');

        return $paginator;
    }

    private function applyFilters(Builder $query, BookSeriesIndexData $data): void
    {
        $filters = collect()
                ->when($data->is_completed !== null, fn ($collection) => $collection->push('is_completed = '.($data->is_completed ? 'true' : 'false')))
                ->when($data->min_total_books !== null, fn ($collection) => $collection->push("total_books >= {$data->min_total_books}"))
                ->when($data->max_total_books !== null, fn ($collection) => $collection->push("total_books <= {$data->max_total_books}"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
