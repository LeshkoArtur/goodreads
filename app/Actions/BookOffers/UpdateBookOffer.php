<?php

namespace App\Actions\BookOffers;

use App\DTOs\BookOffer\BookOfferUpdateDTO;
use App\Models\BookOffer;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBookOffer
{
    use AsAction;

    /**
     * Оновити існуючу пропозицію книги.
     *
     * @param BookOffer $bookOffer
     * @param BookOfferUpdateDTO $dto
     * @return BookOffer
     */
    public function handle(BookOffer $bookOffer, BookOfferUpdateDTO $dto): BookOffer
    {
        $attributes = [
            'price' => $dto->price,
            'currency' => $dto->currency,
            'status' => $dto->status,
            'referral_url' => $dto->url,
        ];

        $bookOffer->fill(array_filter($attributes, fn($value) => $value !== null));

        $bookOffer->save();

        return $bookOffer->load(['book', 'store']);
    }
}
