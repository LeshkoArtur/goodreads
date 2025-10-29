<?php

namespace App\Actions\ReadingStats;

use App\Data\ReadingStat\ReadingStatIndexData;
use App\Models\ReadingStat;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetReadingStats
{
    use AsAction;

    public function handle(ReadingStatIndexData $data): LengthAwarePaginator
    {
        $searchQuery = ReadingStat::search('');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at', 'year', 'books_read', 'pages_read']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/reading-stats');

        return $paginator;
    }

    private function applyFilters(Builder $query, ReadingStatIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
            ->when($data->year !== null, fn ($collection) => $collection->push("year = {$data->year}"))
            ->when($data->min_books_read !== null, fn ($collection) => $collection->push("books_read >= {$data->min_books_read}"))
            ->when($data->max_books_read !== null, fn ($collection) => $collection->push("books_read <= {$data->max_books_read}"))
            ->when($data->min_pages_read !== null, fn ($collection) => $collection->push("pages_read >= {$data->min_pages_read}"))
            ->when($data->max_pages_read !== null, fn ($collection) => $collection->push("pages_read <= {$data->max_pages_read}"))
            ->when($data->genres_read, function ($collection) use ($data) {
                $genreFilters = collect($data->genres_read)
                    ->map(fn ($genre) => "genres_read = '{$genre}'")
                    ->implode(' OR ');
                return $collection->push("({$genreFilters})");
            });

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
