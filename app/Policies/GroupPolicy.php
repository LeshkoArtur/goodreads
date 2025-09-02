<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Group.
 */
class GroupPolicy
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
     * Визначає, чи може користувач переглядати будь-які групи.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати групу.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function view(User $user, Group $group): bool
    {
        return $group->is_public || $group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати групи.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати групу.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function update(User $user, Group $group): bool
    {
        return $group->creator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти групу.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function delete(User $user, Group $group): bool
    {
        return $group->creator_id === $user->id;
    }
}
