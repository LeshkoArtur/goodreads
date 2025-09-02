<?php

namespace App\Actions\Users;

use App\DTOs\User\UserIndexDTO;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetUsers
{
    use AsAction;

    /**
     * Отримати список користувачів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param UserIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(UserIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = User::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'username', 'last_login'])) {
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
     * @param UserIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, UserIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->role) {
                $options['filter'][] = "role = '{$dto->role}'";
            }

            if ($dto->gender) {
                $options['filter'][] = "gender = '{$dto->gender}'";
            }

            if ($dto->isPublic !== null) {
                $options['filter'][] = "is_public = " . ($dto->isPublic ? 'true' : 'false');
            }

            if ($dto->location) {
                $options['filter'][] = "location = '{$dto->location}'";
            }

            if ($dto->socialMediaLinks) {
                foreach ($dto->socialMediaLinks as $link) {
                    $options['filter'][] = "social_media_links = '{$link}'";
                }
            }

            if ($dto->minBirthday) {
                $options['filter'][] = "birthday >= {$dto->minBirthday}";
            }

            if ($dto->maxBirthday) {
                $options['filter'][] = "birthday <= {$dto->maxBirthday}";
            }

            if ($dto->minLastLogin) {
                $options['filter'][] = "last_login >= {$dto->minLastLogin}";
            }

            if ($dto->maxLastLogin) {
                $options['filter'][] = "last_login <= {$dto->maxLastLogin}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
