<?php

namespace App\Actions\Posts;

use App\Data\Post\PostIndexData;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPosts
{
    use AsAction;

    public function handle(PostIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Post::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at', 'published_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/posts');

        return $paginator;
    }

    private function applyFilters(Builder $query, PostIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
            ->when($data->book_id, fn ($collection) => $collection->push("book_id = '{$data->book_id}'"))
            ->when($data->author_id, fn ($collection) => $collection->push("author_id = '{$data->author_id}'"))
            ->when($data->type, fn ($collection) => $collection->push("type = '{$data->type->value}'"))
            ->when($data->status, fn ($collection) => $collection->push("status = '{$data->status->value}'"))
            ->when($data->tag_ids, fn ($collection) => $collection->push('tag_ids IN ['.collect($data->tag_ids)->implode(',').']'));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
