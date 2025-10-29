<?php

namespace App\Policies;

use App\Models\GroupEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі GroupEvent.
 */
class GroupEventPolicy
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
     * Визначає, чи може користувач переглядати будь-які події групи.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати подію групи.
     */
    public function view(User $user, GroupEvent $groupEvent): bool
    {
        return $groupEvent->group->is_public || $groupEvent->group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати події групи.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати подію групи.
     */
    public function update(User $user, GroupEvent $groupEvent): bool
    {
        return $groupEvent->creator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти подію групи.
     */
    public function delete(User $user, GroupEvent $groupEvent): bool
    {
        return $groupEvent->creator_id === $user->id;
    }
}
