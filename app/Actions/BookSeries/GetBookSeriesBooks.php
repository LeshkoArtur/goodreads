<?php

namespace App\Actions\BookSeries;

use App\Data\BookSeries\BookSeriesRelationIndexData;
use App\Models\BookSeries;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookSeriesBooks
{
    use AsAction;

    public function handle(BookSeries $bookSeries, BookSeriesRelationIndexData $data): LengthAwarePaginator
    {
        $query = $bookSeries->books();

        if ($data->sort && in_array($data->sort, ['title', 'number_in_series', 'created_at', 'average_rating'])) {
            $query->orderBy($data->sort, $data->direction ?? 'asc');
        } else {
            $query->orderBy('number_in_series', 'asc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
