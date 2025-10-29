<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Like.
 */
class LikePolicy
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
     * Визначає, чи може користувач переглядати будь-які лайки.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати лайк.
     */
    public function view(User $user, Like $like): bool
    {
        return $like->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати лайки.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати лайк.
     */
    public function update(User $user, Like $like): bool
    {
        return $like->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти лайк.
     */
    public function delete(User $user, Like $like): bool
    {
        return $like->user_id === $user->id;
    }
}
