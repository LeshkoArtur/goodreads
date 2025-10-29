<?php

namespace App\Actions\Ratings;

use App\Data\Rating\RatingIndexData;
use App\Models\Rating;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRatings
{
    use AsAction;

    public function handle(RatingIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Rating::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at', 'rating']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/ratings');

        return $paginator;
    }

    private function applyFilters(Builder $query, RatingIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
            ->when($data->book_id, fn ($collection) => $collection->push("book_id = '{$data->book_id}'"))
            ->when($data->min_rating !== null, fn ($collection) => $collection->push("rating >= {$data->min_rating}"))
            ->when($data->max_rating !== null, fn ($collection) => $collection->push("rating <= {$data->max_rating}"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
