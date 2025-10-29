<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Tag.
 */
class TagPolicy
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
     * Визначає, чи може користувач переглядати будь-які теги.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати тег.
     */
    public function view(User $user, Tag $tag): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати теги.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати тег.
     */
    public function update(User $user, Tag $tag): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти тег.
     */
    public function delete(User $user, Tag $tag): bool
    {
        return false;
    }
}
