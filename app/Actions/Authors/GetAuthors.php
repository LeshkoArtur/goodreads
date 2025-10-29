<?php

namespace App\Actions\Authors;

use App\Data\Author\AuthorIndexData;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthors
{
    use AsAction;

    public function handle(AuthorIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Author::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['name', 'birth_date', 'created_at'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/authors');

        return $paginator;
    }

    private function applyFilters(Builder $query, AuthorIndexData $data): void
    {
        $filters = collect()
            ->when($data->nationality, fn ($collection) => $collection->push("nationality = '{$data->nationality}'"))
            ->when($data->min_birth_date !== null, fn ($collection) => $collection->push("birth_date >= '{$data->min_birth_date}'"))
            ->when($data->max_birth_date !== null, fn ($collection) => $collection->push("birth_date <= '{$data->max_birth_date}'"))
            ->when($data->min_death_date !== null, fn ($collection) => $collection->push("death_date >= '{$data->min_death_date}'"))
            ->when($data->max_death_date !== null, fn ($collection) => $collection->push("death_date <= '{$data->max_death_date}'"))
            ->when($data->type_of_work, fn ($collection) => $collection->push("type_of_work = '{$data->type_of_work->value}'"))
            ->when($data->social_media_links, function ($collection) use ($data) {
                $socialMediaFilters = collect($data->social_media_links)
                    ->map(fn ($link) => "social_media_links = '{$link}'")
                    ->implode(' OR ');
                return $collection->push("({$socialMediaFilters})");
            })
            ->when($data->user_ids, fn ($collection) => $collection->push('user_ids IN ['.collect($data->user_ids)->implode(',').']'))
            ->when($data->book_ids, fn ($collection) => $collection->push('book_ids IN ['.collect($data->book_ids)->implode(',').']'));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
