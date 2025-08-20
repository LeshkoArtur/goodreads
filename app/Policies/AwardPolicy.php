<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Award;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Award.
 */
class AwardPolicy
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
     * Визначає, чи може користувач переглядати будь-які нагороди.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати нагороду.
     *
     * @param User $user
     * @param Award $award
     * @return bool
     */
    public function view(User $user, Award $award): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати нагороди.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати нагороду.
     *
     * @param User $user
     * @param Award $award
     * @return bool
     */
    public function update(User $user, Award $award): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти нагороду.
     *
     * @param User $user
     * @param Award $award
     * @return bool
     */
    public function delete(User $user, Award $award): bool
    {
        return false;
    }
}
