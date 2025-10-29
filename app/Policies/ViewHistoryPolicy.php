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
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати історію переглядів.
     */
    public function view(User $user, ViewHistory $viewHistory): bool
    {
        return $viewHistory->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати історії переглядів.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати історію переглядів.
     */
    public function update(User $user, ViewHistory $viewHistory): bool
    {
        return $viewHistory->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти історію переглядів.
     */
    public function delete(User $user, ViewHistory $viewHistory): bool
    {
        return $viewHistory->user_id === $user->id;
    }
}
