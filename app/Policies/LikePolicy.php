<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Like;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Like.
 */
class LikePolicy
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
     * Визначає, чи може користувач переглядати будь-які лайки.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати лайк.
     *
     * @param User $user
     * @param Like $like
     * @return bool
     */
    public function view(User $user, Like $like): bool
    {
        return $like->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати лайки.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати лайк.
     *
     * @param User $user
     * @param Like $like
     * @return bool
     */
    public function update(User $user, Like $like): bool
    {
        return $like->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти лайк.
     *
     * @param User $user
     * @param Like $like
     * @return bool
     */
    public function delete(User $user, Like $like): bool
    {
        return $like->user_id === $user->id;
    }
}
