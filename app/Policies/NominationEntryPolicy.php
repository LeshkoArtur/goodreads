<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NominationEntry;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі NominationEntry.
 */
class NominationEntryPolicy
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
     * Визначає, чи може користувач переглядати будь-які записи номінацій.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати запис номінації.
     *
     * @param User $user
     * @param NominationEntry $nominationEntry
     * @return bool
     */
    public function view(User $user, NominationEntry $nominationEntry): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати записи номінацій.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати запис номінації.
     *
     * @param User $user
     * @param NominationEntry $nominationEntry
     * @return bool
     */
    public function update(User $user, NominationEntry $nominationEntry): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти запис номінації.
     *
     * @param User $user
     * @param NominationEntry $nominationEntry
     * @return bool
     */
    public function delete(User $user, NominationEntry $nominationEntry): bool
    {
        return false;
    }
}
