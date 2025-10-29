<?php

namespace App\Actions\Collections;

use App\Data\Collection\CollectionRelationIndexData;
use App\Models\Collection;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCollectionPosts
{
    use AsAction;

    public function handle(Collection $collection, CollectionRelationIndexData $data): LengthAwarePaginator
    {
        $query = Post::where(function ($q) use ($collection) {
            $q->where('content', 'like', "%{$collection->id}%")
                ->orWhere('content', 'like', "%{$collection->title}%");
        })->with(['user']);

        if ($data->sort && in_array($data->sort, ['created_at'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
