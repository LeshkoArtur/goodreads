<?php

namespace App\Actions\NominationEntries;

use App\DTOs\NominationEntry\NominationEntryIndexDTO;
use App\Models\NominationEntry;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetNominationEntries
{
    use AsAction;

    /**
     * Отримати список записів номінацій із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param NominationEntryIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(NominationEntryIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = NominationEntry::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at'])) {
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
     * @param NominationEntryIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, NominationEntryIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->nominationId) {
                $options['filter'][] = "nomination_id = {$dto->nominationId}";
            }

            if ($dto->bookId) {
                $options['filter'][] = "book_id = {$dto->bookId}";
            }

            if ($dto->authorId) {
                $options['filter'][] = "author_id = {$dto->authorId}";
            }

            if ($dto->status) {
                $options['filter'][] = "status = '{$dto->status}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
