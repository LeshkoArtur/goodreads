<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Book.
 */
class BookPolicy
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
     * Визначає, чи може користувач переглядати будь-які книги.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати книгу.
     *
     * @param User $user
     * @param Book $book
     * @return bool
     */
    public function view(User $user, Book $book): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати книги.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати книгу.
     *
     * @param User $user
     * @param Book $book
     * @return bool
     */
    public function update(User $user, Book $book): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти книгу.
     *
     * @param User $user
     * @param Book $book
     * @return bool
     */
    public function delete(User $user, Book $book): bool
    {
        return false;
    }
}
