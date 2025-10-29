<?php

namespace App\Actions\Comments;

use App\Data\Comment\CommentIndexData;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetComments
{
    use AsAction;

    public function handle(CommentIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Comment::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/comments');

        return $paginator;
    }

    private function applyFilters(Builder $query, CommentIndexData $data): void
    {
        $filters = collect()
                ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
                ->when($data->commentable_type, fn ($collection) => $collection->push("commentable_type = '{$data->commentable_type}'"))
                ->when($data->commentable_id, fn ($collection) => $collection->push("commentable_id = '{$data->commentable_id}'"))
                ->when($data->parent_id !== null, fn ($collection) => $collection->push($data->parent_id ? "parent_id = '{$data->parent_id}'" : 'parent_id IS NULL'))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
