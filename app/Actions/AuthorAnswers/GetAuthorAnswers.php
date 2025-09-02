<?php

namespace App\Actions\AuthorAnswers;

use App\DTOs\AuthorAnswer\AuthorAnswerIndexDTO;
use App\Models\AuthorAnswer;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetAuthorAnswers
{
    use AsAction;

    /**
     * Отримати список відповідей авторів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param AuthorAnswerIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(AuthorAnswerIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = AuthorAnswer::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['published_at', 'created_at'])) {
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
     * @param AuthorAnswerIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, AuthorAnswerIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->questionId) {
                $options['filter'][] = "question_id = '{$dto->questionId}'";
            }

            if ($dto->authorId) {
                $options['filter'][] = "author_id = '{$dto->authorId}'";
            }

            if ($dto->status) {
                $options['filter'][] = "status = '{$dto->status}'";
            }

            if ($dto->minPublishedAt) {
                $options['filter'][] = "published_at >= '{$dto->minPublishedAt}'";
            }

            if ($dto->maxPublishedAt) {
                $options['filter'][] = "published_at <= '{$dto->maxPublishedAt}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
