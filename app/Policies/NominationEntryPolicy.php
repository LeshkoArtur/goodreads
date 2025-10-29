<?php

namespace App\Policies;

use App\Models\NominationEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі NominationEntry.
 */
class NominationEntryPolicy
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
     * Визначає, чи може користувач переглядати будь-які записи номінацій.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати запис номінації.
     */
    public function view(User $user, NominationEntry $nominationEntry): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати записи номінацій.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати запис номінації.
     */
    public function update(User $user, NominationEntry $nominationEntry): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти запис номінації.
     */
    public function delete(User $user, NominationEntry $nominationEntry): bool
    {
        return false;
    }
}
