<?php

namespace App\Actions\UserBooks;

use App\DTOs\UserBook\UserBookIndexDTO;
use App\Models\UserBook;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetUserBooks
{
    use AsAction;

    /**
     * Отримати список зв’язків між користувачами та книгами із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param UserBookIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(UserBookIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = UserBook::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'start_date', 'read_date', 'progress_pages', 'rating'])) {
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
     * @param UserBookIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, UserBookIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->bookId) {
                $options['filter'][] = "book_id = {$dto->bookId}";
            }

            if ($dto->shelfId) {
                $options['filter'][] = "shelf_id = {$dto->shelfId}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
