<?php

namespace App\Actions\Quotes;

use App\DTOs\Quote\QuoteIndexDTO;
use App\Models\Quote;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetQuotes
{
    use AsAction;

    /**
     * Отримати список цитат із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param QuoteIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(QuoteIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Quote::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'page_number'])) {
            $searchQuery->orderBy($dto->sort, $dto->direction ?? 'desc');
        }

        return $searchQuery->paginate(
            perPage: $dto->perPage,
            page: $dto->page
        );
    }

    /**
     * Застосувати фільтри до пошукового запиту Meilisearch.
     *
     * @param Builder $query
     * @param QuoteIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, QuoteIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->bookId) {
                $options['filter'][] = "book_id = {$dto->bookId}";
            }

            if ($dto->authorId) {
                $options['filter'][] = "author_id = {$dto->authorId}";
            }

            if ($dto->status) {
                $options['filter'][] = "is_public = " . ($dto->status === 'public' ? 'true' : 'false');
            }

            if ($dto->tagIds) {
                $options['filter'][] = "tag_ids IN [" . implode(',', $dto->tagIds) . "]";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
