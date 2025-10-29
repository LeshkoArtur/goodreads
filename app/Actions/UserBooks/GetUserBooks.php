<?php

namespace App\Actions\UserBooks;

use App\Data\UserBook\UserBookIndexData;
use App\Models\UserBook;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserBooks
{
    use AsAction;

    public function handle(UserBookIndexData $data): LengthAwarePaginator
    {
        $searchQuery = UserBook::search('');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at', 'start_date', 'read_date', 'progress_pages', 'rating']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/user-books');

        return $paginator;
    }

    private function applyFilters(Builder $query, UserBookIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
            ->when($data->book_id, fn ($collection) => $collection->push("book_id = '{$data->book_id}'"))
            ->when($data->shelf_id, fn ($collection) => $collection->push("shelf_id = '{$data->shelf_id}'"))
            ->when($data->is_private !== null, fn ($collection) => $collection->push('is_private = '.($data->is_private ? 'true' : 'false')))
            ->when($data->min_rating !== null, fn ($collection) => $collection->push("rating >= {$data->min_rating}"))
            ->when($data->max_rating !== null, fn ($collection) => $collection->push("rating <= {$data->max_rating}"))
            ->when($data->reading_format, fn ($collection) => $collection->push("reading_format = '{$data->reading_format->value}'"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
