<?php

namespace App\Actions\Quotes;

use App\DTOs\Quote\QuoteUpdateDTO;
use App\Models\Quote;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateQuote
{
    use AsAction;

    /**
     * Оновити існуючу цитату.
     *
     * @param Quote $quote
     * @param QuoteUpdateDTO $dto
     * @return Quote
     */
    public function handle(Quote $quote, QuoteUpdateDTO $dto): Quote
    {
        $attributes = [
            'text' => $dto->body,
            'is_public' => $dto->status === 'public' ? true : ($dto->status === 'private' ? false : null),
        ];

        $quote->fill(array_filter($attributes, fn($value) => $value !== null));

        $quote->save();

        if ($dto->tagIds !== null) {
            $quote->tags()->sync($dto->tagIds);
        }

        return $quote->load(['user', 'book', 'comments', 'likes', 'favorites']);
    }
}
