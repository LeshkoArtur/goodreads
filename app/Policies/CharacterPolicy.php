<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Character;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Character.
 */
class CharacterPolicy
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
     * Визначає, чи може користувач переглядати будь-які персонажі.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати персонажа.
     *
     * @param User $user
     * @param Character $character
     * @return bool
     */
    public function view(User $user, Character $character): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати персонажів.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати персонажа.
     *
     * @param User $user
     * @param Character $character
     * @return bool
     */
    public function update(User $user, Character $character): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти персонажа.
     *
     * @param User $user
     * @param Character $character
     * @return bool
     */
    public function delete(User $user, Character $character): bool
    {
        return false;
    }
}
