<?php

namespace App\Policies;

use App\Models\BookOffer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі BookOffer.
 */
class BookOfferPolicy
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
     * Визначає, чи може користувач переглядати будь-які пропозиції книг.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати пропозицію книги.
     */
    public function view(User $user, BookOffer $bookOffer): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати пропозиції книг.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати пропозицію книги.
     */
    public function update(User $user, BookOffer $bookOffer): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти пропозицію книги.
     */
    public function delete(User $user, BookOffer $bookOffer): bool
    {
        return false;
    }
}
