<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GroupModerationLog;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі GroupModerationLog.
 */
class GroupModerationLogPolicy
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
     * Визначає, чи може користувач переглядати будь-які журнали модерації груп.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати журнал модерації групи.
     *
     * @param User $user
     * @param GroupModerationLog $groupModerationLog
     * @return bool
     */
    public function view(User $user, GroupModerationLog $groupModerationLog): bool
    {
        return $groupModerationLog->moderator_id === $user->id || $groupModerationLog->group->creator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати журнали модерації груп.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати журнал модерації групи.
     *
     * @param User $user
     * @param GroupModerationLog $groupModerationLog
     * @return bool
     */
    public function update(User $user, GroupModerationLog $groupModerationLog): bool
    {
        return $groupModerationLog->moderator_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти журнал модерації групи.
     *
     * @param User $user
     * @param GroupModerationLog $groupModerationLog
     * @return bool
     */
    public function delete(User $user, GroupModerationLog $groupModerationLog): bool
    {
        return $groupModerationLog->moderator_id === $user->id;
    }
}
