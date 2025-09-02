<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserBook;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі UserBook.
 */
class UserBookPolicy
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
     * Визначає, чи може користувач переглядати будь-які записи книг користувачів.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати запис книги користувача.
     *
     * @param User $user
     * @param UserBook $userBook
     * @return bool
     */
    public function view(User $user, UserBook $userBook): bool
    {
        return $userBook->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати записи книг користувачів.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати запис книги користувача.
     *
     * @param User $user
     * @param UserBook $userBook
     * @return bool
     */
    public function update(User $user, UserBook $userBook): bool
    {
        return $userBook->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти запис книги користувача.
     *
     * @param User $user
     * @param UserBook $userBook
     * @return bool
     */
    public function delete(User $user, UserBook $userBook): bool
    {
        return $userBook->user_id === $user->id;
    }
}
