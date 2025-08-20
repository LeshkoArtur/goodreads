<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GroupInvitation;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі GroupInvitation.
 */
class GroupInvitationPolicy
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
     * Визначає, чи може користувач переглядати будь-які запрошення до груп.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати запрошення до групи.
     *
     * @param User $user
     * @param GroupInvitation $groupInvitation
     * @return bool
     */
    public function view(User $user, GroupInvitation $groupInvitation): bool
    {
        return $groupInvitation->inviter_id === $user->id || $groupInvitation->invitee_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати запрошення до груп.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати запрошення до групи.
     *
     * @param User $user
     * @param GroupInvitation $groupInvitation
     * @return bool
     */
    public function update(User $user, GroupInvitation $groupInvitation): bool
    {
        return $groupInvitation->inviter_id === $user->id || $groupInvitation->invitee_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти запрошення до групи.
     *
     * @param User $user
     * @param GroupInvitation $groupInvitation
     * @return bool
     */
    public function delete(User $user, GroupInvitation $groupInvitation): bool
    {
        return $groupInvitation->inviter_id === $user->id || $groupInvitation->invitee_id === $user->id;
    }
}
