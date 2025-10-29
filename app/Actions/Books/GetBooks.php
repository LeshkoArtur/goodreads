<?php

namespace App\Actions\Books;

use App\Data\Book\BookIndexData;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBooks
{
    use AsAction;

    public function handle(BookIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Book::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['average_rating', 'page_count', 'created_at'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/books');

        return $paginator;
    }

    private function applyFilters(Builder $query, BookIndexData $data): void
    {
        $filters = collect()
            ->when($data->series_id, fn ($collection) => $collection->push("series_id = {$data->series_id}"))
            ->when($data->min_page_count !== null, fn ($collection) => $collection->push("page_count >= {$data->min_page_count}"))
            ->when($data->max_page_count !== null, fn ($collection) => $collection->push("page_count <= {$data->max_page_count}"))
            ->when($data->languages, function ($collection) use ($data) {
                $languageFilters = collect($data->languages)
                    ->map(fn ($lang) => "languages = '{$lang}'")
                    ->implode(' OR ');
                return $collection->push("({$languageFilters})");
            })
            ->when($data->is_bestseller !== null, fn ($collection) => $collection->push('is_bestseller = '.($data->is_bestseller ? 'true' : 'false')))
            ->when($data->min_average_rating !== null, fn ($collection) => $collection->push("average_rating >= {$data->min_average_rating}"))
            ->when($data->max_average_rating !== null, fn ($collection) => $collection->push("average_rating <= {$data->max_average_rating}"))
            ->when($data->age_restriction, fn ($collection) => $collection->push("age_restriction = '{$data->age_restriction->value}'"))
            ->when($data->author_ids, fn ($collection) => $collection->push('author_ids IN ['.collect($data->author_ids)->implode(',').']'))
            ->when($data->genre_ids, fn ($collection) => $collection->push('genre_ids IN ['.collect($data->genre_ids)->implode(',').']'))
            ->when($data->publisher_ids, fn ($collection) => $collection->push('publisher_ids IN ['.collect($data->publisher_ids)->implode(',').']'));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
