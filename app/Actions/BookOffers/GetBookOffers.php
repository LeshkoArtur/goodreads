<?php

namespace App\Actions\BookOffers;

use App\DTOs\BookOffer\BookOfferIndexDTO;
use App\Models\BookOffer;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetBookOffers
{
    use AsAction;

    /**
     * Отримати список пропозицій книг із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param BookOfferIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(BookOfferIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = BookOffer::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['price', 'last_updated_at', 'created_at'])) {
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
     * @param BookOfferIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, BookOfferIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->bookId) {
                $options['filter'][] = "book_id = '{$dto->bookId}'";
            }

            if ($dto->storeId) {
                $options['filter'][] = "store_id = '{$dto->storeId}'";
            }

            if ($dto->minPrice !== null) {
                $options['filter'][] = "price >= {$dto->minPrice}";
            }

            if ($dto->maxPrice !== null) {
                $options['filter'][] = "price <= {$dto->maxPrice}";
            }

            if ($dto->currency) {
                $options['filter'][] = "currency = '{$dto->currency}'";
            }

            if ($dto->status) {
                $options['filter'][] = "status = '{$dto->status}'";
            }

            if ($dto->minLastUpdatedAt) {
                $options['filter'][] = "last_updated_at >= '{$dto->minLastUpdatedAt}'";
            }

            if ($dto->maxLastUpdatedAt) {
                $options['filter'][] = "last_updated_at <= '{$dto->maxLastUpdatedAt}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
