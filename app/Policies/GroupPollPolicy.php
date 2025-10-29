<?php

namespace App\Policies;

use App\Models\GroupPoll;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі GroupPoll.
 */
class GroupPollPolicy
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
     * Визначає, чи може користувач переглядати будь-які опитування груп.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати опитування групи.
     */
    public function view(User $user, GroupPoll $groupPoll): bool
    {
        return $groupPoll->group->is_public || $groupPoll->group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати опитування груп.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати опитування групи.
     */
    public function update(User $user, GroupPoll $groupPoll): bool
    {
        return $groupPoll->creator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти опитування групи.
     */
    public function delete(User $user, GroupPoll $groupPoll): bool
    {
        return $groupPoll->creator_id === $user->id;
    }
}
