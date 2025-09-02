<?php

namespace App\Actions\Groups;

use App\DTOs\Group\GroupIndexDTO;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetGroups
{
    use AsAction;

    /**
     * Отримати список груп із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param GroupIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(GroupIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Group::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['name', 'member_count', 'created_at'])) {
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
     * @param GroupIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, GroupIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->creatorId) {
                $options['filter'][] = "creator_id = '{$dto->creatorId}'";
            }

            if ($dto->isPublic !== null) {
                $options['filter'][] = "is_public = " . ($dto->isPublic ? 'true' : 'false');
            }

            if ($dto->isActive !== null) {
                $options['filter'][] = "is_active = " . ($dto->isActive ? 'true' : 'false');
            }

            if ($dto->joinPolicy) {
                $options['filter'][] = "join_policy = '{$dto->joinPolicy}'";
            }

            if ($dto->postPolicy) {
                $options['filter'][] = "post_policy = '{$dto->postPolicy}'";
            }

            if ($dto->minMemberCount !== null) {
                $options['filter'][] = "member_count >= {$dto->minMemberCount}";
            }

            if ($dto->maxMemberCount !== null) {
                $options['filter'][] = "member_count <= {$dto->maxMemberCount}";
            }

            if ($dto->memberIds) {
                $options['filter'][] = "member_ids IN [" . implode(',', $dto->memberIds) . "]";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
