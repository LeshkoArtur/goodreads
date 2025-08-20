<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Genre;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Genre.
 */
class GenrePolicy
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
     * Визначає, чи може користувач переглядати будь-які жанри.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати жанр.
     *
     * @param User $user
     * @param Genre $genre
     * @return bool
     */
    public function view(User $user, Genre $genre): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати жанри.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати жанр.
     *
     * @param User $user
     * @param Genre $genre
     * @return bool
     */
    public function update(User $user, Genre $genre): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти жанр.
     *
     * @param User $user
     * @param Genre $genre
     * @return bool
     */
    public function delete(User $user, Genre $genre): bool
    {
        return false;
    }
}
