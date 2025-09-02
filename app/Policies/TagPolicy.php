<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Tag.
 */
class TagPolicy
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
     * Визначає, чи може користувач переглядати будь-які теги.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати тег.
     *
     * @param User $user
     * @param Tag $tag
     * @return bool
     */
    public function view(User $user, Tag $tag): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати теги.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати тег.
     *
     * @param User $user
     * @param Tag $tag
     * @return bool
     */
    public function update(User $user, Tag $tag): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти тег.
     *
     * @param User $user
     * @param Tag $tag
     * @return bool
     */
    public function delete(User $user, Tag $tag): bool
    {
        return false;
    }
}
