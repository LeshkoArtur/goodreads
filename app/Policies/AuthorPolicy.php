<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Author;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Author.
 */
class AuthorPolicy
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
     * Визначає, чи може користувач переглядати будь-які автори.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати автора.
     *
     * @param User $user
     * @param Author $author
     * @return bool
     */
    public function view(User $user, Author $author): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати авторів.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати автора.
     *
     * @param User $user
     * @param Author $author
     * @return bool
     */
    public function update(User $user, Author $author): bool
    {
        return $author->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач видаляти автора.
     *
     * @param User $user
     * @param Author $author
     * @return bool
     */
    public function delete(User $user, Author $author): bool
    {
        return $author->users()->where('user_id', $user->id)->exists();
    }
}
