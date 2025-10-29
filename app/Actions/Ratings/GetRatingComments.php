<?php

namespace App\Actions\Ratings;

use App\Data\Rating\RatingRelationIndexData;
use App\Models\Rating;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRatingComments
{
    use AsAction;

    public function handle(Rating $rating, RatingRelationIndexData $data): LengthAwarePaginator
    {
        $query = $rating->comments()->with(['user']);

        if ($data->sort && in_array($data->sort, ['created_at'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
