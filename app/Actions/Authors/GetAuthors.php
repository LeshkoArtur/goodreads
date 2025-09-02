<?php

namespace App\Actions\Authors;

use App\DTOs\Author\AuthorIndexDTO;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetAuthors
{
    use AsAction;

    /**
     * Отримати список авторів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param AuthorIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(AuthorIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Author::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['name', 'birth_date', 'created_at'])) {
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
     * @param AuthorIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, AuthorIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->nationality) {
                $options['filter'][] = "nationality = '{$dto->nationality}'";
            }

            if ($dto->minBirthDate !== null) {
                $options['filter'][] = "birth_date >= '{$dto->minBirthDate}'";
            }
            if ($dto->maxBirthDate !== null) {
                $options['filter'][] = "birth_date <= '{$dto->maxBirthDate}'";
            }

            if ($dto->minDeathDate !== null) {
                $options['filter'][] = "death_date >= '{$dto->minDeathDate}'";
            }
            if ($dto->maxDeathDate !== null) {
                $options['filter'][] = "death_date <= '{$dto->maxDeathDate}'";
            }

            if ($dto->typeOfWork) {
                $options['filter'][] = "type_of_work = '{$dto->typeOfWork}'";
            }

            if ($dto->socialMediaLinks) {
                foreach ($dto->socialMediaLinks as $link) {
                    $options['filter'][] = "social_media_links = '{$link}'";
                }
            }

            if ($dto->userIds) {
                $options['filter'][] = 'user_ids IN [' . implode(',', $dto->userIds) . ']';
            }

            if ($dto->bookIds) {
                $options['filter'][] = 'book_ids IN [' . implode(',', $dto->bookIds) . ']';
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
