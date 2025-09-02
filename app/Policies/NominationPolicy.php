<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Nomination;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Nomination.
 */
class NominationPolicy
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
     * Визначає, чи може користувач переглядати будь-які номінації.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати номінацію.
     *
     * @param User $user
     * @param Nomination $nomination
     * @return bool
     */
    public function view(User $user, Nomination $nomination): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати номінації.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати номінацію.
     *
     * @param User $user
     * @param Nomination $nomination
     * @return bool
     */
    public function update(User $user, Nomination $nomination): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти номінацію.
     *
     * @param User $user
     * @param Nomination $nomination
     * @return bool
     */
    public function delete(User $user, Nomination $nomination): bool
    {
        return false;
    }
}
