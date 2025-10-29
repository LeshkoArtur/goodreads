<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Store.
 */
class StorePolicy
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
     * Визначає, чи може користувач переглядати будь-які магазини.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати магазин.
     */
    public function view(User $user, Store $store): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати магазини.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач оновлювати магазин.
     */
    public function update(User $user, Store $store): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти магазин.
     */
    public function delete(User $user, Store $store): bool
    {
        return false;
    }
}
