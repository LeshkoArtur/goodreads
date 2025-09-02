<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PollVoteQueryBuilder extends Builder
{
    /**
     * Голоси для певного опитування.
     */
    public function forPoll(string $pollId): static
    {
        return $this->where('group_poll_id', $pollId);
    }

    /**
     * Голоси для певної опції.
     */
    public function forOption(string $optionId): static
    {
        return $this->where('poll_option_id', $optionId);
    }

    /**
     * Голоси від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }
}
