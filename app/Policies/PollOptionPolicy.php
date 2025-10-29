<?php

namespace App\Policies;

use App\Models\PollOption;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі PollOption.
 */
class PollOptionPolicy
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
     * Визначає, чи може користувач переглядати будь-які варіанти опитувань.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати варіант опитування.
     */
    public function view(User $user, PollOption $pollOption): bool
    {
        return $pollOption->poll->group->is_public || $pollOption->poll->group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати варіанти опитувань.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати варіант опитування.
     */
    public function update(User $user, PollOption $pollOption): bool
    {
        return $pollOption->poll->creator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти варіант опитування.
     */
    public function delete(User $user, PollOption $pollOption): bool
    {
        return $pollOption->poll->creator_id === $user->id;
    }
}
