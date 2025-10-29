<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі User.
 */
class UserPolicy
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
     * Визначає, чи може користувач переглядати будь-які профілі користувачів.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати профіль користувача.
     */
    public function view(User $user, User $targetUser): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати профілі користувачів.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач оновлювати профіль користувача.
     */
    public function update(User $user, User $targetUser): bool
    {
        return $user->id === $targetUser->id;
    }

    /**
     * Визначає, чи може користувач видаляти профіль користувача.
     */
    public function delete(User $user, User $targetUser): bool
    {
        return $user->id === $targetUser->id;
    }
}
