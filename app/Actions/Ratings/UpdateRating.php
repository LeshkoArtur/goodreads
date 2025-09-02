<?php

namespace App\Actions\Ratings;

use App\DTOs\Rating\RatingUpdateDTO;
use App\Models\Rating;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateRating
{
    use AsAction;

    /**
     * Оновити існуючий рейтинг.
     *
     * @param Rating $rating
     * @param RatingUpdateDTO $dto
     * @return Rating
     */
    public function handle(Rating $rating, RatingUpdateDTO $dto): Rating
    {
        $attributes = [
            'rating' => $dto->score,
        ];

        $rating->fill(array_filter($attributes, fn($value) => $value !== null));

        $rating->save();

        return $rating->load(['user', 'book', 'comments', 'likes', 'favorites']);
    }
}
