<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Favorite;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Favorite.
 */
class FavoritePolicy
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
     * Визначає, чи може користувач переглядати будь-які обрані записи.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати обраний запис.
     *
     * @param User $user
     * @param Favorite $favorite
     * @return bool
     */
    public function view(User $user, Favorite $favorite): bool
    {
        return $favorite->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати обрані записи.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати обраний запис.
     *
     * @param User $user
     * @param Favorite $favorite
     * @return bool
     */
    public function update(User $user, Favorite $favorite): bool
    {
        return $favorite->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти обраний запис.
     *
     * @param User $user
     * @param Favorite $favorite
     * @return bool
     */
    public function delete(User $user, Favorite $favorite): bool
    {
        return $favorite->user_id === $user->id;
    }
}
