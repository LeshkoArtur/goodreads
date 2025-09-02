<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PollOptionQueryBuilder extends Builder
{
    /**
     * Опції для певного опитування.
     */
    public function forPoll(string $pollId): static
    {
        return $this->where('group_poll_id', $pollId);
    }

    /**
     * Опції з певним текстом (частковий збіг).
     */
    public function withText(string $text): static
    {
        return $this->where('text', 'like', '%' . $text . '%');
    }

    /**
     * Опції з мінімальною кількістю голосів.
     */
    public function minVotes(int $count): static
    {
        return $this->where('vote_count', '>=', $count);
    }
}
