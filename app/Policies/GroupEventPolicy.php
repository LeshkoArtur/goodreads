<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GroupEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі GroupEvent.
 */
class GroupEventPolicy
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
     * Визначає, чи може користувач переглядати будь-які події групи.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати подію групи.
     *
     * @param User $user
     * @param GroupEvent $groupEvent
     * @return bool
     */
    public function view(User $user, GroupEvent $groupEvent): bool
    {
        return $groupEvent->group->is_public || $groupEvent->group->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати події групи.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати подію групи.
     *
     * @param User $user
     * @param GroupEvent $groupEvent
     * @return bool
     */
    public function update(User $user, GroupEvent $groupEvent): bool
    {
        return $groupEvent->creator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти подію групи.
     *
     * @param User $user
     * @param GroupEvent $groupEvent
     * @return bool
     */
    public function delete(User $user, GroupEvent $groupEvent): bool
    {
        return $groupEvent->creator_id === $user->id;
    }
}
