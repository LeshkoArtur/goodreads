<?php

namespace App\Actions\BookOffers;

use App\Data\BookOffer\BookOfferIndexData;
use App\Models\BookOffer;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookOffers
{
    use AsAction;

    public function handle(BookOfferIndexData $data): LengthAwarePaginator
    {
        $searchQuery = BookOffer::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['price', 'last_updated_at', 'created_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/book-offers');

        return $paginator;
    }

    private function applyFilters(Builder $query, BookOfferIndexData $data): void
    {
        $filters = collect()
                ->when($data->book_id, fn ($collection) => $collection->push("book_id = '{$data->book_id}'"))
                ->when($data->store_id, fn ($collection) => $collection->push("store_id = '{$data->store_id}'"))
                ->when($data->min_price !== null, fn ($collection) => $collection->push("price >= {$data->min_price}"))
                ->when($data->max_price !== null, fn ($collection) => $collection->push("price <= {$data->max_price}"))
                ->when($data->currency, fn ($collection) => $collection->push("currency = '{$data->currency->value}'"))
                ->when($data->status, fn ($collection) => $collection->push("status = '{$data->status->value}'"))
                ->when($data->availability !== null, fn ($collection) => $collection->push('availability = '.($data->availability ? 'true' : 'false')))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
