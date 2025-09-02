<?php

namespace App\Actions\Notes;

use App\DTOs\Note\NoteIndexDTO;
use App\Models\Note;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetNotes
{
    use AsAction;

    /**
     * Отримати список нотаток із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param NoteIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(NoteIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Note::search($dto->query ?? '');

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
     * @param NoteIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, NoteIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->bookId) {
                $options['filter'][] = "book_id = {$dto->bookId}";
            }

            if ($dto->containsSpoilers !== null) {
                $options['filter'][] = "contains_spoilers = " . ($dto->containsSpoilers ? 'true' : 'false');
            }

            if ($dto->isPrivate !== null) {
                $options['filter'][] = "is_private = " . ($dto->isPrivate ? 'true' : 'false');
            }

            if ($dto->minPageNumber !== null) {
                $options['filter'][] = "page_number >= {$dto->minPageNumber}";
            }

            if ($dto->maxPageNumber !== null) {
                $options['filter'][] = "page_number <= {$dto->maxPageNumber}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
