<?php

namespace App\Actions\Ratings;

use App\Data\Rating\RatingStoreData;
use App\Models\Rating;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateRating
{
    use AsAction;

    public function handle(RatingStoreData $data): Rating
    {
        $rating = new Rating;
        $rating->user_id = $data->user_id;
        $rating->book_id = $data->book_id;
        $rating->rating = $data->rating;
        $rating->review = $data->review;
        $rating->save();

        return $rating->fresh(['user', 'book']);
    }
}
