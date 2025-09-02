<?php

namespace App\Actions\PollVotes;

use App\DTOs\PollVote\PollVoteIndexDTO;
use App\Models\PollVote;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetPollVotes
{
    use AsAction;

    /**
     * Отримати список голосів в опитуваннях із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param PollVoteIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(PollVoteIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = PollVote::search($dto->query ?? '');

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
     * @param PollVoteIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, PollVoteIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->groupPollId) {
                $options['filter'][] = "group_poll_id = {$dto->groupPollId}";
            }

            if ($dto->pollOptionId) {
                $options['filter'][] = "poll_option_id = {$dto->pollOptionId}";
            }

            if ($dto->userId) {
                $options['filter'][] = "user_id = {$dto->userId}";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
