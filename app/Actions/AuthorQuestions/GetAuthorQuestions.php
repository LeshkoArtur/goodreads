<?php

namespace App\Actions\AuthorQuestions;

use App\DTOs\AuthorQuestion\AuthorQuestionIndexDTO;
use App\Models\AuthorQuestion;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetAuthorQuestions
{
    use AsAction;

    /**
     * Отримати список питань до авторів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param AuthorQuestionIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(AuthorQuestionIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = AuthorQuestion::search($dto->query ?? '');

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
     * @param AuthorQuestionIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, AuthorQuestionIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->userId) {
                $options['filter'][] = "user_id = '{$dto->userId}'";
            }

            if ($dto->authorId) {
                $options['filter'][] = "author_id = '{$dto->authorId}'";
            }

            if ($dto->bookId) {
                $options['filter'][] = "book_id = '{$dto->bookId}'";
            }

            if ($dto->status) {
                $options['filter'][] = "status = '{$dto->status}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
