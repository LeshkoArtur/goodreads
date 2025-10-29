<?php

namespace App\Policies;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Collection.
 */
class CollectionPolicy
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
     * Визначає, чи може користувач переглядати будь-які колекції.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати колекцію.
     */
    public function view(User $user, Collection $collection): bool
    {
        return $collection->is_public || $collection->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати колекції.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати колекцію.
     */
    public function update(User $user, Collection $collection): bool
    {
        return $collection->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти колекцію.
     */
    public function delete(User $user, Collection $collection): bool
    {
        return $collection->user_id === $user->id;
    }
}
