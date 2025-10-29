<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Group.
 */
class GroupPolicy
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
     * Визначає, чи може користувач переглядати будь-які групи.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати групу.
     */
    public function view(User $user, Group $group): bool
    {
        return $group->is_public || $group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати групи.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати групу.
     */
    public function update(User $user, Group $group): bool
    {
        return $group->creator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти групу.
     */
    public function delete(User $user, Group $group): bool
    {
        return $group->creator_id === $user->id;
    }
}
