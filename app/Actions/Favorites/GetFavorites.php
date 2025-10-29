<?php

namespace App\Actions\Favorites;

use App\Data\Favorite\FavoriteIndexData;
use App\Models\Favorite;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFavorites
{
    use AsAction;

    public function handle(FavoriteIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Favorite::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/favorites');

        return $paginator;
    }

    private function applyFilters(Builder $query, FavoriteIndexData $data): void
    {
        $filters = collect()
                ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
                ->when($data->favoriteable_type, fn ($collection) => $collection->push("favoriteable_type = '{$data->favoriteable_type}'"))
                ->when($data->favoriteable_id, fn ($collection) => $collection->push("favoriteable_id = '{$data->favoriteable_id}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
