<?php

namespace App\Policies;

use App\Models\EventRsvp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі EventRsvp.
 */
class EventRsvpPolicy
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
     * Визначає, чи може користувач переглядати будь-які RSVP.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати RSVP.
     */
    public function view(User $user, EventRsvp $eventRsvp): bool
    {
        return $eventRsvp->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати RSVP.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати RSVP.
     */
    public function update(User $user, EventRsvp $eventRsvp): bool
    {
        return $eventRsvp->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти RSVP.
     */
    public function delete(User $user, EventRsvp $eventRsvp): bool
    {
        return $eventRsvp->user_id === $user->id;
    }
}
