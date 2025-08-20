<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shelf;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Shelf.
 */
class ShelfPolicy
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
     * Визначає, чи може користувач переглядати будь-які полиці.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати полицю.
     *
     * @param User $user
     * @param Shelf $shelf
     * @return bool
     */
    public function view(User $user, Shelf $shelf): bool
    {
        return $shelf->is_public || $shelf->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати полиці.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати полицю.
     *
     * @param User $user
     * @param Shelf $shelf
     * @return bool
     */
    public function update(User $user, Shelf $shelf): bool
    {
        return $shelf->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти полицю.
     *
     * @param User $user
     * @param Shelf $shelf
     * @return bool
     */
    public function delete(User $user, Shelf $shelf): bool
    {
        return $shelf->user_id === $user->id;
    }
}
