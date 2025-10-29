<?php

namespace App\Policies;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Favorite.
 */
class FavoritePolicy
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
     * Визначає, чи може користувач переглядати будь-які обрані записи.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати обраний запис.
     */
    public function view(User $user, Favorite $favorite): bool
    {
        return $favorite->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати обрані записи.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати обраний запис.
     */
    public function update(User $user, Favorite $favorite): bool
    {
        return $favorite->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти обраний запис.
     */
    public function delete(User $user, Favorite $favorite): bool
    {
        return $favorite->user_id === $user->id;
    }
}
