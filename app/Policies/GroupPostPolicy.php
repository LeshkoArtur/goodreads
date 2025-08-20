<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GroupPost;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі GroupPost.
 */
class GroupPostPolicy
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
     * Визначає, чи може користувач переглядати будь-які пости груп.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати пост групи.
     *
     * @param User $user
     * @param GroupPost $groupPost
     * @return bool
     */
    public function view(User $user, GroupPost $groupPost): bool
    {
        return $groupPost->group->is_public || $groupPost->group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати пости груп.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати пост групи.
     *
     * @param User $user
     * @param GroupPost $groupPost
     * @return bool
     */
    public function update(User $user, GroupPost $groupPost): bool
    {
        return $groupPost->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти пост групи.
     *
     * @param User $user
     * @param GroupPost $groupPost
     * @return bool
     */
    public function delete(User $user, GroupPost $groupPost): bool
    {
        return $groupPost->user_id === $user->id;
    }
}
