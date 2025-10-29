<?php

namespace App\Policies;

use App\Models\Shelf;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Shelf.
 */
class ShelfPolicy
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
     * Визначає, чи може користувач переглядати будь-які полиці.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати полицю.
     */
    public function view(User $user, Shelf $shelf): bool
    {
        return $shelf->is_public || $shelf->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати полиці.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати полицю.
     */
    public function update(User $user, Shelf $shelf): bool
    {
        return $shelf->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти полицю.
     */
    public function delete(User $user, Shelf $shelf): bool
    {
        return $shelf->user_id === $user->id;
    }
}
