<?php

namespace App\Actions\Tags;

use App\DTOs\Tag\TagIndexDTO;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetTags
{
    use AsAction;

    /**
     * Отримати список тегів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param TagIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(TagIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Tag::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'name'])) {
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
     * @param TagIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, TagIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->minUsageCount !== null) {
                $options['filter'][] = "taggable_count >= {$dto->minUsageCount}";
            }

            if ($dto->maxUsageCount !== null) {
                $options['filter'][] = "taggable_count <= {$dto->maxUsageCount}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
