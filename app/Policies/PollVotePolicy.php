<?php

namespace App\Policies;

use App\Models\PollVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі PollVote.
 */
class PollVotePolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма перевірками авторизації.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Визначає, чи може користувач переглядати будь-які голоси в опитуваннях.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати голос в опитуванні.
     */
    public function view(User $user, PollVote $pollVote): bool
    {
        return $pollVote->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати голоси в опитуваннях.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати голос в опитуванні.
     */
    public function update(User $user, PollVote $pollVote): bool
    {
        return $pollVote->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти голос в опитуванні.
     */
    public function delete(User $user, PollVote $pollVote): bool
    {
        return $pollVote->user_id === $user->id;
    }
}
