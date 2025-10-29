<?php

namespace App\Actions\Ratings;

use App\Data\Rating\RatingUpdateData;
use App\Models\Rating;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateRating
{
    use AsAction;

    public function handle(Rating $rating, RatingUpdateData $data): Rating
    {
        $rating->update(array_filter([
            'user_id' => $data->user_id,
            'book_id' => $data->book_id,
            'rating' => $data->rating,
            'review' => $data->review,
        ], fn ($value) => $value !== null));

        return $rating->fresh(['user', 'book']);
    }
}
