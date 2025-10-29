<?php

namespace App\Actions\Publishers;

use App\Data\Publisher\PublisherRelationIndexData;
use App\Models\Publisher;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPublisherBooks
{
    use AsAction;

    public function handle(Publisher $publisher, PublisherRelationIndexData $data): LengthAwarePaginator
    {
        $query = $publisher->books();

        if ($data->sort && in_array($data->sort, ['title', 'created_at', 'average_rating', 'page_count'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
