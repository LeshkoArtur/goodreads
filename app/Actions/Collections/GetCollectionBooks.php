<?php

namespace App\Actions\Collections;

use App\Data\Collection\CollectionRelationIndexData;
use App\Models\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCollectionBooks
{
    use AsAction;

    public function handle(Collection $collection, CollectionRelationIndexData $data): LengthAwarePaginator
    {
        $query = $collection->books()->withPivot('order_index');

        if ($data->sort && in_array($data->sort, ['title', 'created_at', 'average_rating'])) {
            $query->orderBy($data->sort, $data->direction ?? 'asc');
        } else {
            $query->orderByPivot('order_index', 'asc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
