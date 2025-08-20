<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GroupPoll;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі GroupPoll.
 */
class GroupPollPolicy
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
     * Визначає, чи може користувач переглядати будь-які опитування груп.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати опитування групи.
     *
     * @param User $user
     * @param GroupPoll $groupPoll
     * @return bool
     */
    public function view(User $user, GroupPoll $groupPoll): bool
    {
        return $groupPoll->group->is_public || $groupPoll->group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати опитування груп.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати опитування групи.
     *
     * @param User $user
     * @param GroupPoll $groupPoll
     * @return bool
     */
    public function update(User $user, GroupPoll $groupPoll): bool
    {
        return $groupPoll->creator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти опитування групи.
     *
     * @param User $user
     * @param GroupPoll $groupPoll
     * @return bool
     */
    public function delete(User $user, GroupPoll $groupPoll): bool
    {
        return $groupPoll->creator_id === $user->id;
    }
}
