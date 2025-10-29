<?php

namespace App\Actions\Quotes;

use App\Data\Quote\QuoteUpdateData;
use App\Models\Quote;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateQuote
{
    use AsAction;

    public function handle(Quote $quote, QuoteUpdateData $data): Quote
    {
        $quote->update(array_filter([
            'user_id' => $data->user_id,
            'book_id' => $data->book_id,
            'text' => $data->text,
            'page_number' => $data->page_number,
            'contains_spoilers' => $data->contains_spoilers,
            'is_public' => $data->is_public,
        ], fn ($value) => $value !== null));

        return $quote->fresh(['user', 'book']);
    }
}
