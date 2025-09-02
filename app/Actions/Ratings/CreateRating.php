<?php

namespace App\Actions\Ratings;

use App\DTOs\Rating\RatingStoreDTO;
use App\Models\Rating;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateRating
{
    use AsAction;

    /**
     * Створити новий рейтинг.
     *
     * @param RatingStoreDTO $dto
     * @return Rating
     */
    public function handle(RatingStoreDTO $dto): Rating
    {
        $rating = new Rating();
        $rating->user_id = $dto->userId;
        $rating->book_id = $dto->bookId;
        $rating->rating = $dto->rating;
        $rating->review = $dto->review;

        $rating->save();

        return $rating->load(['user', 'book', 'comments', 'likes', 'favorites']);
    }
}
