<?php

namespace App\Actions\BookOffers;

use App\Data\BookOffer\BookOfferStoreData;
use App\Models\BookOffer;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBookOffer
{
    use AsAction;

    public function handle(BookOfferStoreData $data): BookOffer
    {
        $bookOffer = new BookOffer;
        $bookOffer->book_id = $data->book_id;
        $bookOffer->store_id = $data->store_id;
        $bookOffer->price = $data->price;
        $bookOffer->currency = $data->currency;
        $bookOffer->referral_url = $data->referral_url;
        $bookOffer->availability = $data->availability;
        $bookOffer->status = $data->status;
        $bookOffer->last_updated_at = $data->last_updated_at;
        $bookOffer->save();

        return $bookOffer->fresh(['book', 'store']);
    }
}
