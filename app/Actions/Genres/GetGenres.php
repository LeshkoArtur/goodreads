<?php

namespace App\Actions\Genres;

use App\Data\Genre\GenreIndexData;
use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGenres
{
    use AsAction;

    public function handle(GenreIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Genre::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['name', 'book_count', 'created_at'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/genres');

        return $paginator;
    }

    private function applyFilters(Builder $query, GenreIndexData $data): void
    {
        $filters = collect()
            ->when($data->parent_id, fn ($collection) => $collection->push("parent_id = '{$data->parent_id}'"))
            ->when($data->min_book_count !== null, fn ($collection) => $collection->push("book_count >= {$data->min_book_count}"))
            ->when($data->max_book_count !== null, fn ($collection) => $collection->push("book_count <= {$data->max_book_count}"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
