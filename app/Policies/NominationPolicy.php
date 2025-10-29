<?php

namespace App\Policies;

use App\Models\Nomination;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Nomination.
 */
class NominationPolicy
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
     * Визначає, чи може користувач переглядати будь-які номінації.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати номінацію.
     */
    public function view(User $user, Nomination $nomination): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати номінації.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати номінацію.
     */
    public function update(User $user, Nomination $nomination): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти номінацію.
     */
    public function delete(User $user, Nomination $nomination): bool
    {
        return false;
    }
}
