<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Character.
 */
class CharacterPolicy
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
     * Визначає, чи може користувач переглядати будь-які персонажі.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати персонажа.
     */
    public function view(User $user, Character $character): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати персонажів.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати персонажа.
     */
    public function update(User $user, Character $character): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти персонажа.
     */
    public function delete(User $user, Character $character): bool
    {
        return false;
    }
}
