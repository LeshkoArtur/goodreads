<?php

namespace App\Actions\Posts;

use App\DTOs\Post\PostIndexDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetPosts
{
    use AsAction;

    /**
     * Отримати список постів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param PostIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(PostIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Post::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'published_at'])) {
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
     * @param PostIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, PostIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            if ($dto->bookId) {
                $options['filter'][] = "book_id = {$dto->bookId}";
            }

            if ($dto->authorId) {
                $options['filter'][] = "author_id = {$dto->authorId}";
            }

            if ($dto->type) {
                $options['filter'][] = "type = '{$dto->type}'";
            }

            if ($dto->status) {
                $options['filter'][] = "status = '{$dto->status}'";
            }

            if ($dto->minPublishedAt) {
                $options['filter'][] = "published_at >= {$dto->minPublishedAt}";
            }

            if ($dto->maxPublishedAt) {
                $options['filter'][] = "published_at <= {$dto->maxPublishedAt}";
            }

            if ($dto->tagIds) {
                $options['filter'][] = "tag_ids IN [" . implode(',', $dto->tagIds) . "]";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
