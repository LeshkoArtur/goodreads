<?php

namespace App\Policies;

use App\Models\BookSeries;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі BookSeries.
 */
class BookSeriesPolicy
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
     * Визначає, чи може користувач переглядати будь-які серії книг.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати серію книг.
     */
    public function view(User $user, BookSeries $bookSeries): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати серії книг.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати серію книг.
     */
    public function update(User $user, BookSeries $bookSeries): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти серію книг.
     */
    public function delete(User $user, BookSeries $bookSeries): bool
    {
        return false;
    }
}
