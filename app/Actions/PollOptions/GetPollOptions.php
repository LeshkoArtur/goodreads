<?php

namespace App\Actions\PollOptions;

use App\DTOs\PollOption\PollOptionIndexDTO;
use App\Models\PollOption;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetPollOptions
{
    use AsAction;

    /**
     * Отримати список варіантів опитувань із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param PollOptionIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(PollOptionIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = PollOption::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at', 'vote_count'])) {
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
     * @param PollOptionIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, PollOptionIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->groupPollId) {
                $options['filter'][] = "group_poll_id = {$dto->groupPollId}";
            }

            if ($dto->minVoteCount !== null) {
                $options['filter'][] = "vote_count >= {$dto->minVoteCount}";
            }

            if ($dto->maxVoteCount !== null) {
                $options['filter'][] = "vote_count <= {$dto->maxVoteCount}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
