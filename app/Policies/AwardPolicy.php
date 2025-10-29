<?php

namespace App\Policies;

use App\Models\Award;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Award.
 */
class AwardPolicy
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
     * Визначає, чи може користувач переглядати будь-які нагороди.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати нагороду.
     */
    public function view(User $user, Award $award): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати нагороди.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати нагороду.
     */
    public function update(User $user, Award $award): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти нагороду.
     */
    public function delete(User $user, Award $award): bool
    {
        return false;
    }
}
