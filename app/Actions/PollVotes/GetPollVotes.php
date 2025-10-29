<?php

namespace App\Actions\PollVotes;

use App\Data\PollVote\PollVoteIndexData;
use App\Models\PollVote;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPollVotes
{
    use AsAction;

    public function handle(PollVoteIndexData $data): LengthAwarePaginator
    {
        $searchQuery = PollVote::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/poll-votes');

        return $paginator;
    }

    private function applyFilters(Builder $query, PollVoteIndexData $data): void
    {
        $filters = collect()
                ->when($data->group_poll_id, fn ($collection) => $collection->push("group_poll_id = '{$data->group_poll_id}'"))
                ->when($data->poll_option_id, fn ($collection) => $collection->push("poll_option_id = '{$data->poll_option_id}'"))
                ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
