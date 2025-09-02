<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PollVote;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі PollVote.
 */
class PollVotePolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма перевірками авторизації.
     *
     * @param User $user
     * @param string $ability
     * @return bool|null
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
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати голос в опитуванні.
     *
     * @param User $user
     * @param PollVote $pollVote
     * @return bool
     */
    public function view(User $user, PollVote $pollVote): bool
    {
        return $pollVote->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати голоси в опитуваннях.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати голос в опитуванні.
     *
     * @param User $user
     * @param PollVote $pollVote
     * @return bool
     */
    public function update(User $user, PollVote $pollVote): bool
    {
        return $pollVote->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти голос в опитуванні.
     *
     * @param User $user
     * @param PollVote $pollVote
     * @return bool
     */
    public function delete(User $user, PollVote $pollVote): bool
    {
        return $pollVote->user_id === $user->id;
    }
}
