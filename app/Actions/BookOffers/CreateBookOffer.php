<?php

namespace App\Actions\BookOffers;

use App\DTOs\BookOffer\BookOfferStoreDTO;
use App\Models\BookOffer;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBookOffer
{
    use AsAction;

    /**
     * Створити нову пропозицію книги.
     *
     * @param BookOfferStoreDTO $dto
     * @return BookOffer
     */
    public function handle(BookOfferStoreDTO $dto): BookOffer
    {
        $bookOffer = new BookOffer();
        $bookOffer->book_id = $dto->bookId;
        $bookOffer->store_id = $dto->storeId;
        $bookOffer->price = $dto->price;
        $bookOffer->currency = $dto->currency;
        $bookOffer->referral_url = $dto->referralUrl;
        $bookOffer->availability = $dto->availability;
        $bookOffer->status = $dto->status;
        $bookOffer->last_updated_at = $dto->lastUpdatedAt;

        $bookOffer->save();

        return $bookOffer->load(['book', 'store']);
    }
}
