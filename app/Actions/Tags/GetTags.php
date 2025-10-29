<?php

namespace App\Actions\Tags;

use App\Data\Tag\TagIndexData;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTags
{
    use AsAction;

    public function handle(TagIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Tag::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at', 'name', 'taggable_count']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/tags');

        return $paginator;
    }

    private function applyFilters(Builder $query, TagIndexData $data): void
    {
        $filters = collect()
            ->when($data->min_taggable_count !== null, fn ($collection) => $collection->push("taggable_count >= {$data->min_taggable_count}"))
            ->when($data->max_taggable_count !== null, fn ($collection) => $collection->push("taggable_count <= {$data->max_taggable_count}"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
