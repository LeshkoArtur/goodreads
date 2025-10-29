<?php

namespace App\Actions\Likes;

use App\Data\Like\LikeIndexData;
use App\Models\Like;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetLikes
{
    use AsAction;

    public function handle(LikeIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Like::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/likes');

        return $paginator;
    }

    private function applyFilters(Builder $query, LikeIndexData $data): void
    {
        $filters = collect()
                ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
                ->when($data->likeable_type, fn ($collection) => $collection->push("likeable_type = '{$data->likeable_type}'"))
                ->when($data->likeable_id, fn ($collection) => $collection->push("likeable_id = '{$data->likeable_id}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
