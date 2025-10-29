<?php

namespace App\Policies;

use App\Models\GroupPost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі GroupPost.
 */
class GroupPostPolicy
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
     * Визначає, чи може користувач переглядати будь-які пости груп.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати пост групи.
     */
    public function view(User $user, GroupPost $groupPost): bool
    {
        return $groupPost->group->is_public || $groupPost->group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати пости груп.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати пост групи.
     */
    public function update(User $user, GroupPost $groupPost): bool
    {
        return $groupPost->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти пост групи.
     */
    public function delete(User $user, GroupPost $groupPost): bool
    {
        return $groupPost->user_id === $user->id;
    }
}
