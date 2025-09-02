<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BookOffer;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі BookOffer.
 */
class BookOfferPolicy
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
     * Визначає, чи може користувач переглядати будь-які пропозиції книг.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати пропозицію книги.
     *
     * @param User $user
     * @param BookOffer $bookOffer
     * @return bool
     */
    public function view(User $user, BookOffer $bookOffer): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати пропозиції книг.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати пропозицію книги.
     *
     * @param User $user
     * @param BookOffer $bookOffer
     * @return bool
     */
    public function update(User $user, BookOffer $bookOffer): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти пропозицію книги.
     *
     * @param User $user
     * @param BookOffer $bookOffer
     * @return bool
     */
    public function delete(User $user, BookOffer $bookOffer): bool
    {
        return false;
    }
}
