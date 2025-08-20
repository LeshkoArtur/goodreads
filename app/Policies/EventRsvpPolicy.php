<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EventRsvp;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі EventRsvp.
 */
class EventRsvpPolicy
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
     * Визначає, чи може користувач переглядати будь-які RSVP.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати RSVP.
     *
     * @param User $user
     * @param EventRsvp $eventRsvp
     * @return bool
     */
    public function view(User $user, EventRsvp $eventRsvp): bool
    {
        return $eventRsvp->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати RSVP.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати RSVP.
     *
     * @param User $user
     * @param EventRsvp $eventRsvp
     * @return bool
     */
    public function update(User $user, EventRsvp $eventRsvp): bool
    {
        return $eventRsvp->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти RSVP.
     *
     * @param User $user
     * @param EventRsvp $eventRsvp
     * @return bool
     */
    public function delete(User $user, EventRsvp $eventRsvp): bool
    {
        return $eventRsvp->user_id === $user->id;
    }
}
