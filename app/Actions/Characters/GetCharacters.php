<?php

namespace App\Actions\Characters;

use App\DTOs\Character\CharacterIndexDTO;
use App\Models\Character;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetCharacters
{
    use AsAction;

    /**
     * Отримати список персонажів із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param CharacterIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(CharacterIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = Character::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['name', 'created_at'])) {
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
     * @param CharacterIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, CharacterIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->bookId) {
                $options['filter'][] = "book_id = '{$dto->bookId}'";
            }

            if ($dto->race) {
                $options['filter'][] = "race = '{$dto->race}'";
            }

            if ($dto->nationality) {
                $options['filter'][] = "nationality = '{$dto->nationality}'";
            }

            if ($dto->residence) {
                $options['filter'][] = "residence = '{$dto->residence}'";
            }

            if ($dto->otherNames) {
                foreach ($dto->otherNames as $name) {
                    $options['filter'][] = "other_names = '{$name}'";
                }
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
