<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Book.
 */
class BookPolicy
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
     * Визначає, чи може користувач переглядати будь-які книги.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати книгу.
     */
    public function view(User $user, Book $book): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати книги.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати книгу.
     */
    public function update(User $user, Book $book): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти книгу.
     */
    public function delete(User $user, Book $book): bool
    {
        return false;
    }
}
