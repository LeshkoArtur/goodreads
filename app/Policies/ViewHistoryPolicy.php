<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ViewHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі ViewHistory.
 */
class ViewHistoryPolicy
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
     * Визначає, чи може користувач переглядати будь-які історії переглядів.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати історію переглядів.
     *
     * @param User $user
     * @param ViewHistory $viewHistory
     * @return bool
     */
    public function view(User $user, ViewHistory $viewHistory): bool
    {
        return $viewHistory->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати історії переглядів.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати історію переглядів.
     *
     * @param User $user
     * @param ViewHistory $viewHistory
     * @return bool
     */
    public function update(User $user, ViewHistory $viewHistory): bool
    {
        return $viewHistory->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти історію переглядів.
     *
     * @param User $user
     * @param ViewHistory $viewHistory
     * @return bool
     */
    public function delete(User $user, ViewHistory $viewHistory): bool
    {
        return $viewHistory->user_id === $user->id;
    }
}
