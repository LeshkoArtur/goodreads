<?php

namespace App\Actions\Quotes;

use App\DTOs\Quote\QuoteStoreDTO;
use App\Models\Quote;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateQuote
{
    use AsAction;

    /**
     * Створити нову цитату.
     *
     * @param QuoteStoreDTO $dto
     * @return Quote
     */
    public function handle(QuoteStoreDTO $dto): Quote
    {
        $quote = new Quote();
        $quote->user_id = $dto->userId;
        $quote->book_id = $dto->bookId;
        $quote->text = $dto->text;
        $quote->page_number = $dto->pageNumber;
        $quote->contains_spoilers = $dto->containsSpoilers;
        $quote->is_public = $dto->isPublic;

        $quote->save();

        return $quote->load(['user', 'book', 'comments', 'likes', 'favorites']);
    }
}
