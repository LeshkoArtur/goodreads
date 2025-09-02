<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Store.
 */
class StorePolicy
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
     * Визначає, чи може користувач переглядати будь-які магазини.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати магазин.
     *
     * @param User $user
     * @param Store $store
     * @return bool
     */
    public function view(User $user, Store $store): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати магазини.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач оновлювати магазин.
     *
     * @param User $user
     * @param Store $store
     * @return bool
     */
    public function update(User $user, Store $store): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти магазин.
     *
     * @param User $user
     * @param Store $store
     * @return bool
     */
    public function delete(User $user, Store $store): bool
    {
        return false;
    }
}
