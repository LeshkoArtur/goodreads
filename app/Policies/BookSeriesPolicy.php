<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BookSeries;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі BookSeries.
 */
class BookSeriesPolicy
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
     * Визначає, чи може користувач переглядати будь-які серії книг.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати серію книг.
     *
     * @param User $user
     * @param BookSeries $bookSeries
     * @return bool
     */
    public function view(User $user, BookSeries $bookSeries): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати серії книг.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати серію книг.
     *
     * @param User $user
     * @param BookSeries $bookSeries
     * @return bool
     */
    public function update(User $user, BookSeries $bookSeries): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти серію книг.
     *
     * @param User $user
     * @param BookSeries $bookSeries
     * @return bool
     */
    public function delete(User $user, BookSeries $bookSeries): bool
    {
        return false;
    }
}
