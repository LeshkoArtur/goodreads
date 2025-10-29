<?php

namespace App\Actions\Quotes;

use App\Data\Quote\QuoteRelationIndexData;
use App\Models\Quote;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetQuoteLikes
{
    use AsAction;

    public function handle(Quote $quote, QuoteRelationIndexData $data): LengthAwarePaginator
    {
        $query = $quote->likes()->with(['user']);

        if ($data->sort && in_array($data->sort, ['created_at'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
