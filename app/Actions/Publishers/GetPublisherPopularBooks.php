<?php

namespace App\Actions\Publishers;

use App\Data\Publisher\PublisherRelationIndexData;
use App\Models\Publisher;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPublisherPopularBooks
{
    use AsAction;

    public function handle(Publisher $publisher, PublisherRelationIndexData $data): LengthAwarePaginator
    {
        $query = $publisher->books()->orderBy('average_rating', 'desc')->where('average_rating', '>=', 4.0);

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
