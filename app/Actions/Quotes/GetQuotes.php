<?php

namespace App\Actions\Quotes;

use App\Data\Quote\QuoteIndexData;
use App\Models\Quote;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetQuotes
{
    use AsAction;

    public function handle(QuoteIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Quote::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at', 'page_number']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/quotes');

        return $paginator;
    }

    private function applyFilters(Builder $query, QuoteIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
            ->when($data->book_id, fn ($collection) => $collection->push("book_id = '{$data->book_id}'"))
            ->when($data->contains_spoilers !== null, fn ($collection) => $collection->push('contains_spoilers = '.($data->contains_spoilers ? 'true' : 'false')))
            ->when($data->is_public !== null, fn ($collection) => $collection->push('is_public = '.($data->is_public ? 'true' : 'false')))
            ->when($data->min_page_number !== null, fn ($collection) => $collection->push("page_number >= {$data->min_page_number}"))
            ->when($data->max_page_number !== null, fn ($collection) => $collection->push("page_number <= {$data->max_page_number}"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
