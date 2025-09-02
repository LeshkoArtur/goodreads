<?php

namespace App\Actions\ReadingStats;

use App\DTOs\ReadingStat\ReadingStatIndexDTO;
use App\Models\ReadingStat;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetReadingStats
{
    use AsAction;

    /**
     * Отримати список статистик читання із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param ReadingStatIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(ReadingStatIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = ReadingStat::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'year', 'books_read', 'pages_read'])) {
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
     * @param ReadingStatIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, ReadingStatIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->bookId) {
                $options['filter'][] = "book_id = {$dto->bookId}";
            }

            if ($dto->minPagesRead !== null) {
                $options['filter'][] = "pages_read >= {$dto->minPagesRead}";
            }

            if ($dto->maxPagesRead !== null) {
                $options['filter'][] = "pages_read <= {$dto->maxPagesRead}";
            }

            if ($dto->minStartDate) {
                $options['filter'][] = "created_at >= {$dto->minStartDate}";
            }

            if ($dto->maxStartDate) {
                $options['filter'][] = "created_at <= {$dto->maxStartDate}";
            }

            if ($dto->minFinishDate) {
                $options['filter'][] = "updated_at >= {$dto->minFinishDate}";
            }

            if ($dto->maxFinishDate) {
                $options['filter'][] = "updated_at <= {$dto->maxFinishDate}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
