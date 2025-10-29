<?php

namespace App\Actions\Quotes;

use App\Data\Quote\QuoteStoreData;
use App\Models\Quote;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateQuote
{
    use AsAction;

    public function handle(QuoteStoreData $data): Quote
    {
        $quote = new Quote;
        $quote->user_id = $data->user_id;
        $quote->book_id = $data->book_id;
        $quote->text = $data->text;
        $quote->page_number = $data->page_number;
        $quote->contains_spoilers = $data->contains_spoilers;
        $quote->is_public = $data->is_public;
        $quote->save();

        return $quote->fresh(['user', 'book']);
    }
}
