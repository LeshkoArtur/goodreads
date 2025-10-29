<?php

namespace App\Policies;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Genre.
 */
class GenrePolicy
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
     * Визначає, чи може користувач переглядати будь-які жанри.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати жанр.
     */
    public function view(User $user, Genre $genre): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати жанри.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати жанр.
     */
    public function update(User $user, Genre $genre): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти жанр.
     */
    public function delete(User $user, Genre $genre): bool
    {
        return false;
    }
}
