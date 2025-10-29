<?php

namespace App\Actions\BookOffers;

use App\Data\BookOffer\BookOfferUpdateData;
use App\Models\BookOffer;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBookOffer
{
    use AsAction;

    public function handle(BookOffer $bookOffer, BookOfferUpdateData $data): BookOffer
    {
        $bookOffer->update(array_filter([
            'book_id' => $data->book_id,
            'store_id' => $data->store_id,
            'price' => $data->price,
            'currency' => $data->currency,
            'referral_url' => $data->referral_url,
            'availability' => $data->availability,
            'status' => $data->status,
            'last_updated_at' => $data->last_updated_at,
        ], fn ($value) => $value !== null));

        return $bookOffer->fresh(['book', 'store']);
    }
}
