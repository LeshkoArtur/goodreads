<?php

namespace App\Actions\GroupPosts;

use App\DTOs\GroupPost\GroupPostIndexDTO;
use App\Models\GroupPost;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetGroupPosts
{
    use AsAction;

    /**
     * Отримати список постів груп із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param GroupPostIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(GroupPostIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = GroupPost::search($dto->query ?? '');

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
     * @param GroupPostIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, GroupPostIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->groupId) {
                $options['filter'][] = "group_id = {$dto->groupId}";
            }

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->isPinned !== null) {
                $options['filter'][] = "is_pinned = " . ($dto->isPinned ? 'true' : 'false');
            }

            if ($dto->category) {
                $options['filter'][] = "category = '{$dto->category}'";
            }

            if ($dto->postStatus) {
                $options['filter'][] = "post_status = '{$dto->postStatus}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
