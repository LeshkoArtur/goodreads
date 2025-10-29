<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Author.
 */
class AuthorPolicy
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
     * Визначає, чи може користувач переглядати будь-які автори.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати автора.
     */
    public function view(User $user, Author $author): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати авторів.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати автора.
     */
    public function update(User $user, Author $author): bool
    {
        return $author->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Визначає, чи може користувач видаляти автора.
     */
    public function delete(User $user, Author $author): bool
    {
        return $author->users()->where('user_id', $user->id)->exists();
    }
}
