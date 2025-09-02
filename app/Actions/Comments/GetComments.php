<?php

namespace App\Actions\Comments;

use App\DTOs\Comment\CommentIndexDTO;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetComments
{
    use AsAction;

    /**
     * Отримати список коментарів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param CommentIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(CommentIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Comment::search($dto->query ?? '');

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
     * @param CommentIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, CommentIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = '{$dto->userId}'";
            }

            if ($dto->commentableType) {
                $options['filter'][] = "commentable_type = '{$dto->commentableType}'";
            }

            if ($dto->commentableId) {
                $options['filter'][] = "commentable_id = '{$dto->commentableId}'";
            }

            if ($dto->isRoot !== null) {
                $options['filter'][] = "parent_id IS " . ($dto->isRoot ? 'NULL' : 'NOT NULL');
            }

            if ($dto->parentId) {
                $options['filter'][] = "parent_id = '{$dto->parentId}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
