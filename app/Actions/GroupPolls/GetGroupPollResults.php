<?php

namespace App\Actions\GroupPolls;

use App\Models\GroupPoll;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPollResults
{
    use AsAction;

    public function handle(GroupPoll $groupPoll): array
    {
        $options = $groupPoll->options()->withCount('votes')->get();
        $totalVotes = $groupPoll->votes()->count();

        return [
            'poll_id' => $groupPoll->id,
            'question' => $groupPoll->question,
            'total_votes' => $totalVotes,
            'options' => $options->map(function ($option) use ($totalVotes) {
                $percentage = $totalVotes > 0 ? round(($option->votes_count / $totalVotes) * 100, 2) : 0;

                return [
                    'id' => $option->id,
                    'text' => $option->text,
                    'votes_count' => $option->votes_count,
                    'percentage' => $percentage,
                ];
            })->toArray(),
        ];
    }
}
