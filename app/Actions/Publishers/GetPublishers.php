<?php

namespace App\Actions\Publishers;

use App\DTOs\Publisher\PublisherIndexDTO;
use App\Models\Publisher;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetPublishers
{
    use AsAction;

    /**
     * Отримати список видавців із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param PublisherIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(PublisherIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Publisher::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'founded_year'])) {
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
     * @param PublisherIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, PublisherIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->country) {
                $options['filter'][] = "country = '{$dto->country}'";
            }

            if ($dto->minFoundedYear !== null) {
                $options['filter'][] = "founded_year >= {$dto->minFoundedYear}";
            }

            if ($dto->maxFoundedYear !== null) {
                $options['filter'][] = "founded_year <= {$dto->maxFoundedYear}";
            }

            if ($dto->contactEmails) {
                foreach ($dto->contactEmails as $email) {
                    $options['filter'][] = "contact_email = '{$email}'";
                }
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
